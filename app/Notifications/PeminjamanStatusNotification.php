<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PeminjamanStatusNotification extends Notification
{
    use Queueable;

    protected $status;
    protected $keterangan;

    public function __construct($status, $keterangan = null)
    {
        $this->status = $status;
        $this->keterangan = $keterangan;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Status peminjaman Anda telah diperbarui.')
            ->line('Status: ' . ucfirst($this->status))
            ->line('Keterangan: ' . ($this->keterangan ?? '-'))
            ->action('Lihat Detail', url('/riwayat'))
            ->line('Terima kasih telah menggunakan JURPIN.');
    }

    public function toArray($notifiable)
    {
        return [
            'status' => $this->status,
            'keterangan' => $this->keterangan,
        ];
    }
}
