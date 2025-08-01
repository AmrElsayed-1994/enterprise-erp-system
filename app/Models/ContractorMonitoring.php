<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorMonitoring extends Model
{
    use HasFactory;

    protected $table = 'contractor_monitoring';

    protected $fillable = [
        'tender_id',
        'contractor_id',
        'evaluation_date',
        'evaluation_period',
        'evaluation_period_ar',
        'quality_score',
        'schedule_performance_score',
        'cost_performance_score',
        'safety_score',
        'communication_score',
        'overall_score',
        'performance_rating',
        'performance_rating_ar',
        'quality_comments',
        'quality_comments_ar',
        'schedule_comments',
        'schedule_comments_ar',
        'cost_comments',
        'cost_comments_ar',
        'safety_comments',
        'safety_comments_ar',
        'communication_comments',
        'communication_comments_ar',
        'improvement_recommendations',
        'improvement_recommendations_ar',
        'corrective_actions',
        'corrective_actions_ar',
        'next_evaluation_date',
        'is_blacklisted',
        'blacklist_reason',
        'blacklist_reason_ar',
        'evaluated_by',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'quality_score' => 'decimal:2',
        'schedule_performance_score' => 'decimal:2',
        'cost_performance_score' => 'decimal:2',
        'safety_score' => 'decimal:2',
        'communication_score' => 'decimal:2',
        'overall_score' => 'decimal:2',
        'evaluation_date' => 'date',
        'next_evaluation_date' => 'date',
        'is_blacklisted' => 'boolean',
    ];

    public function tender()
    {
        return $this->belongsTo(ContractorTender::class, 'tender_id');
    }

    public function contractor()
    {
        return $this->belongsTo(User::class, 'contractor_id');
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluated_by');
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
