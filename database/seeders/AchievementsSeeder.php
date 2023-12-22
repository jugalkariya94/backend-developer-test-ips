<?php

namespace Database\Seeders;

use App\Enums\AchievementNameEnum;
use App\Enums\AchievementTypeEnum;
use App\Models\Achievement;
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
        }
    }
}
