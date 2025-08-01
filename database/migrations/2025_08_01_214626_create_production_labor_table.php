<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('production_labor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained('contractor_tenders');
            $table->foreignId('contractor_id')->constrained('users');
            $table->string('worker_name');
            $table->string('worker_name_ar');
            $table->string('worker_id')->unique();
            $table->string('position');
            $table->string('position_ar');
            $table->enum('skill_level', ['unskilled', 'semi_skilled', 'skilled', 'highly_skilled', 'supervisor']);
            $table->string('skill_level_ar');
            $table->decimal('hourly_rate', 8, 2);
            $table->decimal('daily_rate', 8, 2);
            $table->decimal('monthly_rate', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'inactive', 'terminated', 'on_leave'])->default('active');
            $table->integer('total_hours_worked')->default(0);
            $table->integer('total_days_worked')->default(0);
            $table->decimal('productivity_score', 5, 2)->nullable();
            $table->text('certifications')->nullable();
            $table->text('certifications_ar')->nullable();
            $table->text('safety_training')->nullable();
            $table->text('safety_training_ar')->nullable();
            $table->date('last_safety_training')->nullable();
            $table->text('notes')->nullable();
            $table->text('notes_ar')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_labor');
    }
};
