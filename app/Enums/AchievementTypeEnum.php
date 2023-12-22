<?php


namespace App\Enums;

use App\Models\Comment;
use App\Models\Lesson;

enum AchievementTypeEnum:string
{
    case LESSON = Lesson::class;
    case COMMENT = Comment::class;
}
