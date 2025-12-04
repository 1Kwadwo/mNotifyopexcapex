<?php

namespace App\Livewire\PaymentRequests;

use App\Models\PaymentRequest;
use App\Services\ApprovalService;
use Livewire\Component;

class Show extends Component
{
    public PaymentRequest $paymentRequest;
    public $comment = '';
    public $rejectReason = '';
    public $showRejectModal = false;

    public function mount(PaymentRequest $paymentRequest)
    {
        $this->authorize('view', $paymentRequest);
        $this->paymentRequest = $paymentRequest->load(['requester', 'budget', 'lineItems', 'approvals.approver', 'comments.user', 'attachments']);
    }

    public function approve()
    {
        $this->authorize('approve', $this->paymentRequest);

        $service = app(ApprovalService::class);
        $service->approve($this->paymentRequest, auth()->user(), $this->comment);

        session()->flash('message', 'Payment request approved successfully!');
        $this->comment = '';
        $this->paymentRequest->refresh();
    }

    public function reject()
    {
        $this->authorize('reject', $this->paymentRequest);

        $this->validate([
            'rejectReason' => 'required|string|min:10',
        ]);

        $service = app(ApprovalService::class);
        $service->reject($this->paymentRequest, auth()->user(), $this->rejectReason);

        session()->flash('message', 'Payment request rejected.');
        $this->showRejectModal = false;
        $this->rejectReason = '';
        $this->paymentRequest->refresh();
    }

    public function render()
    {
        $canApprove = auth()->user()->can('approve', $this->paymentRequest);
        $canReject = auth()->user()->can('reject', $this->paymentRequest);

        return view('livewire.payment-requests.show', [
            'canApprove' => $canApprove,
            'canReject' => $canReject,
        ])->layout('components.layouts.app', ['title' => 'Payment Request #' . $this->paymentRequest->id]);
    }
}
