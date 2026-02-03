<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private Message $message)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pesan Baru dari Form Kontak')
            ->greeting('Halo Admin,')
            ->line('Anda menerima pesan baru melalui form kontak website:')
            ->line('Nama: ' . $this->message->nama)
            ->line('Email: ' . $this->message->email)
            ->line('Pesan:')
            ->line($this->message->pesan)
            ->action('Buka Admin Panel', url('/admin/messages'))
            ->line('Terima kasih.');
    }
}
