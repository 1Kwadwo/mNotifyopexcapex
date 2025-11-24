<div class="mx-auto max-w-4xl space-y-6">
    @if (session()->has('message'))
        <div class="rounded-lg border-l-4 border-orange-500 bg-orange-50 p-4 text-orange-800">
            {{ session('message') }}
        </div>
    @endif
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">{{ $budget->name }}</h1>
        <flux:button href="{{ route('budgets.index') }}" variant="outline">
            Back to List
        </flux:button>
    </div>
    {{-- Status and Actions --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-500">Status</div>
                <span class="mt-1 inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ match($budget->status) {
                    'draft' => 'bg-gray-100 text-gray-700',
                    'pending_ceo_approval' => 'bg-orange-100 text-orange-700',
                    'approved' => 'bg-orange-100 text-orange-700',
                    'rejected' => 'bg-red-100 text-red-700',
                    default => 'bg-gray-100 text-gray-700'
                } }}">
                    {{ str_replace('_', ' ', ucfirst($budget->status)) }}
                </span>
            </div>
            @if($canApprove && $budget->status === 'pending_ceo_approval')
                <div class="flex gap-2">
                    <flux:button wire:click="approve" variant="primary">
                        Approve Budget
                    </flux:button>
                    <flux:button wire:click="reject" variant="danger">
                        Reject Budget
                    </flux:button>
                </div>
            @endif
        </div>
    </div>
    {{-- Budget Overview --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="mb-4 text-lg font-semibold text-gray-900">Budget Overview</h2>
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <div class="text-sm text-gray-500">Type</div>
                <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold bg-orange-100 text-orange-700">
                    {{ $budget->type }}
                </span>
            </div>
            <div>
                <div class="text-sm text-gray-500">Period</div>
                <div class="font-medium text-gray-900">{{ $budget->period_start->format('M d, Y') }} - {{ $budget->period_end->format('M d, Y') }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Created By</div>
                <div class="font-medium text-gray-900">{{ $budget->creator->name }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Created On</div>
                <div class="font-medium text-gray-900">{{ $budget->created_at->format('M d, Y') }}</div>
            </div>
            @if($budget->department)
                <div>
                    <div class="text-sm text-gray-500">Department</div>
                    <div class="font-medium text-gray-900">{{ $budget->department->name }}</div>
                </div>
            @endif
            @if($budget->project)
                <div>
                    <div class="text-sm text-gray-500">Project</div>
                    <div class="font-medium text-gray-900">{{ $budget->project->name }}</div>
                </div>
            @endif
        </div>
    </div>
    {{-- Financial Summary --}}
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="mb-4 text-lg font-semibold text-gray-900">Financial Summary</h2>
        
        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                <div class="text-sm text-gray-500">Total Budget</div>
                <div class="text-2xl font-bold text-gray-900">${{ number_format($budget->total_amount, 2) }}</div>
            </div>
            <div class="rounded-lg border border-orange-200 bg-gradient-to-br from-white to-orange-50 p-4 shadow-sm">
                <div class="text-sm text-gray-500">Available</div>
                <div class="text-2xl font-bold text-orange-600">${{ number_format($budget->available_amount, 2) }}</div>
            </div>
            <div class="rounded-lg border border-orange-200 bg-gradient-to-br from-white to-orange-50 p-4 shadow-sm">
                <div class="text-sm text-gray-500">Committed</div>
                <div class="text-2xl font-bold text-orange-600">${{ number_format($budget->committed_amount, 2) }}</div>
            </div>
            <div class="rounded-lg border border-orange-200 bg-gradient-to-br from-white to-orange-50 p-4 shadow-sm">
                <div class="text-sm text-gray-500">Spent</div>
                <div class="text-2xl font-bold text-orange-600">${{ number_format($budget->spent_amount, 2) }}</div>
            </div>
        </div>
        @if($budget->isApproved())
            <div class="mt-6">
                <div class="mb-2 flex justify-between text-sm text-gray-600">
                    <span>Utilization: {{ number_format($budget->utilizationPercentage(), 1) }}%</span>
                    <span>Warning: {{ $budget->threshold_warning }}% | Limit: {{ $budget->threshold_limit }}%</span>
                </div>
                <div class="h-4 w-full overflow-hidden rounded-full bg-gray-200">
                    <div class="h-full {{ $budget->utilizationPercentage() > $budget->threshold_warning ? 'bg-red-500' : 'bg-orange-500' }}" 
                         style="width: {{ min($budget->utilizationPercentage(), 100) }}%"></div>
                </div>
            </div>
        @endif
    </div>
    {{-- Analytics Section (CEO & Finance Manager Only) --}}
    @if(auth()->user()->isCEO() || auth()->user()->isFinanceManager())
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="mb-6 flex items-center gap-2">
                <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <h2 class="text-lg font-semibold text-gray-900">Budget Analytics</h2>
            </div>
            
            {{-- Key Metrics --}}
            <div class="mb-6 grid gap-4 md:grid-cols-4">
                <div class="rounded-lg border border-orange-200 bg-gradient-to-br from-white to-orange-50 p-4 shadow-sm">
                    <div class="text-sm text-gray-600">Total Requests</div>
                    <div class="text-3xl font-bold text-orange-600">{{ $analytics['total_requests'] }}</div>
                </div>
                <div class="rounded-lg border border-orange-200 bg-gradient-to-br from-white to-orange-50 p-4 shadow-sm">
                    <div class="text-sm text-gray-600">Approved</div>
                    <div class="text-3xl font-bold text-orange-600">{{ $analytics['approved_requests'] }}</div>
                </div>
                <div class="rounded-lg border border-orange-200 bg-gradient-to-br from-white to-orange-50 p-4 shadow-sm">
                    <div class="text-sm text-gray-600">Pending</div>
                    <div class="text-3xl font-bold text-orange-600">{{ $analytics['pending_requests'] }}</div>
                </div>
                <div class="rounded-lg border border-red-200 bg-gradient-to-br from-white to-red-50 p-4 shadow-sm">
                    <div class="text-sm text-gray-600">Rejected</div>
                    <div class="text-3xl font-bold text-red-600">{{ $analytics['rejected_requests'] }}</div>
                </div>
            </div>

            {{-- Budget Utilization Chart --}}
            <div class="mb-6">
                <h3 class="mb-4 font-semibold text-gray-900">Budget Utilization Breakdown</h3>
                <div class="space-y-4">
                    {{-- Available --}}
                    <div>
                        <div class="mb-2 flex justify-between text-sm">
                            <span class="font-medium text-orange-600">Available</span>
                            <span class="font-bold text-gray-900">${{ number_format($analytics['total_available'], 2) }} ({{ number_format(($analytics['total_available'] / $budget->total_amount) * 100, 1) }}%)</span>
                        </div>
                        <div class="h-8 w-full overflow-hidden rounded-lg bg-gray-200">
                            <div class="h-full bg-orange-500" style="width: {{ ($analytics['total_available'] / $budget->total_amount) * 100 }}%"></div>
                        </div>
                    </div>
                    {{-- Committed --}}
                    <div>
                        <div class="mb-2 flex justify-between text-sm">
                            <span class="font-medium text-orange-600">Committed</span>
                            <span class="font-bold text-gray-900">${{ number_format($analytics['total_committed'], 2) }} ({{ number_format(($analytics['total_committed'] / $budget->total_amount) * 100, 1) }}%)</span>
                        </div>
                        <div class="h-8 w-full overflow-hidden rounded-lg bg-gray-200">
                            <div class="h-full bg-orange-500" style="width: {{ ($analytics['total_committed'] / $budget->total_amount) * 100 }}%"></div>
                        </div>
                    </div>
                    {{-- Spent --}}
                    <div>
                        <div class="mb-2 flex justify-between text-sm">
                            <span class="font-medium text-orange-600">Spent</span>
                            <span class="font-bold text-gray-900">${{ number_format($analytics['total_spent'], 2) }} ({{ number_format(($analytics['total_spent'] / $budget->total_amount) * 100, 1) }}%)</span>
                        </div>
                        <div class="h-8 w-full overflow-hidden rounded-lg bg-gray-200">
                            <div class="h-full bg-orange-500" style="width: {{ ($analytics['total_spent'] / $budget->total_amount) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Request Statistics --}}
            <div class="mb-6 grid gap-4 md:grid-cols-3">
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="text-sm text-gray-500">Average Request</div>
                    <div class="text-xl font-bold text-orange-600">${{ number_format($analytics['average_request_amount'], 2) }}</div>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="text-sm text-gray-500">Largest Request</div>
                    <div class="text-xl font-bold text-orange-600">${{ number_format($analytics['largest_request'], 2) }}</div>
                </div>
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                    <div class="text-sm text-gray-500">Smallest Request</div>
                    <div class="text-xl font-bold text-orange-600">${{ number_format($analytics['smallest_request'], 2) }}</div>
                </div>
            </div>

            {{-- Monthly Spending Trend --}}
            @if($monthlySpending->count() > 0)
                <div class="mb-6">
                    <h3 class="mb-4 font-semibold text-gray-900">Monthly Spending Trend</h3>
                    <div class="space-y-2">
                        @php
                            $maxMonthly = $monthlySpending->max('total');
                        @endphp
                        @foreach($monthlySpending as $month)
                            <div>
                                <div class="mb-1 flex justify-between text-sm">
                                    <span class="font-medium text-gray-700">{{ \Carbon\Carbon::parse($month->month . '-01')->format('F Y') }}</span>
                                    <span class="font-bold text-gray-900">${{ number_format($month->total, 2) }}</span>
                                </div>
                                <div class="h-6 w-full overflow-hidden rounded-lg bg-gray-200">
                                    <div class="h-full bg-gradient-to-r from-orange-400 to-orange-600" 
                                         style="width: {{ $maxMonthly > 0 ? ($month->total / $maxMonthly) * 100 : 0 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Status Breakdown --}}
            @if($statusBreakdown->count() > 0)
                <div>
                    <h3 class="mb-4 font-semibold text-gray-900">Requests by Status</h3>
                    <div class="grid gap-4 md:grid-cols-2">
                        @foreach($statusBreakdown as $status)
                            <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ match($status->status) {
                                            'draft' => 'bg-gray-100 text-gray-700',
                                            'pending' => 'bg-orange-100 text-orange-700',
                                            'approved_by_fm' => 'bg-orange-100 text-orange-700',
                                            'approved_by_ceo' => 'bg-orange-100 text-orange-700',
                                            'rejected' => 'bg-red-100 text-red-700',
                                            default => 'bg-gray-100 text-gray-700'
                                        } }}">
                                            {{ str_replace('_', ' ', ucfirst($status->status)) }}
                                        </span>
                                        <div class="mt-2 text-2xl font-bold text-gray-900">{{ $status->count }}</div>
                                        <div class="text-sm text-gray-500">requests</div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xl font-bold text-orange-600">${{ number_format($status->total, 2) }}</div>
                                        <div class="text-sm text-gray-500">total amount</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endif

    {{-- Breakdown --}}
    @if($budget->breakdown)
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Budget Breakdown</h2>
            <div class="whitespace-pre-wrap text-gray-700">{{ $budget->breakdown }}</div>
        </div>
    @endif
    {{-- Payment Requests --}}
    @if($budget->paymentRequests->count() > 0)
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Payment Requests ({{ $budget->paymentRequests->count() }})</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Title</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Amount</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($budget->paymentRequests as $request)
                            <tr class="border-b border-gray-100 transition-colors hover:bg-orange-50">
                                <td class="px-4 py-2 text-gray-900">#{{ $request->id }}</td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('payment-requests.show', $request) }}" class="text-orange-600 hover:underline">
                                        {{ $request->title }}
                                    </a>
                                </td>
                                <td class="px-4 py-2 text-gray-900">${{ number_format($request->amount, 2) }}</td>
                                <td class="px-4 py-2">
                                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ match($request->status) {
                                        'draft' => 'bg-gray-100 text-gray-700',
                                        'pending' => 'bg-orange-100 text-orange-700',
                                        'approved_by_fm' => 'bg-orange-100 text-orange-700',
                                        'approved_by_ceo' => 'bg-orange-100 text-orange-700',
                                        'rejected' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    } }}">
                                        {{ str_replace('_', ' ', ucfirst($request->status)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-gray-900">{{ $request->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    {{-- Transaction History --}}
    @if($budget->transactions->count() > 0)
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Transaction History</h2>
            <div class="space-y-2">
                @foreach($budget->transactions->sortByDesc('created_at') as $transaction)
                    <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                        <div>
                            <div class="font-medium text-gray-900">
                                {{ ucfirst($transaction->type) }} - ${{ number_format($transaction->amount, 2) }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $transaction->created_at->format('M d, Y H:i') }}
                                @if($transaction->paymentRequest)
                                    - Request #{{ $transaction->paymentRequest->id }}
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">Balance After</div>
                            <div class="font-medium text-orange-600">${{ number_format($transaction->balance_after, 2) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
