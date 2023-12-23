<?php

namespace App\Services;

use App\Enums\AchievementTypeEnum;
use App\Models\Achievement;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AchievementService
{
    private Model $model;

    public function __construct(Achievement $achievement)
    {
        $this->model = $achievement;
    }

    public function getCount(User $user): int
    {
        return $user->achievements->count();
    }

    public function getUnlockedAchievementNames(User $user): array
    {
        return $user->achievements->pluck('name')->toArray();
    }

    public function getNextAchievementForClass(User $user, int $currentRecordCount, string|AchievementTypeEnum $type): Achievement|null
    {
        return $this->model->where('min_required_entries', '>', $currentRecordCount)->where('class', $type)->first();
    }
}
