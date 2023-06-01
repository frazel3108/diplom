<?php

namespace App\Repositories;

use App\Models\Category;
use App\Utils\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CategoryRepository
{
    public function paginateForAdmin(array $params, ?int $perPage = null): AbstractPaginator
    {
        $query = Category::select('categories.*')->distinct()
            ->leftJoinProducts()
            ->whereNotNull('products.category_id')
            ->groupBy('categories.id');

        if (array_key_exists('search', $params) && !empty($params['search'])) {
            $query->where(function ($group) use ($params) {
                $group->where('name', 'like', "%{$params['search']}%")
                    ->orWhere('url', 'like', "%{$params['search']}%")
                    ->orWhere('parent_id', 'like', '%' . trim($params['search'], '#') . '%')
                    ->orWhere('id', 'like', '%' . trim($params['search'], '#') . '%');
            });
        }

        if (array_key_exists('sort-by', $params) && !empty($params['sort-by'])) {
            $query->orderBy($params['sort-by'], $params['sort-dir'] ?? 'asc');
        }

        return $query->paginate(perPage: $perPage);
    }

    public function getListForAdmin(): Collection
    {
        return Category::where('parent_id', 0)->get();
    }

    public function paginateTrashedForAdmin(array $params, ?int $perPage = null): AbstractPaginator
    {
        $query = Category::onlyTrashed();

        if (array_key_exists('search', $params) && !empty($params['search'])) {
            $query->where(function ($group) use ($params) {
                $group->where('name', 'like', "%{$params['search']}%")
                    ->orWhere('url', 'like', "%{$params['search']}%")
                    ->orWhere('parent_id', 'like', '%' . trim($params['search'], '#') . '%')
                    ->orWhere('id', 'like', '%' . trim($params['search'], '#') . '%');
            });
        }

        if (array_key_exists('sort-by', $params) && !empty($params['sort-by'])) {
            $query->orderBy($params['sort-by'], $params['sort-dir'] ?? 'asc');
        }

        return $query->paginate(perPage: $perPage);
    }

    public function paginateWithoutProductsForAdmin(array $params, ?int $perPage = null): AbstractPaginator
    {
        $query = Category::select('categories.*')->leftJoinProducts()
            ->whereNull('products.category_id');

        if (array_key_exists('search', $params) && !empty($params['search'])) {
            $query->where(function ($group) use ($params) {
                $group->where('name', 'like', "%{$params['search']}%")
                    ->orWhere('url', 'like', "%{$params['search']}%")
                    ->orWhere('parent_id', 'like', '%' . trim($params['search'], '#') . '%')
                    ->orWhere('id', 'like', '%' . trim($params['search'], '#') . '%');
            });
        }

        if (array_key_exists('sort-by', $params) && !empty($params['sort-by'])) {
            $query->orderBy($params['sort-by'], $params['sort-dir'] ?? 'asc');
        }

        return $query->paginate(perPage: $perPage);
    }

    public function getPopularCategory(int $perPage = 12): Collection
    {
        return \Cache::remember(
            key: 'categories.main.popular',
            ttl: 60 * 30,
            callback: fn () => Category::select('categories.*')
                ->distinct()
                ->with(['products'])
                ->leftJoinProducts()
                ->whereNotNull('products.id')
                ->orderBy('categories.order')
                ->limit($perPage)
                ->withImg()
                ->get(),
        );
    }

    public function mainBlocksCategoryWithProduct(int $perPage = 15): Collection
    {
        return \Cache::remember(
            key: 'categories.main.blocks_with_products_perPage' . $perPage,
            ttl: 60 * 30,
            callback: fn () => Category::select('categories.*')
                ->distinct()
                ->with([
                    'products' => fn ($qb) => $qb->select('products.*')
                        ->distinct()
                        ->with(['category', 'content', 'offers'])
                        ->join('products_content', 'products_content.product_id', 'products.id')
                        ->whereNull('products_content.deleted_at')
                        ->orderBy('products.order', 'DESC')
                        ->orderBy('products.name')
                ])
                ->leftJoinProducts()
                ->leftJoin('products_content', 'products_content.product_id', 'products.id')
                ->whereNull('products_content.deleted_at')
                ->whereNotNull('products.id')
                ->get()
        );
    }

    public function getForFilter(Filter $filter)
    {
        return \Cache::remember(
            key: 'filter.categories.' . md5((string)$filter),
            ttl: 60 * 30,
            callback: fn () => Category::select('categories.*')
                ->withCount([
                    'products' => static fn (Builder $query) => $query->forFilter(
                        params: $filter->getParams(),
                    )
                ])
                ->having('products_count', '>', 0, false)
                ->orderBy('name')
                ->get()
        );
    }

    public function getWithoutParrent(): Collection
    {
        return \Cache::remember(
            key: 'categories.without.parrent',
            ttl: 60 * 30,
            callback: fn () => Category::select('categories.*')
                ->withCount(['products'])
                ->where('parent_id', 0)
                ->having('products_count', '>', 0, false)
                ->orderBy('name')
                ->get()
        );
    }
}