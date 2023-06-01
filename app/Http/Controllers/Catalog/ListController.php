<?php

namespace App\Http\Controllers\Catalog;

use App\Facades\Breadcrumbs;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Services\CategoryService;
use App\Utils\Filter;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function __invoke(
        Request $request,
        ProductRepository $repo,
    ) {
        Breadcrumbs::add('Каталог');
        $filter = Filter::fromRequest($request);
        $categories = CategoryService::sortChild($filter->getParamsWithData()['categories']);
        $products = $repo->paginateFilter(filter: $filter)->withQueryString();

        return view(
            'modules.catalog.list',
            compact('filter', 'categories', 'products')
        );
    }
}