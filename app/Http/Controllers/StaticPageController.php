<?php

namespace App\Http\Controllers;

use App\Repositories\CategoryRepository;

class StaticPageController extends Controller
{
    public function about()
    {
        $categories = resolve(CategoryRepository::class)->getWithoutParrent();
        return view('modules.static_pages.about', compact('categories'));
    }

    public function warranty()
    {
        return view('modules.static_pages.warranty');
    }
}