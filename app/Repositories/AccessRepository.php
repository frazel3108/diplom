<?php

namespace App\Repositories;

use Illuminate\Pagination\AbstractPaginator;
use App\Models\Admin\Role;

class AccessRepository
{
    public function paginateForAdmin(array $params, ?int $perPage = null): AbstractPaginator
    {
        $query = Role::query();

        if (array_key_exists('search', $params) && !empty($params['search'])) {
            $query->where(function ($group) use ($params) {
                $group->where('name', 'like', "%{$params['search']}%")
                    ->orWhere('id', 'like', '%' . trim($params['search'], '#') . '%');
            });
        }

        if (array_key_exists('sort-by', $params) && !empty($params['sort-by'])) {
            $query->orderBy($params['sort-by'], $params['sort-dir'] ?? 'asc');
        }

        return $query->paginate(perPage: $perPage);
    }
}
