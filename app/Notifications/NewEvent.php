<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class NewEvent extends Notification implements ShouldQueue
{
    use Queueable;

    public $event;

    public function __construct($event)
    {
        $this->event = $event;
    }

    public function via($notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Event Baru OKKA!')
            ->icon('/favicon.ico')
            ->body('Event baru: ' . $this->event->name . ' telah dibuka. Segera daftar!')
            ->action('Lihat Detail', '/dashboard')
            ->data(['url' => '/dashboard']);
    }
}
