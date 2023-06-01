<?php

namespace App\Http\Controllers\Admin\Order;

use App\Models\Order\Order;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    public function __invoke(Order $order)
    {
        return view('admin.modules.order.form', compact('order'));
    }
}