<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model
 */
trait HasLogPanelName
{
    public function getCustomLogPanelName(string $custom, bool $withKey = true): string
    {
        return $withKey ? sprintf('%s #%d', $custom, $this->getKey()) : $custom;
    }

    public function getLogPanelName(string $attribute, bool $withKey = true): ?string
    {
        /** @var string|null $title */
        $title = $this->getAttribute($attribute);

        if (empty($title)) {
            return null;
        }

        return $withKey ? sprintf('%s #%d', $title, $this->getKey()) : $title;
    }
}
