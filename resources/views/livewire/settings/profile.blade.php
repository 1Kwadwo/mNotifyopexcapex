<?php
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;
    
    public string $name = '';
    public string $email = '';
    public $photo;
    
    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }
    
    /**
     * Update the profile photo.
     */
    public function updatePhoto(): void
    {
        $this->validate([
            'photo' => ['required', 'image', 'max:2048'], // 2MB max
        ]);
        
        $user = Auth::user();
        
        // Delete old photo if exists
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }
        
        // Store new photo
        $path = $this->photo->store('profile-photos', 'public');
        
        $user->profile_photo_path = $path;
        $user->save();
        
        $this->photo = null;
        $this->dispatch('photo-updated');
    }
    
    /**
     * Delete the profile photo.
     */
    public function deletePhoto(): void
    {
        $user = Auth::user();
        
        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
            $user->profile_photo_path = null;
            $user->save();
            
            $this->dispatch('photo-updated');
        }
    }
    
    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id)
            ],
        ]);
        $user->fill($validated);
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();
        $this->dispatch('profile-updated', name: $user->name);
    }
    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();
        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));
            return;
        }
        $user->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }
}; ?>
<section class="w-full">
    @include('partials.settings-heading')
    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <!-- Profile Photo Section -->
        <div class="my-6 w-full">
            <flux:heading size="lg">{{ __('Profile Photo') }}</flux:heading>
            <flux:subheading>{{ __('Update your profile picture') }}</flux:subheading>
            
            <div class="mt-4 flex items-center gap-6">
                <!-- Current Photo -->
                <div class="relative">
                    @if(auth()->user()->profile_photo_path)
                        <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" 
                             alt="{{ auth()->user()->name }}" 
                             class="h-24 w-24 rounded-full object-cover ring-2 ring-gray-200" />
                    @else
                        <div class="flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-orange-400 to-orange-600 text-3xl font-bold text-white ring-2 ring-gray-200">
                            {{ auth()->user()->initials() }}
                        </div>
                    @endif
                </div>
                
                <!-- Upload Controls -->
                <div class="flex-1 space-y-4">
                    <div>
                        <input type="file" wire:model="photo" accept="image/*" id="photo-upload" class="hidden" />
                        <flux:button type="button" variant="outline" onclick="document.getElementById('photo-upload').click()">
                            {{ __('Choose Photo') }}
                        </flux:button>
                        
                        @if(auth()->user()->profile_photo_path)
                            <flux:button type="button" variant="ghost" wire:click="deletePhoto" class="ml-2">
                                {{ __('Remove Photo') }}
                            </flux:button>
                        @endif
                    </div>
                    
                    @if ($photo)
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-600">{{ $photo->getClientOriginalName() }}</span>
                            <flux:button type="button" variant="primary" size="sm" wire:click="updatePhoto">
                                {{ __('Upload') }}
                            </flux:button>
                        </div>
                    @endif
                    
                    @error('photo')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                    
                    <p class="text-xs text-gray-500">JPG, PNG or GIF. Max size 2MB.</p>
                </div>
            </div>
        </div>
        
        <flux:separator />
        
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />
            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />
                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}
                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>
                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full" data-test="update-profile-button">
                        {{ __('Save') }}
                    </flux:button>
                </div>
                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
