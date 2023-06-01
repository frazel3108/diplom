<?php

namespace App\Http\Controllers\Admin\Offer;

use App\Http\Controllers\Controller;
use App\Repositories\OfferRepository;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function __invoke(OfferRepository $repo, Request $request)
    {
        switch ($request->get('tab', '')) {
            case '':
                $offers = $repo->paginateForAdmin($request->all());
                break;
            case 'archive':
                $offers = $repo->paginateTrashedForAdmin($request->all());
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
                'name' => 'Архивные',
                'link' => '?' . http_build_query(array_merge($query, ['tab' => 'archive'])),
                'active' => $request->get('tab', '') == 'archive',
            ],
        ];


        return view('admin.modules.offer.list', compact('offers', 'tabs'));
    }
}
