<?php

namespace App\Livewire\Budgets;

use App\Models\Budget;
use App\Models\Department;
use App\Models\Project;
use App\Models\CostCenter;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $type = 'OPEX';
    public $currency = 'GHS';
    public $period_start;
    public $period_end;
    public $total_amount = '';
    public $threshold_warning = 80;
    public $threshold_limit = 100;
    public $breakdown = '';
    public $department_name = '';
    public $cost_center_name = '';
    public $project_name = '';

    public function mount()
    {
        $this->period_start = now()->startOfMonth()->format('Y-m-d');
        $this->period_end = now()->endOfMonth()->format('Y-m-d');
    }

    public function saveDraft()
    {
        $this->save('draft');
    }

    public function submitToCEO()
    {
        $this->save('submit');
    }

    protected function save($action)
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:OPEX,CAPEX',
            'currency' => 'required|in:GHS,USD,EUR',
            'period_start' => 'required|date',
            'period_end' => 'required|date|after:period_start',
            'total_amount' => 'required|numeric|min:0',
            'threshold_warning' => 'required|integer|min:0|max:100',
            'threshold_limit' => 'required|integer|min:0|max:100',
        ]);

        $status = $action === 'submit' ? 'pending_ceo_approval' : 'draft';

        // Handle department - find or create
        $departmentId = null;
        if (!empty($this->department_name)) {
            $department = Department::firstOrCreate(
                ['name' => trim($this->department_name)],
                ['code' => strtoupper(substr(trim($this->department_name), 0, 3))]
            );
            $departmentId = $department->id;
        }

        // Handle cost center - find or create
        $costCenterId = null;
        if (!empty($this->cost_center_name)) {
            $costCenter = CostCenter::firstOrCreate(
                ['name' => trim($this->cost_center_name)],
                [
                    'code' => strtoupper(substr(trim($this->cost_center_name), 0, 3)),
                    'department_id' => $departmentId
                ]
            );
            $costCenterId = $costCenter->id;
        }

        // Handle project - find or create
        $projectId = null;
        if (!empty($this->project_name)) {
            $project = Project::firstOrCreate(
                ['name' => trim($this->project_name)],
                [
                    'code' => strtoupper(substr(trim($this->project_name), 0, 3)) . '-' . date('Y'),
                    'status' => 'active',
                    'start_date' => now(),
                    'end_date' => now()->addYear(),
                ]
            );
            $projectId = $project->id;
        }

        $budget = Budget::create([
            'name' => $this->name,
            'type' => $this->type,
            'currency' => $this->currency,
            'status' => $status,
            'period_start' => $this->period_start,
            'period_end' => $this->period_end,
            'total_amount' => $this->total_amount,
            'available_amount' => $this->total_amount,
            'committed_amount' => 0,
            'spent_amount' => 0,
            'threshold_warning' => $this->threshold_warning,
            'threshold_limit' => $this->threshold_limit,
            'breakdown' => $this->breakdown,
            'department_id' => $departmentId,
            'cost_center_id' => $costCenterId,
            'project_id' => $projectId,
            'created_by' => auth()->id(),
        ]);

        $message = $action === 'submit' 
            ? 'Budget submitted to CEO for approval!' 
            : 'Budget draft saved successfully!';

        session()->flash('message', $message);

        return redirect()->route('budgets.show', $budget);
    }

    public function render()
    {
        $departments = Department::all();
        $projects = Project::where('status', 'active')->get();
        $costCenters = CostCenter::all();

        return view('livewire.budgets.create', [
            'departments' => $departments,
            'projects' => $projects,
            'costCenters' => $costCenters,
        ])->layout('components.layouts.app', ['title' => 'Create Budget']);
    }
}
