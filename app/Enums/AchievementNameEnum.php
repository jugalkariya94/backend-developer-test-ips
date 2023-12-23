<?php


namespace App\Enums;

enum AchievementNameEnum: string
{
    // Achievements for lessons
    case LESSONS_1 = 'First Lesson Watched';
    case LESSONS_5 = '5 Lessons Watched';
    case LESSONS_10 = '10 Lessons Watched';
    case LESSONS_25 = '25 Lessons Watched';
    case LESSONS_50 = '50 Lessons Watched';

    // Achievements for comments
    case COMMENTS_1 = 'First Comment Written';
    case COMMENTS_3 = '3 Comments Written';
    case COMMENTS_5 = '5 Comments Written';
    case COMMENTS_10 = '10 Comments Written';
    case COMMENTS_20 = '20 Comments Written';
}
