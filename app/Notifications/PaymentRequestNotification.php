<?php

namespace App\Notifications;

use App\Models\PaymentRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class PaymentRequestNotification extends Notification
{
    use Queueable;

    public function __construct(
        public PaymentRequest $paymentRequest,
        public string $action,
        public ?string $actionBy = null
    ) {}

    public function via(object $notifiable): array
    {
        return [WebPushChannel::class, 'database'];
    }

    public function toWebPush($notifiable, $notification)
    {
        $title = match($this->action) {
            'submitted' => '🔔 New Payment Request',
            'approved_by_fm' => '✅ Request Approved by Finance Manager',
            'approved_by_ceo' => '✅ Request Approved by CEO',
            'rejected' => '❌ Request Rejected',
            default => '📋 Payment Request Update',
        };

        $body = match($this->action) {
            'submitted' => "{$this->paymentRequest->requester->name} submitted a payment request for \${$this->paymentRequest->amount}",
            'approved_by_fm' => "Your payment request #{$this->paymentRequest->id} was approved by {$this->actionBy}",
            'approved_by_ceo' => "Your payment request #{$this->paymentRequest->id} was approved by {$this->actionBy}",
            'rejected' => "Your payment request #{$this->paymentRequest->id} was rejected by {$this->actionBy}",
            default => "Payment request #{$this->paymentRequest->id} - {$this->paymentRequest->title}",
        };

        return (new WebPushMessage)
            ->title($title)
            ->icon('/mnotify-logo.svg')
            ->body($body)
            ->action('View Request', 'view_request')
            ->data(['id' => $this->paymentRequest->id])
            ->badge('/mnotify-logo.svg');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'payment_request_id' => $this->paymentRequest->id,
            'action' => $this->action,
            'action_by' => $this->actionBy,
            'title' => $this->paymentRequest->title,
            'amount' => $this->paymentRequest->amount,
            'requester' => $this->paymentRequest->requester->name,
        ];
    }
}
