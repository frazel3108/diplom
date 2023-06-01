<?php

namespace App\Http\Controllers\Admin\Characteristic;

use App\Facades\Breadcrumbs;
use App\Http\Controllers\Controller;
use App\Models\Characteristic;
use App\Repositories\CharacteristicRepository;

class ShowController extends Controller
{
    public function __invoke(Characteristic $characteristic, CharacteristicRepository $repo)
    {
        Breadcrumbs::add('Обновление характеристики ' . $characteristic->name);
        return view('admin.modules.characteristic.form', compact('characteristic'));
    }
}