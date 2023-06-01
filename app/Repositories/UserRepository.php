<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Pagination\AbstractPaginator;

class UserRepository
{
    public function paginateForAdmin(array $params, ?int $perPage = null): AbstractPaginator
    {
        $query = User::query();

        if (array_key_exists('search', $params) && !empty($params['search'])) {
            $query->where(function ($group) use ($params) {
                $group->where('name', 'like', "%{$params['search']}%")
                    ->orWhere('email', 'like', "%{$params['search']}%")
                    ->orWhere('phone', 'like', "%{$params['search']}%")
                    ->orWhere('id', 'like', '%' . trim($params['search'], '#') . '%');
            });
        }

        if (array_key_exists('sort-by', $params) && !empty($params['sort-by'])) {
            $query->orderBy($params['sort-by'], $params['sort-dir'] ?? 'asc');
        }

        return $query->paginate(perPage: $perPage);
    }

    public function paginateTrashedForAdmin(array $params, ?int $perPage = null): AbstractPaginator
    {
        $query = User::onlyTrashed();

        if (array_key_exists('search', $params) && !empty($params['search'])) {
            $query->where(function ($group) use ($params) {
                $group->where('name', 'like', "%{$params['search']}%")
                    ->orWhere('email', 'like', "%{$params['search']}%")
                    ->orWhere('phone', 'like', "%{$params['search']}%")
                    ->orWhere('id', 'like', '%' . trim($params['search'], '#') . '%');
            });
        }

        if (array_key_exists('sort-by', $params) && !empty($params['sort-by'])) {
            $query->orderBy($params['sort-by'], $params['sort-dir'] ?? 'asc');
        }

        return $query->paginate(perPage: $perPage);
    }

    public function dashboardData()
    {
        $withWeek = User::where('created_at', '>=', date('Y-m-d', strtotime("-7 day")))
            ->get()
            ->count();

        $lastWeek = User::where('created_at', '>=', date('Y-m-d', strtotime("-14 day")))
            ->where('created_at', '<=', date('Y-m-d', strtotime("-7 day")))
            ->get()
            ->count();

        return ['value' => $withWeek, 'difference' => ($withWeek - $lastWeek) / 100];
    }
}