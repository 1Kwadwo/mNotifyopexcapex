<div class="space-y-6">
    @if (session()->has('message'))
        <div class="rounded-lg border-l-4 border-orange-500 bg-orange-50 p-4 text-orange-800">
            {{ session('message') }}
        </div>
    @endif
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">User Management</h1>
        @if(auth()->user()->isFinanceManager())
            <flux:button wire:click="$set('showCreateModal', true)" variant="primary">
                Create Staff User
            </flux:button>
        @endif
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Role</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b border-gray-100 transition-colors hover:bg-orange-50">
                            <td class="px-4 py-2 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $user->email }}</td>
                            <td class="px-4 py-2">
                                @foreach($user->roles as $role)
                                    <span class="inline-flex rounded-full px-2 py-1 text-xs font-semibold {{ match($role->slug) {
                                        'ceo' => 'bg-orange-100 text-orange-700',
                                        'finance_manager' => 'bg-orange-100 text-orange-700',
                                        'staff' => 'bg-gray-100 text-gray-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    } }}">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-4 py-2 text-gray-700">{{ $user->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
    {{-- Create User Modal --}}
    @if($showCreateModal)
        <flux:modal wire:model="showCreateModal">
            <form wire:submit="createUser">
                <flux:heading>Create New Staff User</flux:heading>
                <flux:subheading>Create a new staff account. The user will be assigned the Staff role automatically.</flux:subheading>
                <div class="mt-6 space-y-4">
                    <flux:input wire:model="name" label="Full Name" placeholder="John Doe" required />
                    <flux:input wire:model="email" type="email" label="Email Address" placeholder="john@example.com" required />
                    <flux:input wire:model="password" type="password" label="Password" placeholder="Minimum 8 characters" required />
                    <p class="text-sm text-gray-600">
                        The user will be able to log in immediately with these credentials.
                    </p>
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <flux:button type="button" wire:click="$set('showCreateModal', false)" variant="outline">
                        Cancel
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Create User
                    </flux:button>
                </div>
            </form>
        </flux:modal>
    @endif
</div>
