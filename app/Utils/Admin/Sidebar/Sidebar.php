<?php

namespace App\Utils\Admin\Sidebar;

use App\Utils\Admin\Sidebar\Structure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Route;

class Sidebar
{
    private Structure $structure;

    function __construct()
    {
        $this->structure = new Structure();
    }

    public function getStructure(): array
    {
        return $this->structure->getStructure();
    }

    public function section(string $name, \Closure $closure): void
    {
        $structure = $this->parseClosure($closure);

        if ($structure->hasItems()) {
            $this->structure->add([
                'type' => 'section',
                'name' => $name,
                'items' => $structure->getStructure(),
                'active' => $structure->isActive(),
            ]);
        }
    }

    public function group(string $name, \Closure $closure): void
    {
        $structure = $this->parseClosure($closure);

        if ($structure->hasItems()) {
            $this->structure->add([
                'type' => 'group',
                'name' => $name,
                'items' => $structure->getStructure(),
                'active' => $structure->isActive(),
            ]);
        }
    }

    private function parseClosure(\Closure $closure): Structure
    {
        $prevStructure = $this->structure;
        $structure = new Structure();
        $this->structure = $structure;

        $closure->__invoke();

        $this->structure = $prevStructure;
        return $structure;
    }

    public function link(string $name, string $route): void
    {
        if ($this->routeIsAuthorized($route)) {
            $isActive = $this->routeIsActive($route);

            $this->structure->add([
                'type' => 'link',
                'name' => $name,
                'route' => $route,
                'url' => route($route),
                'active' => $isActive,
            ]);

            if ($isActive) {
                $this->structure->active(true);
            }
        }
    }

    private function routeIsAuthorized(string $name): bool
    {
        $route = Route::getRoutes()->getByName($name);
        foreach ($route->action['middleware'] ?? [] as $middleware) {
            if (preg_match('/^can\:([^,]+)(,(.+))?$/', $middleware, $matches)) {
                try {
                    app()->make($route->action['controller'])
                        ->authorize($matches[1], $matches[3] ?? null);
                } catch (AuthorizationException $e) {
                    return false;
                }
            }
        }

        return true;
    }

    private function routeIsActive(string $name): bool
    {
        return request()->routeIs($name) || request()->routeIs($name . '.*');
    }
}
