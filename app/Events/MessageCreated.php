<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class MessageCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Message $message) {}

    public function broadcastOn(): array
    {
        return [new PrivateChannel('conversation.' . $this->message->conversation_id),];
    }

    public function broadcastAs(): string
    {
        return 'MessageCreated';
    }

    public function broadcastWith(): array
    {
        return [
            'message' => [
                'id'            => $this->message->id,
                'body'          => $this->message->body,
                'created_at'    => $this->message->created_at->toISOString(),
                'user'          => [
                    'id'    => $this->message->user_id,
                    'name'  => $this->message->user->name ?? '',
                ]
            ]
        ];
    }
}
