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
                
            $recentRequests = PaymentRequest::where('requester_id', $user->id)
                ->latest()->take(5)->get();
        } else {
            $stats['total_requests'] = PaymentRequest::count();
            $stats['pending_requests'] = PaymentRequest::whereIn('status', ['pending', 'approved_by_fm'])->count();
            $stats['approved_requests'] = PaymentRequest::where('status', 'approved_by_ceo')->count();
            $stats['rejected_requests'] = PaymentRequest::where('status', 'rejected')->count();
            
            $recentRequests = PaymentRequest::latest()->take(5)->get();
        }

        $approvedBudgets = Budget::where('status', 'approved')->get();

        return view('livewire.dashboard', [
            'stats' => $stats,
            'recentRequests' => $recentRequests,
            'approvedBudgets' => $approvedBudgets,
        ])->layout('components.layouts.app', ['title' => 'Dashboard']);
    }
}
