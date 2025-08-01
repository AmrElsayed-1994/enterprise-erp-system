<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'change_order_number',
        'tender_id',
        'contractor_id',
        'type',
        'type_ar',
        'title',
        'title_ar',
        'description',
        'description_ar',
        'justification',
        'justification_ar',
        'original_amount',
        'change_amount',
        'new_total_amount',
        'currency',
        'time_extension_days',
        'original_completion_date',
        'new_completion_date',
        'status',
        'priority',
        'impact_analysis',
        'impact_analysis_ar',
        'supporting_documents',
        'submission_date',
        'review_date',
        'approval_date',
        'review_comments',
        'review_comments_ar',
        'reviewed_by',
        'approved_by',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'original_amount' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'new_total_amount' => 'decimal:2',
        'original_completion_date' => 'date',
        'new_completion_date' => 'date',
        'submission_date' => 'date',
        'review_date' => 'date',
        'approval_date' => 'date',
    ];

    public function tender()
    {
        return $this->belongsTo(ContractorTender::class, 'tender_id');
    }

    public function contractor()
    {
        return $this->belongsTo(User::class, 'contractor_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
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
