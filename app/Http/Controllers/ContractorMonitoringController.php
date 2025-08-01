<?php

namespace App\Http\Controllers;

use App\Models\ContractorMonitoring;
use App\Models\ContractorTender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractorMonitoringController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasPermission('contractor_monitoring.view')) {
            abort(403);
        }

        $monitoringRecords = ContractorMonitoring::with(['tender', 'contractor', 'evaluator'])->paginate(15);
        return view('modules.contractor-monitoring.index', compact('monitoringRecords'));
    }

    public function dashboard()
    {
        if (!Auth::user()->hasPermission('contractor_monitoring.view')) {
            abort(403);
        }

        $totalEvaluations = ContractorMonitoring::count();
        $avgOverallScore = ContractorMonitoring::avg('overall_score');
        $excellentPerformers = ContractorMonitoring::where('performance_rating', 'excellent')->count();
        $blacklistedContractors = ContractorMonitoring::where('is_blacklisted', true)->distinct('contractor_id')->count();

        return view('modules.contractor-monitoring.dashboard', compact('totalEvaluations', 'avgOverallScore', 'excellentPerformers', 'blacklistedContractors'));
    }

    public function create()
    {
        if (!Auth::user()->hasPermission('contractor_monitoring.create')) {
            abort(403);
        }

        $tenders = ContractorTender::where('status', 'awarded')->get();
        $contractors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['contractor', 'admin', 'super_admin']);
        })->get();

        return view('modules.contractor-monitoring.create', compact('tenders', 'contractors'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('contractor_monitoring.create')) {
            abort(403);
        }

        $validated = $request->validate([
            'tender_id' => 'required|exists:contractor_tenders,id',
            'contractor_id' => 'required|exists:users,id',
            'evaluation_date' => 'required|date',
            'evaluation_period' => 'required',
            'evaluation_period_ar' => 'required',
            'quality_score' => 'required|numeric|min:0|max:100',
            'schedule_performance_score' => 'required|numeric|min:0|max:100',
            'cost_performance_score' => 'required|numeric|min:0|max:100',
            'safety_score' => 'required|numeric|min:0|max:100',
            'communication_score' => 'required|numeric|min:0|max:100',
            'performance_rating' => 'required|in:excellent,good,satisfactory,needs_improvement,poor',
            'performance_rating_ar' => 'required',
            'quality_comments' => 'nullable',
            'quality_comments_ar' => 'nullable',
            'schedule_comments' => 'nullable',
            'schedule_comments_ar' => 'nullable',
            'cost_comments' => 'nullable',
            'cost_comments_ar' => 'nullable',
            'safety_comments' => 'nullable',
            'safety_comments_ar' => 'nullable',
            'communication_comments' => 'nullable',
            'communication_comments_ar' => 'nullable',
            'improvement_recommendations' => 'nullable',
            'improvement_recommendations_ar' => 'nullable',
            'corrective_actions' => 'nullable',
            'corrective_actions_ar' => 'nullable',
            'next_evaluation_date' => 'nullable|date|after:evaluation_date',
            'is_blacklisted' => 'boolean',
            'blacklist_reason' => 'nullable',
            'blacklist_reason_ar' => 'nullable',
        ]);

        $overallScore = ($validated['quality_score'] + $validated['schedule_performance_score'] + 
                        $validated['cost_performance_score'] + $validated['safety_score'] + 
                        $validated['communication_score']) / 5;

        $validated['overall_score'] = $overallScore;
        $validated['evaluated_by'] = Auth::id();
        $validated['created_by'] = Auth::id();
        ContractorMonitoring::create($validated);

        return redirect()->route('contractor-monitoring.index')->with('success', 'Evaluation created successfully');
    }

    public function show(ContractorMonitoring $contractorMonitoring)
    {
        if (!Auth::user()->hasPermission('contractor_monitoring.view')) {
            abort(403);
        }

        return view('modules.contractor-monitoring.show', compact('contractorMonitoring'));
    }

    public function edit(ContractorMonitoring $contractorMonitoring)
    {
        if (!Auth::user()->hasPermission('contractor_monitoring.edit')) {
            abort(403);
        }

        $tenders = ContractorTender::where('status', 'awarded')->get();
        $contractors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['contractor', 'admin', 'super_admin']);
        })->get();

        return view('modules.contractor-monitoring.edit', compact('contractorMonitoring', 'tenders', 'contractors'));
    }

    public function update(Request $request, ContractorMonitoring $contractorMonitoring)
    {
        if (!Auth::user()->hasPermission('contractor_monitoring.edit')) {
            abort(403);
        }

        $validated = $request->validate([
            'tender_id' => 'required|exists:contractor_tenders,id',
            'contractor_id' => 'required|exists:users,id',
            'evaluation_date' => 'required|date',
            'evaluation_period' => 'required',
            'evaluation_period_ar' => 'required',
            'quality_score' => 'required|numeric|min:0|max:100',
            'schedule_performance_score' => 'required|numeric|min:0|max:100',
            'cost_performance_score' => 'required|numeric|min:0|max:100',
            'safety_score' => 'required|numeric|min:0|max:100',
            'communication_score' => 'required|numeric|min:0|max:100',
            'performance_rating' => 'required|in:excellent,good,satisfactory,needs_improvement,poor',
            'performance_rating_ar' => 'required',
            'quality_comments' => 'nullable',
            'quality_comments_ar' => 'nullable',
            'schedule_comments' => 'nullable',
            'schedule_comments_ar' => 'nullable',
            'cost_comments' => 'nullable',
            'cost_comments_ar' => 'nullable',
            'safety_comments' => 'nullable',
            'safety_comments_ar' => 'nullable',
            'communication_comments' => 'nullable',
            'communication_comments_ar' => 'nullable',
            'improvement_recommendations' => 'nullable',
            'improvement_recommendations_ar' => 'nullable',
            'corrective_actions' => 'nullable',
            'corrective_actions_ar' => 'nullable',
            'next_evaluation_date' => 'nullable|date|after:evaluation_date',
            'is_blacklisted' => 'boolean',
            'blacklist_reason' => 'nullable',
            'blacklist_reason_ar' => 'nullable',
        ]);

        $overallScore = ($validated['quality_score'] + $validated['schedule_performance_score'] + 
                        $validated['cost_performance_score'] + $validated['safety_score'] + 
                        $validated['communication_score']) / 5;

        $validated['overall_score'] = $overallScore;
        $validated['updated_by'] = Auth::id();
        $contractorMonitoring->update($validated);

        return redirect()->route('contractor-monitoring.index')->with('success', 'Evaluation updated successfully');
    }

    public function destroy(ContractorMonitoring $contractorMonitoring)
    {
        if (!Auth::user()->hasPermission('contractor_monitoring.delete')) {
            abort(403);
        }

        $contractorMonitoring->delete();
        return redirect()->route('contractor-monitoring.index')->with('success', 'Evaluation deleted successfully');
    }
}
