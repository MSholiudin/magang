<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $productName = $this->faker->unique()->words($this->faker->numberBetween(1, 3), true);
        
        return [
            'name' => Str::title($productName),
            'price' => $this->faker->numberBetween(1000, 1000000), // Harga antara 1.000 - 1.000.000
            'stock' => $this->faker->numberBetween(0, 500), // Stok antara 0-500
            'description' => $this->faker->paragraph(),
            'file_path' => $this->faker->optional(0.7)->imageUrl(640, 480, 'products', true), // 70% punya gambar
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}