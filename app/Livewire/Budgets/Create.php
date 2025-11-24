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
    public $period_start;
    public $period_end;
    public $total_amount = '';
    public $threshold_warning = 80;
    public $threshold_limit = 100;
    public $breakdown = '';
    public $department_id = '';
    public $cost_center_id = '';
    public $project_id = '';

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
            'period_start' => 'required|date',
            'period_end' => 'required|date|after:period_start',
            'total_amount' => 'required|numeric|min:0',
            'threshold_warning' => 'required|integer|min:0|max:100',
            'threshold_limit' => 'required|integer|min:0|max:100',
        ]);

        $status = $action === 'submit' ? 'pending_ceo_approval' : 'draft';

        $budget = Budget::create([
            'name' => $this->name,
            'type' => $this->type,
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
            'department_id' => $this->department_id ?: null,
            'cost_center_id' => $this->cost_center_id ?: null,
            'project_id' => $this->project_id ?: null,
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
