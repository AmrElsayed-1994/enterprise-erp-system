<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{
    use HasFactory;

    protected $fillable = [
        'guarantee_number',
        'tender_id',
        'contractor_id',
        'type',
        'type_ar',
        'amount',
        'currency',
        'percentage',
        'issuing_bank',
        'bank_reference',
        'issue_date',
        'expiry_date',
        'extension_date',
        'status',
        'terms_conditions',
        'terms_conditions_ar',
        'claim_details',
        'claim_details_ar',
        'claim_date',
        'claim_amount',
        'release_date',
        'notes',
        'notes_ar',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'percentage' => 'decimal:2',
        'claim_amount' => 'decimal:2',
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'extension_date' => 'date',
        'claim_date' => 'date',
        'release_date' => 'date',
    ];

    public function tender()
    {
        return $this->belongsTo(ContractorTender::class, 'tender_id');
    }

    public function contractor()
    {
        return $this->belongsTo(User::class, 'contractor_id');
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
