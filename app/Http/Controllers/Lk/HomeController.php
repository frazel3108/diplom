<?php

namespace App\Http\Controllers\Lk;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('modules.lk.home');
    }
}
