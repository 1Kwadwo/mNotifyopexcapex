<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gray-50">
        <flux:sidebar sticky stashable class="border-e border-gray-200" style="background: linear-gradient(to right, #FFF5E6 0%, #FFF9F0 30%, #FFFCF7 60%, #FFFFFF 100%); box-shadow: 2px 0 8px rgba(0,0,0,0.05);">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center" wire:navigate>
                <img src="/mnotify-logo.svg" alt="mNotify | BudgetIQ" class="h-8 w-auto" />
            </a>

            <!-- Profile Picture Upload Section -->
            <div class="mb-4 flex flex-col items-center">
                <a href="{{ route('profile.edit') }}" class="profile-picture-link group relative block" wire:navigate>
                    @if(auth()->user()->profile_photo_path)
                        <div class="h-12 w-12 overflow-hidden rounded-full ring-2 ring-gray-200 transition-all group-hover:ring-orange-500">
                            <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" 
                                 alt="{{ auth()->user()->name }}" 
                                 class="h-full w-full object-cover" />
                        </div>
                    @else
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-orange-400 to-orange-600 text-sm font-bold text-white ring-2 ring-gray-200 transition-all group-hover:ring-orange-500">
                            {{ auth()->user()->initials() }}
                        </div>
                    @endif
                    
                    <!-- Upload Icon Overlay -->
                    <div class="absolute inset-0 flex items-center justify-center rounded-full bg-black bg-opacity-0 transition-all group-hover:bg-opacity-40">
                        <svg class="h-4 w-4 text-white opacity-0 transition-opacity group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </a>
                <p class="mt-1 text-center text-xs text-gray-500">Click to update</p>
            </div>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="document-text" :href="route('payment-requests.index')" :current="request()->routeIs('payment-requests.*')" wire:navigate>{{ __('Payment Requests') }}</flux:navlist.item>
                    <flux:navlist.item icon="currency-dollar" :href="route('budgets.index')" :current="request()->routeIs('budgets.*')" wire:navigate>{{ __('Budgets') }}</flux:navlist.item>
                    @if(auth()->user()->isFinanceManager())
                        <flux:navlist.item icon="users" :href="route('users.index')" :current="request()->routeIs('users.*')" wire:navigate>{{ __('Users') }}</flux:navlist.item>
                    @endif
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <!-- Role-Based Illustration -->
            <div class="hidden lg:block px-4 py-6">
                <div class="rounded-lg bg-gradient-to-br from-orange-50 to-orange-100 p-4">
                    @if(auth()->user()->isCEO())
                        <!-- CEO Illustration -->
                        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                            <circle cx="100" cy="100" r="90" fill="#FED7AA" opacity="0.3"/>
                            <ellipse cx="100" cy="60" rx="18" ry="20" fill="#374151"/>
                            <path d="M 82 78 Q 82 75 85 75 L 115 75 Q 118 75 118 78 L 118 110 L 82 110 Z" fill="#374151"/>
                            <path d="M 100 75 L 95 85 L 97 100 L 100 105 L 103 100 L 105 85 Z" fill="#F97316"/>
                            <rect x="75" y="80" width="8" height="35" rx="4" fill="#374151"/>
                            <rect x="117" y="80" width="8" height="35" rx="4" fill="#374151"/>
                            <rect x="88" y="110" width="10" height="30" fill="#9CA3AF"/>
                            <rect x="102" y="110" width="10" height="30" fill="#9CA3AF"/>
                            <rect x="120" y="95" width="25" height="18" rx="2" fill="#F97316" stroke="#374151" stroke-width="1.5"/>
                            <rect x="130" y="95" width="5" height="5" fill="#374151"/>
                            <line x1="125" y1="104" x2="140" y2="104" stroke="#374151" stroke-width="1"/>
                            <rect x="45" y="125" width="35" height="25" rx="2" fill="white" stroke="#374151" stroke-width="1.5"/>
                            <polyline points="50,145 55,140 60,142 65,135 70,138 75,132" stroke="#F97316" stroke-width="2" fill="none"/>
                            <path d="M 75 132 L 73 134 L 75 136" fill="#F97316"/>
                            <circle cx="140" cy="135" r="8" fill="#F97316" stroke="#374151" stroke-width="1.5"/>
                            <text x="140" y="140" font-size="10" fill="#374151" text-anchor="middle" font-weight="bold">$</text>
                            <circle cx="155" cy="140" r="7" fill="#F97316" stroke="#374151" stroke-width="1.5"/>
                            <text x="155" y="144" font-size="9" fill="#374151" text-anchor="middle" font-weight="bold">$</text>
                            <circle cx="60" cy="165" r="10" fill="#374151" stroke="#F97316" stroke-width="1.5"/>
                            <path d="M 54 165 L 58 169 L 66 161" stroke="#F97316" stroke-width="2.5" fill="none" stroke-linecap="round"/>
                            <rect x="115" y="155" width="20" height="25" rx="2" fill="white" stroke="#374151" stroke-width="1.5"/>
                            <line x1="119" y1="160" x2="131" y2="160" stroke="#F97316" stroke-width="1.5"/>
                            <line x1="119" y1="165" x2="131" y2="165" stroke="#D1D5DB" stroke-width="1"/>
                            <line x1="119" y1="169" x2="131" y2="169" stroke="#D1D5DB" stroke-width="1"/>
                            <line x1="119" y1="173" x2="128" y2="173" stroke="#D1D5DB" stroke-width="1"/>
                        </svg>
                        <div class="mt-3 text-center">
                            <p class="text-xs font-semibold text-gray-900">Financial Excellence</p>
                            <p class="mt-1 text-xs text-gray-600">Track, Approve, Succeed</p>
                        </div>
                    @elseif(auth()->user()->isFinanceManager())
                        <!-- Finance Manager Illustration -->
                        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                            <circle cx="100" cy="100" r="90" fill="#FED7AA" opacity="0.3"/>
                            <ellipse cx="100" cy="55" rx="16" ry="18" fill="#374151"/>
                            <path d="M 84 71 Q 84 68 87 68 L 113 68 Q 116 68 116 71 L 116 100 L 84 100 Z" fill="#374151"/>
                            <rect x="77" y="73" width="7" height="30" rx="3" fill="#374151"/>
                            <rect x="116" y="73" width="7" height="30" rx="3" fill="#374151"/>
                            <rect x="90" y="100" width="9" height="25" fill="#9CA3AF"/>
                            <rect x="101" y="100" width="9" height="25" fill="#9CA3AF"/>
                            <rect x="55" y="80" width="40" height="50" rx="3" fill="white" stroke="#374151" stroke-width="2"/>
                            <rect x="60" y="85" width="30" height="8" rx="1" fill="#F97316"/>
                            <line x1="62" y1="98" x2="88" y2="98" stroke="#D1D5DB" stroke-width="2"/>
                            <line x1="62" y1="104" x2="88" y2="104" stroke="#D1D5DB" stroke-width="2"/>
                            <line x1="62" y1="110" x2="88" y2="110" stroke="#D1D5DB" stroke-width="2"/>
                            <line x1="62" y1="116" x2="80" y2="116" stroke="#D1D5DB" stroke-width="2"/>
                            <rect x="105" y="80" width="40" height="50" rx="3" fill="white" stroke="#374151" stroke-width="2"/>
                            <rect x="110" y="85" width="30" height="8" rx="1" fill="#F97316"/>
                            <line x1="112" y1="98" x2="138" y2="98" stroke="#D1D5DB" stroke-width="2"/>
                            <line x1="112" y1="104" x2="138" y2="104" stroke="#D1D5DB" stroke-width="2"/>
                            <line x1="112" y1="110" x2="138" y2="110" stroke="#D1D5DB" stroke-width="2"/>
                            <line x1="112" y1="116" x2="130" y2="116" stroke="#D1D5DB" stroke-width="2"/>
                            <rect x="65" y="140" width="70" height="45" rx="3" fill="#374151" stroke="#F97316" stroke-width="2"/>
                            <circle cx="80" cy="155" r="8" fill="#F97316"/>
                            <text x="80" y="160" font-size="10" fill="#374151" text-anchor="middle" font-weight="bold">$</text>
                            <circle cx="100" cy="155" r="8" fill="#F97316"/>
                            <text x="100" y="160" font-size="10" fill="#374151" text-anchor="middle" font-weight="bold">$</text>
                            <circle cx="120" cy="155" r="8" fill="#F97316"/>
                            <text x="120" y="160" font-size="10" fill="#374151" text-anchor="middle" font-weight="bold">$</text>
                            <rect x="70" y="168" width="60" height="3" fill="#F97316"/>
                            <rect x="70" y="173" width="60" height="3" fill="#F97316"/>
                            <rect x="70" y="178" width="45" height="3" fill="#F97316"/>
                        </svg>
                        <div class="mt-3 text-center">
                            <p class="text-xs font-semibold text-gray-900">Budget Management</p>
                            <p class="mt-1 text-xs text-gray-600">Plan, Review, Control</p>
                        </div>
                    @else
                        <!-- Staff Illustration -->
                        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                            <circle cx="100" cy="100" r="90" fill="#FED7AA" opacity="0.3"/>
                            <ellipse cx="100" cy="55" rx="16" ry="18" fill="#374151"/>
                            <path d="M 84 71 Q 84 68 87 68 L 113 68 Q 116 68 116 71 L 116 105 L 84 105 Z" fill="#374151"/>
                            <rect x="77" y="73" width="7" height="32" rx="3" fill="#374151"/>
                            <rect x="116" y="73" width="7" height="32" rx="3" fill="#374151"/>
                            <rect x="90" y="105" width="9" height="28" fill="#9CA3AF"/>
                            <rect x="101" y="105" width="9" height="28" fill="#9CA3AF"/>
                            <rect x="50" y="90" width="45" height="55" rx="3" fill="white" stroke="#374151" stroke-width="2"/>
                            <rect x="55" y="95" width="35" height="10" rx="1" fill="#F97316"/>
                            <line x1="58" y1="110" x2="87" y2="110" stroke="#D1D5DB" stroke-width="2"/>
                            <line x1="58" y1="117" x2="87" y2="117" stroke="#D1D5DB" stroke-width="2"/>
                            <line x1="58" y1="124" x2="87" y2="124" stroke="#D1D5DB" stroke-width="2"/>
                            <line x1="58" y1="131" x2="75" y2="131" stroke="#D1D5DB" stroke-width="2"/>
                            <circle cx="70" cy="138" r="3" fill="#F97316"/>
                            <text x="78" y="141" font-size="8" fill="#374151" font-weight="bold">Submit</text>
                            <rect x="105" y="90" width="45" height="55" rx="3" fill="white" stroke="#374151" stroke-width="2"/>
                            <circle cx="127" cy="110" r="12" fill="#F97316" opacity="0.2"/>
                            <path d="M 120 110 L 125 115 L 134 106" stroke="#F97316" stroke-width="3" fill="none" stroke-linecap="round"/>
                            <line x1="112" y1="128" x2="142" y2="128" stroke="#D1D5DB" stroke-width="2"/>
                            <line x1="112" y1="135" x2="142" y2="135" stroke="#D1D5DB" stroke-width="2"/>
                            <rect x="60" y="155" width="80" height="30" rx="3" fill="#374151" stroke="#F97316" stroke-width="2"/>
                            <path d="M 75 165 L 75 175 M 70 170 L 80 170" stroke="#F97316" stroke-width="2.5" stroke-linecap="round"/>
                            <text x="90" y="173" font-size="12" fill="#F97316" font-weight="bold">New Request</text>
                        </svg>
                        <div class="mt-3 text-center">
                            <p class="text-xs font-semibold text-gray-900">Request & Track</p>
                            <p class="mt-1 text-xs text-gray-600">Submit, Monitor, Succeed</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                    data-test="sidebar-menu-button"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
