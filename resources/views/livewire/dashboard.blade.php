<div class="space-y-6">
    {{-- Welcome Message --}}
    <div class="rounded-lg border border-orange-200 bg-gradient-to-r from-orange-50 to-white p-8 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-2">
                    <span class="typewriter-welcome">Welcome, </span>
                    <span class="typewriter-name text-orange-600">{{ auth()->user()->name }}</span>
                    <span class="typewriter-icon inline-block">
                        <svg class="h-8 w-8 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    </span>
                </h1>
                <p class="mt-2 text-gray-600 fade-in-subtitle">Here's your financial overview for today</p>
            </div>
            <div class="hidden md:block">
                <svg class="h-16 w-16 text-orange-500 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                </svg>
            </div>
        </div>
    </div>

    <style>
        .typewriter-welcome {
            display: inline-block;
            overflow: hidden;
            white-space: nowrap;
            width: 0;
            animation: typing-welcome 0.8s steps(9, end) forwards;
        }
        
        .typewriter-name {
            display: inline-block;
            overflow: hidden;
            white-space: nowrap;
            width: 0;
            animation: typing-name 1s steps(20, end) 0.8s forwards, removeOverflow 0s 1.8s forwards;
        }
        
        .typewriter-icon {
            opacity: 0;
            animation: fadeInIcon 0.5s ease-in 1.8s forwards, rotateIcon 0.6s ease-in-out 1.8s forwards;
        }
        
        .fade-in-subtitle {
            opacity: 0;
            animation: fadeInSubtitle 0.8s ease-out 2s forwards;
        }
        
        @keyframes typing-welcome {
            from { width: 0; }
            to { width: 100%; }
        }
        
        @keyframes typing-name {
            from { width: 0; }
            to { width: 100%; }
        }
        
        @keyframes removeOverflow {
            to { overflow: visible; }
        }
        
        @keyframes fadeInIcon {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }
        
        @keyframes rotateIcon {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.1); }
            100% { transform: rotate(360deg) scale(1); }
        }
        
        @keyframes fadeInSubtitle {
            from { opacity: 0; transform: translateY(5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    {{-- Stats Grid --}}
    <div class="grid gap-6 md:grid-cols-4">
        <div class="group relative overflow-hidden rounded-lg border border-gray-200 bg-white p-6 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-600">Total Requests</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total_requests'] }}</p>
                </div>
                <div class="rounded-lg bg-gray-100 p-3">
                    <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 h-1 w-full bg-gray-200">
                <div class="h-full w-full bg-gray-400"></div>
            </div>
        </div>
        
        <div class="group relative overflow-hidden rounded-lg border border-orange-200 bg-white p-6 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $stats['pending_requests'] }}</p>
                </div>
                <div class="rounded-lg bg-orange-100 p-3">
                    <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 h-1 w-full bg-orange-200">
                <div class="h-full w-full bg-orange-500"></div>
            </div>
        </div>
        
        <div class="group relative overflow-hidden rounded-lg border border-orange-200 bg-white p-6 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-600">Approved</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $stats['approved_requests'] }}</p>
                </div>
                <div class="rounded-lg bg-orange-100 p-3">
                    <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 h-1 w-full bg-orange-200">
                <div class="h-full w-full bg-orange-500"></div>
            </div>
        </div>
        
        <div class="group relative overflow-hidden rounded-lg border border-gray-200 bg-white p-6 shadow-sm transition-all hover:shadow-md">
            <div class="flex items-start justify-between">
                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-600">Rejected</p>
                    <p class="text-3xl font-bold text-gray-500">{{ $stats['rejected_requests'] }}</p>
                </div>
                <div class="rounded-lg bg-gray-100 p-3">
                    <svg class="h-6 w-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 h-1 w-full bg-gray-200">
                <div class="h-full w-full bg-gray-400"></div>
            </div>
        </div>
    </div>

    @if($opexCapexStats)
        {{-- OPEX/CAPEX Analytics --}}
        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">OPEX & CAPEX Overview</h2>
            
            {{-- Overall Stats --}}
            <div class="grid gap-4 md:grid-cols-2 mb-6">
                <div class="rounded-lg border-2 border-orange-200 bg-orange-50 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-semibold text-orange-900">OPEX (Operational Expenditure)</h3>
                        <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <p class="text-2xl font-bold text-orange-900">{{ $opexCapexStats['opex_count'] }} Requests</p>
                        <p class="text-lg text-orange-700">Total: ₵{{ number_format($opexCapexStats['opex_amount'], 2) }}</p>
                    </div>
                </div>
                
                <div class="rounded-lg border-2 border-orange-200 bg-orange-50 p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-sm font-semibold text-orange-900">CAPEX (Capital Expenditure)</h3>
                        <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <p class="text-2xl font-bold text-orange-900">{{ $opexCapexStats['capex_count'] }} Requests</p>
                        <p class="text-lg text-orange-700">Total: ₵{{ number_format($opexCapexStats['capex_amount'], 2) }}</p>
                    </div>
                </div>
            </div>
            
            {{-- Monthly Breakdown --}}
            <div class="mb-6">
                <h3 class="text-md font-semibold text-gray-900 mb-3">Monthly Breakdown ({{ now()->year }})</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 bg-gray-50">
                                <th class="px-3 py-2 text-left font-semibold text-gray-700">Month</th>
                                <th class="px-3 py-2 text-right font-semibold text-gray-700">OPEX Count</th>
                                <th class="px-3 py-2 text-right font-semibold text-gray-700">OPEX Amount</th>
                                <th class="px-3 py-2 text-right font-semibold text-gray-700">CAPEX Count</th>
                                <th class="px-3 py-2 text-right font-semibold text-gray-700">CAPEX Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyStats as $month => $data)
                                @if($data['opex_count'] > 0 || $data['capex_count'] > 0)
                                    <tr class="border-b border-gray-100 hover:bg-orange-50">
                                        <td class="px-3 py-2 font-medium text-gray-900">{{ \Carbon\Carbon::create()->month($month)->format('F') }}</td>
                                        <td class="px-3 py-2 text-right text-gray-900">{{ $data['opex_count'] }}</td>
                                        <td class="px-3 py-2 text-right text-gray-900">₵{{ number_format($data['opex_amount'], 2) }}</td>
                                        <td class="px-3 py-2 text-right text-gray-900">{{ $data['capex_count'] }}</td>
                                        <td class="px-3 py-2 text-right text-gray-900">₵{{ number_format($data['capex_amount'], 2) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Per-Budget Breakdown --}}
            <div>
                <h3 class="text-md font-semibold text-gray-900 mb-3">Per-Budget Breakdown</h3>
                <div class="space-y-3">
                    @foreach($budgetBreakdown as $item)
                        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-semibold text-gray-900">{{ $item['budget']->name }}</h4>
                                <span class="text-xs px-2 py-1 rounded-full bg-orange-100 text-orange-700">{{ $item['budget']->type }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-600">OPEX: <span class="font-semibold text-gray-900">{{ $item['opex_count'] }} requests</span></p>
                                    <p class="text-gray-600">Amount: <span class="font-semibold text-orange-600">₵{{ number_format($item['opex_amount'], 2) }}</span></p>
                                </div>
                                <div>
                                    <p class="text-gray-600">CAPEX: <span class="font-semibold text-gray-900">{{ $item['capex_count'] }} requests</span></p>
                                    <p class="text-gray-600">Amount: <span class="font-semibold text-orange-600">₵{{ number_format($item['capex_amount'], 2) }}</span></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Quick Actions --}}
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                <p class="mt-1 text-sm text-gray-600">Create and manage your payment requests</p>
            </div>
            <flux:button href="{{ route('payment-requests.create') }}" variant="primary" class="flex items-center gap-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                New Payment Request
            </flux:button>
        </div>
    </div>

    {{-- Recent Requests --}}
    <div class="rounded-lg border border-gray-200 bg-white shadow-sm overflow-hidden">
        <div class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Recent Payment Requests</h2>
                    <p class="mt-1 text-sm text-gray-600">Your latest payment request submissions</p>
                </div>
                <flux:button href="{{ route('payment-requests.index') }}" variant="outline" size="sm" class="hidden md:flex">
                    View All
                </flux:button>
            </div>
        </div>
        
        @if($recentRequests->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Requester</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">Date</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach($recentRequests as $request)
                            <tr class="group hover:bg-orange-50 transition-colors cursor-pointer border-l-2 border-transparent hover:border-orange-400">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-gray-900">
                                        #{{ $request->id }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 max-w-xs truncate">{{ $request->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $request->requester->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">
                                        @php
                                            $symbol = match($request->currency ?? 'GHS') {
                                                'GHS' => '₵',
                                                'USD' => '$',
                                                'EUR' => '€',
                                                default => '₵'
                                            };
                                        @endphp
                                        {{ $symbol }}{{ number_format($request->amount, 2) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($request->status === 'approved_by_ceo')
                                        <span class="inline-flex items-center rounded-full bg-orange-100 px-3 py-1 text-xs font-semibold text-orange-800">
                                            Approved by CEO
                                        </span>
                                    @elseif($request->status === 'approved_by_fm')
                                        <span class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1 text-xs font-semibold text-orange-700">
                                            Approved by FM
                                        </span>
                                    @elseif($request->status === 'pending')
                                        <span class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1 text-xs font-semibold text-orange-600">
                                            Pending
                                        </span>
                                    @elseif($request->status === 'draft')
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                            Draft
                                        </span>
                                    @elseif($request->status === 'rejected')
                                        <span class="inline-flex items-center rounded-full bg-gray-200 px-3 py-1 text-xs font-semibold text-gray-700">
                                            Rejected
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                            {{ str_replace('_', ' ', ucfirst($request->status)) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $request->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <flux:button href="{{ route('payment-requests.show', $request) }}" size="sm" variant="ghost" class="opacity-0 group-hover:opacity-100 transition-opacity">
                                        View
                                    </flux:button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="border-t border-gray-200 bg-gray-50 px-6 py-4 text-center md:hidden">
                <flux:button href="{{ route('payment-requests.index') }}" variant="outline" class="w-full">
                    View All Requests
                </flux:button>
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No payment requests</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new payment request.</p>
                <div class="mt-6">
                    <flux:button href="{{ route('payment-requests.create') }}" variant="primary">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        New Payment Request
                    </flux:button>
                </div>
            </div>
        @endif
    </div>

    {{-- Budgets Overview --}}
    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
        <div class="space-y-4">
            <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Active Budgets</h2>
                    <p class="mt-1 text-sm text-gray-600">Current budget allocations and utilization</p>
                </div>
            </div>
            
            @if($approvedBudgets->count() > 0)
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($approvedBudgets as $budget)
                        <a href="{{ route('budgets.show', $budget) }}" class="group block rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition-all hover:border-orange-300 hover:shadow-md">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 group-hover:text-orange-600 transition-colors">{{ $budget->name }}</h3>
                                    <p class="mt-1 inline-flex items-center rounded-full bg-orange-100 px-2.5 py-0.5 text-xs font-medium text-orange-800">{{ $budget->type }}</p>
                                </div>
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $budget->utilizationPercentage() > 80 ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700' }}">
                                    {{ number_format($budget->utilizationPercentage(), 1) }}%
                                </span>
                            </div>
                            <div class="mt-4 space-y-3">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Available</span>
                                    <span class="font-semibold text-gray-900">
                                        @php
                                            $symbol = match($budget->currency ?? 'GHS') {
                                                'GHS' => '₵',
                                                'USD' => '$',
                                                'EUR' => '€',
                                                default => '₵'
                                            };
                                        @endphp
                                        {{ $symbol }}{{ number_format($budget->available_amount, 2) }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600">Total Budget</span>
                                    <span class="font-semibold text-gray-900">{{ $symbol }}{{ number_format($budget->total_amount, 2) }}</span>
                                </div>
                                <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200">
                                    <div class="h-full transition-all {{ $budget->utilizationPercentage() > 80 ? 'bg-red-500' : 'bg-orange-500' }}" 
                                         style="width: {{ min($budget->utilizationPercentage(), 100) }}%"></div>
                                </div>
                            </div>
                        </a>
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
