<?php

namespace App\Repositories;

use App\Models\Offer;
use App\Utils\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OfferRepository
{
    public function paginateForAdmin(array $params, ?int $perPage = null): AbstractPaginator
    {
        $query = Offer::query();

        if (array_key_exists('search', $params) && !empty($params['search'])) {
            $query->where(function ($group) use ($params) {
                $group->where('name', 'like', "%{$params['search']}%")
                    ->orWhere('href', 'like', "%{$params['search']}%")
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
        $query = Offer::onlyTrashed();

        if (array_key_exists('search', $params) && !empty($params['search'])) {
            $query->where(function ($group) use ($params) {
                $group->where('name', 'like', "%{$params['search']}%")
                    ->orWhere('href', 'like', "%{$params['search']}%")
                    ->orWhere('id', 'like', '%' . trim($params['search'], '#') . '%');
            });
        }

        if (array_key_exists('sort-by', $params) && !empty($params['sort-by'])) {
            $query->orderBy($params['sort-by'], $params['sort-dir'] ?? 'asc');
        }

        return $query->paginate(perPage: $perPage);
    }

    public function bannersMain(): Collection
    {
        return Offer::active()->get();
    }

    public function getForFilter(Filter $filter)
    {
        return \Cache::remember(
            key: 'filter.offers.' . md5((string)$filter),
            ttl: 30,
            callback: fn () => Offer::select('offers.*')
                ->withCount([
                    'products' => static fn (Builder $query) => $query->forFilter(
                        params: $filter->getParams(),
                        ignoreParams: ['offer'],
                        aliases: ['offer_product' => 'o_p'],
                    )
                ])
                ->having('products_count', '>', 0, false)
                ->orderBy('name')
                ->get()
        );
    }
}