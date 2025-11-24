<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ApprovalService
{
    public function __construct(
        protected BudgetService $budgetService,
        protected AuditService $auditService
    ) {}

    public function approve(PaymentRequest $request, User $approver, ?string $comment = null): void
    {
        DB::transaction(function () use ($request, $approver, $comment) {
            $role = $this->determineApproverRole($approver);
            
            Approval::create([
                'payment_request_id' => $request->id,
                'approver_id' => $approver->id,
                'role' => $role,
                'status' => 'approved',
                'comment' => $comment,
                'approved_at' => now(),
            ]);

            if ($role === 'finance_manager') {
                $request->update(['status' => 'approved_by_fm']);
            } elseif ($role === 'ceo') {
                $request->update(['status' => 'approved_by_ceo']);
                $this->budgetService->commitAmount($request->budget, $request, $approver);
            }

            $this->auditService->log($request, 'approved_by_' . $role, $approver);
        });
    }

    public function reject(PaymentRequest $request, User $approver, string $reason): void
    {
        DB::transaction(function () use ($request, $approver, $reason) {
            $role = $this->determineApproverRole($approver);
            
            Approval::create([
                'payment_request_id' => $request->id,
                'approver_id' => $approver->id,
                'role' => $role,
                'status' => 'rejected',
                'comment' => $reason,
                'rejected_at' => now(),
            ]);

            $request->update(['status' => 'rejected']);
            
            $this->budgetService->releaseAmount($request->budget, $request, $approver);
            
            $this->auditService->log($request, 'rejected_by_' . $role, $approver);
        });
    }

    protected function determineApproverRole(User $user): string
    {
        if ($user->isCEO()) {
            return 'ceo';
        }
        return 'finance_manager';
    }
}
