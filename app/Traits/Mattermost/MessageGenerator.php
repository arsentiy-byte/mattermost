<?php

declare(strict_types=1);

namespace App\Traits\Mattermost;

trait MessageGenerator
{
    public function randomEmoji(): string
    {
        $emojis = [':palm_tree:', ':mountain:', ':high_brightness:', ':sun_with_face:', ':thinking_face:'];

        return $emojis[array_rand($emojis)];
    }
}
