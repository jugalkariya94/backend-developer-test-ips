<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BadgeService
{
    private Model $model;

    public function __construct(Badge $badge)
    {
        $this->model = $badge;
    }

    public function getCurrentBadge(User $user): Badge
    {
        return $user->current_badge;
    }

    public function getCurrentBadgeName(User $user): string
    {
        return $user->current_badge->name ?? "";
    }

    public function getNextBadge(User $user)
    {
        $currentUserBadgeRequirements = optional($user->current_badge)->min_required_achievements ?? 0;
        return $this->model->where('min_required_achievements', !empty($currentUserBadgeRequirements) ? '>' : 0, $currentUserBadgeRequirements)->orderBy('min_required_achievements')->first();
    }

}
