<?php

namespace App\Livewire\PaymentRequests;

use App\Models\PaymentRequest;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $statusFilter = 'all';

    public function render()
    {
        $query = PaymentRequest::with(['requester', 'budget']);

        // Filter by user role
        if (auth()->user()->isStaff()) {
            $query->where('requester_id', auth()->id());
        }

        // Filter by status
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        $requests = $query->latest()->paginate(15);

        return view('livewire.payment-requests.index', [
            'requests' => $requests,
        ])->layout('components.layouts.app', ['title' => 'Payment Requests']);
    }
}
