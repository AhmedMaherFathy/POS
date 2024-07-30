<?php

namespace Modules\Product\Database\Factories;

use Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $sellingPrice = $this->faker->randomFloat(2, 0, 100);
        $buyingPrice = $this->faker->randomFloat(2, $sellingPrice + 1, $sellingPrice + 100);

        return [
            'name' => $this->faker->name,
            'selling_price' => $sellingPrice,
            'buying_price' => $buyingPrice,
            'quantity' => $this->faker->randomNumber(2),
            'production_date' => $this->faker->date(),
            'expiration_date' => $this->faker->date(),
        ];
    }
}

