<?php

declare(strict_types=1);

namespace App\Http\Resources\Mattermost;

use Arsentiyz\MattermostDriver\DTO\ActionHookResponseDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ActionHookResponseDTO
 */
final class ActionHookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return $this->map();
    }
}
