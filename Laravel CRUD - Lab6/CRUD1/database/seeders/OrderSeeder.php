<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $products = Product::all();

        // Order 1
        $order1 = Order::create([
            'customer_id' => $customers[0]->id,
            'order_date' => now()->subDays(5),
            'status' => 'completed',
            'total_amount' => 0,
        ]);

        $subtotal1 = 0;
        $detail1 = $order1->orderDetails()->create([
            'product_id' => $products[0]->id,
            'quantity' => 1,
            'price' => $products[0]->price,
            'subtotal' => $products[0]->price * 1,
        ]);
        $subtotal1 += $detail1->subtotal;

        $detail2 = $order1->orderDetails()->create([
            'product_id' => $products[5]->id,
            'quantity' => 2,
            'price' => $products[5]->price,
            'subtotal' => $products[5]->price * 2,
        ]);
        $subtotal1 += $detail2->subtotal;

        $order1->update(['total_amount' => $subtotal1]);

        // Order 2
        $order2 = Order::create([
            'customer_id' => $customers[1]->id,
            'order_date' => now()->subDays(3),
            'status' => 'processing',
            'total_amount' => 0,
        ]);

        $subtotal2 = 0;
        $detail3 = $order2->orderDetails()->create([
            'product_id' => $products[1]->id,
            'quantity' => 1,
            'price' => $products[1]->price,
            'subtotal' => $products[1]->price * 1,
        ]);
        $subtotal2 += $detail3->subtotal;

        $detail4 = $order2->orderDetails()->create([
            'product_id' => $products[2]->id,
            'quantity' => 1,
            'price' => $products[2]->price,
            'subtotal' => $products[2]->price * 1,
        ]);
        $subtotal2 += $detail4->subtotal;

        $order2->update(['total_amount' => $subtotal2]);

        // Order 3
        $order3 = Order::create([
            'customer_id' => $customers[2]->id,
            'order_date' => now()->subDays(1),
            'status' => 'pending',
            'total_amount' => 0,
        ]);

        $subtotal3 = 0;
        $detail5 = $order3->orderDetails()->create([
            'product_id' => $products[3]->id,
            'quantity' => 1,
            'price' => $products[3]->price,
            'subtotal' => $products[3]->price * 1,
        ]);
        $subtotal3 += $detail5->subtotal;

        $order3->update(['total_amount' => $subtotal3]);

        // Update product stock
        $products[0]->decrement('stock', 1);
        $products[5]->decrement('stock', 2);
        $products[1]->decrement('stock', 1);
        $products[2]->decrement('stock', 1);
        $products[3]->decrement('stock', 1);
    }
}
