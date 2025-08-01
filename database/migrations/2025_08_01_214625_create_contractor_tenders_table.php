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
        Schema::create('contractor_tenders', function (Blueprint $table) {
            $table->id();
            $table->string('tender_number')->unique();
            $table->string('title');
            $table->string('title_ar');
            $table->text('description');
            $table->text('description_ar');
            $table->enum('type', ['public', 'private', 'limited']);
            $table->decimal('estimated_value', 15, 2);
            $table->string('currency', 3)->default('USD');
            $table->date('publication_date');
            $table->date('submission_deadline');
            $table->date('opening_date');
            $table->enum('status', ['draft', 'published', 'closed', 'awarded', 'cancelled'])->default('draft');
            $table->text('requirements')->nullable();
            $table->text('requirements_ar')->nullable();
            $table->text('evaluation_criteria')->nullable();
            $table->text('evaluation_criteria_ar')->nullable();
            $table->foreignId('awarded_to')->nullable()->constrained('users');
            $table->decimal('awarded_amount', 15, 2)->nullable();
            $table->date('award_date')->nullable();
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
        Schema::dropIfExists('contractor_tenders');
    }
};
