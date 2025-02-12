<?php

namespace App\Modules\Storefront\Order\Domain\Models;

use App\Modules\Storefront\Customer\Domain\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property int $customer_id
 * @property string $customer_name
 * @property string $customer_email
 * @property string $shipping_address
 * @property string $billing_address
 * @property string $payment_method
 * @property Collection<OrderLine> $lines
 * @property Customer $customer
 */
class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_email',
        'shipping_address',
        'billing_address',
        'payment_method',
    ];

    /**
     * @return BelongsTo<Customer>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function lines(): HasMany
    {
        return $this->hasMany(OrderLine::class);
    }
}
