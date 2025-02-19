<?php

declare(strict_types=1);

namespace App\Http\Requests\Jenkins;

use App\DTO\Jenkins\WebhookRequestDTO;
use Illuminate\Foundation\Http\FormRequest;

final class WebhookRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'display_name' => ['required', 'string'],
            'url' => ['required', 'string'],
            'build' => ['required', 'array'],
            'build.full_url' => ['required', 'string'],
            'build.number' => ['required', 'integer'],
            'build.queue_id' => ['required', 'integer'],
            'build.timestamp' => ['required', 'integer'],
            'build.duration' => ['required', 'integer'],
            'build.phase' => ['required', 'string'],
            'build.status' => ['nullable', 'string'],
            'build.url' => ['required', 'string'],
            'build.scm' => ['required', 'array'],
            'build.scm.changes' => ['nullable', 'array'],
            'build.scm.culprits' => ['nullable', 'array'],
            'build.scm.branch' => ['nullable', 'string'],
            'build.scm.url' => ['nullable', 'string'],
            'build.scm.commit' => ['nullable', 'string'],
            'build.log' => ['nullable', 'string'],
            'build.notes' => ['nullable', 'string'],
            'build.artifacts' => ['nullable', 'array'],
        ];
    }

    public function getDto(): WebhookRequestDTO
    {
        return WebhookRequestDTO::fromArray($this->validated());
    }
}
