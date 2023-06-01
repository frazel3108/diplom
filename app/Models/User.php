<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Collection;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function basket(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->order()->where('status', 0)->first(),
        )->shouldCache();
    }

    public function countBasketProduct(Product $product): int
    {
        if (!$this->basket) {
            return 0;
        }

        $orderProduct = $this->basket
            ->products()
            ->where('product_id', $product->id)
            ->first();

        return $orderProduct->quantity ?? 0;
    }

    public function addToOrder(Product $product)
    {
        $order = $this->basket;

        if (!$order) {
            $order = $this->order()->create();
        }

        $order->addProduct($product);

        return $order->touch();
    }

    public function removeToOrder(Product $product)
    {
        if (!$this->basket) {
            return $this->order()->create();
        }

        $this->basket->removeProduct($product);

        return $this->basket->touch();
    }

    public function orderHistory(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->order()->where('status', 1)->orderBy('updated_at', 'DESC')->get(),
        )->shouldCache();
    }

    public function countBuyProducts(): Attribute
    {
        $count = 0;
        foreach ($this->order()->where('status', 1)->get() as $order) {
            foreach ($order->products as $product) {
                $count += $product->quantity;
            }
        }

        return Attribute::make(fn () => $count);
    }

    public function deleteProduct(Product $product)
    {
        $this->basket->deleteProduct($product);

        return $this->basket->touch();
    }
}