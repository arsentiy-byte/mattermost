<?php

declare(strict_types=1);

namespace Database\Factories\Mattermost;

use App\Models\Mattermost\Command;
use App\Models\Mattermost\Team;
use Arsentiyz\MattermostDriver\Enums\Command\Method;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Command>
 */
final class CommandFactory extends Factory
{
    /**
     * @var class-string<Command>
     */
    protected $model = Command::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'external_id' => $this->faker->uuid,
            'token' => $this->faker->uuid,
            'create_at' => $this->faker->dateTime,
            'update_at' => $this->faker->dateTime,
            'delete_at' => null,
            'creator_id' => $this->faker->uuid,
            'team_id' => static fn (): string => Team::factory()->create()->getKey(),
            'trigger' => $this->faker->word,
            'method' => $this->faker->randomElement(Method::cases()),
            'username' => $this->faker->userName,
            'icon_url' => $this->faker->url,
            'auto_complete' => $this->faker->boolean,
            'auto_complete_desc' => $this->faker->sentence,
            'auto_complete_hint' => $this->faker->sentence,
            'display_name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'url' => $this->faker->url,
        ];
    }
}
