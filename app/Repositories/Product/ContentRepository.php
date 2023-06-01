<?php

namespace App\Repositories\Product;

use Illuminate\Pagination\AbstractPaginator;
use App\Models\Product\Content;

class ContentRepository
{

    public function paginateForAdmin(array $params, ?int $perPage = null): AbstractPaginator
    {
        $query = Content::select('products_content.*')->joinProduct()->groupBy('products_content.id');

        if (array_key_exists('search', $params) && !empty($params['search'])) {
            $query->where(function ($group) use ($params) {
                $group->where('products.name', 'like', "%{$params['search']}%")
                    ->orWhere('products_content.id', 'like', '%' . trim($params['search'], '#') . '%');
            });
        }

        if (array_key_exists('sort-by', $params) && !empty($params['sort-by'])) {
            $query->orderBy($params['sort-by'], $params['sort-dir'] ?? 'asc');
        }

        return $query->paginate(perPage: $perPage);
    }

    public function paginateTrashedForAdmin(array $params, ?int $perPage = null): AbstractPaginator
    {
        $query = Content::onlyTrashed();

        if (array_key_exists('search', $params) && !empty($params['search'])) {
            $query->where('id', 'like', '%' . trim($params['search'], '#') . '%');
        }

        if (array_key_exists('sort-by', $params) && !empty($params['sort-by'])) {
            $query->orderBy($params['sort-by'], $params['sort-dir'] ?? 'asc');
        }

        return $query->paginate(perPage: $perPage);
    }
}