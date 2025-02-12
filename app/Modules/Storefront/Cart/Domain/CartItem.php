<?php

namespace App\Modules\Storefront\Cart\Domain;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property int $cart_id
 * @property string $product_name
 * @property string $product_description
 * @property int $price
 * @property int $total_price
 * @property int $quantity
 * @property Cart $cart
 */
class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_name',
        'product_description',
        'price',
        'total_price',
        'quantity'
    ];

    /**
     * @return BelongsTo<Cart>
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
}
