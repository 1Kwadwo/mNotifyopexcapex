<?php

namespace App\Livewire\Budgets;

use App\Models\Budget;
use Livewire\Component;

class Show extends Component
{
    public Budget $budget;
    public $comment = '';

    public function mount(Budget $budget)
    {
        $this->budget = $budget->load(['creator', 'department', 'project', 'costCenter', 'paymentRequests.requester', 'transactions']);
    }

    public function approve()
    {
        $this->authorize('approve', $this->budget);

        $this->budget->update(['status' => 'approved']);

        session()->flash('message', 'Budget approved successfully!');
        $this->budget->refresh();
    }

    public function reject()
    {
        $this->authorize('approve', $this->budget);

        $this->budget->update(['status' => 'rejected']);

        session()->flash('message', 'Budget rejected.');
        $this->budget->refresh();
    }

    public function render()
    {
        $canApprove = auth()->user()->can('approve', $this->budget);

        // Calculate analytics data
        $analytics = [
            'total_requests' => $this->budget->paymentRequests->count(),
            'approved_requests' => $this->budget->paymentRequests->where('status', 'approved_by_ceo')->count(),
            'pending_requests' => $this->budget->paymentRequests->whereIn('status', ['pending', 'approved_by_fm'])->count(),
            'rejected_requests' => $this->budget->paymentRequests->where('status', 'rejected')->count(),
            'total_spent' => $this->budget->spent_amount,
            'total_committed' => $this->budget->committed_amount,
            'total_available' => $this->budget->available_amount,
            'utilization_percentage' => $this->budget->utilizationPercentage(),
            'average_request_amount' => $this->budget->paymentRequests->count() > 0 
                ? $this->budget->paymentRequests->avg('amount') 
                : 0,
            'largest_request' => $this->budget->paymentRequests->max('amount') ?? 0,
            'smallest_request' => $this->budget->paymentRequests->min('amount') ?? 0,
        ];

        // Monthly spending trend
        $monthlySpending = $this->budget->paymentRequests()
            ->where('status', 'approved_by_ceo')
            ->selectRaw('strftime("%Y-%m", submitted_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Status breakdown
        $statusBreakdown = $this->budget->paymentRequests()
            ->selectRaw('status, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('status')
            ->get();

        return view('livewire.budgets.show', [
            'canApprove' => $canApprove,
            'analytics' => $analytics,
            'monthlySpending' => $monthlySpending,
            'statusBreakdown' => $statusBreakdown,
        ])->layout('components.layouts.app', ['title' => 'Budget: ' . $this->budget->name]);
    }
}
