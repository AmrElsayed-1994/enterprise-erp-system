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
        Schema::create('contractor_monitoring', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tender_id')->constrained('contractor_tenders');
            $table->foreignId('contractor_id')->constrained('users');
            $table->date('evaluation_date');
            $table->string('evaluation_period');
            $table->string('evaluation_period_ar');
            $table->decimal('quality_score', 5, 2)->default(0);
            $table->decimal('schedule_performance_score', 5, 2)->default(0);
            $table->decimal('cost_performance_score', 5, 2)->default(0);
            $table->decimal('safety_score', 5, 2)->default(0);
            $table->decimal('communication_score', 5, 2)->default(0);
            $table->decimal('overall_score', 5, 2)->default(0);
            $table->enum('performance_rating', ['excellent', 'good', 'satisfactory', 'needs_improvement', 'poor']);
            $table->string('performance_rating_ar');
            $table->text('quality_comments')->nullable();
            $table->text('quality_comments_ar')->nullable();
            $table->text('schedule_comments')->nullable();
            $table->text('schedule_comments_ar')->nullable();
            $table->text('cost_comments')->nullable();
            $table->text('cost_comments_ar')->nullable();
            $table->text('safety_comments')->nullable();
            $table->text('safety_comments_ar')->nullable();
            $table->text('communication_comments')->nullable();
            $table->text('communication_comments_ar')->nullable();
            $table->text('improvement_recommendations')->nullable();
            $table->text('improvement_recommendations_ar')->nullable();
            $table->text('corrective_actions')->nullable();
            $table->text('corrective_actions_ar')->nullable();
            $table->date('next_evaluation_date')->nullable();
            $table->boolean('is_blacklisted')->default(false);
            $table->text('blacklist_reason')->nullable();
            $table->text('blacklist_reason_ar')->nullable();
            $table->foreignId('evaluated_by')->constrained('users');
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
        Schema::dropIfExists('contractor_monitoring');
    }
};
