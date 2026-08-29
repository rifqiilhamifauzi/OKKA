<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class RegistrationStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public $status;
    public $registration;

    public function __construct($status, $registration)
    {
        $this->status = $status;
        $this->registration = $registration;
    }

    public function via($notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        $statusText = strtoupper($this->status);
        $body = $this->status === 'approved' 
                ? 'Selamat! Pendaftaran Anda telah disetujui.' 
                : "Status pendaftaran Anda saat ini adalah: {$statusText}";

        return (new WebPushMessage)
            ->title('Status Pendaftaran Diperbarui')
            ->icon('/favicon.ico')
            ->body($body)
            ->action('Lihat Dashboard', '/dashboard')
            ->data(['url' => '/dashboard']);
    }
}
