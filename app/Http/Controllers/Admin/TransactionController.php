<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('order')
            ->recent();

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->byPaymentMethod($request->payment_method);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by transaction ID, order ID, or customer info
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhere('gateway_transaction_id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhereHas('order', function($orderQuery) use ($search) {
                      $orderQuery->where('order_number', 'like', "%{$search}%");
                  });
            });
        }

        $transactions = $query->paginate(20)->withQueryString();

        // Get statistics
        $stats = $this->getTransactionStats($request);

        return view('admin.transactions.index', compact('transactions', 'stats'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('order.orderItems.product');
        
        return view('admin.transactions.show', compact('transaction'));
    }

    public function retry(Transaction $transaction)
    {
        if (!$transaction->isFailed()) {
            return back()->with('error', 'Only failed transactions can be retried.');
        }

        // Reset transaction status
        $transaction->update([
            'status' => 'pending',
            'failure_reason' => null,
            'failed_at' => null
        ]);

        return back()->with('success', 'Transaction has been marked for retry.');
    }

    public function refund(Request $request, Transaction $transaction)
    {
        if (!$transaction->isCompleted()) {
            return back()->with('error', 'Only completed transactions can be refunded.');
        }

        $request->validate([
            'refund_reason' => 'required|string|max:500'
        ]);

        $transaction->update([
            'status' => 'refunded',
            'failure_reason' => $request->refund_reason,
            'metadata' => array_merge($transaction->metadata ?? [], [
                'refund_reason' => $request->refund_reason,
                'refunded_by' => auth()->user()->name,
                'refunded_at' => now()->toDateTimeString()
            ])
        ]);

        return back()->with('success', 'Transaction has been marked as refunded.');
    }

    public function export(Request $request)
    {
        $query = Transaction::with('order')
            ->recent();

        // Apply same filters as index
        if ($request->filled('payment_method')) {
            $query->byPaymentMethod($request->payment_method);
        }
        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->get();

        $filename = 'transactions_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'Transaction ID',
                'Order Number',
                'Payment Method',
                'Status',
                'Amount',
                'Transaction Fee',
                'Total Amount',
                'Customer Name',
                'Customer Email',
                'Customer Phone',
                'Gateway Transaction ID',
                'Created At',
                'Completed At',
                'Failed At',
                'Failure Reason'
            ]);

            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->transaction_id,
                    $transaction->order?->order_number ?? 'N/A',
                    $transaction->payment_method_name,
                    ucfirst($transaction->status),
                    $transaction->amount,
                    $transaction->transaction_fee,
                    $transaction->total_amount,
                    $transaction->customer_name,
                    $transaction->customer_email,
                    $transaction->customer_phone,
                    $transaction->gateway_transaction_id,
                    $transaction->created_at?->format('Y-m-d H:i:s'),
                    $transaction->completed_at?->format('Y-m-d H:i:s'),
                    $transaction->failed_at?->format('Y-m-d H:i:s'),
                    $transaction->failure_reason
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getTransactionStats($request = null)
    {
        $query = Transaction::query();
        
        // Apply date filters if provided
        if ($request && $request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request && $request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return [
            'total_transactions' => $query->count(),
            'completed_transactions' => $query->completed()->count(),
            'failed_transactions' => $query->failed()->count(),
            'pending_transactions' => $query->byStatus('pending')->count(),
            'total_amount' => $query->completed()->sum('amount'),
            'total_fees' => $query->completed()->sum('transaction_fee'),
            'webxpay_count' => $query->byPaymentMethod('webxpay')->count(),
            'kokopay_count' => $query->byPaymentMethod('kokopay')->count(),
            'bank_transfer_count' => $query->byPaymentMethod('bank_transfer')->count(),
            'success_rate' => $query->count() > 0 ? round(($query->completed()->count() / $query->count()) * 100, 2) : 0,
        ];
    }
}
