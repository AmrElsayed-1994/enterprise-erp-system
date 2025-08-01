<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionLabor extends Model
{
    use HasFactory;

    protected $table = 'production_labor';

    protected $fillable = [
        'tender_id',
        'contractor_id',
        'worker_name',
        'worker_name_ar',
        'worker_id',
        'position',
        'position_ar',
        'skill_level',
        'skill_level_ar',
        'hourly_rate',
        'daily_rate',
        'monthly_rate',
        'currency',
        'start_date',
        'end_date',
        'status',
        'total_hours_worked',
        'total_days_worked',
        'productivity_score',
        'certifications',
        'certifications_ar',
        'safety_training',
        'safety_training_ar',
        'last_safety_training',
        'notes',
        'notes_ar',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'daily_rate' => 'decimal:2',
        'monthly_rate' => 'decimal:2',
        'productivity_score' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'last_safety_training' => 'date',
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
