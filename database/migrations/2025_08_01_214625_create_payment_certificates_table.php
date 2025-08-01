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
        Schema::create('payment_certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_number')->unique();
            $table->foreignId('tender_id')->constrained('contractor_tenders');
            $table->foreignId('contractor_id')->constrained('users');
            $table->date('period_from');
            $table->date('period_to');
            $table->decimal('work_completed_value', 15, 2);
            $table->decimal('previous_payments', 15, 2)->default(0);
            $table->decimal('current_payment', 15, 2);
            $table->decimal('retention_percentage', 5, 2)->default(10);
            $table->decimal('retention_amount', 15, 2);
            $table->decimal('net_payment', 15, 2);
            $table->decimal('vat_percentage', 5, 2)->default(0);
            $table->decimal('vat_amount', 15, 2)->default(0);
            $table->decimal('total_payment', 15, 2);
            $table->enum('status', ['draft', 'submitted', 'approved', 'paid', 'rejected'])->default('draft');
            $table->text('work_description');
            $table->text('work_description_ar');
            $table->text('notes')->nullable();
            $table->text('notes_ar')->nullable();
            $table->date('submission_date')->nullable();
            $table->date('approval_date')->nullable();
            $table->date('payment_date')->nullable();
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
        Schema::dropIfExists('payment_certificates');
    }
};
