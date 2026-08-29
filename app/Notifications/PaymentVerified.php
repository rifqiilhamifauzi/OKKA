<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class PaymentVerified extends Notification implements ShouldQueue
{
    use Queueable;

    public $registration;

    public function __construct($registration)
    {
        $this->registration = $registration;
    }

    public function via($notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Pembayaran Diverifikasi! 🎉')
            ->icon('/favicon.ico')
            ->body('Pembayaran Anda untuk event telah berhasil diverifikasi oleh admin.')
            ->action('Lihat Dashboard', '/dashboard')
            ->data(['url' => '/dashboard']);
    }
}
