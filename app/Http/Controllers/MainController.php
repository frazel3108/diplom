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

        // $data = [
        //     [
        //         'action' => 'book',
        //         'fio' => 'Хворостьянова, С.В.  / С.В. Хворостьянова // . - 2011. - № 1. - С. 68-73. Требования к содержанию библиотечных веб-сайтов.',
        //         'name' => 'Веб-сайт: требования к информационной структуре и наполнению',
        //         'izda' => 'Современная библиотека',
        //         'numizd' => '',
        //         'year' => '2011',
        //         'countP' => '112',
        //     ], [
        //         'action' => 'link',
        //         'title' => 'Главные тренды веб-разработки и технологий на 2023',
        //         'name' => 'Merehead',
        //         'link' => 'https://merehead.com/ru/blog/web-tech-technology-trends-2023/',
        //         'date' => '15.01.2023',
        //     ]
        // ];

        // foreach ($data as $link) {
        //     if ($link['action'] == 'book') {
        //         $link = $link['fio'] . ' ' . $link['name']. '.'
        //             . (!empty($link['numizd'])
        //                 ? ' - ' . $link['numizd'] . ' изд.'
        //                 : ''
        //             ) . ' - ' . $link['izda'] . ', ' . $link['year'] . '.'
        //             . (!empty($link['countP'])
        //                 ? ' - ' . $link['countP'] . ' с.'
        //                 : ''
        //             );
        //     } elseif ($link['action'] == 'link') {
        //         $link = $link['title'] . ' // ' . $link['name']
        //             . ': [сайт]. — URL: ' . $link['link']
        //             . ' (дата обращения: ' . $link['date'] . ').';
        //     }

        //     dump($link);
        // }
        // die();

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