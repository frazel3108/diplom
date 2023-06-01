<?php

namespace App\Http\Controllers\Admin\Characteristic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Characteristic\UpdateRequest;
use App\Models\Characteristic;

class UpdateController extends Controller
{
    public function __invoke(Characteristic $characteristic, UpdateRequest $request)
    {
        $validated = $request->validated();

        $characteristic->name = $validated['name'];
        $characteristic->is_multi = isset($request->is_multi) && $validated['is_multi'] == 'on' ? 1 : 0;
        $characteristic->order = $validated['order'] ?? 0;

        $characteristic->save();
        \Cache::flush();
        return redirect()->route('admin.characteristic')
            ->withStatus('Данные обновлены!');
    }
}