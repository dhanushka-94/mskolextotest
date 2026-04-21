<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class QuotationController extends Controller
{
    /**
     * Generate and download quotation PDF
     */
    public function generateQuotation(Request $request)
    {
        // Validate the request
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'terms' => 'required|accepted',
        ]);

        // Get cart items
        $cartItems = Cart::where('session_id', session()->getId())
            ->orWhere(function($query) {
                if (Auth::check()) {
                    $query->where('user_id', Auth::id());
                }
            })
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate totals and prepare cart products
        $subtotal = 0;
        $originalSubtotal = 0;
        $totalDiscount = 0;
        $cartProducts = [];

        foreach ($cartItems as $item) {
            $product = $item->product;
            if ($product) {
                $lineTotal = $item->quantity * $product->final_price;
                $originalLineTotal = $item->quantity * $product->price;
                $lineDiscount = $originalLineTotal - $lineTotal;
                
                $subtotal += $lineTotal;
                $originalSubtotal += $originalLineTotal;
                $totalDiscount += $lineDiscount;
                
                $cartProducts[] = [
                    'cart_item' => $item,
                    'product' => $product,
                    'line_total' => $lineTotal,
                    'original_line_total' => $originalLineTotal,
                    'line_discount' => $lineDiscount
                ];
            }
        }

        $shippingCost = 0; // Free shipping for quotations
        $taxAmount = 0; // No tax for quotations
        $total = $subtotal + $shippingCost + $taxAmount;

        // Generate quotation number
        $quotationNumber = 'QUO-' . date('Y') . '-' . strtoupper(substr(uniqid(), -8));

        // Save quotation to database
        $quotation = Quotation::create([
            'quotation_number' => $quotationNumber,
            'user_id' => Auth::id(),
            'session_id' => session()->getId(),
            'customer_name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'customer_email' => $request->customer_email ?? null,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->billing_address_line_1 ?? null,
            'customer_city' => $request->billing_city ?? null,
            'customer_state' => $request->billing_state ?? null,
            'customer_postal_code' => $request->billing_postal_code ?? null,
            'customer_country' => $request->billing_country ?? 'Sri Lanka',
            'subtotal' => $subtotal,
            'original_subtotal' => $originalSubtotal,
            'total_discount' => $totalDiscount,
            'shipping_cost' => $shippingCost,
            'tax_amount' => $taxAmount,
            'total_amount' => $total,
            'valid_until' => now()->addDays(7),
            'notes' => $request->notes ?? null,
            'items_data' => $cartProducts,
        ]);

        // Prepare quotation data for PDF
        $quotationData = [
            'quotation_number' => $quotationNumber,
            'date' => now()->format('F d, Y'),
            'valid_until' => now()->addDays(7)->format('F d, Y'),
            'customer' => [
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->customer_email ?? 'Not provided',
                'phone' => $request->customer_phone,
                'address' => $request->billing_address_line_1 ?? 'Not provided',
                'city' => $request->billing_city ?? 'Not provided',
                'state' => $request->billing_state ?? '',
                'postal_code' => $request->billing_postal_code ?? '',
                'country' => $request->billing_country ?? 'Sri Lanka',
            ],
            'items' => $cartProducts,
            'subtotal' => $subtotal,
            'original_subtotal' => $originalSubtotal,
            'total_discount' => $totalDiscount,
            'shipping_cost' => $shippingCost,
            'tax_amount' => $taxAmount,
            'total' => $total,
            'notes' => $request->notes ?? ''
        ];

        // Generate PDF
        $pdf = Pdf::loadView('quotations.pdf', $quotationData);
        $pdf->setPaper('A4', 'portrait');
        
        // Set PDF options for better rendering
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'defaultFont' => 'DejaVu Sans',
        ]);

        // Return PDF download
        return $pdf->download('MSK-Quotation-' . $quotationNumber . '.pdf');
    }
}

