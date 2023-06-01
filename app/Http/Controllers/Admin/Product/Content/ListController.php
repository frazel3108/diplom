<?php

namespace App\Http\Controllers\Admin\Product\Content;

use App\Http\Controllers\Controller;
use App\Repositories\Product\ContentRepository;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function __invoke(ContentRepository $repo, Request $request)
    {
        if ($request->get('tab', '') == 'archive') {
            $productsContent = $repo->paginateTrashedForAdmin($request->all());
        } else {
            $productsContent = $repo->paginateForAdmin($request->all());
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

        return view('admin.modules.product.content.list', compact('productsContent', 'tabs'));
    }
}