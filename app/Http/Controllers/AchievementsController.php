<?php

namespace App\Http\Controllers;

use App\Enums\AchievementTypeEnum;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use App\Services\AchievementService;
use App\Services\BadgeService;
use App\Services\CommentService;
use App\Services\LessonService;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    protected $commentService;
    protected $lessonService;
    protected $achievementService;
    protected $badgeService;

    public function __construct(
        CommentService $commentService,
        LessonService $lessonService,
        AchievementService $achievementService,
        BadgeService $badgeService
    ) {
        $this->commentService = $commentService;
        $this->lessonService = $lessonService;
        $this->achievementService = $achievementService;
        $this->badgeService = $badgeService;
    }
    public function index(User $user)
    {
        // get user data
        $totalCommentCount = $this->commentService->getCount($user);
        $totalWatchedLessonsCount = $this->lessonService->getWatchedLessons($user);
        $totalAchievements = $this->achievementService->getCount($user);

        // get next available achievements / badge to unlock
        $nextLessonAchievement = $this->achievementService->getNextAchievement($user, $totalWatchedLessonsCount, AchievementTypeEnum::LESSON);
        $nextCommentAchievement = $this->achievementService->getNextAchievement($user, $totalCommentCount, AchievementTypeEnum::COMMENT);

        $nextBadge = $this->badgeService->getNextBadge($user);
        $remainingForNextBadge = ($nextBadge) ? ($nextBadge->min_required_achievements - $totalAchievements) : 0;

        return response()->json([
            'unlocked_achievements' => $this->achievementService->getUnlockedAchievementNames($user),
            'next_available_achievements' => [
                $nextLessonAchievement->name,
                $nextCommentAchievement->name,
            ],
            'current_badge' => $this->badgeService->getCurrentBadgeName($user),
            'next_badge' => $nextBadge->name,
            'remaining_to_unlock_next_badge' => $remainingForNextBadge,
        ]);
    }
}
