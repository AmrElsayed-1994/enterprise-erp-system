<?php

namespace App\Http\Controllers;

use App\Models\PaymentCertificate;
use App\Models\ContractorTender;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentCertificatesController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasPermission('payment_certificates.view')) {
            abort(403);
        }

        $certificates = PaymentCertificate::with(['tender', 'contractor', 'approver'])->paginate(15);
        return view('modules.payment-certificates.index', compact('certificates'));
    }

    public function dashboard()
    {
        if (!Auth::user()->hasPermission('payment_certificates.view')) {
            abort(403);
        }

        $totalCertificates = PaymentCertificate::count();
        $pendingApproval = PaymentCertificate::where('status', 'submitted')->count();
        $totalPayments = PaymentCertificate::where('status', 'paid')->sum('total_payment');
        $avgProcessingTime = 7;

        return view('modules.payment-certificates.dashboard', compact('totalCertificates', 'pendingApproval', 'totalPayments', 'avgProcessingTime'));
    }

    public function create()
    {
        if (!Auth::user()->hasPermission('payment_certificates.create')) {
            abort(403);
        }

        $tenders = ContractorTender::where('status', 'awarded')->get();
        $contractors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['contractor', 'admin', 'super_admin']);
        })->get();

        return view('modules.payment-certificates.create', compact('tenders', 'contractors'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermission('payment_certificates.create')) {
            abort(403);
        }

        $validated = $request->validate([
            'certificate_number' => 'required|unique:payment_certificates',
            'tender_id' => 'required|exists:contractor_tenders,id',
            'contractor_id' => 'required|exists:users,id',
            'period_from' => 'required|date',
            'period_to' => 'required|date|after:period_from',
            'work_completed_value' => 'required|numeric|min:0',
            'previous_payments' => 'required|numeric|min:0',
            'retention_percentage' => 'required|numeric|min:0|max:100',
            'vat_percentage' => 'required|numeric|min:0|max:100',
            'work_description' => 'required',
            'work_description_ar' => 'required',
            'notes' => 'nullable',
            'notes_ar' => 'nullable',
        ]);

        $currentPayment = $validated['work_completed_value'] - $validated['previous_payments'];
        $retentionAmount = $currentPayment * ($validated['retention_percentage'] / 100);
        $netPayment = $currentPayment - $retentionAmount;
        $vatAmount = $netPayment * ($validated['vat_percentage'] / 100);
        $totalPayment = $netPayment + $vatAmount;

        $validated['current_payment'] = $currentPayment;
        $validated['retention_amount'] = $retentionAmount;
        $validated['net_payment'] = $netPayment;
        $validated['vat_amount'] = $vatAmount;
        $validated['total_payment'] = $totalPayment;
        $validated['created_by'] = Auth::id();

        PaymentCertificate::create($validated);

        return redirect()->route('payment-certificates.index')->with('success', 'Payment certificate created successfully');
    }

    public function show(PaymentCertificate $paymentCertificate)
    {
        if (!Auth::user()->hasPermission('payment_certificates.view')) {
            abort(403);
        }

        return view('modules.payment-certificates.show', compact('paymentCertificate'));
    }

    public function edit(PaymentCertificate $paymentCertificate)
    {
        if (!Auth::user()->hasPermission('payment_certificates.edit')) {
            abort(403);
        }

        $tenders = ContractorTender::where('status', 'awarded')->get();
        $contractors = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['contractor', 'admin', 'super_admin']);
        })->get();

        return view('modules.payment-certificates.edit', compact('paymentCertificate', 'tenders', 'contractors'));
    }

    public function update(Request $request, PaymentCertificate $paymentCertificate)
    {
        if (!Auth::user()->hasPermission('payment_certificates.edit')) {
            abort(403);
        }

        $validated = $request->validate([
            'certificate_number' => 'required|unique:payment_certificates,certificate_number,' . $paymentCertificate->id,
            'tender_id' => 'required|exists:contractor_tenders,id',
            'contractor_id' => 'required|exists:users,id',
            'period_from' => 'required|date',
            'period_to' => 'required|date|after:period_from',
            'work_completed_value' => 'required|numeric|min:0',
            'previous_payments' => 'required|numeric|min:0',
            'retention_percentage' => 'required|numeric|min:0|max:100',
            'vat_percentage' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:draft,submitted,approved,paid,rejected',
            'work_description' => 'required',
            'work_description_ar' => 'required',
            'notes' => 'nullable',
            'notes_ar' => 'nullable',
        ]);

        $currentPayment = $validated['work_completed_value'] - $validated['previous_payments'];
        $retentionAmount = $currentPayment * ($validated['retention_percentage'] / 100);
        $netPayment = $currentPayment - $retentionAmount;
        $vatAmount = $netPayment * ($validated['vat_percentage'] / 100);
        $totalPayment = $netPayment + $vatAmount;

        $validated['current_payment'] = $currentPayment;
        $validated['retention_amount'] = $retentionAmount;
        $validated['net_payment'] = $netPayment;
        $validated['vat_amount'] = $vatAmount;
        $validated['total_payment'] = $totalPayment;
        $validated['updated_by'] = Auth::id();

        $paymentCertificate->update($validated);

        return redirect()->route('payment-certificates.index')->with('success', 'Payment certificate updated successfully');
    }

    public function destroy(PaymentCertificate $paymentCertificate)
    {
        if (!Auth::user()->hasPermission('payment_certificates.delete')) {
            abort(403);
        }

        $paymentCertificate->delete();
        return redirect()->route('payment-certificates.index')->with('success', 'Payment certificate deleted successfully');
    }
}
