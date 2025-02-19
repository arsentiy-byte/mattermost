<?php

declare(strict_types=1);

namespace App\DTO\Jenkins\WebhookRequestDTO\Build;

use Illuminate\Support\Arr;

/**
 * @phpstan-type ScmArray array{changes?: array, culprit?: array, branch?: string|null, url?: string|null, commit?: string|null}
 */
final readonly class Scm
{
    public function __construct(
        public array   $changes,
        public array   $culprits,
        public ?string $branch,
        public ?string $url,
        public ?string $commit,
    ) {
    }

    /**
     * @param ScmArray $array
     */
    public static function fromArray(array $array): self
    {
        return new self(
            Arr::get($array, 'changes', []),
            Arr::get($array, 'culprits', []),
            Arr::get($array, 'branch'),
            Arr::get($array, 'url'),
            Arr::get($array, 'commit'),
        );
    }
}
