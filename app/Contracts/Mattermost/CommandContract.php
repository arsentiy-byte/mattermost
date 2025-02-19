<?php

declare(strict_types=1);

namespace App\Contracts\Mattermost;

use Arsentiyz\MattermostDriver\DTO\CommandRequestDTO;
use Arsentiyz\MattermostDriver\DTO\CommandResponseDTO;

interface CommandContract
{
    public function call(CommandRequestDTO $dto): CommandResponseDTO;
}
