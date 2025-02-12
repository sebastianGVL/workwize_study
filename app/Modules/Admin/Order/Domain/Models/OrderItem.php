<?php

namespace App\Modules\Admin\Order\Domain\Models;

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
class OrderItem extends Model
{
    protected $fillable = [];

    /**
     * @return BelongsTo<Order>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
