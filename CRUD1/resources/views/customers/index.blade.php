@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-people-fill"></i> Customers
    </h1>
    <a href="{{ route('customers.create') }}" class="btn btn-primary btn-modern">
        <i class="bi bi-plus-circle"></i> Add Customer
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td><strong>#{{ $customer->id }}</strong></td>
                            <td><i class="bi bi-person-circle me-2"></i>{{ $customer->name }}</td>
                            <td><i class="bi bi-envelope me-2"></i>{{ $customer->email }}</td>
                            <td><i class="bi bi-telephone me-2"></i>{{ $customer->phone ?? 'N/A' }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
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
                                    <p>No customers found. Add your first customer!</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customers->hasPages())
            <div class="mt-3">
                {{ $customers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
