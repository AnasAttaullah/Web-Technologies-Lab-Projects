<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Laptop',
                'description' => 'High-performance laptop with 16GB RAM and 512GB SSD',
                'price' => 1299.99,
                'stock' => 15,
            ],
            [
                'name' => 'Smartphone',
                'description' => 'Latest model smartphone with 128GB storage',
                'price' => 799.99,
                'stock' => 30,
            ],
            [
                'name' => 'Wireless Headphones',
                'description' => 'Noise-cancelling wireless headphones',
                'price' => 249.99,
                'stock' => 50,
            ],
            [
                'name' => 'Smart Watch',
                'description' => 'Fitness tracking smartwatch',
                'price' => 399.99,
                'stock' => 25,
            ],
            [
                'name' => 'Tablet',
                'description' => '10-inch tablet with stylus support',
                'price' => 599.99,
                'stock' => 20,
            ],
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse',
                'price' => 49.99,
                'stock' => 100,
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB mechanical gaming keyboard',
                'price' => 149.99,
                'stock' => 40,
            ],
            [
                'name' => 'External Hard Drive',
                'description' => '2TB portable external hard drive',
                'price' => 89.99,
                'stock' => 60,
            ],
            [
                'name' => 'USB-C Hub',
                'description' => 'Multi-port USB-C hub with HDMI and ethernet',
                'price' => 69.99,
                'stock' => 75,
            ],
            [
                'name' => 'Webcam',
                'description' => '1080p HD webcam with built-in microphone',
                'price' => 79.99,
                'stock' => 35,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
