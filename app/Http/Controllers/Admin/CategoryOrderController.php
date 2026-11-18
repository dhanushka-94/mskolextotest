<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SmaCategory;
use App\Services\CategoryOrderingService;
use Illuminate\Http\Request;

class CategoryOrderController extends Controller
{
    public function index(Request $request)
    {
        $mainCategories = CategoryOrderingService::sortCategories(
            SmaCategory::mainCategories()
                ->select(['id', 'name', 'slug', 'parent_id'])
                ->get()
        );

        $selectedParentId = (int) $request->query('parent', $mainCategories->first()->id ?? 0);
        $selectedParent = $mainCategories->firstWhere('id', $selectedParentId) ?? $mainCategories->first();

        $subcategories = collect();
        if ($selectedParent) {
            $subcategories = CategoryOrderingService::sortSubcategories(
                SmaCategory::query()
                    ->select(['id', 'name', 'slug', 'parent_id'])
                    ->where('parent_id', $selectedParent->id)
                    ->get(),
                $selectedParent->name
            );
        }

        return view('admin.category-order.index', [
            'mainCategories' => $mainCategories,
            'selectedParent' => $selectedParent,
            'subcategories' => $subcategories,
        ]);
    }

    public function reorderMain(Request $request)
    {
        $data = $request->validate([
            'ordered_ids' => 'required|array|min:1',
            'ordered_ids.*' => 'integer',
        ]);

        CategoryOrderingService::saveOrder($data['ordered_ids'], null);

        return response()->json([
            'success' => true,
            'message' => 'Main category order saved.',
        ]);
    }

    public function reorderSub(Request $request)
    {
        $data = $request->validate([
            'parent_id' => 'required|integer|min:1',
            'ordered_ids' => 'required|array|min:1',
            'ordered_ids.*' => 'integer',
        ]);

        CategoryOrderingService::saveOrder($data['ordered_ids'], (int) $data['parent_id']);

        return response()->json([
            'success' => true,
            'message' => 'Subcategory order saved.',
        ]);
    }

    public function resetMain()
    {
        CategoryOrderingService::resetOrder(null);

        return response()->json([
            'success' => true,
            'message' => 'Main category order reset to defaults.',
        ]);
    }

    public function resetSub(Request $request)
    {
        $data = $request->validate([
            'parent_id' => 'required|integer|min:1',
        ]);

        CategoryOrderingService::resetOrder((int) $data['parent_id']);

        return response()->json([
            'success' => true,
            'message' => 'Subcategory order reset to defaults.',
        ]);
    }
}
