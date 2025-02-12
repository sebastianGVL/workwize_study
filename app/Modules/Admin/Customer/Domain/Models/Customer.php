<?php

namespace App\Modules\Admin\Customer\Domain\Models;

use App\Modules\Admin\Order\Domain\Models\Order;
use App\Modules\Storefront\Cart\Domain\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


/**
 * @property-read int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property Cart $cart
 */
class Customer extends Model
{
    protected $fillable = [];

    /**
     * @return HasMany<Order>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
