<?php

namespace App\Http\Controllers\Lk\Order;

use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    public function __invoke()
    {
        return view('modules.lk.order');
    }
}
