<?php

namespace App\Http\Controllers;

use App\Events\StockAdjusted;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('stock', '>', 0)->get();
        return view('orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ], [
            'products.required' => 'Please add at least one product.',
            'products.*.product_id.required' => 'Please select a product for each row.',
            'products.*.quantity.required' => 'Quantity is required for each selected product.',
        ]);

        $validator->after(function ($validator) use ($request) {
            $rows = $request->input('products', []);

            $productIds = collect($rows)
                ->pluck('product_id')
                ->filter()
                ->all();

            if (count($productIds) !== count(array_unique($productIds))) {
                $validator->errors()->add('products', 'Each product can only be added once per order.');
            }

            foreach ($rows as $index => $row) {
                if (empty($row['product_id']) || empty($row['quantity'])) {
                    continue;
                }

                $product = Product::find($row['product_id']);

                if (!$product) {
                    continue;
                }

                if ((int) $row['quantity'] > $product->stock) {
                    $validator->errors()->add(
                        "products.{$index}.quantity",
                        "Only {$product->stock} unit(s) available for {$product->name}."
                    );
                }
            }
        });

        $validated = $validator->validate();

        DB::transaction(function () use ($validated) {
            $order = Order::create([
                'customer_id' => $validated['customer_id'],
                'order_date' => $validated['order_date'],
                'status' => $validated['status'],
                'total_amount' => 0,
            ]);

            $totalAmount = 0;

            foreach ($validated['products'] as $productData) {
                $product = Product::findOrFail($productData['product_id']);
                $quantity = (int) $productData['quantity'];
                $price = $product->price;
                $subtotal = $price * $quantity;

                $order->orderDetails()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                $totalAmount += $subtotal;

                $previousStock = $product->stock;
                $product->decrement('stock', $quantity);

                StockAdjusted::dispatch(
                    productId: $product->id,
                    productName: $product->name,
                    previousStock: $previousStock,
                    newStock: $previousStock - $quantity,
                    reason: 'order_created',
                    orderId: $order->id,
                );
            }

            $order->update(['total_amount' => $totalAmount]);
        });

        return redirect()->route('orders.index')
            ->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load('customer', 'orderDetails.product');
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $customers = Customer::all();
        $order->load('orderDetails.product');
        return view('orders.edit', compact('order', 'customers'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update($validated);

        return redirect()->route('orders.index')
            ->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        DB::transaction(function () use ($order) {
            foreach ($order->orderDetails as $detail) {
                $product = Product::findOrFail($detail->product_id);
                $previousStock = $product->stock;
                $product->increment('stock', $detail->quantity);

                StockAdjusted::dispatch(
                    productId: $product->id,
                    productName: $product->name,
                    previousStock: $previousStock,
                    newStock: $previousStock + $detail->quantity,
                    reason: 'order_deleted',
                    orderId: $order->id,
                    orderDetailId: $detail->id,
                );
            }

            $order->delete();
        });

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}
