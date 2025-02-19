<?php

declare(strict_types=1);

namespace App\Http\Controllers\Webhook\Jenkins;

use App\Handlers\Jenkins\WebhookHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Jenkins\WebhookRequest;
use Illuminate\Http\JsonResponse;

final class WebhookController extends Controller
{
    public function __invoke(string $project, WebhookRequest $request, WebhookHandler $handler): JsonResponse
    {
        $handler->handle($request->getDto(), $project);

        return $this->response();
    }
}
