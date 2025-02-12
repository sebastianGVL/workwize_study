<?php

namespace App\Modules\Storefront\Cart\Domain;

use App\Modules\Storefront\Customer\Domain\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property int $customer_id
 * @property int $type
 * @property Customer $customer
 * @property Collection<CartItem> $items
 */
class Cart extends Model
{
    public const  TYPE_CART = 0;
    public const  TYPE_WISHLIST = 1;

    protected $fillable = [
        'customer_id',
        'type'
    ];

    /**
     * @return BelongsTo<Customer>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * @return HasMany<CartItem>
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function getTotal(string $target, float $initialTotal = 0.00): float
    {
        if (!in_array($target, ['total', 'subtotal'], true)) {
            return $initialTotal;
        }

        $total = $initialTotal;

        if ($target === 'subtotal') {
            foreach ($this->items as $item) {
                $itemPrice = $item->final_price * $item->quantity;
                $total += $itemPrice;
            }
        }

        return (float)number_format($total, 2, '.', '');
    }
}
