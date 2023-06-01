<?php

namespace App\Http\Controllers\Product;

use App\Models\Category;
use App\Models\Product;
use App\Facades\Breadcrumbs;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use App\Http\Resources\Admin\ProductResource;

class ItemController extends Controller
{
    public function __invoke(
        Category $category,
        Product $product,
        ProductRepository $productRepo
    ) {
        $others = ProductResource::collection($productRepo->similarProducts($product));

        Breadcrumbs::add('Каталог', route('catalog.list'))
            ->add($category->name, route('catalog.category', $category))
            ->add($product->name);

        return view(
            'modules.product.item',
            compact(
                'category',
                'product',
                'others'
            )
        );
    }
}