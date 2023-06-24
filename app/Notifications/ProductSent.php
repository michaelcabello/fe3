<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductSent extends Notification
{
    use Queueable;

    public $shipment;


    public function __construct( $shipment)
    {
       $this->shipment = $shipment;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {

        return (new MailMessage)
                    ->error() //color rojo del boton
                    ->line('Tienes un envio.')
                    ->greeting('Bienvenido a TICOM')
                    ->line('Para ver el envío hacer click aqui.')
                    ->action('ver Envio', url('admin/shipments/'.strval($this->shipment->id)))
                    ->line('Hasta Pronto');

    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
