<?php

namespace App\Events;

use App\Models\Group;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupChatSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;
    public Group $group;
    public string $message;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user,Group $group, string $message)
    {
        $this->user = $user;
        $this->message = $message;
        $this->group = $group;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('group-chat' . $this->group->id),
        ];
    }

    /**
     * Define the event's broadcast name.
     */
    public function broadcastAs()
    {
        return 'GroupChatSent';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith()
    {
        return [
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'photo' => $this->user->photo,
            ],
            'message' => $this->message,
        ];
    }
}
