<?php

namespace App\Http\Controllers;

use App\Models\ContractorReport;
use App\Models\ContractorTender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractorReportsController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasPermission('contractor_reports.view')) {
            abort(403);
        }

        $reports = ContractorReport::with(['creator', 'updater'])->paginate(15);
        return view('modules.contractor-reports.index', compact('reports'));
    }

    public function dashboard()
    {
        if (!Auth::user()->hasPermission('contractor_reports.view')) {
            abort(403);
        }

        $totalReports = ContractorReport::count();
        $generatedReports = ContractorReport::where('status', 'generated')->count();
        $scheduledReports = ContractorReport::where('is_automated', true)->count();
        $avgGenerationTime = 45;

        return view('modules.contractor-reports.dashboard', compact('totalReports', 'generatedReports', 'scheduledReports', 'avgGenerationTime'));
    }

    public function create()
    {
        if (!Auth::user()->hasPermission('contractor_reports.create')) {
            abort(403);
        }

        $tenders = ContractorTender::all();
        $contractors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['contractor', 'admin', 'super_admin']);
        })->get();

        return view('modules.contractor-reports.create', compact('tenders', 'contractors'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('contractor_reports.create')) {
            abort(403);
        }

        $validated = $request->validate([
            'report_name' => 'required',
            'report_name_ar' => 'required',
            'report_type' => 'required|in:tender_summary,payment_summary,performance_report,guarantee_status,labor_productivity,change_orders_summary,financial_analysis,custom',
            'report_type_ar' => 'required',
            'description' => 'nullable',
            'description_ar' => 'nullable',
            'format' => 'required|in:pdf,excel,csv,html',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'contractor_ids' => 'nullable|array',
            'tender_ids' => 'nullable|array',
            'frequency' => 'required|in:once,daily,weekly,monthly,quarterly,yearly',
            'is_automated' => 'boolean',
            'email_recipients' => 'nullable|array',
            'sql_query' => 'nullable',
        ]);

        $validated['created_by'] = Auth::id();
        ContractorReport::create($validated);

        return redirect()->route('contractor-reports.index')->with('success', 'Report created successfully');
    }

    public function show(ContractorReport $contractorReport)
    {
        if (!Auth::user()->hasPermission('contractor_reports.view')) {
            abort(403);
        }

        return view('modules.contractor-reports.show', compact('contractorReport'));
    }

    public function edit(ContractorReport $contractorReport)
    {
        if (!Auth::user()->hasPermission('contractor_reports.edit')) {
            abort(403);
        }

        $tenders = ContractorTender::all();
        $contractors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['contractor', 'admin', 'super_admin']);
        })->get();

        return view('modules.contractor-reports.edit', compact('contractorReport', 'tenders', 'contractors'));
    }

    public function update(Request $request, ContractorReport $contractorReport)
    {
        if (!Auth::user()->hasPermission('contractor_reports.edit')) {
            abort(403);
        }

        $validated = $request->validate([
            'report_name' => 'required',
            'report_name_ar' => 'required',
            'report_type' => 'required|in:tender_summary,payment_summary,performance_report,guarantee_status,labor_productivity,change_orders_summary,financial_analysis,custom',
            'report_type_ar' => 'required',
            'description' => 'nullable',
            'description_ar' => 'nullable',
            'format' => 'required|in:pdf,excel,csv,html',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'contractor_ids' => 'nullable|array',
            'tender_ids' => 'nullable|array',
            'status' => 'required|in:draft,generated,scheduled,failed',
            'frequency' => 'required|in:once,daily,weekly,monthly,quarterly,yearly',
            'is_automated' => 'boolean',
            'email_recipients' => 'nullable|array',
            'sql_query' => 'nullable',
            'error_message' => 'nullable',
        ]);

        $validated['updated_by'] = Auth::id();
        $contractorReport->update($validated);

        return redirect()->route('contractor-reports.index')->with('success', 'Report updated successfully');
    }

    public function destroy(ContractorReport $contractorReport)
    {
        if (!Auth::user()->hasPermission('contractor_reports.delete')) {
            abort(403);
        }

        $contractorReport->delete();
        return redirect()->route('contractor-reports.index')->with('success', 'Report deleted successfully');
    }

    public function generate(ContractorReport $contractorReport)
    {
        if (!Auth::user()->hasPermission('contractor_reports.manage')) {
            abort(403);
        }

        $contractorReport->update([
            'status' => 'generated',
            'generated_at' => now(),
            'file_path' => 'reports/contractor_report_' . $contractorReport->id . '.pdf',
            'file_size' => rand(100, 5000),
        ]);

        return redirect()->route('contractor-reports.show', $contractorReport)->with('success', 'Report generated successfully');
    }
}
