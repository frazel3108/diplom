<?php

namespace App\Http\Controllers\Lk\Basket;

use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    public function __invoke()
    {
        return view('modules.lk.basket');
    }
}