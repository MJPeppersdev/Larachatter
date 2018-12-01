<?php

namespace Launcher\Larachatter\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $receiver;

    public $sender;

    public $message;

    public function __construct($receiver, $sender, $message)
    {
        $this->receiver = $receiver;
        $this->sender = $sender;
        $this->message = $message;
    }

    public function broadcastAs()
    {
        return 'larachatter.message.sent';
    }

    public function broadcastOn()
    {
        return new PrivateChannel('larachatter.' .$this->receiver);
    }
}
