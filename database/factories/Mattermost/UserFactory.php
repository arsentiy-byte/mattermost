<?php

declare(strict_types=1);

namespace Database\Factories\Mattermost;

use App\Models\Mattermost\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
final class UserFactory extends Factory
{
    /**
     * @var class-string<User>
     */
    protected $model = User::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid,
            'username' => $this->faker->userName,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'nickname' => $this->faker->userName,
            'email' => $this->faker->safeEmail,
        ];
    }
}
