<?php

namespace App\Http\Controllers;

use App\Models\ContractorItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractorItemsController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasPermission('contractor_items.view')) {
            abort(403);
        }

        $items = ContractorItem::with(['creator', 'updater'])->paginate(15);
        return view('modules.contractor-items.index', compact('items'));
    }

    public function dashboard()
    {
        if (!Auth::user()->hasPermission('contractor_items.view')) {
            abort(403);
        }

        $totalItems = ContractorItem::count();
        $activeItems = ContractorItem::where('is_active', true)->count();
        $categories = ContractorItem::distinct('category')->count();
        $avgPrice = ContractorItem::avg('unit_price');

        return view('modules.contractor-items.dashboard', compact('totalItems', 'activeItems', 'categories', 'avgPrice'));
    }

    public function create()
    {
        if (!Auth::user()->hasPermission('contractor_items.create')) {
            abort(403);
        }

        return view('modules.contractor-items.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('contractor_items.create')) {
            abort(403);
        }

        $validated = $request->validate([
            'code' => 'required|unique:contractor_items',
            'name' => 'required',
            'name_ar' => 'required',
            'category' => 'required',
            'category_ar' => 'required',
            'unit' => 'required',
            'unit_ar' => 'required',
            'unit_price' => 'required|numeric|min:0',
            'currency' => 'required|size:3',
            'description' => 'nullable',
            'description_ar' => 'nullable',
            'specifications' => 'nullable',
            'specifications_ar' => 'nullable',
            'supplier' => 'nullable',
            'brand' => 'nullable',
            'is_active' => 'boolean',
        ]);

        $validated['created_by'] = Auth::id();
        ContractorItem::create($validated);

        return redirect()->route('contractor-items.index')->with('success', 'Item created successfully');
    }

    public function show(ContractorItem $contractorItem)
    {
        if (!Auth::user()->hasPermission('contractor_items.view')) {
            abort(403);
        }

        return view('modules.contractor-items.show', compact('contractorItem'));
    }

    public function edit(ContractorItem $contractorItem)
    {
        if (!Auth::user()->hasPermission('contractor_items.edit')) {
            abort(403);
        }

        return view('modules.contractor-items.edit', compact('contractorItem'));
    }

    public function update(Request $request, ContractorItem $contractorItem)
    {
        if (!Auth::user()->hasPermission('contractor_items.edit')) {
            abort(403);
        }

        $validated = $request->validate([
            'code' => 'required|unique:contractor_items,code,' . $contractorItem->id,
            'name' => 'required',
            'name_ar' => 'required',
            'category' => 'required',
            'category_ar' => 'required',
            'unit' => 'required',
            'unit_ar' => 'required',
            'unit_price' => 'required|numeric|min:0',
            'currency' => 'required|size:3',
            'description' => 'nullable',
            'description_ar' => 'nullable',
            'specifications' => 'nullable',
            'specifications_ar' => 'nullable',
            'supplier' => 'nullable',
            'brand' => 'nullable',
            'is_active' => 'boolean',
        ]);

        $validated['updated_by'] = Auth::id();
        $contractorItem->update($validated);

        return redirect()->route('contractor-items.index')->with('success', 'Item updated successfully');
    }

    public function destroy(ContractorItem $contractorItem)
    {
        if (!Auth::user()->hasPermission('contractor_items.delete')) {
            abort(403);
        }

        $contractorItem->delete();
        return redirect()->route('contractor-items.index')->with('success', 'Item deleted successfully');
    }
}
