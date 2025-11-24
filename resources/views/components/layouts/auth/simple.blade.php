<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased" style="background-color: #ffffff !important;">
        <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10" style="background-color: #ffffff !important;">
            <div class="flex w-full max-w-sm flex-col gap-8">
                <div class="flex flex-col items-center gap-3">
                    <img src="/mnotify-logo.svg" alt="mNotify | BudgetIQ" class="h-12 w-auto" />
                    <p class="text-sm text-center" style="color: #6b7280 !important;">OPEX/CAPEX Management System</p>
                </div>
                <div class="flex flex-col gap-6" style="color: #000000 !important;">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
