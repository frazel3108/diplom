<?php

namespace App\Http\Controllers\Lk\Basket;

use App\Http\Controllers\Controller;
use App\Models\Product;

class OrderController extends Controller
{
    public function __invoke()
    {
        if(auth()->user()->basket->createOrder()) {
            return redirect()->route('lk.order_history')
                ->withStatus('Поздравляем! Вы успешно оформили заказ.');
        }

        return redirect()->back()
                ->with('error', 'Произошла ошибка при оформлении заказа.');
    }
}