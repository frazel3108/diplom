<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class Content extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products_content';

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeJoinProduct(Builder $query): Builder
    {
        return $query->join('products', 'products.id', 'products_content.product_id');
    }

    public function fileLink(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->file ? Storage::disk('public')->url($this->file) : null,
        );
    }
}