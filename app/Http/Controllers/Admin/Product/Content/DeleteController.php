<?php

namespace App\Http\Controllers\Admin\Product\Content;

use App\Http\Controllers\Controller;
use App\Models\Category;

class DeleteController extends Controller
{
    public function __invoke(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.product')
            ->withStatus('Категория удалена!');
    }
}
