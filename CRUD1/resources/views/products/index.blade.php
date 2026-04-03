@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-box-seam-fill"></i> Products
    </h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary btn-modern">
        <i class="bi bi-plus-circle"></i> Add Product
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td><strong>#{{ $product->id }}</strong></td>
                            <td><i class="bi bi-box me-2"></i>{{ $product->name }}</td>
                            <td><strong>${{ number_format($product->price, 2) }}</strong></td>
                            <td>
                                <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }}">
                                    <i class="bi bi-boxes me-1"></i>{{ $product->stock }} units
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
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
                            <td colspan="5" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p>No products found. Add your first product!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
            <div class="mt-3">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
