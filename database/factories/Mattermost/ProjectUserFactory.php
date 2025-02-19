<?php

declare(strict_types=1);

namespace Database\Factories\Mattermost;

use App\Models\Mattermost\ChannelProject;
use App\Models\Mattermost\ProjectUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectUser>
 */
final class ProjectUserFactory extends Factory
{
    /**
     * @var class-string<ProjectUser>
     */
    protected $model = ProjectUser::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'channel_project_id' => static fn (): string => ChannelProject::factory()->create()->getKey(),
            'user_id' => static fn (): string => UserFactory::new()->create()->getKey(),
        ];
    }
}
