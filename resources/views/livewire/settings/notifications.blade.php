<?php
use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<section class="w-full">
    @include('partials.settings-heading')
    <x-settings.layout :heading="__('Notifications')" :subheading="__('Manage how you receive notifications')">
        <div class="my-6 w-full">
            <livewire:notification-settings />
        </div>
    </x-settings.layout>
</section>
