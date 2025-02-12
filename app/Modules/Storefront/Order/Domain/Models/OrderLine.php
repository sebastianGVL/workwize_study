<?php

namespace App\Modules\Storefront\Order\Domain\Models;

use App\Modules\Admin\Product\Domain\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property int $order_id
 * @property int $product_id
 * @property string $product_number
 * @property string $product_name
 * @property string $product_description
 * @property int $quantity
 * @property int $price
 * @property int $total_price
 */
class OrderLine extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'product_number',
        'product_name',
        'product_description',
        'quantity',
        'price',
        'total_price',
    ];

    /**
     * @return BelongsTo<Order>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return BelongsTo<Product>
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
