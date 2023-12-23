<?php

namespace Database\Seeders;

use App\Enums\AchievementNameEnum;
use App\Enums\AchievementTypeEnum;
use App\Events\AchievementUnlocked;
use App\Models\Achievement;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AchievementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $achievementNames = AchievementNameEnum::cases();

        foreach ($achievementNames as $achievementName) {

            $minRequiredPoints = Str::after($achievementName->name, '_');
            $type = AchievementTypeEnum::from('App\\Models\\' . Str::title(Str::singular(Str::before($achievementName->name, '_'))));

            Achievement::updateOrCreate(['name' => $achievementName], ['class' => $type, 'min_required_entries' => $minRequiredPoints]);


            $users = User::all();

            foreach ($users as $user) {
                // get total watched lessons count for the user
                $totalWatchedLessonsCount = $user->watched->count();

                // get lesson achievements
                $lessonAchievements = Achievement::where('min_required_entries', '<=', $totalWatchedLessonsCount)->where('class', Lesson::class)->get();

                foreach ($lessonAchievements as $lessonAchievement) {
                    event(new AchievementUnlocked($lessonAchievement->name, $user));
                }

                // get total comment count for the user
                $totalCommentCount = $user->comments->count();
                // get comment achievements for the user
                $commentAchievements = Achievement::where('min_required_entries', '<=', $totalCommentCount)->where('class', Comment::class)->get();

                foreach ($commentAchievements as $commentAchievement) {
                    event(new AchievementUnlocked($commentAchievement->name, $user));
                }
            }
        }
    }
}
