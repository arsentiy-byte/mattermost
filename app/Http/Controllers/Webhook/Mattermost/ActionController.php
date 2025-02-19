<?php

declare(strict_types=1);

namespace App\Http\Controllers\Webhook\Mattermost;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mattermost\ActionHookResource;
use Arsentiyz\MattermostDriver\DTO\ActionHookResponseDTO;
use Illuminate\Http\JsonResponse;

abstract class ActionController extends Controller
{
    protected function actionResponse(ActionHookResponseDTO $dto): JsonResponse
    {
        return $this->response(new ActionHookResource($dto));
    }
}
