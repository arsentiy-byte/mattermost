<?php

declare(strict_types=1);

namespace App\Contracts;

interface LoggableModelInterface
{
    public function getLogPanelNameAttribute(): ?string;

    public function getLogSubjectTypeAttribute(): string;
}
