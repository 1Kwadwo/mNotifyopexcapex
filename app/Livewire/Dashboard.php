<?php

namespace App\Livewire;

use App\Models\PaymentRequest;
use App\Models\Budget;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        
        $stats = [
            'total_requests' => 0,
            'pending_requests' => 0,
            'approved_requests' => 0,
            'rejected_requests' => 0,
        ];

        if ($user->isStaff()) {
            $stats['total_requests'] = PaymentRequest::where('requester_id', $user->id)->count();
            $stats['pending_requests'] = PaymentRequest::where('requester_id', $user->id)
                ->whereIn('status', ['pending', 'approved_by_fm'])->count();
            $stats['approved_requests'] = PaymentRequest::where('requester_id', $user->id)
                ->where('status', 'approved_by_ceo')->count();
            $stats['rejected_requests'] = PaymentRequest::where('requester_id', $user->id)
                ->where('status', 'rejected')->count();
                
            $recentRequests = PaymentRequest::with('requester')
                ->where('requester_id', $user->id)
                ->latest()->take(5)->get();
                
            $opexCapexStats = null;
            $monthlyStats = null;
            $budgetBreakdown = null;
        } else {
            $stats['total_requests'] = PaymentRequest::count();
            $stats['pending_requests'] = PaymentRequest::whereIn('status', ['pending', 'approved_by_fm'])->count();
            $stats['approved_requests'] = PaymentRequest::where('status', 'approved_by_ceo')->count();
            $stats['rejected_requests'] = PaymentRequest::where('status', 'rejected')->count();
            
            $recentRequests = PaymentRequest::with('requester')
                ->latest()->take(5)->get();
                
            // OPEX/CAPEX Statistics
            $opexCapexStats = [
                'opex_count' => PaymentRequest::where('expense_type', 'OPEX')->count(),
                'opex_amount' => PaymentRequest::where('expense_type', 'OPEX')->sum('amount'),
                'capex_count' => PaymentRequest::where('expense_type', 'CAPEX')->count(),
                'capex_amount' => PaymentRequest::where('expense_type', 'CAPEX')->sum('amount'),
            ];
            
            // Monthly breakdown for current year
            $monthlyStats = [];
            for ($month = 1; $month <= 12; $month++) {
                $monthlyStats[$month] = [
                    'opex_count' => PaymentRequest::where('expense_type', 'OPEX')
                        ->whereYear('created_at', now()->year)
                        ->whereMonth('created_at', $month)
                        ->count(),
                    'opex_amount' => PaymentRequest::where('expense_type', 'OPEX')
                        ->whereYear('created_at', now()->year)
                        ->whereMonth('created_at', $month)
                        ->sum('amount'),
                    'capex_count' => PaymentRequest::where('expense_type', 'CAPEX')
                        ->whereYear('created_at', now()->year)
                        ->whereMonth('created_at', $month)
                        ->count(),
                    'capex_amount' => PaymentRequest::where('expense_type', 'CAPEX')
                        ->whereYear('created_at', now()->year)
                        ->whereMonth('created_at', $month)
                        ->sum('amount'),
                ];
            }
            
            // Per-budget breakdown
            $budgetBreakdown = Budget::where('status', 'approved')->get()->map(function ($budget) {
                return [
                    'budget' => $budget,
                    'opex_count' => PaymentRequest::where('budget_id', $budget->id)
                        ->where('expense_type', 'OPEX')->count(),
                    'opex_amount' => PaymentRequest::where('budget_id', $budget->id)
                        ->where('expense_type', 'OPEX')->sum('amount'),
                    'capex_count' => PaymentRequest::where('budget_id', $budget->id)
                        ->where('expense_type', 'CAPEX')->count(),
                    'capex_amount' => PaymentRequest::where('budget_id', $budget->id)
                        ->where('expense_type', 'CAPEX')->sum('amount'),
                ];
            });
        }

        $approvedBudgets = Budget::where('status', 'approved')->get();

        return view('livewire.dashboard', [
            'stats' => $stats,
            'recentRequests' => $recentRequests,
            'approvedBudgets' => $approvedBudgets,
            'opexCapexStats' => $opexCapexStats,
            'monthlyStats' => $monthlyStats,
            'budgetBreakdown' => $budgetBreakdown,
        ])->layout('components.layouts.app', ['title' => 'Dashboard']);
    }
}
