<?php

namespace App\Repositories;

use App\Models\Order\Order;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class OrderRepository
{
    public function paginateForAdmin(array $params, ?int $perPage = null): AbstractPaginator
    {
        $query = Order::select('orders.*')
            ->joinOrderProducts()
            ->addSelect(DB::raw('sum(`order_products`.`price` * `order_products`.`quantity`) as `price`'))
            ->confirm()
            ->groupBy('orders.id')
            ->joinUser();

        if (array_key_exists('search', $params) && !empty($params['search'])) {
            $query->where(function ($group) use ($params) {
                $group->where('orders.updated_at', 'like', "%{$params['search']}%")
                    ->orWhere('users.email', 'like', "%{$params['search']}%")
                    ->orWhere('orders.id', 'like', '%' . trim($params['search'], '#') . '%')
                    ->orHaving('price', 'like', "%{$params['search']}%");
            });
        }

        if (array_key_exists('sort-by', $params) && !empty($params['sort-by'])) {
            $query->orderBy($params['sort-by'], $params['sort-dir'] ?? 'asc');
        }

        return $query->paginate(perPage: $perPage);
    }

    public function dashboardData(): Collection
    {
        return Order::selectRaw(
            'DATE_FORMAT(`orders`.`updated_at`, "%M %Y") as `date`
            , sum(`order_products`.`price` * `order_products`.`quantity`) as `sale`'
        )->joinOrderProducts()
            ->confirm()
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();
    }

    public function getLastOrders(?int $limit = 5): Collection
    {
        return Order::confirm()
            ->with(['user'])
            ->orderBy('updated_at', 'DESC')
            ->limit($limit)
            ->get();
    }
}