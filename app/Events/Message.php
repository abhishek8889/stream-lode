<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Message implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $username;
    public $message;
    public $sender_id;
    public $reciever_id;
    public $time;

    public function __construct($username,$message,$sender_id,$reciever_id,$time)
    {  
        $this->username = $username;
        $this->message = $message;
        $this->sender_id = $sender_id;
        $this->reciever_id = $reciever_id;
        $this->time = $time;
    }
    public function broadcastOn()
    {
        return new Channel('chat'.$this->reciever_id);
    }
    public function broadcastAs()
    {
        return 'message';
    }
}
