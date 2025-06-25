@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 fw-bold text-dark">Add New Product</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('products.manage.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="form-control">
                </div>

                <div class="mb-3">
                    <label for="sku" class="form-label fw-semibold">SKU</label>
                    <input type="text" name="sku" id="sku" value="{{ old('sku') }}" required class="form-control">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea name="description" id="description" rows="4" class="form-control">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label fw-semibold">Price ($)</label>
                    <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price') }}" required class="form-control">
                </div>

                <div class="mb-3">
                    <label for="inventory" class="form-label fw-semibold">Inventory</label>
                    <input type="number" min="0" name="inventory" id="inventory" value="{{ old('inventory') ?? 0 }}" required class="form-control">
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label fw-semibold">Product Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary px-4">Save Product</button>
                    <a href="{{ route('products.manage.index') }}" class="text-muted text-decoration-none">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
