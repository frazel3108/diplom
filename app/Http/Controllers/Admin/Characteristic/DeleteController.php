<?php

namespace App\Http\Controllers\Admin\Characteristic;

use App\Http\Controllers\Controller;
use App\Models\Characteristic;

class DeleteController extends Controller
{
    public function __invoke(Characteristic $characteristic)
    {
        $characteristic->delete();

        return redirect()->route('admin.characteristic')
            ->withStatus('Характеристика удалена!');
    }
}