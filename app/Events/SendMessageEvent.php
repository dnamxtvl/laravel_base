<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendMessageEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $toUserId;
    public $message;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user, $toUserId, $message)
    {
        $this->user = $user;
        $this->toUserId = $toUserId;
        $this->message = $message;
    }

    public function broadcastOn(): Channel|PrivateChannel|array
    {
        return new PrivateChannel('chat-single.' . $this->toUserId);
    }
}
