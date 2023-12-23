<?php

namespace Tests\Feature;

use App\Enums\AchievementNameEnum;
use App\Enums\BadgeNameEnum;
use App\Models\User;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $user = User::first();
        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200);
    }

    public function test_the_application_returns_a_successful_response_for_valid_user(): void
    {
        $user = User::first();

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'unlocked_achievements',
                'next_available_achievements',
                'current_badge',
                'next_badge',
                'remaining_to_unlock_next_badge'
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json->whereAllType([
                    'unlocked_achievements' => 'array',
                    'next_available_achievements' => 'array',
                    'current_badge' => 'string',
                    'next_badge' => 'string',
                    'remaining_to_unlock_next_badge' => 'integer'
                ])

            );
        ;
    }

    public function test_the_application_returns_a_404_response_for_invalid_user(): void
    {
        $response = $this->get("/users/abc/achievements");

        $response->assertStatus(404);
    }

    public function test_returns_empty_arrays_for_user_with_no_achievements_and_badges()
    {
        $user = User::factory()->create();

        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200)
            ->assertJson([
                'unlocked_achievements' => [],
                'next_available_achievements' => [
                    AchievementNameEnum::LESSONS_1->value,
                    AchievementNameEnum::COMMENTS_1->value,
                ],
                'current_badge' => '',
                'next_badge' => BadgeNameEnum::BEGINNER->value,
                'remaining_to_unlock_next_badge' => 0
            ]);
    }
}
