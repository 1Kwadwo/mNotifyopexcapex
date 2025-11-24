<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\Department;
use App\Models\Project;
use App\Models\CostCenter;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create Departments
        $it = Department::create(['name' => 'IT Department', 'code' => 'IT']);
        $hr = Department::create(['name' => 'Human Resources', 'code' => 'HR']);
        $finance = Department::create(['name' => 'Finance', 'code' => 'FIN']);

        // Create Cost Centers
        CostCenter::create(['name' => 'IT Operations', 'code' => 'IT-OPS', 'department_id' => $it->id]);
        CostCenter::create(['name' => 'HR Admin', 'code' => 'HR-ADM', 'department_id' => $hr->id]);

        // Create Projects
        Project::create([
            'name' => 'Digital Transformation',
            'code' => 'DT-2025',
            'description' => 'Company-wide digital transformation initiative',
            'start_date' => now(),
            'end_date' => now()->addYear(),
            'status' => 'active',
        ]);

        // Create Budgets
        $fm = User::whereHas('roles', fn($q) => $q->where('slug', 'finance_manager'))->first();

        Budget::create([
            'name' => 'Q1 2025 OPEX Budget',
            'type' => 'OPEX',
            'status' => 'approved',
            'period_start' => now()->startOfQuarter(),
            'period_end' => now()->endOfQuarter(),
            'total_amount' => 100000,
            'available_amount' => 100000,
            'committed_amount' => 0,
            'spent_amount' => 0,
            'threshold_warning' => 80,
            'threshold_limit' => 100,
            'breakdown' => 'Quarterly operational expenses including software licenses, office supplies, and utilities.',
            'department_id' => $it->id,
            'created_by' => $fm->id,
        ]);

        Budget::create([
            'name' => '2025 CAPEX Budget',
            'type' => 'CAPEX',
            'status' => 'approved',
            'period_start' => now()->startOfYear(),
            'period_end' => now()->endOfYear(),
            'total_amount' => 500000,
            'available_amount' => 500000,
            'committed_amount' => 0,
            'spent_amount' => 0,
            'threshold_warning' => 80,
            'threshold_limit' => 100,
            'breakdown' => 'Annual capital expenditure for equipment, infrastructure, and major software purchases.',
            'created_by' => $fm->id,
        ]);
    }
}
