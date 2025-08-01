<?php

namespace App\Http\Controllers;

use App\Models\ChangeOrder;
use App\Models\ContractorTender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChangeOrdersController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasPermission('change_orders.view')) {
            abort(403);
        }

        $changeOrders = ChangeOrder::with(['tender', 'contractor', 'reviewer', 'approver'])->paginate(15);
        return view('modules.change-orders.index', compact('changeOrders'));
    }

    public function dashboard()
    {
        if (!Auth::user()->hasPermission('change_orders.view')) {
            abort(403);
        }

        $totalOrders = ChangeOrder::count();
        $pendingApproval = ChangeOrder::where('status', 'submitted')->count();
        $approvedOrders = ChangeOrder::where('status', 'approved')->count();
        $totalValue = ChangeOrder::sum('change_amount');

        return view('modules.change-orders.dashboard', compact('totalOrders', 'pendingApproval', 'approvedOrders', 'totalValue'));
    }

    public function create()
    {
        if (!Auth::user()->hasPermission('change_orders.create')) {
            abort(403);
        }

        $tenders = ContractorTender::where('status', 'awarded')->get();
        $contractors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['contractor', 'admin', 'super_admin']);
        })->get();

        return view('modules.change-orders.create', compact('tenders', 'contractors'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('change_orders.create')) {
            abort(403);
        }

        $validated = $request->validate([
            'change_order_number' => 'required|unique:change_orders',
            'tender_id' => 'required|exists:contractor_tenders,id',
            'contractor_id' => 'required|exists:users,id',
            'type' => 'required|in:change_order,variation_order,claim,dispute',
            'type_ar' => 'required',
            'title' => 'required',
            'title_ar' => 'required',
            'description' => 'required',
            'description_ar' => 'required',
            'justification' => 'required',
            'justification_ar' => 'required',
            'original_amount' => 'required|numeric',
            'change_amount' => 'required|numeric',
            'currency' => 'required|size:3',
            'time_extension_days' => 'required|integer|min:0',
            'original_completion_date' => 'required|date',
            'new_completion_date' => 'nullable|date|after:original_completion_date',
            'priority' => 'required|in:low,medium,high,urgent',
            'impact_analysis' => 'nullable',
            'impact_analysis_ar' => 'nullable',
            'supporting_documents' => 'nullable',
        ]);

        $validated['new_total_amount'] = $validated['original_amount'] + $validated['change_amount'];
        $validated['created_by'] = Auth::id();
        ChangeOrder::create($validated);

        return redirect()->route('change-orders.index')->with('success', 'Change order created successfully');
    }

    public function show(ChangeOrder $changeOrder)
    {
        if (!Auth::user()->hasPermission('change_orders.view')) {
            abort(403);
        }

        return view('modules.change-orders.show', compact('changeOrder'));
    }

    public function edit(ChangeOrder $changeOrder)
    {
        if (!Auth::user()->hasPermission('change_orders.edit')) {
            abort(403);
        }

        $tenders = ContractorTender::where('status', 'awarded')->get();
        $contractors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['contractor', 'admin', 'super_admin']);
        })->get();

        return view('modules.change-orders.edit', compact('changeOrder', 'tenders', 'contractors'));
    }

    public function update(Request $request, ChangeOrder $changeOrder)
    {
        if (!Auth::user()->hasPermission('change_orders.edit')) {
            abort(403);
        }

        $validated = $request->validate([
            'change_order_number' => 'required|unique:change_orders,change_order_number,' . $changeOrder->id,
            'tender_id' => 'required|exists:contractor_tenders,id',
            'contractor_id' => 'required|exists:users,id',
            'type' => 'required|in:change_order,variation_order,claim,dispute',
            'type_ar' => 'required',
            'title' => 'required',
            'title_ar' => 'required',
            'description' => 'required',
            'description_ar' => 'required',
            'justification' => 'required',
            'justification_ar' => 'required',
            'original_amount' => 'required|numeric',
            'change_amount' => 'required|numeric',
            'currency' => 'required|size:3',
            'time_extension_days' => 'required|integer|min:0',
            'original_completion_date' => 'required|date',
            'new_completion_date' => 'nullable|date|after:original_completion_date',
            'status' => 'required|in:draft,submitted,under_review,approved,rejected,disputed',
            'priority' => 'required|in:low,medium,high,urgent',
            'impact_analysis' => 'nullable',
            'impact_analysis_ar' => 'nullable',
            'supporting_documents' => 'nullable',
            'submission_date' => 'nullable|date',
            'review_date' => 'nullable|date',
            'approval_date' => 'nullable|date',
            'review_comments' => 'nullable',
            'review_comments_ar' => 'nullable',
            'reviewed_by' => 'nullable|exists:users,id',
            'approved_by' => 'nullable|exists:users,id',
        ]);

        $validated['new_total_amount'] = $validated['original_amount'] + $validated['change_amount'];
        $validated['updated_by'] = Auth::id();
        $changeOrder->update($validated);

        return redirect()->route('change-orders.index')->with('success', 'Change order updated successfully');
    }

    public function destroy(ChangeOrder $changeOrder)
    {
        if (!Auth::user()->hasPermission('change_orders.delete')) {
            abort(403);
        }

        $changeOrder->delete();
        return redirect()->route('change-orders.index')->with('success', 'Change order deleted successfully');
    }
}
