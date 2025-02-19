<?php

declare(strict_types=1);

namespace App\Http\Requests\Mattermost;

use Arsentiyz\MattermostDriver\DTO\DialogRequestDTO;
use Illuminate\Foundation\Http\FormRequest;

final class DialogRequest extends FormRequest
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
            'type' => ['required', 'string'],
            'callback_id' => ['nullable', 'string'],
            'state' => ['nullable', 'string'],
            'user_id' => ['required', 'string'],
            'channel_id' => ['required', 'string'],
            'team_id' => ['nullable', 'string'],
            'submission' => ['nullable', 'array'],
            'cancelled' => ['nullable', 'boolean'],
        ];
    }

    public function getDto(): DialogRequestDTO
    {
        return DialogRequestDTO::fromArray($this->validated());
    }
}
