@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Order Details</h1>
    <a href="{{ route('order-details.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Order Detail
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orderDetails as $detail)
                        <tr>
                            <td>{{ $detail->id }}</td>
                            <td>
                                <a href="{{ route('orders.show', $detail->order) }}">#{{ $detail->order_id }}</a>
                            </td>
                            <td>{{ $detail->order->customer->name }}</td>
                            <td>{{ $detail->product->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>${{ number_format($detail->price, 2) }}</td>
                            <td>${{ number_format($detail->subtotal, 2) }}</td>
                            <td>
                                <a href="{{ route('order-details.show', $detail) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('order-details.edit', $detail) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('order-details.destroy', $detail) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No order details found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $orderDetails->links() }}
        </div>
    </div>
</div>
@endsection
