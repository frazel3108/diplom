<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\CharacteristicResource;
use App\Http\Resources\Admin\OfferResource;
use App\Models\Characteristic;
use App\Models\Offer;
use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\OfferRepository;

class ShowController extends Controller
{
    public function __invoke(Product $product, CategoryRepository $categoryRepo)
    {
        $categories = CategoryResource::collection($categoryRepo->getListForAdmin());
        $offers = OfferResource::collection(Offer::all());
        $characteristics = CharacteristicResource::collection(Characteristic::all());

        return view(
            'admin.modules.product.form',
            compact('product', 'categories', 'offers', 'characteristics')
        );
    }
}