@extends('layouts.app')

@section('title', 'Place New Order')

@section('content')
<div class="container my-5">
    <h1 class="display-4 fw-bold mb-4 text-dark">Place New Order</h1>

    @if($products->isEmpty())
        <div class="alert alert-info text-center py-5">
            <strong>No products with available inventory.</strong> Please check back later.
        </div>
    @else
        <form method="POST" action="{{ route('orders.store') }}" class="bg-white p-4 rounded shadow-sm" novalidate>
            @csrf

            <p class="mb-3 h5 text-dark">Select Products and Quantities:</p>

            <div class="table-responsive border rounded">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr class="text-uppercase text-muted small">
                            <th style="width: 50%;">Product</th>
                            <th class="text-end" style="width: 16%;">Price ($)</th>
                            <th class="text-center" style="width: 16%;">Inventory</th>
                            <th class="text-center" style="width: 16%;">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $index => $product)
                            <tr>
                                <td class="fw-semibold">{{ $product->name }}</td>
                                <td class="text-end">${{ number_format($product->price, 2) }}</td>
                                <td class="text-center text-muted fw-medium">{{ $product->inventory }}</td>
                                <td class="text-center">
                                    <input type="number"
                                           min="0"
                                           max="{{ $product->inventory }}"
                                           step="1"
                                           name="products[{{ $index }}][quantity]"
                                           value="{{ old("products.$index.quantity", 0) }}"
                                           class="form-control text-center d-inline-block w-50" />
                                    <input type="hidden" name="products[{{ $index }}][product_id]" value="{{ $product->id }}">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-4 gap-2">
                <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary d-flex align-items-center">
                    Place Order
                    <svg xmlns="http://www.w3.org/2000/svg" class="ms-2" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>
            </div>
        </form>
    @endif
</div>
@endsection
