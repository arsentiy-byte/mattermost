<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait ConfigTrait
{
    protected static function isTestingEnvironment(): bool
    {
        return (bool)App::environment('testing');
    }

    protected static function isProductionEnvironment(): bool
    {
        return App::isProduction();
    }

    protected static function isDevelopmentEnvironment(): bool
    {
        return (bool)App::environment('development');
    }

    protected static function getEnvironment(): bool|string
    {
        return App::environment();
    }

    /**
     * @return array<string, string>
     */
    protected static function getAvailableLocales(): array
    {
        return config('app.available_locales', []);
    }

    protected static function setCurrentLocale(string $locale): void
    {
        App::setLocale($locale);
    }

    protected static function getCurrentLocale(): string
    {
        return App::getLocale();
    }

    protected static function getHost(): string
    {
        return config('app.url', 'http://localhost');
    }

    protected static function getTimezone(): string
    {
        return config('app.timezone', 'UTC');
    }

    protected static function getMattermostCommandHook(): string
    {
        return sprintf('%s/commands/mattermost/', self::getHost());
    }

    protected static function getJenkinsHost(): string
    {
        return config('jenkins.host');
    }
}
