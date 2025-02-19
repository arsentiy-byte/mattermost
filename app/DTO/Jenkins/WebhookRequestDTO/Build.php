<?php

declare(strict_types=1);

namespace App\DTO\Jenkins\WebhookRequestDTO;

use App\DTO\Jenkins\WebhookRequestDTO\Build\Scm;
use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;

/**
 * @phpstan-import-type ScmArray from Scm
 * @phpstan-type BuildArray array{fullUrl: string, number: int, queueId: int, timestamp: string, duration: int, phase: string, status?: string, url: string, scm?: ScmArray, log?: string, notes?: string, artifacts?: array}
 */
final readonly class Build
{
    public function __construct(
        public string          $fullUrl,
        public int             $number,
        public int             $queueId,
        public CarbonImmutable $timestamp,
        public int             $duration,
        public string          $phase,
        public ?string         $status,
        public string          $url,
        public Scm             $scm,
        public ?string         $log,
        public ?string         $notes,
        public ?array          $artifacts,
    ) {
    }

    /**
     * @param BuildArray $array
     */
    public static function fromArray(array $array): self
    {
        return new self(
            Arr::get($array, 'full_url'),
            (int)Arr::get($array, 'number'),
            (int)Arr::get($array, 'queue_id'),
            CarbonImmutable::parse(Arr::get($array, 'timestamp')),
            (int)Arr::get($array, 'duration'),
            Arr::get($array, 'phase'),
            Arr::get($array, 'status'),
            Arr::get($array, 'url'),
            Scm::fromArray(Arr::get($array, 'scm')),
            Arr::get($array, 'log'),
            Arr::get($array, 'notes'),
            Arr::get($array, 'artifacts'),
        );
    }
}
