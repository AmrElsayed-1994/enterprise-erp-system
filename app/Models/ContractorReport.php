<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorReport extends Model
{
    use HasFactory;

    protected $table = 'contractor_reports';

    protected $fillable = [
        'report_name',
        'report_name_ar',
        'report_type',
        'report_type_ar',
        'description',
        'description_ar',
        'filters',
        'columns',
        'format',
        'date_from',
        'date_to',
        'contractor_ids',
        'tender_ids',
        'status',
        'file_path',
        'file_size',
        'generated_at',
        'scheduled_at',
        'frequency',
        'is_automated',
        'email_recipients',
        'sql_query',
        'error_message',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'filters' => 'array',
        'columns' => 'array',
        'contractor_ids' => 'array',
        'tender_ids' => 'array',
        'email_recipients' => 'array',
        'date_from' => 'date',
        'date_to' => 'date',
        'generated_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'is_automated' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
