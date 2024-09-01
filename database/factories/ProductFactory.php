<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $category = Category::inRandomOrder()->first();

        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'category_id' => $category->id,  // Assigning a random category
            'stock' => $this->faker->numberBetween(1, 100),
            'image' => $this->faker->imageUrl(),
            'color' => $this->faker->safeColorName(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
