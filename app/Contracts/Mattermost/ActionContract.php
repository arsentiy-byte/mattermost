<?php

declare(strict_types=1);

namespace App\Contracts\Mattermost;

use Arsentiyz\MattermostDriver\DTO\ActionHookRequestDTO;
use Arsentiyz\MattermostDriver\DTO\ActionHookResponseDTO;

interface ActionContract
{
    public function do(ActionHookRequestDTO $dto): ActionHookResponseDTO;
}
