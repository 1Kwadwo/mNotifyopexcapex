<?php

namespace App\Services;

use App\Models\PaymentRequest;
use App\Models\User;
use App\Models\Budget;
use Illuminate\Support\Facades\DB;
use NumberFormatter;

class PaymentRequestService
{
    public function __construct(
        protected BudgetService $budgetService,
        protected AuditService $auditService
    ) {}

    public function createDraft(User $user, array $data): PaymentRequest
    {
        return DB::transaction(function () use ($user, $data) {
            $data['requester_id'] = $user->id;
            $data['status'] = 'draft';
            $data['amount_in_words'] = $this->convertAmountToWords($data['amount']);
            
            $request = PaymentRequest::create($data);
            
            $this->auditService->log($request, 'created', $user);
            
            return $request;
        });
    }

    public function submitRequest(PaymentRequest $request, User $user): void
    {
        DB::transaction(function () use ($request, $user) {
            $budget = $request->budget;
            
            if (!$budget->hasAvailableAmount($request->amount)) {
                throw new \Exception('Insufficient budget available');
            }

            $this->budgetService->reserveAmount($budget, $request, $user);
            
            // If Finance Manager submits, skip FM approval and go straight to CEO
            if ($user->isFinanceManager()) {
                $status = 'approved_by_fm';
                $this->auditService->log($request, 'auto_approved_fm', $user);
            } else {
                $status = 'pending';
            }
            
            $request->update([
                'status' => $status,
                'submitted_at' => now(),
            ]);

            $this->auditService->log($request, 'submitted', $user);
        });
    }

    public function convertAmountToWords(float $amount): string
    {
        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        $words = ucfirst($formatter->format($amount));
        return $words . ' Dollars';
    }
}
