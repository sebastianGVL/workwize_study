<?php

namespace App\Modules\Admin\Order\Domain\Models;

use App\Modules\Storefront\Order\Domain\Models\OrderLine;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property int $customer_id
 * @property string $customer_name
 * @property string $customer_email
 * @property string $shipping_address
 * @property string $billing_address
 * @property string $payment_method
 * @property Collection<OrderItem> $lines
 */
class Order extends Model
{
    protected $fillable = [];

    public function items(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }
}
