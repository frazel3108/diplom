<?php

namespace App\Http\Controllers\Admin\Access;

use App\Enums\Admin\Access;
use App\Enums\Admin\Level;
use App\Models\Admin\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class ShowController extends Controller
{
    public function __invoke(Role $role)
    {
        $acceses = Access::cases();
        $levels = Level::cases();
        $allModels = filesOnPath(app_path() . '/Models')->map(
            fn($path) => substr(substr($path, strlen(app_path() . '/Models/'), strlen($path)), 0, -4)
        );
        $roleInfo = new Collection();
        array_map(
            function($access) use ($role, $roleInfo) {
                $info = $role->roleAccess($access)->info;
                return $roleInfo->prepend(
                    $info
                        ? array_map(
                            fn($model) => substr($model, strlen('\\App\\Models\\'), strlen($model)),
                            $info
                        )
                        : [],
                    $access->name
                );
            },
            $acceses
        );

        return view(
            'admin.modules.access.form',
            compact(
                'role',
                'acceses',
                'levels',
                'allModels',
                'roleInfo'
            )
        );
    }
}
