<?php


namespace App\Enums;

enum BadgeNameEnum: string
{
    // Badges name for users
    case BEGINNER = 'Beginner';
    case INTERMEDIATE = 'Intermediate';
    case ADVANCED = 'Advanced';
    case MASTER = 'Master';
}
