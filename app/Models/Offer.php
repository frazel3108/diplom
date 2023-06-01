<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Offer extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('start_at', '<=', date('Y-m-d'))
            ->where('end_at', '>=', date('Y-m-d'));
    }

    public function bannerLink(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->banner ? Storage::disk('images')->url($this->banner) : null,
        )->shouldCache();
    }
}