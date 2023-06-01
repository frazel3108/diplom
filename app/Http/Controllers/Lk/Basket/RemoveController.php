<?php

namespace App\Http\Controllers\Lk\Basket;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;

class RemoveController extends Controller
{
    public function __invoke(Product $product) {
        if (!auth()->user()->removeToOrder($product)) {
            return redirect()->back()->with('Произошла ошибка, пожалуйста обратитесь к администратору!');
        }
        return redirect()->back();
    }
}