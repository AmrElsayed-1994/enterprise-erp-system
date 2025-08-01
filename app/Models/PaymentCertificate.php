<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_number',
        'tender_id',
        'contractor_id',
        'period_from',
        'period_to',
        'work_completed_value',
        'previous_payments',
        'current_payment',
        'retention_percentage',
        'retention_amount',
        'net_payment',
        'vat_percentage',
        'vat_amount',
        'total_payment',
        'status',
        'work_description',
        'work_description_ar',
        'notes',
        'notes_ar',
        'submission_date',
        'approval_date',
        'payment_date',
        'approved_by',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'work_completed_value' => 'decimal:2',
        'previous_payments' => 'decimal:2',
        'current_payment' => 'decimal:2',
        'retention_percentage' => 'decimal:2',
        'retention_amount' => 'decimal:2',
        'net_payment' => 'decimal:2',
        'vat_percentage' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'total_payment' => 'decimal:2',
        'period_from' => 'date',
        'period_to' => 'date',
        'submission_date' => 'date',
        'approval_date' => 'date',
        'payment_date' => 'date',
    ];

    public function tender()
    {
        return $this->belongsTo(ContractorTender::class, 'tender_id');
    }

    public function contractor()
    {
        return $this->belongsTo(User::class, 'contractor_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
