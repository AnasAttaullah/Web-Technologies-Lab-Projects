<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    public function index()
    {
        $orderDetails = OrderDetail::with('order.customer', 'product')->latest()->paginate(10);
        return view('order_details.index', compact('orderDetails'));
    }

    public function create()
    {
        $orders = Order::with('customer')->get();
        $products = Product::where('stock', '>', 0)->get();
        return view('order_details.create', compact('orders', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($validated['product_id']);
        
        if ($product->stock < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Insufficient stock available.']);
        }

        $price = $product->price;
        $subtotal = $price * $validated['quantity'];

        OrderDetail::create([
            'order_id' => $validated['order_id'],
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'price' => $price,
            'subtotal' => $subtotal,
        ]);

        $product->decrement('stock', $validated['quantity']);

        $order = Order::find($validated['order_id']);
        $order->total_amount = $order->orderDetails()->sum('subtotal');
        $order->save();

        return redirect()->route('order-details.index')
            ->with('success', 'Order detail created successfully.');
    }

    public function show(OrderDetail $orderDetail)
    {
        $orderDetail->load('order.customer', 'product');
        return view('order_details.show', compact('orderDetail'));
    }

    public function edit(OrderDetail $orderDetail)
    {
        $orders = Order::with('customer')->get();
        $products = Product::all();
        return view('order_details.edit', compact('orderDetail', 'orders', 'products'));
    }

    public function update(Request $request, OrderDetail $orderDetail)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $oldQuantity = $orderDetail->quantity;
        $oldProductId = $orderDetail->product_id;

        $oldProduct = Product::find($oldProductId);
        $oldProduct->increment('stock', $oldQuantity);

        $product = Product::find($validated['product_id']);
        
        if ($product->stock < $validated['quantity']) {
            $oldProduct->decrement('stock', $oldQuantity);
            return back()->withErrors(['quantity' => 'Insufficient stock available.']);
        }

        $price = $product->price;
        $subtotal = $price * $validated['quantity'];

        $orderDetail->update([
            'order_id' => $validated['order_id'],
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'price' => $price,
            'subtotal' => $subtotal,
        ]);

        $product->decrement('stock', $validated['quantity']);

        $order = Order::find($validated['order_id']);
        $order->total_amount = $order->orderDetails()->sum('subtotal');
        $order->save();

        return redirect()->route('order-details.index')
            ->with('success', 'Order detail updated successfully.');
    }

    public function destroy(OrderDetail $orderDetail)
    {
        $product = Product::find($orderDetail->product_id);
        $product->increment('stock', $orderDetail->quantity);

        $order = Order::find($orderDetail->order_id);
        
        $orderDetail->delete();

        $order->total_amount = $order->orderDetails()->sum('subtotal');
        $order->save();

        return redirect()->route('order-details.index')
            ->with('success', 'Order detail deleted successfully.');
    }
}
