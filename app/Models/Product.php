<?php

namespace App\Models;

use App\Models\Product\Content;
use App\Traits\Eloquent\Scopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Scopes;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function content()
    {
        return $this->hasMany(Content::class);
    }

    public function characteristics()
    {
        return $this->belongsToMany(Characteristic::class, 'characteristic_product')->withPivot('value');
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class);
    }

    public function prices(): array
    {
        return [
            'old_price' => (float)$this->price,
            'discount' => $this->calc_discount,
            'price' => $this->price * ((100 - $this->calc_discount) / 100)
        ];
    }

    public function scopeJoinContent(Builder $query): Builder
    {
        return $query->safeJoin('products_content', 'products_content.product_id', 'products.id');
    }

    public function scopeLeftJoinContent(Builder $query): Builder
    {
        return $query->safeLeftJoin('products_content', 'products_content.product_id', 'products.id');
    }

    public function scopeWithRelations(Builder $query): Builder
    {
        return $query->with([
            'category',
            'offers',
        ]);
    }

    public function scopeActive(Builder $query, array $joins = []): Builder
    {
        if ($joins['categories'] ?? true) {
            $query->joinCategories();
        }

        return $query;
    }

    public function scopeLeftJoinOffers(Builder $query, ?string $alias = null): Builder
    {
        if ($alias) {
            return $query->safeLeftJoin('offer_product as ' . $alias, $alias . '.product_id', 'products.id')
                ->joinOffers($alias);
        }
        return $query->safeLeftJoin('offer_product', 'offer_product.product_id', 'products.id')
            ->joinOffers();
    }

    public function scopeLeftJoinCategories(Builder $query): Builder
    {
        return $query->safeLeftJoin('categories', 'categories.id', 'products.category_id');
    }

    public function scopeJoinOffers(Builder $query, ?string $alias = null): Builder
    {
        if ($alias) {
            return $query->safeJoin('offers', 'offers.id', $alias . '.offer_id');
        }
        return $query->safeJoin('offers', 'offers.id', 'offer_product.offer_id');
    }

    public function scopeJoinCategories(Builder $query): Builder
    {
        return $query->safeJoin('categories', 'categories.id', 'products.category_id');
    }

    public function imageUploaded(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->images ? $this->imageSrc() : null,
        );
    }

    private function imageSrc(): array
    {
        $images = [];
        foreach (json_decode($this->images) as $image) {
            $images[]=[
                'src' => $image,
                'url' => Storage::disk('images')->url($image),
            ];
        }

        return $images;
    }

    public function route(): Attribute
    {
        return Attribute::make(
            get: fn () => route('catalog.product', [
                'category' => $this->category,
                'product' => $this
            ]),
        );
    }

    public function countContent(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->content->count(),
        );
    }

    public function calcDiscount(): Attribute
    {
        $discount = 0;
        if ($this->sale_price > 0) {
            $discount = 100 - round(($this->sale_price * 100) / $this->price);
        }
        if ($this->offers->count() > 0) {
            foreach ($this->offers as $offer) {
                if ($discount + $offer->percent < env('MAX_DISCOUNT')) {
                    $discount += $offer->percent;
                }
            }
        }

        return Attribute::make(
            get: fn () => $discount,
        );
    }

    public function isNew(): bool
    {
        return explode('-', $this->url)[0] == 'new';
    }

    public function scopeMinOrMaxColumn(
        Builder $query,
        string $column,
        $min_value = null,
        $max_value = null
    ): Builder {
        if (!empty($min_value) && !empty($max_value)) {
            $query->whereBetween($column, [$min_value, $max_value]);
        } elseif (!empty($min_value)) {
            $query->where($column, '>=', $min_value);
        } elseif (!empty($max_value)) {
            $query->where($column, '<=', $max_value);
        }

        return $query;
    }

    public function scopeForFilter(
        Builder $query,
        array $params,
        array $ignoreParams = [],
        array $aliases = [],
    ): Builder {
        foreach ($ignoreParams as $key) {
            $params[$key] = [];
        }

        if (!empty($params['category'])) {
            $query->where('products.category_id', $params['category']);
        }

        if (count($params['offer'] ?? [])) {
            $query->leftJoinOffers(alias: $aliases['offer_product'] ?? null);
            if ($aliases['offer_product'] ?? false) {
                $query->whereIn($aliases['offer_product'] . '.offer_id', $params['offer']);
            } else {
                $query->whereIn('offer_product.offer_id', $params['offer']);
            }
        }

        $query->minOrMaxColumn('products.price', $params['price_min'] ?? null, $params['price_max'] ?? null);
        $query->leftJoinContent()->whereNotNull('products_content.id')->whereNull('products_content.deleted_at');

        return $query;
    }

    public function exportForVue(): array
    {
        return [
            'id' => (int)$this->id,
            'name' => $this->name,
            'url' => $this->route,
            'new' => $this->isNew(),
            'dataPrice' => $this->prices(),
            'images' => $this->image_uploaded,
        ];
    }
}