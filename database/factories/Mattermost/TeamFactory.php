<?php

declare(strict_types=1);

namespace Database\Factories\Mattermost;

use App\Models\Mattermost\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Team>
 */
final class TeamFactory extends Factory
{
    /**
     * @var class-string<Team>
     */
    protected $model = Team::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->word,
            'display_name' => $this->faker->word,
        ];
    }
}
