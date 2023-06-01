<?php

namespace App\Models\Order;

use App\Models\Product;
use App\Models\Product\Content;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'content_ids' => 'json'
    ];

    public function data(): Attribute
    {
        return Attribute::make(
            get: fn () => Product::where('id', $this->product_id)->first(),
        )->shouldCache();
    }

    public function contents(): Attribute
    {
        return Attribute::make(
            get: fn () => Content::whereIn('id', $this->content_ids)->withTrashed()->get(),
        )->shouldCache();
    }
}