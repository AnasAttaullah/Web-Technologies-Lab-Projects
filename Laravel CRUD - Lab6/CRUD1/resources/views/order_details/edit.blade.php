@extends('layouts.app')

@section('title', 'Edit Order Detail')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3>Edit Order Detail</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('order-details.update', $orderDetail) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="order_id" class="form-label">Order *</label>
                        <select class="form-select @error('order_id') is-invalid @enderror" 
                                id="order_id" name="order_id" required>
                            <option value="">Select Order</option>
                            @foreach($orders as $order)
                                <option value="{{ $order->id }}" 
                                    {{ old('order_id', $orderDetail->order_id) == $order->id ? 'selected' : '' }}>
                                    Order #{{ $order->id }} - {{ $order->customer->name }} ({{ $order->order_date->format('Y-m-d') }})
                                </option>
                            @endforeach
                        </select>
                        @error('order_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="product_id" class="form-label">Product *</label>
                        <select class="form-select @error('product_id') is-invalid @enderror" 
                                id="product_id" name="product_id" required>
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                    {{ old('product_id', $orderDetail->product_id) == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} - ${{ number_format($product->price, 2) }} (Stock: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity *</label>
                        <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                               id="quantity" name="quantity" value="{{ old('quantity', $orderDetail->quantity) }}" min="1" required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <strong>Note:</strong> Price and subtotal will be recalculated based on current product price.
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('order-details.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
