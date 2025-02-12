<?php

namespace App\Modules\Admin\Product\Infrastructure\Persistence\Factories;

use App\Modules\Admin\Product\Domain\Models\Product;
use App\Modules\Admin\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->paragraph(2),
            'stock' => fake()->numberBetween(1,500),
            'price' => fake()->numberBetween(100,5000), //between 1 eur and 50 eurs.
            'user_id' => User::factory(),
        ];
    }
}
