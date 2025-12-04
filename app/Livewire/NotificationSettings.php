<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationSettings extends Component
{
    public $pushEnabled = false;
    public $checking = true;

    public function mount()
    {
        // Check if user has push subscriptions
        $this->pushEnabled = auth()->user()->pushSubscriptions()->exists();
        $this->checking = false;
    }

    public function render()
    {
        return view('livewire.notification-settings');
    }
}
