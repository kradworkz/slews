<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PacketReceiver implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $packet;
   
    public function __construct($packet)
    {
        $this->packet= $packet;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('public-channel');
    }

    public function broadcastWith()
    {   
        // $json = \json_decode($this->event->value);
        // $array = \json_decode($json);
      
        return [
            'id' => $this->packet->id,
            'accelerometer' => $this->packet->accelerometer,
            'gyro' => $this->packet->gyro,
            'soilmoisture' => $this->packet->soilmoisture,
            'temperature' => $this->packet->temperature,
            'time' =>  $this->packet->created_at,
        ];
    }
}
