<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Traits\ConfigTrait;
use Closure;
use Exception;
use Illuminate\Http\Request;

final class LocalizationMiddleware
{
    use ConfigTrait;

    /**
     * Handle request.
     *
     *
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (in_array($locale = $request->headers->get('Accept-Language'), self::getAvailableLocales(), true)) {
            self::setCurrentLocale($locale);
        } else {
            self::setCurrentLocale(self::getCurrentLocale());
        }

        return $next($request);
    }
}
