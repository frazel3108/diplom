<?php

namespace App\Http\Controllers\Admin\Access;

use App\Http\Controllers\Controller;
use App\Repositories\AccessRepository;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function __invoke(AccessRepository $repo, Request $request)
    {
        $access = $repo->paginateForAdmin($request->all());

        return view('admin.modules.access.list', compact('access'));
    }
}
