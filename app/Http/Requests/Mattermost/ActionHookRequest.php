<?php

declare(strict_types=1);

namespace App\Http\Requests\Mattermost;

use Arsentiyz\MattermostDriver\DTO\ActionHookRequestDTO;
use Illuminate\Foundation\Http\FormRequest;

final class ActionHookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'string'],
            'user_name' => ['required', 'string'],
            'channel_id' => ['required', 'string'],
            'channel_name' => ['required', 'string'],
            'team_id' => ['nullable', 'string'],
            'team_domain' => ['nullable', 'string'],
            'post_id' => ['required', 'string'],
            'trigger_id' => ['nullable', 'string'],
            'type' => ['nullable', 'string'],
            'data_source' => ['nullable', 'string'],
            'context' => ['nullable', 'array'],
        ];
    }

    public function getDto(): ActionHookRequestDTO
    {
        return ActionHookRequestDTO::fromArray($this->validated());
    }
}
