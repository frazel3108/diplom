<?php

namespace App\Http\Controllers\Product;

use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;

class AddController extends Controller
{
    public function __invoke(Category $category, Product $product) {
        if (!auth()->user()->addToOrder($product)) {
            return redirect()->back()->with('Произошла ошибка, пожалуйста обратитесь к администратору!');
        }
        return redirect()->back();
    }
}
