<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\ChatsMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ReceiveMessages implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $data;
    private Chat $chat;

    /**
     * Create a new event instance.
     */
    public function __construct(Chat $chat, ChatsMessage $message)
    {
        $this->chat = $chat;
        $this->data = [
            'message' => $message->message,
            'sender' => $message->sender,
            'date' => now()->format('Y/m/d h:i:s'),
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel(sprintf('chat-room-%s', $this->chat->id)),
        ];
    }
}
