<?php

namespace Launcher\Larachatter\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Launcher\Larachatter\Repositories\ConversationRepository;

class UserStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     *  The User slug status changed.
     * 
     *  @var string
     */
    public $user;

    /**
     *  User goes active/idle/inactive
     * 
     * @var string
     */
    public $status;

    private $recipients;

    public function __construct($user, $status)
    {
        $this->user = $user;
        $this->status = $status;

        $this->recipients = (new ConversationRepository())->recipients();
    }

    public function broadcastAs()
    {
        return 'larachatter.user.status.changed';
    }

    public function broadcastWhen()
    {
        return count($this->recipients) > 0;
    }

    public function broadcastOn()
    {
        $channels = [];
        foreach ($this->recipients as $recipient) {
            $channels[] = new PrivateChannel('larachatter.'.$recipient);
        }

        return $channels;
    }
}
