<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $eventId;
    public $eventTitle;

    /**
     * Create a new event instance.
     */
    public function __construct(int $eventId, string $eventTitle)
    {
        $this->eventId = $eventId;
        $this->eventTitle = $eventTitle;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('events');
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'event.deleted';
    }

    /**
     * Get the data to broadcast.
     */
   public function broadcastWith(): array
{
    return [
        'id' => $this->eventId,
        'title' => $this->eventTitle,
        'message' => 'Event deleted: ' . $this->eventTitle,
    ];
}
}
