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
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('amount_in_words');
            $table->enum('status', ['draft', 'pending', 'approved_by_fm', 'approved_by_ceo', 'rejected', 'paid'])->default('draft');
            $table->enum('expense_type', ['OPEX', 'CAPEX']);
            $table->text('purpose');
            $table->string('prepared_by');
            $table->date('request_date');
            $table->string('vendor_name')->nullable();
            $table->json('vendor_details')->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('cost_center_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('budget_id')->constrained()->onDelete('restrict');
            $table->foreignId('requester_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_requests');
    }
};
