<?php

declare(strict_types=1);

namespace App\Http\Controllers\Commands\Mattermost;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mattermost\CommandResource;
use Arsentiyz\MattermostDriver\DTO\CommandResponseDTO;
use Illuminate\Http\JsonResponse;

abstract class CommandController extends Controller
{
    protected function commandResponse(CommandResponseDTO $dto): JsonResponse
    {
        return $this->response(new CommandResource($dto));
    }
}
