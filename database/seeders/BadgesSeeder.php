<?php

namespace Database\Seeders;

use App\Enums\BadgeNameEnum;
use App\Events\BadgeUnlocked;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $badgesDetails = [
            [
                'name' => BadgeNameEnum::BEGINNER,
                'min_required_achievements' => 0,
            ],
            [
                'name' => BadgeNameEnum::INTERMEDIATE,
                'min_required_achievements' => 4,
            ],
            [
                'name' => BadgeNameEnum::ADVANCED,
                'min_required_achievements' => 8,
            ],
            [
                'name' => BadgeNameEnum::MASTER,
                'min_required_achievements' => 10,
            ],
        ];

        foreach ($badgesDetails as $badgesDetail) {
            Badge::updateOrCreate(['name' => $badgesDetail['name']],  ['min_required_achievements' => $badgesDetail['min_required_achievements']]);
        }

        // Assign badge to all the current users accordingly
        $users = User::all();

        foreach ($users as $user) {
            // get all the required badges for the users based on their current achievements

            $badges = Badge::where('min_required_achievements', '<=', count($user->achievements))->get();

            foreach ($badges as $badge) {
                event( new BadgeUnlocked($badge->name, $user));
            }
        }
    }
}
