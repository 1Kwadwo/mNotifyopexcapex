<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\BudgetTransaction;
use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BudgetService
{
    public function reserveAmount(Budget $budget, PaymentRequest $request, User $user): void
    {
        DB::transaction(function () use ($budget, $request, $user) {
            $budget->available_amount -= $request->amount;
            $budget->save();

            BudgetTransaction::create([
                'budget_id' => $budget->id,
                'payment_request_id' => $request->id,
                'type' => 'reserve',
                'amount' => $request->amount,
                'balance_after' => $budget->available_amount,
                'created_by' => $user->id,
            ]);
        });
    }

    public function releaseAmount(Budget $budget, PaymentRequest $request, User $user): void
    {
        DB::transaction(function () use ($budget, $request, $user) {
            $budget->available_amount += $request->amount;
            $budget->save();

            BudgetTransaction::create([
                'budget_id' => $budget->id,
                'payment_request_id' => $request->id,
                'type' => 'release',
                'amount' => $request->amount,
                'balance_after' => $budget->available_amount,
                'created_by' => $user->id,
            ]);
        });
    }

    public function commitAmount(Budget $budget, PaymentRequest $request, User $user): void
    {
        DB::transaction(function () use ($budget, $request, $user) {
            $budget->committed_amount += $request->amount;
            $budget->spent_amount += $request->amount;
            $budget->save();

            BudgetTransaction::create([
                'budget_id' => $budget->id,
                'payment_request_id' => $request->id,
                'type' => 'commit',
                'amount' => $request->amount,
                'balance_after' => $budget->available_amount,
                'created_by' => $user->id,
            ]);
        });
    }
}
