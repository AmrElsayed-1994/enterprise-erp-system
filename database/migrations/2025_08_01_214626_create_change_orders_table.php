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
        Schema::create('change_orders', function (Blueprint $table) {
            $table->id();
            $table->string('change_order_number')->unique();
            $table->foreignId('tender_id')->constrained('contractor_tenders');
            $table->foreignId('contractor_id')->constrained('users');
            $table->enum('type', ['change_order', 'variation_order', 'claim', 'dispute']);
            $table->string('type_ar');
            $table->string('title');
            $table->string('title_ar');
            $table->text('description');
            $table->text('description_ar');
            $table->text('justification');
            $table->text('justification_ar');
            $table->decimal('original_amount', 15, 2);
            $table->decimal('change_amount', 15, 2);
            $table->decimal('new_total_amount', 15, 2);
            $table->string('currency', 3)->default('USD');
            $table->integer('time_extension_days')->default(0);
            $table->date('original_completion_date');
            $table->date('new_completion_date')->nullable();
            $table->enum('status', ['draft', 'submitted', 'under_review', 'approved', 'rejected', 'disputed'])->default('draft');
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->text('impact_analysis')->nullable();
            $table->text('impact_analysis_ar')->nullable();
            $table->text('supporting_documents')->nullable();
            $table->date('submission_date')->nullable();
            $table->date('review_date')->nullable();
            $table->date('approval_date')->nullable();
            $table->text('review_comments')->nullable();
            $table->text('review_comments_ar')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
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
        Schema::dropIfExists('change_orders');
    }
};
