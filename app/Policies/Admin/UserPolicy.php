<?php

namespace App\Policies\Admin;

use App\Enums\Admin\Access;
use App\Models\Admin\User;
use App\Utils\Support\Str;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    private array $methodAccesses = [
        'create' => Access::CREATE,
        'view' => Access::READ,
        'update' => Access::UPDATE,
        'delete' => Access::DELETE,
    ];

    public function __call(string $method, array $args = [])
    {
        [$access, $model] = $this->parseMethod($method);

        if (is_null($access) || is_null($model)) {
            return false;
        }

        return Auth::user()->hasAccess($access, $model);
    }

    private function parseMethod(string $method): array
    {
        $exploded = explode('_', $method, 2);

        $access = $this->methodAccesses[$exploded[0] ?? ''] ?? null;
        if (count($exploded) > 1) {
            $model = $this->methodModels[$exploded[1]] ?? $this->buildModelClassName($exploded[1]);
        } else {
            $model = null;
        }

        return [$access, $model];
    }

    private function buildModelClassName(string $modelName): string
    {
        return "\\App\\Models\\"
            . implode(
                "\\",
                array_map(
                    fn ($segment) => Str::studly($segment),
                    explode('__', $modelName)
                )
            );
    }
}