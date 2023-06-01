<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function scopeLeftJoinProducts(Builder $query): Builder
    {
        return $query->leftJoin('products', 'products.category_id', 'categories.id');
    }

    public function scopeWithImg(Builder $query): Builder
    {
        return $query->whereNotNull('categories.image');
    }

    public function imageLink(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image ? Storage::disk('images')->url($this->image) : null,
        )->shouldCache();
    }

    public function parentCategory()
    {
        return $this->parent_id ? Category::find($this->parent_id) : null;
    }

    public function appUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => env('APP_URL') . '/category/' . $this->url,
        );
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}