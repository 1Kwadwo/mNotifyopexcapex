    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Create Payment Request</h1>
            <flux:button href="{{ route('payment-requests.index') }}" variant="outline">
                Back to List
            </flux:button>
        </div>
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <form wire:submit="submit" class="space-y-6">
                {{-- Header Information --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900">Header Information</h2>
                    
                    <div class="grid gap-4 md:grid-cols-2">
                        <flux:input wire:model="prepared_by" label="Prepared By" readonly />
                        <flux:input wire:model="request_date" type="date" label="Date" readonly />
                    </div>
                    <flux:input wire:model="title" label="Title" placeholder="Brief description of the request" required />
                    <div class="grid gap-4 md:grid-cols-3">
                        <flux:select wire:model="expense_type" label="Type" required>
                            <option value="OPEX">OPEX</option>
                            <option value="CAPEX">CAPEX</option>
                        </flux:select>
                        <flux:select wire:model.live="currency" label="Currency" required>
                            <option value="GHS">GHS (₵)</option>
                            <option value="USD">USD ($)</option>
                            <option value="EUR">EUR (€)</option>
                        </flux:select>
                        <flux:select wire:model="budget_id" label="Budget" required>
                            <option value="">Select Budget</option>
                            @foreach($budgets as $budget)
                                <option value="{{ $budget->id }}">
                                    @php
                                        $budgetSymbol = match($budget->currency ?? 'GHS') {
                                            'GHS' => '₵',
                                            'USD' => '$',
                                            'EUR' => '€',
                                            default => '₵'
                                        };
                                    @endphp
                                    {{ $budget->name }} (Available: {{ $budgetSymbol }}{{ number_format($budget->available_amount, 2) }})
                                </option>
                            @endforeach
                        </flux:select>
                    </div>
                    <flux:textarea wire:model="purpose" label="Purpose/Reason" rows="3" required />
                </div>
                {{-- Line Items --}}
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Line Items</h2>
                        <flux:button type="button" wire:click="addLineItem" size="sm" variant="outline">
                            + Add Row
                        </flux:button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="px-2 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
                                    <th class="w-24 px-2 py-3 text-left text-sm font-semibold text-gray-700">Qty</th>
                                    <th class="w-32 px-2 py-3 text-left text-sm font-semibold text-gray-700">Unit Price</th>
                                    <th class="w-32 px-2 py-3 text-left text-sm font-semibold text-gray-700">Total</th>
                                    <th class="w-16 px-2 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lineItems as $index => $item)
                                    <tr class="border-b border-gray-100">
                                        <td class="px-2 py-2">
                                            <flux:input wire:model="lineItems.{{ $index }}.description" placeholder="Item description" />
                                        </td>
                                        <td class="px-2 py-2">
                                            <flux:input wire:model.live="lineItems.{{ $index }}.quantity" type="number" min="1" step="1" />
                                        </td>
                                        <td class="px-2 py-2">
                                            <flux:input wire:model.live="lineItems.{{ $index }}.unit_price" type="number" step="0.01" min="0" />
                                        </td>
                                        <td class="px-2 py-2 text-gray-900">
                                            @php
                                                $qty = is_numeric($item['quantity'] ?? 0) ? (float) $item['quantity'] : 0;
                                                $price = is_numeric($item['unit_price'] ?? 0) ? (float) $item['unit_price'] : 0;
                                                $symbol = match($currency) {
                                                    'GHS' => '₵',
                                                    'USD' => '$',
                                                    'EUR' => '€',
                                                    default => '₵'
                                                };
                                            @endphp
                                            {{ $symbol }}{{ number_format($qty * $price, 2) }}
                                        </td>
                                        <td class="px-2 py-2">
                                            @if(count($lineItems) > 1)
                                                <flux:button type="button" wire:click="removeLineItem({{ $index }})" size="sm" variant="ghost" color="red">
                                                    ×
                                                </flux:button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="border-t-2 border-orange-200 bg-orange-50">
                                    <td colspan="3" class="px-2 py-3 text-right font-semibold text-gray-700">Total Amount:</td>
                                    <td class="px-2 py-3 text-lg font-bold text-orange-600">
                                        @php
                                            $symbol = match($currency) {
                                                'GHS' => '₵',
                                                'USD' => '$',
                                                'EUR' => '€',
                                                default => '₵'
                                            };
                                        @endphp
                                        {{ $symbol }}{{ number_format($totalAmount, 2) }}
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                {{-- Budget Assignment --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900">Budget Assignment (Optional)</h2>
                    
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <flux:input 
                                wire:model.live="department_name" 
                                label="Department" 
                                placeholder="Type or select department"
                                list="departments-list"
                            />
                            <datalist id="departments-list">
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->name }}">
                                @endforeach
                            </datalist>
                            <p class="mt-1 text-xs text-gray-500">Type to create new or select existing</p>
                        </div>
                        
                        <div>
                            <flux:input 
                                wire:model.live="project_name" 
                                label="Project" 
                                placeholder="Type or select project"
                                list="projects-list"
                            />
                            <datalist id="projects-list">
                                @foreach($projects as $project)
                                    <option value="{{ $project->name }}">
                                @endforeach
                            </datalist>
                            <p class="mt-1 text-xs text-gray-500">Type to create new or select existing</p>
                        </div>
                    </div>
                </div>
                {{-- Vendor Information --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900">Vendor/Payee Information (Optional)</h2>
                    
                    <div class="grid gap-4 md:grid-cols-2">
                        <flux:input wire:model="vendor_name" label="Name" />
                        <flux:input wire:model="vendor_email" type="email" label="Email" />
                        <flux:input wire:model="vendor_phone" label="Phone" />
                    </div>
                </div>
                {{-- Additional Comments --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900">Additional Comments (Optional)</h2>
                    <flux:textarea wire:model="comments" label="Comments" rows="3" placeholder="Add any additional notes or comments about this payment request..." />
                </div>
                {{-- Invoice Upload --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900">Invoice/Supporting Documents (Optional)</h2>
                    <div class="rounded-lg border-2 border-dashed border-gray-300 p-6">
                        <div class="space-y-2">
                            <label class="block">
                                <span class="sr-only">Choose files</span>
                                <input 
                                    type="file" 
                                    wire:model="invoiceFiles" 
                                    multiple
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-orange-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-orange-700 hover:file:bg-orange-100"
                                />
                            </label>
                            <p class="text-xs text-gray-500">Accepted formats: PDF, JPG, JPEG, PNG (Max 10MB per file)</p>
                        </div>
                        
                        @if(!empty($invoiceFiles))
                            <div class="mt-4 space-y-2">
                                <p class="text-sm font-medium text-gray-700">Selected Files:</p>
                                @foreach($invoiceFiles as $index => $file)
                                    <div class="flex items-center justify-between rounded-lg border border-gray-200 bg-gray-50 p-3">
                                        <div class="flex items-center space-x-3">
                                            <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $file->getClientOriginalName() }}</p>
                                                <p class="text-xs text-gray-500">{{ number_format($file->getSize() / 1024, 2) }} KB</p>
                                            </div>
                                        </div>
                                        <button 
                                            type="button" 
                                            wire:click="removeAttachment({{ $index }})"
                                            class="text-red-600 hover:text-red-800"
                                        >
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        
                        <div wire:loading wire:target="invoiceFiles" class="mt-4">
                            <div class="flex items-center space-x-2 text-sm text-orange-600">
                                <svg class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>Uploading files...</span>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Actions --}}
                <div class="flex justify-end gap-2">
                    <flux:button type="button" wire:click="saveDraft" variant="outline">
                        Save Draft
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Submit for Approval
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
