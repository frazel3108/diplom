<?php

namespace App\Http\Controllers\Admin\Category;

use App\Repositories\CategoryRepository;
use App\Http\Resources\Admin\CategoryResource;
use App\Facades\Breadcrumbs;

class CreateController
{
    public function __invoke(CategoryRepository $repo)
    {
        $categories = CategoryResource::collection($repo->getListForAdmin());
        Breadcrumbs::add('Создание категории');
        return view('admin.modules.category.form', compact('categories'));
    }
}
