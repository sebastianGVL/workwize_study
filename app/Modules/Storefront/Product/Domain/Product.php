<?php

namespace App\Modules\Storefront\Product\Domain;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $name
 * @property string $product_number
 * @property string $description
 * @property int $price
 * @property int $stock
 */
class Product extends Model
{
    protected $fillable =[];

    protected function price(): Attribute
    {
        return Attribute::make(
//            get: fn (string $value) => $value * 100,
            set: fn (string $value) => $value * 100,
        );
    }
}
