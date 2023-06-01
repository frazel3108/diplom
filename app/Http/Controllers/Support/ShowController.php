<?php

namespace App\Http\Controllers\Support;

use App\Facades\Breadcrumbs;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    public function __invoke() {
        Breadcrumbs::add('Помощь');

        return view('modules.support.show');
    }
}
