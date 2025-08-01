<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorTender extends Model
{
    use HasFactory;

    protected $fillable = [
        'tender_number',
        'title',
        'title_ar',
        'description',
        'description_ar',
        'type',
        'estimated_value',
        'currency',
        'publication_date',
        'submission_deadline',
        'opening_date',
        'status',
        'requirements',
        'requirements_ar',
        'evaluation_criteria',
        'evaluation_criteria_ar',
        'awarded_to',
        'awarded_amount',
        'award_date',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'estimated_value' => 'decimal:2',
        'awarded_amount' => 'decimal:2',
        'publication_date' => 'date',
        'submission_deadline' => 'date',
        'opening_date' => 'date',
        'award_date' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function awardedContractor()
    {
        return $this->belongsTo(User::class, 'awarded_to');
    }

    public function paymentCertificates()
    {
        return $this->hasMany(PaymentCertificate::class, 'tender_id');
    }

    public function guarantees()
    {
        return $this->hasMany(Guarantee::class, 'tender_id');
    }

    public function productionLabor()
    {
        return $this->hasMany(ProductionLabor::class, 'tender_id');
    }

    public function changeOrders()
    {
        return $this->hasMany(ChangeOrder::class, 'tender_id');
    }

    public function monitoring()
    {
        return $this->hasMany(ContractorMonitoring::class, 'tender_id');
    }
}
