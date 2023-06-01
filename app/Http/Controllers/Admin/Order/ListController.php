<?php

namespace App\Http\Controllers\Admin\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;

class ListController extends Controller
{
    public function __invoke(OrderRepository $repo, Request $request)
    {
        $orders = $repo->paginateForAdmin($request->all());

        return view('admin.modules.order.list', compact('orders'));
    }
}