<?php

namespace App\Policies;

use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PaymentRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // All authenticated users can view
    }

    public function view(User $user, PaymentRequest $paymentRequest): bool
    {
        // Staff can only view their own, FM and CEO can view all
        return $user->isFinanceManager() || $user->isCEO() || $paymentRequest->requester_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true; // All authenticated users can create
    }

    public function update(User $user, PaymentRequest $paymentRequest): bool
    {
        // Only owner can update, and only if it's a draft
        return $paymentRequest->requester_id === $user->id && $paymentRequest->isDraft();
    }

    public function delete(User $user, PaymentRequest $paymentRequest): bool
    {
        // Only owner can delete drafts
        return $paymentRequest->requester_id === $user->id && $paymentRequest->isDraft();
    }

    public function approve(User $user, PaymentRequest $paymentRequest): bool
    {
        // FM can approve pending requests (but not their own)
        if ($user->isFinanceManager() && $paymentRequest->isPending()) {
            return $paymentRequest->requester_id !== $user->id;
        }
        
        // CEO can approve FM-approved requests (including their own if they submitted)
        if ($user->isCEO() && $paymentRequest->isApprovedByFM()) {
            return true;
        }
        
        return false;
    }

    public function reject(User $user, PaymentRequest $paymentRequest): bool
    {
        // FM can reject pending, CEO can reject FM-approved
        return $this->approve($user, $paymentRequest);
    }
}
