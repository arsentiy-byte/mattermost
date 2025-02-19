<?php

declare(strict_types=1);

namespace App\Http\Resources\Mattermost;

use Arsentiyz\MattermostDriver\DTO\CommandResponseDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CommandResponseDTO
 */
final class CommandResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return $this->map();
    }
}
