<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', \App\Livewire\Dashboard::class)->name('dashboard');
    
    // Payment Requests
    Route::get('payment-requests', \App\Livewire\PaymentRequests\Index::class)->name('payment-requests.index');
    Route::get('payment-requests/create', \App\Livewire\PaymentRequests\Create::class)->name('payment-requests.create');
    Route::get('payment-requests/{paymentRequest}', \App\Livewire\PaymentRequests\Show::class)->name('payment-requests.show');
    
    // Budgets
    Route::get('budgets', \App\Livewire\Budgets\Index::class)->name('budgets.index');
    Route::get('budgets/create', \App\Livewire\Budgets\Create::class)->name('budgets.create');
    Route::get('budgets/{budget}', \App\Livewire\Budgets\Show::class)->name('budgets.show');
    
    // Users (Finance Manager only)
    Route::get('users', \App\Livewire\Users\Index::class)->name('users.index');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
