<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Bitrix\BitrixController;
use App\Http\Controllers\IndexController;
use App\Http\Middleware\Bitrix\BitrixEndpointsClient;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, 'index'])->name('base');

Route::prefix('bitrix')
    ->name('bitrix-')
    ->middleware(BitrixEndpointsClient::class)
    ->group(function (): void {
        Route::get('users', [BitrixController::class, 'users'])->name('users');
    });
