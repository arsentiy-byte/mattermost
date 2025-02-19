<?php

declare(strict_types=1);

namespace App\Traits;

trait LocalizationTrait
{
    protected function translate(string $key, array $replace = [], ?string $locale = null): ?string
    {
        return __($key, $replace, $locale);
    }
}
