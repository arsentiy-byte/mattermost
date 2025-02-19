<?php

declare(strict_types=1);

namespace App\Http\Middleware\Mattermost\Command;

use App\Models\Mattermost\Command;
use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

final class Authenticate
{
    use ResponseTrait;

    public function handle(Request $request, Closure $next): mixed
    {
        $token = $this->getToken($request);

        if (empty($token) || ! $this->checkToken($token)) {
            return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }

    private function getToken(Request $request): string
    {
        return Str::after($request->header('Authorization', ''), 'Token ');
    }

    private function checkToken(string $token): bool
    {
        return Command::query()->where('token', $token)->exists();
    }
}
