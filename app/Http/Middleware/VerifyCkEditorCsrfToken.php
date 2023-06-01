<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class VerifyCkEditorCsrfToken
{
    const TOKEN_NAME = 'ckCsrfToken';
    const COOKIE_NAME = 'ckCsrfToken';
    const TOKEN_MIN_LENGTH = 32;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $paramToken = trim((string)$request->get(self::TOKEN_NAME));
        $cookieToken = trim((string)$request->cookies->get(self::COOKIE_NAME));

        if (
            strlen($paramToken) >= self::TOKEN_MIN_LENGTH
            && strlen($cookieToken) >= self::TOKEN_MIN_LENGTH
            && $paramToken == $cookieToken
        ) {
            return $next($request);
        }

        return abort(401);
    }
}
