<?php

declare(strict_types=1);

namespace App\DTO\Jenkins;

use App\DTO\Jenkins\WebhookRequestDTO\Build;
use Illuminate\Support\Arr;

/**
 * @phpstan-import-type BuildArray from Build
 * @phpstan-type WebhookRequestArray array{name: string, display_name: string, url: string, build: BuildArray}
 */
final readonly class WebhookRequestDTO
{
    public function __construct(
        public string $name,
        public string $displayName,
        public string $url,
        public Build  $build,
    ) {
    }

    /**
     * @param WebhookRequestArray $array
     */
    public static function fromArray(array $array): self
    {
        return new self(
            Arr::get($array, 'name'),
            Arr::get($array, 'display_name'),
            Arr::get($array, 'url'),
            Build::fromArray(Arr::get($array, 'build')),
        );
    }
}
