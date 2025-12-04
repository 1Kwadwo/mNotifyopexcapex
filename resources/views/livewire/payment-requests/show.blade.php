<div class="mx-auto max-w-4xl space-y-6">
    @if (session()->has('message'))
        <div class="rounded-lg border-l-4 border-orange-500 bg-orange-50 p-4 text-orange-800">
            {{ session('message') }}
        </div>
    @endif
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Payment Request #{{ $paymentRequest->id }}</h1>
            <div class="flex gap-2">
                <flux:button onclick="window.print()" variant="outline">
                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print PV
                </flux:button>
                <flux:button href="{{ route('payment-requests.index') }}" variant="outline">
                    Back to List
                </flux:button>
            </div>
        </div>
        {{-- Status and Actions --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-sm text-gray-500">Status</div>
                    <span class="mt-1 inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ match($paymentRequest->status) {
                        'draft' => 'bg-gray-100 text-gray-700',
                        'pending' => 'bg-orange-100 text-orange-700',
                        'pending_ceo_approval' => 'bg-orange-100 text-orange-700',
                        'approved_by_fm' => 'bg-orange-100 text-orange-700',
                        'approved_by_ceo' => 'bg-orange-100 text-orange-700',
                        'rejected' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-700'
                    } }}">
                        {{ match($paymentRequest->status) {
                            'pending_ceo_approval' => 'Pending CEO Approval',
                            'approved_by_fm' => 'Approved by FM',
                            'approved_by_ceo' => 'Approved by CEO',
                            default => str_replace('_', ' ', ucfirst($paymentRequest->status))
                        } }}
                    </span>
                </div>
                @if($canApprove || $canReject)
                    <div class="flex gap-2">
                        @if($canApprove)
                            <flux:button wire:click="approve" variant="primary">
                                Approve
                            </flux:button>
                        @endif
                        @if($canReject)
                            <flux:button wire:click="$set('showRejectModal', true)" variant="danger">
                                Reject
                            </flux:button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        {{-- Header Information --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Request Details</h2>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <div class="text-sm text-gray-500">Title</div>
                    <div class="font-medium text-gray-900">{{ $paymentRequest->title }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Prepared By</div>
                    <div class="font-medium text-gray-900">{{ $paymentRequest->prepared_by }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Requester</div>
                    <div class="font-medium text-gray-900">{{ $paymentRequest->requester->name }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Request Date</div>
                    <div class="font-medium text-gray-900">{{ $paymentRequest->request_date->format('M d, Y') }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Type</div>
                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold bg-orange-100 text-orange-700">
                        {{ $paymentRequest->expense_type }}
                    </span>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Budget</div>
                    <div class="font-medium text-gray-900">{{ $paymentRequest->budget->name }}</div>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Currency</div>
                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold bg-orange-100 text-orange-700">
                        {{ $paymentRequest->currency ?? 'GHS' }}
                    </span>
                </div>
            </div>
            <div class="mt-4">
                <div class="text-sm text-gray-500">Purpose</div>
                <div class="mt-1 text-gray-900">{{ $paymentRequest->purpose }}</div>
            </div>
        </div>
        {{-- Line Items --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Line Items</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Quantity</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Unit Price</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentRequest->lineItems as $item)
                            <tr class="border-b border-gray-100">
                                <td class="px-4 py-2 text-gray-900">{{ $item->description }}</td>
                                <td class="px-4 py-2 text-right text-gray-900">{{ $item->quantity }}</td>
                                <td class="px-4 py-2 text-right text-gray-900">
                                    @php
                                        $symbol = match($paymentRequest->currency ?? 'GHS') {
                                            'GHS' => '₵',
                                            'USD' => '$',
                                            'EUR' => '€',
                                            default => '₵'
                                        };
                                    @endphp
                                    {{ $symbol }}{{ number_format($item->unit_price, 2) }}
                                </td>
                                <td class="px-4 py-2 text-right text-gray-900">{{ $symbol }}{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-orange-200 bg-orange-50">
                            <td colspan="3" class="px-4 py-3 text-right font-semibold text-gray-700">Total Amount:</td>
                            <td class="px-4 py-3 text-right text-lg font-bold text-orange-600">
                                @php
                                    $symbol = match($paymentRequest->currency ?? 'GHS') {
                                        'GHS' => '₵',
                                        'USD' => '$',
                                        'EUR' => '€',
                                        default => '₵'
                                    };
                                @endphp
                                {{ $symbol }}{{ number_format($paymentRequest->amount, 2) }}
                            </td>
                        </tr>
                        <tr class="bg-orange-50">
                            <td colspan="4" class="px-4 py-2 text-right text-sm italic text-gray-600">
                                {{ $paymentRequest->amount_in_words }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        {{-- Vendor Information --}}
        @if($paymentRequest->vendor_name)
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Vendor Information</h2>
                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <div class="text-sm text-gray-500">Name</div>
                        <div class="font-medium text-gray-900">{{ $paymentRequest->vendor_name }}</div>
                    </div>
                    @if($paymentRequest->vendor_details['email'] ?? null)
                        <div>
                            <div class="text-sm text-gray-500">Email</div>
                            <div class="font-medium text-gray-900">{{ $paymentRequest->vendor_details['email'] }}</div>
                        </div>
                    @endif
                    @if($paymentRequest->vendor_details['phone'] ?? null)
                        <div>
                            <div class="text-sm text-gray-500">Phone</div>
                            <div class="font-medium text-gray-900">{{ $paymentRequest->vendor_details['phone'] }}</div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
        {{-- Additional Comments --}}
        @if($paymentRequest->vendor_details['comments'] ?? null)
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Additional Comments</h2>
                <div class="text-gray-900">{{ $paymentRequest->vendor_details['comments'] }}</div>
            </div>
        @endif
        {{-- Attachments --}}
        @if($paymentRequest->attachments->count() > 0)
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Invoice/Supporting Documents</h2>
                <div class="space-y-2">
                    @foreach($paymentRequest->attachments as $attachment)
                        <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 p-3">
                            <div class="flex items-center space-x-3">
                                @if(str_contains($attachment->mime_type, 'pdf'))
                                    <svg class="h-8 w-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg class="h-8 w-8 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $attachment->filename }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ number_format($attachment->size / 1024, 2) }} KB • 
                                        Uploaded {{ $attachment->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                            <a 
                                href="{{ asset('storage/' . $attachment->path) }}" 
                                target="_blank"
                                class="flex items-center gap-1 rounded-md bg-orange-50 px-3 py-2 text-sm font-semibold text-orange-700 hover:bg-orange-100"
                            >
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span class="hidden sm:inline">Download</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        {{-- Approval History --}}
        @if($paymentRequest->approvals->count() > 0)
            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="mb-4 text-lg font-semibold text-gray-900">Approval History</h2>
                <div class="space-y-3">
                    @foreach($paymentRequest->approvals as $approval)
                        <div class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $approval->approver->name }}</div>
                                    <div class="text-sm text-gray-500">
                                        {{ ucfirst(str_replace('_', ' ', $approval->role)) }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ $approval->status === 'approved' ? 'bg-orange-100 text-orange-700' : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst($approval->status) }}
                                    </span>
                                    <div class="mt-1 text-xs text-gray-500">
                                        {{ ($approval->approved_at ?? $approval->rejected_at)->format('M d, Y H:i') }}
                                    </div>
                                </div>
                            </div>
                            @if($approval->comment)
                                <div class="mt-2 text-sm text-gray-700">{{ $approval->comment }}</div>
                            @endif>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        {{-- Reject Modal --}}
        @if($showRejectModal)
            <flux:modal wire:model="showRejectModal">
                <form wire:submit="reject">
                    <flux:heading>Reject Payment Request</flux:heading>
                    <flux:subheading>Please provide a reason for rejection.</flux:subheading>
                    <flux:textarea wire:model="rejectReason" label="Reason for Rejection" rows="4" required />
                    <div class="mt-4 flex justify-end gap-2">
                        <flux:button type="button" wire:click="$set('showRejectModal', false)" variant="outline">
                            Cancel
                        </flux:button>
                        <flux:button type="submit" variant="danger">
                            Reject Request
                        </flux:button>
                    </div>
                </form>
            </flux:modal>
        @endif
    
    {{-- Print Styles --}}
    <style>
        @media print {
            nav, .no-print, flux\:button, button, [wire\:click] {
                display: none !important;
            }
            body {
                background: white !important;
            }
            .mx-auto {
                max-width: 100% !important;
            }
            .shadow-sm, .shadow {
                box-shadow: none !important;
            }
            .space-y-6 > * {
                page-break-inside: avoid;
            }
            @page {
                margin: 1cm;
            }
            .mx-auto:first-child::before {
                content: "PAYMENT VOUCHER";
                display: block;
                text-align: center;
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 20px;
                padding-bottom: 10px;
                border-bottom: 2px solid #000;
            }
            table {
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            .text-gray-500, .text-gray-600, .text-gray-700 {
                color: #000 !important;
            }
            .rounded-xl {
                border: 1px solid #000 !important;
                border-radius: 0 !important;
                margin-bottom: 15px !important;
            }
        }
    </style>
</div>
