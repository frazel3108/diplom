<?php

namespace App\Http\Controllers\Admin\Offer;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Repositories\OfferRepository;

class ShowController extends Controller
{
    public function __invoke(Offer $offer, OfferRepository $repo)
    {
        return view('admin.modules.offer.form', compact('offer'));
    }
}
