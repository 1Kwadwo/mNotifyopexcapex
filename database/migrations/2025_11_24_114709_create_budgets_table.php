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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['OPEX', 'CAPEX']);
            $table->enum('status', ['draft', 'pending_ceo_approval', 'approved', 'rejected'])->default('draft');
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('total_amount', 15, 2);
            $table->decimal('available_amount', 15, 2);
            $table->decimal('committed_amount', 15, 2)->default(0);
            $table->decimal('spent_amount', 15, 2)->default(0);
            $table->integer('threshold_warning')->default(80);
            $table->integer('threshold_limit')->default(100);
            $table->text('breakdown')->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('cost_center_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
