<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationsSend implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $host_id;
    public $appoinments;

    public function __construct($host_id,$appoinments)
    {  
        $this->host_id = $host_id;
        $this->appoinments = $appoinments;
    }
    public function broadcastOn()
    {
        return new Channel('notifications'.$this->host_id);
    }

    public function broadcastAs()
    {
        return 'notification';
    }
}
