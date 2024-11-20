<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'nama' => $this->faker->word() . ' ' . $this->faker->word(), // Random product name like "T-Shirt Large"
            'deskripsi' => $this->faker->sentence(),
            'harga' => $this->faker->numberBetween(10, 1000) * 1000, // Random price between 100,000 and 1,000,000
            'stok' => $this->faker->numberBetween(1, 100), // Random stock quantity
            'sku' => strtoupper($this->faker->lexify('????')) . $this->faker->numberBetween(1000, 9999), // Random SKU code (e.g., ABC1234)
            'kategori' => $this->faker->randomElement(['Men', 'Women', 'Kids']), // Random clothing category
            'ukuran' => $this->faker->randomElement(['S', 'M', 'L', 'XL', 'XXL']), // Random clothing size
            'stok_minimum' => $this->faker->numberBetween(1, 10), // Random minimum stock
            'stok_maximum' => $this->faker->numberBetween(50, 200), // Random maximum stock
        ];
    }
}