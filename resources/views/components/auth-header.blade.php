@props([
    'title',
    'description',
])

<div class="flex w-full flex-col items-center text-center">
    {{-- Brand Logo --}}
    <div class="mb-6">
        <div class="flex items-center justify-center gap-2">
            <div class="flex items-center gap-1">
                <span class="text-3xl font-bold text-orange-600 dark:text-orange-400">m</span>
                <span class="text-3xl font-bold text-gray-900 dark:text-white">Notify</span>
            </div>
            <span class="text-2xl text-orange-400">|</span>
            <div class="flex items-center gap-1">
                <span class="text-3xl font-bold bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent">Budget</span>
                <span class="text-3xl font-bold text-gray-900 dark:text-white">IQ</span>
            </div>
        </div>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">OPEX/CAPEX Management System</p>
    </div>
    
    <flux:heading size="xl">{{ $title }}</flux:heading>
    <flux:subheading>{{ $description }}</flux:subheading>
</div>
