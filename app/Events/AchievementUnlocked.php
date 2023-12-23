<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 *
 */
class AchievementUnlocked
{
    use Dispatchable, SerializesModels;

    /**
     * Name of the achievement
     * @var string
     */
    public string $achievementName;

    /**
     * Model of the user who unlocks the achievement
     * @var User
     */
    public User $user;

    /**
     * Create a new event instance.
     */
    public function __construct(string $achievementName, User $user)
    {
        $this->achievementName = $achievementName;
        $this->user = $user;
    }

}
