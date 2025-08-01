<?php

namespace App\Http\Controllers;

use App\Models\ProductionLabor;
use App\Models\ContractorTender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductionLaborController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasPermission('production_labor.view')) {
            abort(403);
        }

        $laborRecords = ProductionLabor::with(['tender', 'contractor'])->paginate(15);
        return view('modules.production-labor.index', compact('laborRecords'));
    }

    public function dashboard()
    {
        if (!Auth::user()->hasPermission('production_labor.view')) {
            abort(403);
        }

        $totalWorkers = ProductionLabor::count();
        $activeWorkers = ProductionLabor::where('status', 'active')->count();
        $avgProductivity = ProductionLabor::avg('productivity_score');
        $totalHours = ProductionLabor::sum('total_hours_worked');

        return view('modules.production-labor.dashboard', compact('totalWorkers', 'activeWorkers', 'avgProductivity', 'totalHours'));
    }

    public function create()
    {
        if (!Auth::user()->hasPermission('production_labor.create')) {
            abort(403);
        }

        $tenders = ContractorTender::where('status', 'awarded')->get();
        $contractors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['contractor', 'admin', 'super_admin']);
        })->get();

        return view('modules.production-labor.create', compact('tenders', 'contractors'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('production_labor.create')) {
            abort(403);
        }

        $validated = $request->validate([
            'tender_id' => 'required|exists:contractor_tenders,id',
            'contractor_id' => 'required|exists:users,id',
            'worker_name' => 'required',
            'worker_name_ar' => 'required',
            'worker_id' => 'required|unique:production_labor',
            'position' => 'required',
            'position_ar' => 'required',
            'skill_level' => 'required|in:unskilled,semi_skilled,skilled,highly_skilled,supervisor',
            'skill_level_ar' => 'required',
            'hourly_rate' => 'required|numeric|min:0',
            'daily_rate' => 'required|numeric|min:0',
            'monthly_rate' => 'required|numeric|min:0',
            'currency' => 'required|size:3',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'certifications' => 'nullable',
            'certifications_ar' => 'nullable',
            'safety_training' => 'nullable',
            'safety_training_ar' => 'nullable',
            'last_safety_training' => 'nullable|date',
            'notes' => 'nullable',
            'notes_ar' => 'nullable',
        ]);

        $validated['created_by'] = Auth::id();
        ProductionLabor::create($validated);

        return redirect()->route('production-labor.index')->with('success', 'Worker record created successfully');
    }

    public function show(ProductionLabor $productionLabor)
    {
        if (!Auth::user()->hasPermission('production_labor.view')) {
            abort(403);
        }

        return view('modules.production-labor.show', compact('productionLabor'));
    }

    public function edit(ProductionLabor $productionLabor)
    {
        if (!Auth::user()->hasPermission('production_labor.edit')) {
            abort(403);
        }

        $tenders = ContractorTender::where('status', 'awarded')->get();
        $contractors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['contractor', 'admin', 'super_admin']);
        })->get();

        return view('modules.production-labor.edit', compact('productionLabor', 'tenders', 'contractors'));
    }

    public function update(Request $request, ProductionLabor $productionLabor)
    {
        if (!Auth::user()->hasPermission('production_labor.edit')) {
            abort(403);
        }

        $validated = $request->validate([
            'tender_id' => 'required|exists:contractor_tenders,id',
            'contractor_id' => 'required|exists:users,id',
            'worker_name' => 'required',
            'worker_name_ar' => 'required',
            'worker_id' => 'required|unique:production_labor,worker_id,' . $productionLabor->id,
            'position' => 'required',
            'position_ar' => 'required',
            'skill_level' => 'required|in:unskilled,semi_skilled,skilled,highly_skilled,supervisor',
            'skill_level_ar' => 'required',
            'hourly_rate' => 'required|numeric|min:0',
            'daily_rate' => 'required|numeric|min:0',
            'monthly_rate' => 'required|numeric|min:0',
            'currency' => 'required|size:3',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,inactive,terminated,on_leave',
            'total_hours_worked' => 'required|integer|min:0',
            'total_days_worked' => 'required|integer|min:0',
            'productivity_score' => 'nullable|numeric|min:0|max:100',
            'certifications' => 'nullable',
            'certifications_ar' => 'nullable',
            'safety_training' => 'nullable',
            'safety_training_ar' => 'nullable',
            'last_safety_training' => 'nullable|date',
            'notes' => 'nullable',
            'notes_ar' => 'nullable',
        ]);

        $validated['updated_by'] = Auth::id();
        $productionLabor->update($validated);

        return redirect()->route('production-labor.index')->with('success', 'Worker record updated successfully');
    }

    public function destroy(ProductionLabor $productionLabor)
    {
        if (!Auth::user()->hasPermission('production_labor.delete')) {
            abort(403);
        }

        $productionLabor->delete();
        return redirect()->route('production-labor.index')->with('success', 'Worker record deleted successfully');
    }
}
