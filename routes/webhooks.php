<?php

declare(strict_types=1);

use App\Http\Controllers\Webhook\Jenkins\WebhookController;
use Illuminate\Support\Facades\Route;

Route::prefix('jenkins')->name('jenkins-')->group(function (): void {
    Route::post('{project}', WebhookController::class)->name('webhook');
});
