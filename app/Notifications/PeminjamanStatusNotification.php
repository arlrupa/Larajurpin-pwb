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
            ->subject('Status Peminjaman Anda Telah Diperbarui')
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line('Status peminjaman Anda telah diperbarui menjadi: *' . strtoupper($this->status) . '*.')
            ->when($this->keterangan, fn($msg) => $msg->line('Keterangan: ' . $this->keterangan))
            ->line('Terima kasih telah menggunakan layanan kami.');
    }

    public function toArray($notifiable)
    {
        return [
            'status' => $this->status,
            'keterangan' => $this->keterangan,
        ];
    }
}
