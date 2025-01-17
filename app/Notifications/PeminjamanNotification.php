<?php

namespace App\Notifications;

use App\Models\Pinjaman;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PeminjamanNotification extends Notification
{
    use Queueable;
    private $pinjaman;

    /**
     * Create a new notification instance.
     */
    public function __construct($pinjaman)
    {
        $this->pinjaman = $pinjaman;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Peminjaman dengan kode ' . $this->pinjaman->kode_pinjaman . ' perlu diapprove',
            'peminjaman_id' => $this->pinjaman->id,
            'peminjaman_kode' => $this->pinjaman->kode_pinjaman,
            'peminjaman_created_at' => $this->pinjaman->created_at,
        ];
    }
}
