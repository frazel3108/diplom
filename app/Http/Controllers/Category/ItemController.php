<?php

namespace App\Http\Controllers\Category;

use App\Facades\Breadcrumbs;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Services\CategoryService;
use App\Utils\Filter;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function __invoke(
        Category $category,
        Request $request,
        ProductRepository $repo,
    ) {
        $filter = Filter::fromRequest($request);
        $filter->updateParams(['category' => $category->id]);
        $categories = CategoryService::sortChild($filter->getParamsWithData()['categories']);
        $products = $repo->paginateFilter(filter: $filter)->withQueryString();

        Breadcrumbs::add('Каталог', route('catalog.list'))
            ->add($category->name);

        return view(
            'modules.catalog.list',
            compact('filter', 'categories', 'products')
        );
        return null;
    }
}