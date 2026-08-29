<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class NewAnnouncement extends Notification implements ShouldQueue
{
    use Queueable;

    public $announcement;

    public function __construct($announcement)
    {
        $this->announcement = $announcement;
    }

    public function via($notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Pengumuman Baru: ' . $this->announcement->title)
            ->icon('/favicon.ico')
            ->body(substr(strip_tags($this->announcement->content), 0, 100) . '...')
            ->action('Baca Selengkapnya', '/dashboard')
            ->data(['url' => '/dashboard']);
    }
}
