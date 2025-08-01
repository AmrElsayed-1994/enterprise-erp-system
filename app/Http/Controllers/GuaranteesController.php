<?php

namespace App\Http\Controllers;

use App\Models\Guarantee;
use App\Models\ContractorTender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuaranteesController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasPermission('guarantees.view')) {
            abort(403);
        }

        $guarantees = Guarantee::with(['tender', 'contractor'])->paginate(15);
        return view('modules.guarantees.index', compact('guarantees'));
    }

    public function dashboard()
    {
        if (!Auth::user()->hasPermission('guarantees.view')) {
            abort(403);
        }

        $totalGuarantees = Guarantee::count();
        $activeGuarantees = Guarantee::where('status', 'active')->count();
        $expiringGuarantees = Guarantee::where('expiry_date', '<=', now()->addDays(30))->count();
        $totalValue = Guarantee::sum('amount');

        return view('modules.guarantees.dashboard', compact('totalGuarantees', 'activeGuarantees', 'expiringGuarantees', 'totalValue'));
    }

    public function create()
    {
        if (!Auth::user()->hasPermission('guarantees.create')) {
            abort(403);
        }

        $tenders = ContractorTender::where('status', 'awarded')->get();
        $contractors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['contractor', 'admin', 'super_admin']);
        })->get();

        return view('modules.guarantees.create', compact('tenders', 'contractors'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('guarantees.create')) {
            abort(403);
        }

        $validated = $request->validate([
            'guarantee_number' => 'required|unique:guarantees',
            'tender_id' => 'required|exists:contractor_tenders,id',
            'contractor_id' => 'required|exists:users,id',
            'type' => 'required|in:bid_bond,performance_bond,advance_payment,warranty,retention',
            'type_ar' => 'required',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|size:3',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'issuing_bank' => 'required',
            'bank_reference' => 'required',
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date|after:issue_date',
            'terms_conditions' => 'nullable',
            'terms_conditions_ar' => 'nullable',
            'notes' => 'nullable',
            'notes_ar' => 'nullable',
        ]);

        $validated['created_by'] = Auth::id();
        Guarantee::create($validated);

        return redirect()->route('guarantees.index')->with('success', 'Guarantee created successfully');
    }

    public function show(Guarantee $guarantee)
    {
        if (!Auth::user()->hasPermission('guarantees.view')) {
            abort(403);
        }

        return view('modules.guarantees.show', compact('guarantee'));
    }

    public function edit(Guarantee $guarantee)
    {
        if (!Auth::user()->hasPermission('guarantees.edit')) {
            abort(403);
        }

        $tenders = ContractorTender::where('status', 'awarded')->get();
        $contractors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['contractor', 'admin', 'super_admin']);
        })->get();

        return view('modules.guarantees.edit', compact('guarantee', 'tenders', 'contractors'));
    }

    public function update(Request $request, Guarantee $guarantee)
    {
        if (!Auth::user()->hasPermission('guarantees.edit')) {
            abort(403);
        }

        $validated = $request->validate([
            'guarantee_number' => 'required|unique:guarantees,guarantee_number,' . $guarantee->id,
            'tender_id' => 'required|exists:contractor_tenders,id',
            'contractor_id' => 'required|exists:users,id',
            'type' => 'required|in:bid_bond,performance_bond,advance_payment,warranty,retention',
            'type_ar' => 'required',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|size:3',
            'percentage' => 'nullable|numeric|min:0|max:100',
            'issuing_bank' => 'required',
            'bank_reference' => 'required',
            'issue_date' => 'required|date',
            'expiry_date' => 'required|date|after:issue_date',
            'extension_date' => 'nullable|date|after:expiry_date',
            'status' => 'required|in:active,expired,claimed,released,extended',
            'terms_conditions' => 'nullable',
            'terms_conditions_ar' => 'nullable',
            'claim_details' => 'nullable',
            'claim_details_ar' => 'nullable',
            'claim_date' => 'nullable|date',
            'claim_amount' => 'nullable|numeric|min:0',
            'release_date' => 'nullable|date',
            'notes' => 'nullable',
            'notes_ar' => 'nullable',
        ]);

        $validated['updated_by'] = Auth::id();
        $guarantee->update($validated);

        return redirect()->route('guarantees.index')->with('success', 'Guarantee updated successfully');
    }

    public function destroy(Guarantee $guarantee)
    {
        if (!Auth::user()->hasPermission('guarantees.delete')) {
            abort(403);
        }

        $guarantee->delete();
        return redirect()->route('guarantees.index')->with('success', 'Guarantee deleted successfully');
    }
}
