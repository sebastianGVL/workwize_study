<?php

declare(strict_types=1);

namespace App\Modules\Admin\Product\Domain\Models;

use App\Modules\Admin\Product\Infrastructure\Persistence\Factories\ProductFactory;
use App\Modules\Admin\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property string $name
 * @property string $product_number
 * @property string $description
 * @property int $price
 * @property int $stock
 * @property int $user_id
 * @property User $user
 */
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'product_number',
        'description',
        'price',
        'stock',
        'user_id'
    ];

    /**
     * @return BelongsTo<User>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return ProductFactory
     */
    protected static function newFactory()
    {
        return new ProductFactory();
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => $value / 100,
            set: fn(string $value) => $value * 100,
        );
    }
}
