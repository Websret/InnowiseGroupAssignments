<?php

namespace Database\Factories;

use App\Models\ProductType;
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
    public function definition()
    {
        $productTypeIds = ProductType::select('id')->get()->pluck('id');
        return [
            'name' => fake()->words(1, true),
            'manufacture' => fake()->words(1, true),
            'release_date' => fake()->date(),
            'cost' => fake()->numberBetween(600, 3000),
            'description' => fake()->words(3, true),
            'product_type' => fake()->randomElement($productTypeIds),
        ];
    }
}
