<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use App\Facades\Breadcrumbs;

class ListController extends Controller
{
    public function __invoke(CategoryRepository $repo, Request $request)
    {
        switch ($request->get('tab', '')) {
            case '':
                $categories = $repo->paginateForAdmin($request->all());
                break;
            case 'without_products':
                $categories = $repo->paginateWithoutProductsForAdmin($request->all());
                break;
            case 'archive':
                $categories = $repo->paginateTrashedForAdmin($request->all());
                break;
        }

        $query = $request->only(['search']);
        $tabs = [
            [
                'name' => 'Активные',
                'link' => '?' . http_build_query($query),
                'active' => $request->get('tab', '') == '',
            ],
            [
                'name' => 'Без товаров',
                'link' => '?' . http_build_query(array_merge($query, ['tab' => 'without_products'])),
                'active' => $request->get('tab', '') == 'without_products',
            ],
            [
                'name' => 'Архивные',
                'link' => '?' . http_build_query(array_merge($query, ['tab' => 'archive'])),
                'active' => $request->get('tab', '') == 'archive',
            ],
        ];
        Breadcrumbs::add('Категории');

        return view('admin.modules.category.list', compact('categories', 'tabs'));
    }
}