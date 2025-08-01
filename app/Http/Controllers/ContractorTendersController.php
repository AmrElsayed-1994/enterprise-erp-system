<?php

namespace App\Http\Controllers;

use App\Models\ContractorTender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractorTendersController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasPermission('contractor_tenders.view')) {
            abort(403);
        }

        $tenders = ContractorTender::with(['creator', 'updater', 'awardedContractor'])->paginate(15);
        return view('modules.contractor-tenders.index', compact('tenders'));
    }

    public function dashboard()
    {
        if (!Auth::user()->hasPermission('contractor_tenders.view')) {
            abort(403);
        }

        $totalTenders = ContractorTender::count();
        $activeTenders = ContractorTender::where('status', 'published')->count();
        $awardedTenders = ContractorTender::where('status', 'awarded')->count();
        $totalValue = ContractorTender::sum('estimated_value');

        return view('modules.contractor-tenders.dashboard', compact('totalTenders', 'activeTenders', 'awardedTenders', 'totalValue'));
    }

    public function create()
    {
        if (!Auth::user()->hasPermission('contractor_tenders.create')) {
            abort(403);
        }

        $contractors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['contractor', 'admin', 'super_admin']);
        })->get();

        return view('modules.contractor-tenders.create', compact('contractors'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('contractor_tenders.create')) {
            abort(403);
        }

        $validated = $request->validate([
            'tender_number' => 'required|unique:contractor_tenders',
            'title' => 'required',
            'title_ar' => 'required',
            'description' => 'required',
            'description_ar' => 'required',
            'type' => 'required|in:public,private,limited',
            'estimated_value' => 'required|numeric|min:0',
            'currency' => 'required|size:3',
            'publication_date' => 'required|date',
            'submission_deadline' => 'required|date|after:publication_date',
            'opening_date' => 'required|date|after:submission_deadline',
            'requirements' => 'nullable',
            'requirements_ar' => 'nullable',
            'evaluation_criteria' => 'nullable',
            'evaluation_criteria_ar' => 'nullable',
        ]);

        $validated['created_by'] = Auth::id();
        ContractorTender::create($validated);

        return redirect()->route('contractor-tenders.index')->with('success', 'Tender created successfully');
    }

    public function show(ContractorTender $contractorTender)
    {
        if (!Auth::user()->hasPermission('contractor_tenders.view')) {
            abort(403);
        }

        return view('modules.contractor-tenders.show', compact('contractorTender'));
    }

    public function edit(ContractorTender $contractorTender)
    {
        if (!Auth::user()->hasPermission('contractor_tenders.edit')) {
            abort(403);
        }

        $contractors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['contractor', 'admin', 'super_admin']);
        })->get();

        return view('modules.contractor-tenders.edit', compact('contractorTender', 'contractors'));
    }

    public function update(Request $request, ContractorTender $contractorTender)
    {
        if (!Auth::user()->hasPermission('contractor_tenders.edit')) {
            abort(403);
        }

        $validated = $request->validate([
            'tender_number' => 'required|unique:contractor_tenders,tender_number,' . $contractorTender->id,
            'title' => 'required',
            'title_ar' => 'required',
            'description' => 'required',
            'description_ar' => 'required',
            'type' => 'required|in:public,private,limited',
            'estimated_value' => 'required|numeric|min:0',
            'currency' => 'required|size:3',
            'publication_date' => 'required|date',
            'submission_deadline' => 'required|date|after:publication_date',
            'opening_date' => 'required|date|after:submission_deadline',
            'status' => 'required|in:draft,published,closed,awarded,cancelled',
            'requirements' => 'nullable',
            'requirements_ar' => 'nullable',
            'evaluation_criteria' => 'nullable',
            'evaluation_criteria_ar' => 'nullable',
            'awarded_to' => 'nullable|exists:users,id',
            'awarded_amount' => 'nullable|numeric|min:0',
            'award_date' => 'nullable|date',
        ]);

        $validated['updated_by'] = Auth::id();
        $contractorTender->update($validated);

        return redirect()->route('contractor-tenders.index')->with('success', 'Tender updated successfully');
    }

    public function destroy(ContractorTender $contractorTender)
    {
        if (!Auth::user()->hasPermission('contractor_tenders.delete')) {
            abort(403);
        }

        $contractorTender->delete();
        return redirect()->route('contractor-tenders.index')->with('success', 'Tender deleted successfully');
    }
}
