<?php

namespace App\Http\Controllers\Admin\Characteristic;

use App\Repositories\CharacteristicRepository;
use App\Facades\Breadcrumbs;

class CreateController
{
    public function __invoke(CharacteristicRepository $repo)
    {
        Breadcrumbs::add('Создание характеристики');
        return view('admin.modules.characteristic.form');
    }
}