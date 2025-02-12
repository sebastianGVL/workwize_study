<?php

namespace App\Modules\Storefront\Customer\Domain\Models;

use App\Modules\Storefront\Cart\Domain\Cart;
use App\Modules\Storefront\Cart\Domain\CartItem;
use App\Modules\Storefront\Customer\Application\Observers\CustomerObserver;
use App\Modules\Storefront\Customer\Infrastructure\Persistence\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property-read int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property Cart $cart
 */
#[ObservedBy([CustomerObserver::class])]
class Customer extends Authenticatable
{
    /** @use HasFactory<CustomerFactory> */
    use HasApiTokens, Notifiable, HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return CustomerFactory
     */
    protected static function newFactory()
    {
        return new CustomerFactory();
    }

    /**
     * @return HasOne<Cart>
     */
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class)->where('type', Cart::TYPE_CART);
    }

    /**
     * @return HasManyThrough<CartItem>
     */
    public function cartItems(): HasManyThrough
    {
        return $this->hasManyThrough(CartItem::class, Cart::class)
            ->where('type', Cart::TYPE_CART);
    }

    public static function getCart(): Cart
    {
        /** @var self $customer */
        $customer = self::query()
            ->with(['cart.items'])
            ->where('id', Auth::guard('customer')->id())
            ->first();

        if ($customer == null) {
            throw ValidationException::withMessages(['cart' => 'customer_not_logged_in']);
        }

        assert($customer instanceof self);
        assert($customer->cart instanceof Cart);

        return $customer->cart;
    }
}
