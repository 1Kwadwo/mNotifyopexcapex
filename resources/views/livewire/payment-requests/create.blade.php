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
                        <flux:input wire:model="prepared_by" label="Prepared By" required />
                        <flux:input wire:model="request_date" type="date" label="Date" required />
                    </div>
                    <flux:input wire:model="title" label="Title" placeholder="Brief description of the request" required />
                    <div class="grid gap-4 md:grid-cols-2">
                        <flux:select wire:model="expense_type" label="Type" required>
                            <option value="OPEX">OPEX</option>
                            <option value="CAPEX">CAPEX</option>
                        </flux:select>
                        <flux:select wire:model="budget_id" label="Budget" required>
                            <option value="">Select Budget</option>
                            @foreach($budgets as $budget)
                                <option value="{{ $budget->id }}">
                                    {{ $budget->name }} (Available: ${{ number_format($budget->available_amount, 2) }})
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
                                            @endphp
                                            ${{ number_format($qty * $price, 2) }}
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
                                    <td class="px-2 py-3 text-lg font-bold text-orange-600">${{ number_format($totalAmount, 2) }}</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                {{-- Budget Assignment --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900">Budget Assignment (Optional)</h2>
                    
                    <div class="grid gap-4 md:grid-cols-3">
                        <flux:select wire:model="department_id" label="Department">
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </flux:select>
                        <flux:select wire:model="cost_center_id" label="Cost Center">
                            <option value="">Select Cost Center</option>
                            @foreach($costCenters as $cc)
                                <option value="{{ $cc->id }}">{{ $cc->name }}</option>
                            @endforeach
                        </flux:select>
                        <flux:select wire:model="project_id" label="Project">
                            <option value="">Select Project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>
                {{-- Vendor Information --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-semibold text-gray-900">Vendor/Payee Information (Optional)</h2>
                    
                    <div class="grid gap-4 md:grid-cols-2">
                        <flux:input wire:model="vendor_name" label="Name" />
                        <flux:input wire:model="vendor_email" type="email" label="Email" />
                        <flux:input wire:model="vendor_phone" label="Phone" />
                        <flux:textarea wire:model="vendor_address" label="Address" rows="2" />
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
