<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Resources\Admin\CategoryResource;
use App\Repositories\CategoryRepository;
use App\Facades\Breadcrumbs;

class ShowController extends Controller
{
    public function __invoke(Category $category, CategoryRepository $repo)
    {
        $categories = CategoryResource::collection($repo->getListForAdmin());
        Breadcrumbs::add('Обновление категории ' . $category->name);

        return view('admin.modules.category.form', compact('category', 'categories'));
    }
}
