<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Lesson;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//        $lessons = Lesson::factory()
//            ->count(20)
//            ->create();

//        $user = User::factory()
//            ->count(20)
//            ->create();
//
        $comment = Comment::factory(['user_id' => 10])
            ->count(20)
            ->create();
//
//        $this->call([
//            BadgesSeeder::class,
//            AchievementsSeeder::class,
//        ]);
//        $user = User::factory()
//            ->count(5)
//            ->create();
    }
}
