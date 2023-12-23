<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 *
 */
class BadgeUnlocked
{
    use Dispatchable, SerializesModels;

    /**
     * Name of the badge
     * @var string
     */
    public string $badgeName;

    /**
     * Model of the user who unlocks the achievement
     * @var User
     */
    public User $user;

    /**
     * Create a new event instance.
     */
    public function __construct(string $badgeName, User $user)
    {
        $this->badgeName = $badgeName;
        $this->user = $user;
    }

}
