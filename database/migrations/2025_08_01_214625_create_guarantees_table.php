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
        Schema::create('guarantees', function (Blueprint $table) {
            $table->id();
            $table->string('guarantee_number')->unique();
            $table->foreignId('tender_id')->constrained('contractor_tenders');
            $table->foreignId('contractor_id')->constrained('users');
            $table->enum('type', ['bid_bond', 'performance_bond', 'advance_payment', 'warranty', 'retention']);
            $table->string('type_ar');
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('USD');
            $table->decimal('percentage', 5, 2)->nullable();
            $table->string('issuing_bank');
            $table->string('bank_reference');
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->date('extension_date')->nullable();
            $table->enum('status', ['active', 'expired', 'claimed', 'released', 'extended'])->default('active');
            $table->text('terms_conditions')->nullable();
            $table->text('terms_conditions_ar')->nullable();
            $table->text('claim_details')->nullable();
            $table->text('claim_details_ar')->nullable();
            $table->date('claim_date')->nullable();
            $table->decimal('claim_amount', 15, 2)->nullable();
            $table->date('release_date')->nullable();
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
        Schema::dropIfExists('guarantees');
    }
};
