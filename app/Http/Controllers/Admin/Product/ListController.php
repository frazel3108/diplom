<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function __invoke(ProductRepository $repo, Request $request)
    {
        if ($request->get('tab', '') == 'archive') {
            $products = $repo->paginateTrashedForAdmin($request->all());
        } elseif ($request->get('tab', '') == 'without_content') {
            $products = $repo->paginateWithoutContentForAdmin($request->all());
        } else {
            $products = $repo->paginateForAdmin($request->all());
        }

        $query = $request->only(['search']);
        $tabs = [
            [
                'name' => 'Активные',
                'link' => '?' . http_build_query($query),
                'active' => $request->get('tab', '') == '',
            ],
            [
                'name' => 'Без позиций',
                'link' => '?' . http_build_query(array_merge($query, ['tab' => 'without_content'])),
                'active' => $request->get('tab', '') == 'without_content',
            ],
            [
                'name' => 'Архивные',
                'link' => '?' . http_build_query(array_merge($query, ['tab' => 'archive'])),
                'active' => $request->get('tab', '') == 'archive',
            ],
        ];


        return view('admin.modules.product.list', compact('products', 'tabs'));
    }
}