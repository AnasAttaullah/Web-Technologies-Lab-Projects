@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Order #{{ $order->id }}</h1>
    <div>
        <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Order Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Order ID</th>
                        <td>#{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <th>Order Date</th>
                        <td>{{ $order->order_date->format('Y-m-d') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Amount</th>
                        <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <th>Created At</th>
                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Customer Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Name</th>
                        <td>
                            <a href="{{ route('customers.show', $order->customer) }}">
                                {{ $order->customer->name }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $order->customer->email }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $order->customer->phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $order->customer->address ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Order Items</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderDetails as $detail)
                        <tr>
                            <td>
                                <a href="{{ route('products.show', $detail->product) }}">
                                    {{ $detail->product->name }}
                                </a>
                            </td>
                            <td>${{ number_format($detail->price, 2) }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>${{ number_format($detail->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total:</th>
                        <th>${{ number_format($order->total_amount, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
