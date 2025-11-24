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
                <div class="grid gap-4 md:grid-cols-2">
                    <flux:select wire:model="type" label="Type" required>
                        <option value="OPEX">OPEX (Operational Expenditure)</option>
                        <option value="CAPEX">CAPEX (Capital Expenditure)</option>
                    </flux:select>
                    <flux:input wire:model="total_amount" type="number" step="0.01" label="Total Amount ($)" placeholder="100000" required />
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
