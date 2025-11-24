<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />
        
        <div class="text-center">
            <h2 class="text-xl font-semibold" style="color: #000000 !important;">Log in to your account</h2>
            <p class="mt-1 text-sm" style="color: #6b7280 !important;">Enter your email and password below to log in</p>
        </div>
        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />
            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                    viewable
                />
                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </flux:link>
                @endif
            </div>
            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />
            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('Log in') }}
                </flux:button>
            </div>
        </form>
        <div class="space-x-1 text-sm text-center rtl:space-x-reverse" style="color: #000000 !important;">
            <span style="color: #000000 !important;">{{ __('Need access?') }}</span>
            <a href="mailto:finance@example.com?subject=Access Request for mNotify BudgetIQ&body=Hi mNotify Financial Manager,%0D%0A%0D%0AI am a staff member and I would like to request access to the mNotify BudgetIQ system.%0D%0A%0D%0AMy email address is: [Your Email]%0D%0A%0D%0AThank you." 
               class="font-medium text-orange-600 hover:text-orange-500" style="color: #f97316 !important;">
                {{ __('Contact Financial Manager') }}
            </a>
        </div>
    </div>
</x-layouts.auth>
