    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Budgets</h1>
            <div class="flex gap-2">
                <flux:button onclick="window.print()" variant="outline">
                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print List
                </flux:button>
                @if(auth()->user()->isFinanceManager())
                    <flux:button href="{{ route('budgets.create') }}" variant="primary">
                        Create Budget
                    </flux:button>
                @endif
            </div>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="mb-4 flex gap-2">
                <flux:button wire:click="$set('statusFilter', 'all')" 
                    variant="{{ $statusFilter === 'all' ? 'primary' : 'outline' }}" size="sm">
                    All
                </flux:button>
                <flux:button wire:click="$set('statusFilter', 'approved')" 
                    variant="{{ $statusFilter === 'approved' ? 'primary' : 'outline' }}" size="sm">
                    Approved
                </flux:button>
                <flux:button wire:click="$set('statusFilter', 'pending_ceo_approval')" 
                    variant="{{ $statusFilter === 'pending_ceo_approval' ? 'primary' : 'outline' }}" size="sm">
                    Pending
                </flux:button>
                <flux:button wire:click="$set('statusFilter', 'draft')" 
                    variant="{{ $statusFilter === 'draft' ? 'primary' : 'outline' }}" size="sm">
                    Drafts
                </flux:button>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                @forelse($budgets as $budget)
                    <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm transition-shadow hover:shadow-md">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $budget->name }}</h3>
                                <p class="text-sm text-gray-500">
                                    {{ $budget->type }} • {{ $budget->period_start->format('M Y') }} - {{ $budget->period_end->format('M Y') }}
                                </p>
                            </div>
                            <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ match($budget->status) {
                                'draft' => 'bg-gray-100 text-gray-700',
                                'pending_ceo_approval' => 'bg-orange-100 text-orange-700',
                                'approved' => 'bg-orange-100 text-orange-700',
                                'rejected' => 'bg-red-100 text-red-700',
                                default => 'bg-gray-100 text-gray-700'
                            } }}">
                                {{ str_replace('_', ' ', ucfirst($budget->status)) }}
                            </span>
                        </div>
                        @if($budget->isApproved())
                            <div class="mt-4">
                                <div class="mb-2 flex justify-between text-sm text-gray-600">
                                    @php
                                        $symbol = match($budget->currency ?? 'GHS') {
                                            'GHS' => '₵',
                                            'USD' => '$',
                                            'EUR' => '€',
                                            default => '₵'
                                        };
                                    @endphp
                                    <span>Available: {{ $symbol }}{{ number_format($budget->available_amount, 2) }}</span>
                                    <span>Total: {{ $symbol }}{{ number_format($budget->total_amount, 2) }}</span>
                                </div>
                                <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200">
                                    <div class="h-full {{ $budget->utilizationPercentage() > 80 ? 'bg-red-500' : 'bg-orange-500' }}" 
                                         style="width: {{ min($budget->utilizationPercentage(), 100) }}%"></div>
                                </div>
                                <div class="mt-1 text-xs text-gray-500">
                                    {{ number_format($budget->utilizationPercentage(), 1) }}% utilized
                                </div>
                            </div>
                        @endif
                        <div class="mt-4">
                            <flux:button href="{{ route('budgets.show', $budget) }}" size="sm" variant="outline">
                                View Details
                            </flux:button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 py-8 text-center text-gray-500">
                        No budgets found.
                    </div>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $budgets->links() }}
            </div>
        </div>
    
    {{-- Print Styles --}}
    <style>
        @media print {
            nav, .no-print, flux\:button, button, [wire\:click], .mt-4 {
                display: none !important;
            }
            body {
                background: white !important;
            }
            .shadow-sm, .shadow {
                box-shadow: none !important;
            }
            @page {
                margin: 1cm;
            }
            .space-y-6::before {
                content: "BUDGETS LIST";
                display: block;
                text-align: center;
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 20px;
                padding-bottom: 10px;
                border-bottom: 2px solid #000;
            }
            .grid {
                display: block !important;
            }
            .grid > * {
                page-break-inside: avoid;
                margin-bottom: 15px;
            }
            .text-gray-500, .text-gray-600, .text-gray-700, .text-gray-900 {
                color: #000 !important;
            }
            .rounded-xl {
                border: 1px solid #000 !important;
                border-radius: 0 !important;
            }
        }
    </style>
</div>
