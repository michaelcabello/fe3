<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class NotificationShipment extends Component
{

    public $notifications;


    public function mount(){
        $this->notifications = auth()->user()->notifications;
    }

    public function read($notification_id){
        $notification = auth()->user()->notifications()->findOrFail($notification_id);
        $notification->markAsRead();//guarda el campoone fecha al campo read_at
    }

    public function render()
    {
        return view('livewire.admin.notification-shipment');
    }
}
