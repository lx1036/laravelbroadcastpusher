<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PusherEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $text, $id;
    private $content;
    protected $title;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($text, $id, $content, $title)
    {
        $this->text    = $text;
        $this->id      = $id;
        $this->content = $content;
        $this->title   = $title;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['laravel-broadcast-channel'];
    }
}
