<?php

namespace App\Repositories;

use App\Models\Product;
use App\Utils\Filter;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function paginateForAdmin(array $params, ?int $perPage = null): AbstractPaginator
    {
        $query = Product::select('products.*')
            ->distinct()
            ->joinContent()
            ->leftJoinCategories()
            ->whereNull('products_content.deleted_at')
            ->groupBy('products.id');

        if (array_key_exists('search', $params) && !empty($params['search'])) {
            $query->where(function ($group) use ($params) {
                $group->where('products.name', 'like', "%{$params['search']}%")
                    ->orWhere('products.url', 'like', "%{$params['search']}%")
                    ->orWhere('categories.name', 'like', "%{$params['search']}%")
                    ->orWhere('products.id', 'like', '%' . trim($params['search'], '#') . '%');
            });
        }

        if (array_key_exists('sort-by', $params) && !empty($params['sort-by'])) {
            $query->orderBy($params['sort-by'], $params['sort-dir'] ?? 'asc');
        }

        return $query->paginate(perPage: $perPage);
    }

    public function paginateTrashedForAdmin(array $params, ?int $perPage = null): AbstractPaginator
    {
        $query = Product::leftJoinCategories()->onlyTrashed();

        if (array_key_exists('search', $params) && !empty($params['search'])) {
            $query->where(function ($group) use ($params) {
                $group->where('products.name', 'like', "%{$params['search']}%")
                    ->orWhere('products.url', 'like', "%{$params['search']}%")
                    ->orWhere('categories.name', 'like', "%{$params['search']}%")
                    ->orWhere('products.id', 'like', '%' . trim($params['search'], '#') . '%');
            });
        }

        if (array_key_exists('sort-by', $params) && !empty($params['sort-by'])) {
            $query->orderBy($params['sort-by'], $params['sort-dir'] ?? 'asc');
        }

        return $query->paginate(perPage: $perPage);
    }

    public function paginateWithoutContentForAdmin(array $params, ?int $perPage = null): AbstractPaginator
    {
        $query = Product::select('products.*')
            ->leftJoinContent()
            ->whereNull('products_content.id')
            ->orWhereNotNull('products_content.deleted_at')
            ->leftJoinCategories();

        if (array_key_exists('search', $params) && !empty($params['search'])) {
            $query->where(function ($group) use ($params) {
                $group->where('products.name', 'like', "%{$params['search']}%")
                    ->orWhere('products.url', 'like', "%{$params['search']}%")
                    ->orWhere('categories.name', 'like', "%{$params['search']}%")
                    ->orWhere('products.id', 'like', '%' . trim($params['search'], '#') . '%');
            });
        }

        if (array_key_exists('sort-by', $params) && !empty($params['sort-by'])) {
            $query->orderBy($params['sort-by'], $params['sort-dir'] ?? 'asc');
        }

        return $query->paginate(perPage: $perPage);
    }

    public function getListForAdmin(): Collection
    {
        return Product::get();
    }

    public function randomListRecommendations(?int $limit = 20): Collection
    {
        $products = Product::select('products.*')
            ->with(['content', 'category', 'offers'])
            ->leftJoinContent()
            ->whereNotNull('products_content.id')
            ->whereNull('products_content.deleted_at')
            ->inRandomOrder()
            ->where('products.popular', 1)
            ->limit($limit)
            ->orderBy('products.order', 'Desc')
            ->orderBy('products.name')
            ->get();

        if ($products->count() < $limit) {
            $qb = Product::select('products.*')
                ->with(['content', 'category', 'offers'])
                ->leftJoinContent()
                ->whereNotNull('products_content.id')
                ->whereNull('products_content.deleted_at')
                ->inRandomOrder()
                ->orderBy('products.order', 'Desc')
                ->orderBy('products.name')
                ->limit($limit - $products->count());

            if ($products->count() > 0) {
                $qb->whereNotIn('products.id', $products->pluck('id'));
            }

            $products = $products->merge($qb->get());
        }

        return $products;
    }

    public function similarProducts(Product $product, ?int $perPage = 4): Collection
    {
        return \Cache::remember(
            key: 'product.similar.' . $product->id . '.' . $perPage,
            ttl: 60 * 30,
            callback: fn () => Product::select('products.*')
                ->distinct()
                ->with(['content', 'category', 'offers'])
                ->joinContent()
                ->leftJoinCategories()
                ->whereNotNull('products_content.id')
                ->whereNull('products_content.deleted_at')
                ->whereNot('products.id', $product->id)
                ->where('products.category_id', $product->category_id)
                ->orderBy('products.created_at', 'DESC')
                ->orderBy('products.order', 'DESC')
                ->orderBy('products.name')
                ->limit($perPage)
                ->get()
        );
    }

    public function getPriceRangeForFilter(Filter $filter): object
    {
        return $this->getMinMaxForFilter('price', $filter);
    }

    public function getMinMaxForFilter(
        string $column,
        Filter $filter,
    ): object {
        $params = $filter->getParams();
        unset($params[$column . '_min']);
        unset($params[$column . '_max']);

        return \Cache::remember(
            key: 'filter.min-max.' . $column . '.' . md5(http_build_query($params)),
            ttl: 60 * 30,
            callback: function () use ($column, $params) {
                $query = Product::select(
                        DB::raw("MIN(`products`.`${column}`) min"),
                        DB::raw("MAX(`products`.`${column}`) max"),
                    )->forFilter(params: $params);

                return $query->toBase()->first();
            }
        );
    }

    public function getIdsForFilter(array $params): array
    {
        return \Cache::remember(
            key: 'filter.ids.' . md5(http_build_query($params)),
            ttl: 60 * 30,
            callback: fn () => Product::select('products.id')
                ->distinct()
                ->forFilter(
                    params: $params,
                    aliases: ['offer_product' => 'o_p'],
                )
                ->toBase()
                ->get()
                ->pluck('id')
                ->toArray()
        );
    }

    public function paginateFilter(
        Filter $filter,
        ?int $per_page = null,
    ): AbstractPaginator {
        $per_page = $per_page ?? $filter->perPage();

        return \Cache::remember(
            key: 'filter.products.' . md5((string)$filter) . '.' . $per_page . '.' . request()->get('page', 1),
            ttl: 60 * 30,
            callback: fn () => Product::select('products.*')
                ->with(['content', 'category', 'offers'])
                ->whereIn('products.id', $filter->getProductIds())
                ->orderBy('popular', 'DESC')
                ->orderBy('order', 'DESC')
                ->orderBy('name')
                ->paginate($per_page)
        );
    }
}