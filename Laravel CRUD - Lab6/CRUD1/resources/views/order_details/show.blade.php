@extends('layouts.app')

@section('title', 'Order Detail')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Order Detail #{{ $orderDetail->id }}</h1>
    <div>
        <a href="{{ route('order-details.edit', $orderDetail) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('order-details.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Order Detail Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">ID</th>
                        <td>{{ $orderDetail->id }}</td>
                    </tr>
                    <tr>
                        <th>Order</th>
                        <td>
                            <a href="{{ route('orders.show', $orderDetail->order) }}">
                                Order #{{ $orderDetail->order_id }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Product</th>
                        <td>
                            <a href="{{ route('products.show', $orderDetail->product) }}">
                                {{ $orderDetail->product->name }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{ $orderDetail->quantity }}</td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>${{ number_format($orderDetail->price, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Subtotal</th>
                        <td><strong>${{ number_format($orderDetail->subtotal, 2) }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Order Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Customer</th>
                        <td>
                            <a href="{{ route('customers.show', $orderDetail->order->customer) }}">
                                {{ $orderDetail->order->customer->name }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Order Date</th>
                        <td>{{ $orderDetail->order->order_date->format('Y-m-d') }}</td>
                    </tr>
                    <tr>
                        <th>Order Status</th>
                        <td>
                            <span class="badge bg-{{ $orderDetail->order->status == 'completed' ? 'success' : ($orderDetail->order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                {{ ucfirst($orderDetail->order->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Order Total</th>
                        <td><strong>${{ number_format($orderDetail->order->total_amount, 2) }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
