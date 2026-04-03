@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-cart-check-fill"></i> Orders
    </h1>
    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-modern">
        <i class="bi bi-plus-circle"></i> Create Order
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Order Date</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td><i class="bi bi-person-circle me-2"></i>{{ $order->customer->name }}</td>
                            <td><i class="bi bi-calendar-event me-2"></i>{{ $order->order_date->format('M d, Y') }}</td>
                            <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                            <td>
                                <span class="badge {{ $order->status == 'completed' ? 'bg-success' : ($order->status == 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('orders.destroy', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p>No orders found. Create your first order!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
