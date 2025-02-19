<?php

declare(strict_types=1);

namespace App\Http\Requests\Mattermost;

use App\Models\Mattermost\Command;
use Arsentiyz\MattermostDriver\DTO\CommandRequestDTO;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

final class CommandRequest extends FormRequest
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
            'channel_id' => ['required', 'string'],
            'channel_name' => ['required', 'string'],
            'command' => ['required', 'string'],
            'response_url' => ['required', 'string'],
            'team_domain' => ['required', 'string'],
            'team_id' => ['required', 'string'],
            'text' => ['nullable', 'string'],
            'token' => ['required', 'string', new Exists(Command::class, 'token')],
            'trigger_id' => ['required', 'string'],
            'user_id' => ['required', 'string'],
            'user_name' => ['required', 'string'],
        ];
    }

    public function getDto(): CommandRequestDTO
    {
        return CommandRequestDTO::fromArray($this->validated());
    }
}
