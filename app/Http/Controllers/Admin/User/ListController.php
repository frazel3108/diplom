<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function __invoke(UserRepository $userRepo, Request $request)
    {
        if ($request->get('tab', '') == 'archive') {
            $users = $userRepo->paginateTrashedForAdmin($request->all());
        } else {
            $users = $userRepo->paginateForAdmin($request->all());
        }

        $query = $request->only(['search']);
        $tabs = [
            [
                'name' => 'Активные',
                'link' => '?' . http_build_query($query),
                'active' => $request->get('tab', '') == '',
            ],
            [
                'name' => 'Архивные',
                'link' => '?' . http_build_query(array_merge($query, ['tab' => 'archive'])),
                'active' => $request->get('tab', '') == 'archive',
            ],
        ];


        return view('admin.modules.user.list', compact('users', 'tabs'));
    }
}