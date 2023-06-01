<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;

class DashboardController extends Controller
{
    public function __invoke(
        UserRepository $userRepo,
        OrderRepository $orderRepo,
    ) {
        $newUsers = $userRepo->dashboardData();
        $sales = $orderRepo->dashboardData();
        $sale = [
            'datesSales' => $sales->pluck('date')->toArray(),
            'valuesSales' => $sales->pluck('sale')->toArray(),
        ];
        $lastOrders = $orderRepo->getLastOrders();

        return view('admin.modules.dashboard', compact('newUsers', 'sale', 'lastOrders'));
    }
}