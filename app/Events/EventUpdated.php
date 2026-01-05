<?php

namespace App\Events;

use App\Models\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $event;

    /**
     * Create a new event instance.
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
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
        return 'event.updated';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
            return [
            'id' => $this->event->id,
            'title' => $this->event->title,
            'description' => $this->event->description,
            'location' => $this->event->location,
            'event_date' => $this->event->formatted_event_date,
            'user_name' => $this->event->user->name,
            'status' => $this->event->status,
            'message' => 'Event updated: ' . $this->event->title,
        ];
    }
}
