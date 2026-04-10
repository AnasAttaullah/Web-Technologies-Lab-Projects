<?php

namespace App\Http\Controllers;

use App\Events\StockAdjusted;
use App\Models\OrderDetail;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $validator->after(function ($validator) use ($request) {
            $productId = $request->input('product_id');
            $quantity = (int) $request->input('quantity', 0);

            if (!$productId || $quantity < 1) {
                return;
            }

            $product = Product::find($productId);
            if ($product && $quantity > $product->stock) {
                $validator->errors()->add('quantity', "Only {$product->stock} unit(s) available for {$product->name}.");
            }
        });

        $validated = $validator->validate();

        DB::transaction(function () use ($validated) {
            $product = Product::findOrFail($validated['product_id']);
            $price = $product->price;
            $subtotal = $price * $validated['quantity'];

            $orderDetail = OrderDetail::create([
                'order_id' => $validated['order_id'],
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'price' => $price,
                'subtotal' => $subtotal,
            ]);

            $previousStock = $product->stock;
            $product->decrement('stock', $validated['quantity']);

            StockAdjusted::dispatch(
                productId: $product->id,
                productName: $product->name,
                previousStock: $previousStock,
                newStock: $previousStock - $validated['quantity'],
                reason: 'order_detail_created',
                orderId: (int) $validated['order_id'],
                orderDetailId: $orderDetail->id,
            );

            $order = Order::findOrFail($validated['order_id']);
            $order->total_amount = $order->orderDetails()->sum('subtotal');
            $order->save();
        });

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
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $validator->after(function ($validator) use ($request, $orderDetail) {
            $productId = $request->input('product_id');
            $quantity = (int) $request->input('quantity', 0);

            if (!$productId || $quantity < 1) {
                return;
            }

            $product = Product::find($productId);
            if (!$product) {
                return;
            }

            $availableStock = $product->stock;
            if ((int) $orderDetail->product_id === (int) $product->id) {
                $availableStock += $orderDetail->quantity;
            }

            if ($quantity > $availableStock) {
                $validator->errors()->add('quantity', "Only {$availableStock} unit(s) available for {$product->name}.");
            }
        });

        $validated = $validator->validate();

        $oldQuantity = $orderDetail->quantity;
        $oldProductId = $orderDetail->product_id;
        $oldOrderId = $orderDetail->order_id;

        DB::transaction(function () use ($validated, $orderDetail, $oldProductId, $oldQuantity, $oldOrderId) {
            $oldProduct = Product::findOrFail($oldProductId);
            $oldPreviousStock = $oldProduct->stock;
            $oldProduct->increment('stock', $oldQuantity);

            StockAdjusted::dispatch(
                productId: $oldProduct->id,
                productName: $oldProduct->name,
                previousStock: $oldPreviousStock,
                newStock: $oldPreviousStock + $oldQuantity,
                reason: 'order_detail_reverted',
                orderId: (int) $oldOrderId,
                orderDetailId: $orderDetail->id,
            );

            $product = Product::findOrFail($validated['product_id']);
            $price = $product->price;
            $subtotal = $price * $validated['quantity'];

            $orderDetail->update([
                'order_id' => $validated['order_id'],
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'price' => $price,
                'subtotal' => $subtotal,
            ]);

            $newPreviousStock = $product->stock;
            $product->decrement('stock', $validated['quantity']);

            StockAdjusted::dispatch(
                productId: $product->id,
                productName: $product->name,
                previousStock: $newPreviousStock,
                newStock: $newPreviousStock - $validated['quantity'],
                reason: 'order_detail_updated',
                orderId: (int) $validated['order_id'],
                orderDetailId: $orderDetail->id,
            );

            $newOrder = Order::findOrFail($validated['order_id']);
            $newOrder->total_amount = $newOrder->orderDetails()->sum('subtotal');
            $newOrder->save();

            if ((int) $oldOrderId !== (int) $validated['order_id']) {
                $oldOrder = Order::findOrFail($oldOrderId);
                $oldOrder->total_amount = $oldOrder->orderDetails()->sum('subtotal');
                $oldOrder->save();
            }
        });

        return redirect()->route('order-details.index')
            ->with('success', 'Order detail updated successfully.');
    }

    public function destroy(OrderDetail $orderDetail)
    {
        DB::transaction(function () use ($orderDetail) {
            $product = Product::findOrFail($orderDetail->product_id);
            $previousStock = $product->stock;
            $product->increment('stock', $orderDetail->quantity);

            StockAdjusted::dispatch(
                productId: $product->id,
                productName: $product->name,
                previousStock: $previousStock,
                newStock: $previousStock + $orderDetail->quantity,
                reason: 'order_detail_deleted',
                orderId: $orderDetail->order_id,
                orderDetailId: $orderDetail->id,
            );

            $order = Order::findOrFail($orderDetail->order_id);

            $orderDetail->delete();

            $order->total_amount = $order->orderDetails()->sum('subtotal');
            $order->save();
        });

        return redirect()->route('order-details.index')
            ->with('success', 'Order detail deleted successfully.');
    }
}
