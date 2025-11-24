    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Payment Requests</h1>
            <flux:button href="{{ route('payment-requests.create') }}" variant="primary">
                New Request
            </flux:button>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="mb-4 flex gap-2">
                <flux:button wire:click="$set('statusFilter', 'all')" 
                    variant="{{ $statusFilter === 'all' ? 'primary' : 'ghost' }}" size="sm">
                    All
                </flux:button>
                <flux:button wire:click="$set('statusFilter', 'draft')" 
                    variant="{{ $statusFilter === 'draft' ? 'primary' : 'ghost' }}" size="sm">
                    Drafts
                </flux:button>
                <flux:button wire:click="$set('statusFilter', 'pending')" 
                    variant="{{ $statusFilter === 'pending' ? 'primary' : 'ghost' }}" size="sm">
                    Pending
                </flux:button>
                <flux:button wire:click="$set('statusFilter', 'approved_by_ceo')" 
                    variant="{{ $statusFilter === 'approved_by_ceo' ? 'primary' : 'ghost' }}" size="sm">
                    Approved
                </flux:button>
                <flux:button wire:click="$set('statusFilter', 'rejected')" 
                    variant="{{ $statusFilter === 'rejected' ? 'primary' : 'ghost' }}" size="sm">
                    Rejected
                </flux:button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Title</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Requester</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Amount</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Type</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $request)
                            <tr class="border-b border-gray-100 transition-colors hover:bg-orange-50">
                                <td class="px-4 py-2 text-gray-900">#{{ $request->id }}</td>
                                <td class="px-4 py-2 text-gray-900">{{ $request->title }}</td>
                                <td class="px-4 py-2 text-gray-900">{{ $request->requester->name }}</td>
                                <td class="px-4 py-2 text-gray-900">${{ number_format($request->amount, 2) }}</td>
                                <td class="px-4 py-2">
                                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $request->expense_type === 'OPEX' ? 'bg-orange-100 text-orange-700' : 'bg-orange-100 text-orange-700' }}">
                                        {{ $request->expense_type }}
                                    </span>
                                </td>
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
                                <td class="px-4 py-2">
                                    <flux:button href="{{ route('payment-requests.show', $request) }}" size="sm" variant="outline">
                                        View
                                    </flux:button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                    No payment requests found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
