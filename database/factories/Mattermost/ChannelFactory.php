<?php

declare(strict_types=1);

namespace Database\Factories\Mattermost;

use App\Models\Mattermost\Channel;
use App\Models\Mattermost\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Channel>
 */
final class ChannelFactory extends Factory
{
    /**
     * @var class-string<Channel>
     */
    protected $model = Channel::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'team_id' => static fn (): string => Team::factory()->create()->getKey(),
            'name' => $this->faker->word,
            'display_name' => $this->faker->word,
        ];
    }
}
