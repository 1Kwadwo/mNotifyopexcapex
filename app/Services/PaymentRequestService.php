<?php

namespace App\Services;

use App\Models\PaymentRequest;
use App\Models\User;
use App\Models\Budget;
use App\Notifications\PaymentRequestNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
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
            
            // Auto-approval logic based on user role
            if ($user->isCEO()) {
                // CEO requests are automatically fully approved
                $status = 'approved_by_ceo';
                $this->auditService->log($request, 'auto_approved_ceo', $user);
                
                // Create approval records for both FM and CEO
                $request->approvals()->create([
                    'approver_id' => $user->id,
                    'role' => 'finance_manager',
                    'status' => 'approved',
                    'approved_at' => now(),
                    'comment' => 'Auto-approved (CEO request)',
                ]);
                
                $request->approvals()->create([
                    'approver_id' => $user->id,
                    'role' => 'ceo',
                    'status' => 'approved',
                    'approved_at' => now(),
                    'comment' => 'Auto-approved (CEO request)',
                ]);
            } elseif ($user->isFinanceManager()) {
                // Finance Manager submits, skip FM approval and go to approved_by_fm
                $status = 'approved_by_fm';
                $this->auditService->log($request, 'auto_approved_fm', $user);
                
                // Create FM approval record (auto-approved)
                $request->approvals()->create([
                    'approver_id' => $user->id,
                    'role' => 'finance_manager',
                    'status' => 'approved',
                    'approved_at' => now(),
                    'comment' => 'Auto-approved (FM request)',
                ]);
            } else {
                $status = 'pending';
            }
            
            $request->update([
                'status' => $status,
                'submitted_at' => now(),
            ]);

            $this->auditService->log($request, 'submitted', $user);
            
            // Send notifications to Finance Manager and CEO
            if (!$user->isCEO()) {
                $notifiableUsers = User::whereHas('roles', function($q) {
                    $q->whereIn('slug', ['finance_manager', 'ceo']);
                })->get();
                
                Notification::send($notifiableUsers, new PaymentRequestNotification($request, 'submitted'));
            }
        });
    }

    public function convertAmountToWords(float $amount): string
    {
        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        $words = ucfirst($formatter->format($amount));
        return $words . ' Dollars';
    }
}
