<?php

namespace App\Utils\Admin;

use Illuminate\Support\Facades\Route;

class RouteHelper
{
    public static function register(): void
    {
        $config = config('admin.route');

        if ($config['type'] == 'subdomain') {
            self::registerSubdomainWeb($config['value']);
        } else {
            self::registerUrlWeb($config['value']);
        }
    }

    private static function registerSubdomainWeb(string $value): void
    {
        Route::domain($value)
            ->namespace('App\Http\Controllers\Admin')
            ->name('admin.')
            ->middleware('admin-web')
            ->group(fn () => self::registerRoutes());
    }

    private static function registerUrlWeb(string $value): void
    {
        Route::prefix($value)
            ->namespace('App\Http\Controllers\Admin')
            ->name('admin.')
            ->middleware('admin-web')
            ->group(fn () => self::registerRoutes());
    }

    private static function registerRoutes()
    {
        Route::middleware('guest:admin')
            ->namespace('Auth')
            ->group(function () {
                Route::get('login', 'FormController')->name('login');
                Route::post('login', 'LoginController');
            });

        Route::post('logout', 'Auth\\LogoutController')
            ->middleware('auth:admin')
            ->name('logout');

        Route::middleware('auth:admin')->group(base_path('routes/admin/web.php'));
    }
}