<?php

namespace App\Policies;

use App\Models\Budget;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BudgetPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // All can view budgets
    }

    public function view(User $user, Budget $budget): bool
    {
        return true; // All can view individual budgets
    }

    public function create(User $user): bool
    {
        return $user->isFinanceManager(); // Only FM can create budgets
    }

    public function update(User $user, Budget $budget): bool
    {
        // Only FM can update, and only drafts or rejected
        return $user->isFinanceManager() && in_array($budget->status, ['draft', 'rejected']);
    }

    public function delete(User $user, Budget $budget): bool
    {
        // Only FM can delete drafts or rejected budgets
        return $user->isFinanceManager() && in_array($budget->status, ['draft', 'rejected']);
    }

    public function approve(User $user, Budget $budget): bool
    {
        // Only CEO can approve budgets
        return $user->isCEO() && $budget->status === 'pending_ceo_approval';
    }
}
