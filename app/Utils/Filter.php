<?php

namespace App\Utils;

use App\Services\CategoryService;
use App\Repositories\CategoryRepository;
use App\Repositories\OfferRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class Filter
{
    public const PER_PAGE_DEFAULT = 12;

    private array $params;
    private ?int $perPage;
    private bool $isSet;
    private array $productIds;

    public function __construct(
        array $params,
        ?int $perPage = null,
        bool $isSet = false,
    )
    {
        $this->params = $params;
        $this->perPage = $perPage;
        $this->isSet = $isSet;
    }

    public static function empty(): Filter
    {
        return new Filter(
            params: []
        );
    }

    public static function withParams(array $params): Filter
    {
        $params = self::prepareParams($params);

        $perPage = $params['per-page'] ?? null;
        if ($perPage && !in_array($perPage, self::PER_PAGE_OPTIONS)) {
            $perPage = null;
        }
        $isSet = $params['set'] ?? false;

        return new Filter(
            params: $params,
            perPage: $perPage,
            isSet: $isSet,
        );
    }

    public function updateParams(array $params): void
    {
        foreach ($params as $key => $param) {
            if (isset($this->params[$key])) {
                $this->params[$key] = $param;
            }
        }
    }

    public static function fromRequest(Request $request): Filter
    {
        return self::withParams(
            $request->only([
                'category',
                'offer',
                'price_min',
                'price_max',
                'per-page'
            ])
        );
    }

    private static function prepareParams(array $params): array
    {
        $set = false;

        $category = $params['category'] ?? [];
        $set = $set || (count($category) > 0);
        $offer = self::prepareArrayOfInts($params['offer'] ?? []);
        $set = $set || (count($offer) > 0);

        [$price_min, $price_max] = self::prepareMinMax($params['price_min'] ?? null, $params['price_max'] ?? null);
        $set = $set || $price_min || $price_max;

        if (array_key_exists('per-page', $params)) {
            $perPage = $params['per-page'];
        }

        return [
            'category' => $category,
            'offer' => $offer,
            'price_min' => $price_min,
            'price_max' => $price_max,
            'per-page' => $perPage ?? null,
            'set' => $set ?? false
        ];
    }

    private static function prepareMinMax(int|float|null $min, int|float|null $max): array
    {
        return ($min && $max && $max < $min) ? [$max, $min] : [$min, $max];
    }

    public function getParams(): array
    {
        return $this->params;
    }

     public function getParamsWithData(): array
    {
        return [
            'categories' => CategoryService::treeFromCollection(
                resolve(CategoryRepository::class)->getForFilter($this)
            ),
            'offers' => resolve(OfferRepository::class)->getForFilter($this)->toArray(),
            'prices' => resolve(ProductRepository::class)->getPriceRangeForFilter($this),
        ];
    }

    public function perPage(): int
    {
        return $this->perPage ?? self::PER_PAGE_DEFAULT;
    }

     public function getProductIds(): array
    {
        if (!isset($this->productIds)) {
            $this->productIds = resolve(ProductRepository::class)->getIdsForFilter($this->params);
        }

        return $this->productIds;
    }

    private static function prepareArrayOfInts(mixed $array): array
    {
        if (!is_array($array)) {
            return [];
        }

        return array_values(array_filter(array_map(
            fn ($elem) => (int)$elem,
            $array
        )));
    }

    public function __toString(): string
    {
        return http_build_query($this->params);
    }
}