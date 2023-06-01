<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        \App\Utils\Breadcrumbs::class => \App\Utils\Breadcrumbs::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once base_path('app/helpers.php');

        $this->app->bind(
            \Illuminate\Database\Schema\Blueprint::class,
            \App\Utils\Database\Schema\Blueprint::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
        if (request()->routeIs('admin.*')) {
            Paginator::defaultView('admin.elements.pagination');
        } else {
            Paginator::defaultView('components.pagination');
        }

        $this->app->bind(
            \Illuminate\Pagination\LengthAwarePaginator::class,
            \App\Overwrites\Illuminate\Pagination\LengthAwarePaginator::class,
        );
    }
}