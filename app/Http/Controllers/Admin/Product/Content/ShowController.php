<?php

namespace App\Http\Controllers\Admin\Product\Content;

use App\Http\Controllers\Controller;
use App\Models\Product\Content;
use App\Http\Resources\Admin\ProductResource;
use App\Repositories\ProductRepository;

class ShowController extends Controller
{
    public function __invoke(Content $content, ProductRepository $repo)
    {
        $products = ProductResource::collection($repo->getListForAdmin());

        return view('admin.modules.product.content.form', compact('products', 'content'));
    }
}