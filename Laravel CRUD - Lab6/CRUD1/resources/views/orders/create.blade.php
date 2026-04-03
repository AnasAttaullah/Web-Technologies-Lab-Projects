@extends('layouts.app')

@section('title', 'Create Order')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h3>Create New Order</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customer_id" class="form-label">Customer *</label>
                                <select class="form-select @error('customer_id') is-invalid @enderror" 
                                        id="customer_id" name="customer_id" required>
                                    <option value="">Select Customer</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }} ({{ $customer->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="order_date" class="form-label">Order Date *</label>
                                <input type="date" class="form-control @error('order_date') is-invalid @enderror" 
                                       id="order_date" name="order_date" value="{{ old('order_date', date('Y-m-d')) }}" required>
                                @error('order_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3">Order Items</h5>
                    <div id="productItems">
                        <div class="row product-row mb-3">
                            <div class="col-md-8">
                                <label class="form-label">Product *</label>
                                <select class="form-select" name="products[0][product_id]" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                                            {{ $product->name }} - ${{ number_format($product->price, 2) }} (Stock: {{ $product->stock }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Quantity *</label>
                                <input type="number" class="form-control" name="products[0][quantity]" min="1" value="1" required>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm remove-product" style="display: none;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary btn-sm mb-3" id="addProduct">
                        <i class="bi bi-plus"></i> Add Product
                    </button>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Create Order</button>
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let productCount = 1;
const productsData = @json($products);

document.getElementById('addProduct').addEventListener('click', function() {
    const productItems = document.getElementById('productItems');
    const newRow = document.createElement('div');
    newRow.className = 'row product-row mb-3';
    newRow.innerHTML = `
        <div class="col-md-8">
            <label class="form-label">Product *</label>
            <select class="form-select" name="products[${productCount}][product_id]" required>
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                        {{ $product->name }} - ${{ number_format($product->price, 2) }} (Stock: {{ $product->stock }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Quantity *</label>
            <input type="number" class="form-control" name="products[${productCount}][quantity]" min="1" value="1" required>
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button type="button" class="btn btn-danger btn-sm remove-product">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    productItems.appendChild(newRow);
    productCount++;
    updateRemoveButtons();
});

document.getElementById('productItems').addEventListener('click', function(e) {
    if (e.target.closest('.remove-product')) {
        e.target.closest('.product-row').remove();
        updateRemoveButtons();
    }
});

function updateRemoveButtons() {
    const rows = document.querySelectorAll('.product-row');
    rows.forEach((row, index) => {
        const removeBtn = row.querySelector('.remove-product');
        if (rows.length > 1) {
            removeBtn.style.display = 'block';
        } else {
            removeBtn.style.display = 'none';
        }
    });
}
</script>
@endsection
