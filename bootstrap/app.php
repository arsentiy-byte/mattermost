<?php

declare(strict_types=1);

use App\Http\Middleware\LocalizationMiddleware;
use App\Http\Middleware\Mattermost\Command\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function (): void {
            Illuminate\Support\Facades\Route::prefix('webhooks')
                ->name('webhooks-')
                ->group(base_path('routes/webhooks.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api([
            LocalizationMiddleware::class,
        ]);

        $middleware->alias([
            'mm-command-auth' => Authenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

    })->create();
