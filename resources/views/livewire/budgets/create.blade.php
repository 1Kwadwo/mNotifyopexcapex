<div class="mx-auto max-w-4xl space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Create Budget</h1>
        <flux:button href="{{ route('budgets.index') }}" variant="outline">
            Back to List
        </flux:button>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <form wire:submit="submitToCEO" class="space-y-6">
            {{-- Basic Information --}}
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-900">Basic Information</h2>
                
                <flux:input wire:model="name" label="Budget Name" placeholder="e.g., Q1 2025 OPEX Budget" required />
                <div class="grid gap-4 md:grid-cols-3">
                    <flux:select wire:model="type" label="Type" required>
                        <option value="OPEX">OPEX (Operational Expenditure)</option>
                        <option value="CAPEX">CAPEX (Capital Expenditure)</option>
                    </flux:select>
                    <flux:select wire:model.live="currency" label="Currency" required>
                        <option value="GHS">GHS (₵)</option>
                        <option value="USD">USD ($)</option>
                        <option value="EUR">EUR (€)</option>
                    </flux:select>
                    <flux:input wire:model="total_amount" type="number" step="0.01" label="Total Amount" placeholder="100000" required />
                </div>
            </div>
            {{-- Period --}}
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-900">Budget Period</h2>
                
                <div class="grid gap-4 md:grid-cols-2">
                    <flux:input wire:model="period_start" type="date" label="Start Date" required />
                    <flux:input wire:model="period_end" type="date" label="End Date" required />
                </div>
            </div>
            {{-- Assignment --}}
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-900">Assignment (Optional)</h2>
                
                <div class="grid gap-4 md:grid-cols-3">
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
                            wire:model.live="cost_center_name" 
                            label="Cost Center" 
                            placeholder="Type or select cost center"
                            list="cost-centers-list"
                        />
                        <datalist id="cost-centers-list">
                            @foreach($costCenters as $cc)
                                <option value="{{ $cc->name }}">
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
            {{-- Thresholds --}}
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-900">Thresholds</h2>
                
                <div class="grid gap-4 md:grid-cols-2">
                    <flux:input wire:model="threshold_warning" type="number" min="0" max="100" label="Warning Threshold (%)" />
                    <flux:input wire:model="threshold_limit" type="number" min="0" max="100" label="Limit Threshold (%)" />
                </div>
                <p class="text-sm text-gray-600">
                    Warning threshold triggers alerts when budget utilization reaches this percentage. Limit threshold prevents new requests when reached.
                </p>
            </div>
            {{-- Breakdown --}}
            <div class="space-y-4">
                <h2 class="text-lg font-semibold text-gray-900">Budget Breakdown (Optional)</h2>
                
                <flux:textarea wire:model="breakdown" label="Detailed Breakdown" rows="6" placeholder="Provide a detailed breakdown of how this budget will be allocated...&#10;&#10;Example:&#10;- Software Licenses: $30,000&#10;- Office Supplies: $15,000&#10;- Utilities: $25,000&#10;- Miscellaneous: $30,000" />
            </div>
            {{-- Actions --}}
            <div class="flex justify-end gap-2">
                <flux:button type="button" wire:click="saveDraft" variant="outline">
                    Save Draft
                </flux:button>
                <flux:button type="submit" variant="primary">
                    Submit to CEO
                </flux:button>
            </div>
        </form>
    </div>
</div>
