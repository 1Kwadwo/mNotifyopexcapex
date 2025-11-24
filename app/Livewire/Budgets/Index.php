<?php

namespace App\Livewire\Budgets;

use App\Models\Budget;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $statusFilter = 'all';

    public function render()
    {
        $query = Budget::with(['creator', 'department']);

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $budgets = $query->latest()->paginate(15);

        return view('livewire.budgets.index', [
            'budgets' => $budgets,
        ])->layout('components.layouts.app', ['title' => 'Budgets']);
    }
}
