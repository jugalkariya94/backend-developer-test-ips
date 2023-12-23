<?php

namespace App\Services;

use App\Models\User;

class CommentService
{
    public function getCount(User $user)
    {
        return $user->comments->count();
    }
}
