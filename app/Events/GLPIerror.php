<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GLPIerror
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

   
    /**
     * Create a new event instance.
     */
    public function __construct(int $typeError, string $message, string $param1, string $param2)
    {
        $this->typeError = $typeError;
        $this->message = $message;
        $this->param1 = $param1;
        $this->param2 = $param2;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }



    public $typeError;
    public $message ;
    public $param1;
    public $param2;
}
