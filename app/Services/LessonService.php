<?php

namespace App\Services;

use App\Models\User;

class LessonService
{
    public function getWatchedLessons(User $user)
    {
        return $user->watched->count();
    }
}
