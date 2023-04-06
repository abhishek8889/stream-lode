<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendStreamPaymentRequest implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $appointment_id;
    public $stream_amount;
    public $currency;
    public $message;

    public function __construct($stream_amount,$currency,$appointment_id,$message)
    {  
        $this->stream_amount = $stream_amount;
        $this->currency = $currency;
        $this->appointment_id = $appointment_id;
        $this->message = $message;
    }
    public function broadcastOn()
    {
        return new Channel('sendStreamRequest');
    }
    public function broadcastAs()
    {
        return 'streamPaymentRequest';
    }
}
