<?php

namespace App\Http\Controllers\Lk\Basket;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;

class DeleteController extends Controller
{
    public function __invoke(Product $product) {
        if (!auth()->user()->deleteProduct($product)) {
            return redirect()->back()->with('Произошла ошибка, пожалуйста обратитесь к администратору!');
        }
        return redirect()->back();
    }
}