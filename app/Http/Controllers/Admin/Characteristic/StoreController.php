<?php

namespace App\Http\Controllers\Admin\Characteristic;

use App\Http\Requests\Admin\Characteristic\StoreRequest;
use App\Models\Characteristic;
use Illuminate\Support\Str;

class StoreController
{
    public function __invoke(Characteristic $characteristic, StoreRequest $request)
    {
        $validated = $request->validated();

        $characteristic = new Characteristic();
        $characteristic->name = $validated['name'];
        $characteristic->is_multi = isset($request->is_multi) && $validated['is_multi'] == 'on' ? 1 : 0;
        $characteristic->order = $validated['order'] ?? 0;

        $characteristic->save();
        \Cache::flush();
        return redirect()->route('admin.characteristic')
            ->withStatus('Характеристика создана!');
    }
}