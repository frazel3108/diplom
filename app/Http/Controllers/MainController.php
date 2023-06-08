<?php

namespace App\Http\Controllers;

use App\Repositories\ProductRepository;
use App\Repositories\OfferRepository;
use App\Repositories\CategoryRepository;
use App\Http\Resources\Admin\ProductResource;
use App\Http\Resources\Admin\OfferResource;

class MainController extends Controller
{
    public function __invoke(
        ProductRepository $productRepo,
        CategoryRepository $categoryRepo,
        OfferRepository $offerRepo
    ) {
        $recommendations = ProductResource::collection(
            $productRepo->randomListRecommendations()
        );
        $topCategories = $categoryRepo->getPopularCategory(perPage: 3);
        $categories = $categoryRepo->mainBlocksCategoryWithProduct();
        $offers = OfferResource::collection($offerRepo->bannersMain());

        return view(
            'modules.main',
            compact(
                'recommendations',
                'topCategories',
                'categories',
                'offers',
            )
        );
    }
}