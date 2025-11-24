<div class="space-y-6">
    {{-- Stats Grid --}}
    <div class="grid gap-4 md:grid-cols-4">
        <div class="rounded-xl border-t-4 border-t-orange-500 bg-white p-6 shadow-sm">
            <div class="space-y-2">
                <div class="text-sm font-medium text-gray-600">Total Requests</div>
                <div class="text-3xl font-bold text-gray-900">{{ $stats['total_requests'] }}</div>
            </div>
        </div>
        
        <div class="rounded-xl border-t-4 border-t-orange-400 bg-white p-6 shadow-sm">
            <div class="space-y-2">
                <div class="text-sm font-medium text-gray-600">Pending</div>
                <div class="text-3xl font-bold text-orange-600">{{ $stats['pending_requests'] }}</div>
            </div>
        </div>
        
        <div class="rounded-xl border-t-4 border-t-orange-500 bg-white p-6 shadow-sm">
            <div class="space-y-2">
                <div class="text-sm font-medium text-gray-600">Approved</div>
                <div class="text-3xl font-bold text-orange-600">{{ $stats['approved_requests'] }}</div>
            </div>
        </div>
        
        <div class="rounded-xl border-t-4 border-t-gray-300 bg-white p-6 shadow-sm">
            <div class="space-y-2">
                <div class="text-sm font-medium text-gray-600">Rejected</div>
                <div class="text-3xl font-bold text-gray-500">{{ $stats['rejected_requests'] }}</div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="rounded-xl bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
            <div class="flex gap-2">
                <flux:button href="{{ route('payment-requests.create') }}" variant="primary">
                    New Payment Request
                </flux:button>
                @if(auth()->user()->isFinanceManager())
                    <flux:button href="{{ route('budgets.create') }}" variant="outline">
                        Create Budget
                    </flux:button>
                @endif
            </div>
        </div>
    </div>

    {{-- Recent Requests --}}
    <div class="rounded-xl bg-white p-6 shadow-sm">
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-900">Recent Payment Requests</h2>
            
            @if($recentRequests->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Title</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Amount</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRequests as $request)
                                <tr class="border-b border-gray-100 hover:bg-orange-50 transition-colors">
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">#{{ $request->id }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $request->title }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">${{ number_format($request->amount, 2) }}</td>
                                    <td class="px-4 py-3">
                                        @if($request->status === 'approved_by_ceo')
                                            <span class="inline-flex items-center rounded-full bg-orange-100 px-3 py-1 text-xs font-medium text-orange-800">
                                                Approved by CEO
                                            </span>
                                        @elseif($request->status === 'approved_by_fm')
                                            <span class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1 text-xs font-medium text-orange-700">
                                                Approved by FM
                                            </span>
                                        @elseif($request->status === 'pending')
                                            <span class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1 text-xs font-medium text-orange-600">
                                                Pending
                                            </span>
                                        @elseif($request->status === 'rejected')
                                            <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                                Rejected
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                                                {{ str_replace('_', ' ', ucfirst($request->status)) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $request->created_at->format('M d, Y') }}</td>
                                    <td class="px-4 py-3">
                                        <flux:button href="{{ route('payment-requests.show', $request) }}" size="sm" variant="outline">
                                            View
                                        </flux:button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-600">No payment requests yet.</p>
            @endif
            
            <div class="text-center">
                <flux:button href="{{ route('payment-requests.index') }}" variant="outline">
                    View All Requests
                </flux:button>
            </div>
        </div>
    </div>

    {{-- Budgets Overview --}}
    <div class="rounded-xl bg-white p-6 shadow-sm">
        <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-900">Active Budgets</h2>
            
            @if($approvedBudgets->count() > 0)
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($approvedBudgets as $budget)
                        <div class="rounded-lg border border-gray-200 bg-gradient-to-br from-white to-orange-50 p-5 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $budget->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $budget->type }}</p>
                                </div>
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $budget->utilizationPercentage() > 80 ? 'bg-red-100 text-red-800' : 'bg-orange-100 text-orange-800' }}">
                                    {{ number_format($budget->utilizationPercentage(), 1) }}% Used
                                </span>
                            </div>
                            <div class="mt-4">
                                <div class="mb-2 flex justify-between text-sm">
                                    <span class="text-gray-600">Available: <span class="font-semibold text-gray-900">${{ number_format($budget->available_amount, 2) }}</span></span>
                                    <span class="text-gray-600">Total: <span class="font-semibold text-gray-900">${{ number_format($budget->total_amount, 2) }}</span></span>
                                </div>
                                <div class="h-2.5 w-full overflow-hidden rounded-full bg-gray-200">
                                    <div class="h-full transition-all {{ $budget->utilizationPercentage() > 80 ? 'bg-red-500' : 'bg-gradient-to-r from-orange-500 to-orange-600' }}" 
                                         style="width: {{ min($budget->utilizationPercentage(), 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600">No active budgets.</p>
            @endif
            
            <div class="text-center">
                <flux:button href="{{ route('budgets.index') }}" variant="outline">
                    View All Budgets
                </flux:button>
            </div>
        </div>
    </div>
</div>
