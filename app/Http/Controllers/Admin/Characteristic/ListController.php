<?php

namespace App\Http\Controllers\Admin\Characteristic;

use App\Http\Controllers\Controller;
use App\Repositories\CharacteristicRepository;
use Illuminate\Http\Request;
use App\Facades\Breadcrumbs;

class ListController extends Controller
{
    public function __invoke(CharacteristicRepository $repo, Request $request)
    {
        $characteristics = $repo->paginateForAdmin($request->all());
        Breadcrumbs::add('Характеристики');
        return view('admin.modules.characteristic.list', compact('characteristics'));
    }
}