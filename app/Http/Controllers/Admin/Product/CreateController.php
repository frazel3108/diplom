<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Resources\Admin\CategoryResource;
use App\Http\Resources\Admin\CharacteristicResource;
use App\Http\Resources\Admin\OfferResource;
use App\Models\Characteristic;
use App\Models\Offer;
use App\Repositories\CategoryRepository;

class CreateController
{
    public function __invoke(CategoryRepository $categoryRepo)
    {
        $categories = CategoryResource::collection($categoryRepo->getListForAdmin());
        $offers = OfferResource::collection(Offer::all());
        $productCharacteristics = [];
        $characteristics = CharacteristicResource::collection(Characteristic::all());

        return view(
            'admin.modules.product.form',
            compact('categories', 'offers', 'characteristics', 'productCharacteristics')
        );
    }
}