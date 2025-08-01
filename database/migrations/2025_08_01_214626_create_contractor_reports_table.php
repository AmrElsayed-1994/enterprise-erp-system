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
        Schema::create('contractor_reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_name');
            $table->string('report_name_ar');
            $table->enum('report_type', ['tender_summary', 'payment_summary', 'performance_report', 'guarantee_status', 'labor_productivity', 'change_orders_summary', 'financial_analysis', 'custom']);
            $table->string('report_type_ar');
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();
            $table->json('filters')->nullable();
            $table->json('columns')->nullable();
            $table->enum('format', ['pdf', 'excel', 'csv', 'html'])->default('pdf');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->json('contractor_ids')->nullable();
            $table->json('tender_ids')->nullable();
            $table->enum('status', ['draft', 'generated', 'scheduled', 'failed'])->default('draft');
            $table->string('file_path')->nullable();
            $table->integer('file_size')->nullable();
            $table->timestamp('generated_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();
            $table->enum('frequency', ['once', 'daily', 'weekly', 'monthly', 'quarterly', 'yearly'])->default('once');
            $table->boolean('is_automated')->default(false);
            $table->json('email_recipients')->nullable();
            $table->text('sql_query')->nullable();
            $table->text('error_message')->nullable();
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
        Schema::dropIfExists('contractor_reports');
    }
};
