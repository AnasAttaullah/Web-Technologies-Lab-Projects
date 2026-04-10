@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Product Details</h1>
    <div>
        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4>{{ $product->name }}</h4>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th width="20%">ID</th>
                <td>{{ $product->id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $product->name }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $product->description ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Price</th>
                <td>${{ number_format($product->price, 2) }}</td>
            </tr>
            <tr>
                <th>Stock</th>
                <td>
                    <span class="badge bg-{{ $product->stock > 10 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                        {{ $product->stock }} units
                    </span>
                </td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $product->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $product->updated_at->format('Y-m-d H:i') }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
