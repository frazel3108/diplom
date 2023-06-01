<?php

namespace App\Http\Controllers\Admin\Offer;

use App\Repositories\OfferRepository;

class CreateController
{
    public function __invoke(OfferRepository $repo)
    {
        return view('admin.modules.offer.form');
    }
}
