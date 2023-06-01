<?php

namespace App\Http\Controllers\Lk\Basket;

use App\Http\Controllers\Controller;
use App\Models\Product;

class AddController extends Controller
{
    public function __invoke(Product $product)
    {
        if (!auth()->user()->addToOrder($product)) {
            return redirect()->back()->with('Произошла ошибка, пожалуйста обратитесь к администратору!');
        }
        return redirect()->back();
    }
}