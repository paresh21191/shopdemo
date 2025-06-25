@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="max-w-4xl mx-auto my-5">
    <h1 class="display-4 fw-bold mb-4">Edit Product</h1>

    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                   value="{{ old('name', $product->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="sku" class="form-label fw-semibold">SKU</label>
            <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" 
                   value="{{ old('sku', $product->sku) }}" required>
            @error('sku')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label fw-semibold">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="price" class="form-label fw-semibold">Price ($)</label>
                <input type="number" min="0" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" 
                       value="{{ old('price', $product->price) }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="inventory" class="form-label fw-semibold">Inventory</label>
                <input type="number" min="0" step="1" class="form-control @error('inventory') is-invalid @enderror" id="inventory" name="inventory" 
                       value="{{ old('inventory', $product->inventory) }}" required>
                @error('inventory')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="image" class="form-label fw-semibold">Product Image</label>
            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" accept="image/*">
            @error('image')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            @if($product->image)
                <div class="mt-3">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="img-fluid rounded" style="max-width: 200px;">
                </div>
            @endif
        </div>

        <div class="d-flex gap-3">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </div>
    </form>
</div>
@endsection