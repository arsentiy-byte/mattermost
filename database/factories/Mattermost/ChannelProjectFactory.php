<?php

declare(strict_types=1);

namespace Database\Factories\Mattermost;

use App\Models\Mattermost\Channel;
use App\Models\Mattermost\ChannelProject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ChannelProject>
 */
final class ChannelProjectFactory extends Factory
{
    /**
     * @var class-string<ChannelProject>
     */
    protected $model = ChannelProject::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'channel_id' => static fn (): string => Channel::factory()->create()->getKey(),
            'project' => $this->faker->word,
            'workflow_enabled' => $this->faker->boolean,
        ];
    }
}
