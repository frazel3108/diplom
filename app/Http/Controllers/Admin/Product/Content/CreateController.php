<?php

namespace App\Http\Controllers\Admin\Product\Content;

use App\Repositories\ProductRepository;
use App\Http\Resources\Admin\ProductResource;

class CreateController
{
    public function __invoke(ProductRepository $repo)
    {
        $products = ProductResource::collection($repo->getListForAdmin());
        return view('admin.modules.product.content.form', compact('products'));
    }
}