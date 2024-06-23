<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_name' => fake()->firstName() . fake()->lastName(),
            'barcode' => str_pad(fake()->numberBetween(), 12, '0', STR_PAD_LEFT),
            'fk_category' => fake()->numberBetween(1, 2),
            'fk_supplier' => fake()->numberBetween(1, 3),
            'stock_quantity' => fake()->numberBetween(50, 500),
            'price' => fake()->numberBetween(100, 200),
            'available' => true,
        ];
    }
}
