<?php

namespace App\Notifications;

use App\Models\TravelRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class TravelStatusChangedNotification extends Notification
{
    use Queueable;

    public function __construct(public TravelRequest $travelRequest) {}

    public function via($notifiable): array
    {
        return ['log']; // ou 'mail' se quiser enviar por e-mail
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "O status do pedido #{$this->travelRequest->id} foi alterado para '{$this->travelRequest->status}'.",
            'destination' => $this->travelRequest->destination,
            'dates' => "{$this->travelRequest->departure_date} → {$this->travelRequest->return_date}",
        ];
    }
}
