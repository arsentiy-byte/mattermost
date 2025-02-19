<?php

declare(strict_types=1);

namespace App\Providers;

use App\Traits\ConfigTrait;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

final class AppServiceProvider extends ServiceProvider
{
    use ConfigTrait;

    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (self::isDevelopmentEnvironment() || self::isProductionEnvironment()) {
            URL::forceScheme('https');
        }
    }
}
