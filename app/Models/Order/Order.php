<?php

namespace App\Models\Order;

use App\Models\Product;
use App\Models\User;
use App\Traits\Eloquent\Scopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Order extends Model
{
    use HasFactory;
    use Scopes;

    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

     public function scopeConfirm(Builder $query): Builder
    {
        return $query->where('status', 1);
    }

    public function scopeJoinUser(Builder $query): Builder
    {
        return $query->safeJoin('users', 'users.id', 'orders.user_id');
    }

    public function scopeJoinOrderProducts(Builder $query): Builder
    {
        return $query->safeJoin('order_products', 'order_products.order_id', 'orders.id');
    }

    public function summary()
    {
        $subTotal = 0;
        $discountTotal = 0;
        $total = 0;

        foreach ($this->products as $product) {
            $dataProduct = $product->data->prices();
            if ($dataProduct['discount']) {
                $discountTotal += ($dataProduct['old_price'] - $dataProduct['price']) * $product->quantity;
            }
            $subTotal += $dataProduct['old_price'] * $product->quantity;
            $total += $dataProduct['price'] * $product->quantity;
        }

        return [
            'subTotal' => $subTotal,
            'discountTotal' => $discountTotal,
            'total' => $total
        ];
    }

    public function priceBasket(): Attribute
    {
        $count = 0;
        foreach ($this->products as $product) {
            $count += $product->price * $product->quantity;
        }
        return Attribute::make(
            get: fn () => $count,
        );
    }

    public function addProduct(Product $product)
    {
        $orderProduct = $this->products()->where('product_id', $product->id)->first();
        if (
            $orderProduct &&
            (($orderProduct->data->count_content - 1) - $orderProduct->quantity) >= 0
        ) {
            $orderProduct->quantity++;
            return $orderProduct->save();
        } elseif ($orderProduct) {
            $orderProduct->quantity = 1;
            return $orderProduct->save();
        }

        if ($product->count_content > 0) {
            return $this->products()->create([
                'product_id' => $product->id,
                'price' => $product->prices()['price']
            ]);
        } else {
            return;
        }
    }

    public function removeProduct(Product $product)
    {
        $orderProduct = $this->products()->where('product_id', $product->id)->first();

        if (!$orderProduct) {
            return;
        }

        if ($orderProduct->quantity > 1) {
            $orderProduct->quantity--;
            return $orderProduct->save();
        }

        return $this->deleteProduct($product);
    }

    public function deleteProduct(Product $product)
    {
        return $this->products()->where('product_id', $product->id)->delete();
    }

    public function createOrder()
    {
        foreach ($this->products as $product) {
            $contents = $product->data->content()->limit($product->quantity)->get();
            foreach ($contents as $content) {
                $content->update(['user_id' => auth()->user()->id]);
                $content->delete();
            }

            $product->content_ids = $contents->pluck('id')->toArray();
            $product->save();
        }
        return $this->update(['status' => 1]);
    }
}