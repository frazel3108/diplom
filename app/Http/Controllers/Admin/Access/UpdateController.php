<?php

namespace App\Http\Controllers\Admin\Access;

use App\Http\Controllers\Controller;
use App\Enums\Admin\Access;
use App\Enums\Admin\Level;
use App\Http\Requests\Admin\Access\UpdateRequest;
use App\Models\Admin\Role;
use Illuminate\Support\Facades\Hash;

class UpdateController extends Controller
{
    public function __invoke(Role $role, UpdateRequest $request)
    {
        $validated = $request->validated();

        $role->name = $validated['name'];
        $role->key = $validated['key'];

        $role->save();

        foreach (Access::cases() as $access) {
            $roleAccess = $role->roleAccess($access);
            $requestAccess = $request->Access[$access->name];
            $partial = null;

            $level = Level::fromKey($requestAccess['level']);
            if ($level == Level::PARTIAL_ACCESS && isset($requestAccess['info'])) {
                $partial = array_map(
                    fn($model) => '\\App\\Models\\' . $model,
                    $requestAccess['info']
                ) ?? [];
            } else if ($level == Level::PARTIAL_ACCESS) {
                $partial = [];
            }

            $roleAccess->level = $level;
            $roleAccess->info = $partial;
            $roleAccess->save();
        }

        return redirect()->route('admin.access')
            ->withStatus('Данные обновлены!');
    }
}
