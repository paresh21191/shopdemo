@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-900">Add New Product</h1>

<form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data" class="max-w-lg bg-white p-6 rounded shadow">
    @csrf
    <div class="mb-4">
        <label class="block font-semibold mb-1" for="name">Name</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="input-field w-full" />
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1" for="sku">SKU</label>
        <input type="text" name="sku" id="sku" value="{{ old('sku') }}" required class="input-field w-full" />
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1" for="description">Description</label>
        <textarea name="description" id="description" rows="4" class="input-field w-full">{{ old('description') }}</textarea>
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1" for="price">Price ($)</label>
        <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price') }}" required class="input-field w-full" />
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1" for="inventory">Inventory</label>
        <input type="number" min="0" name="inventory" id="inventory" value="{{ old('inventory') ?? 0 }}" required class="input-field w-full" />
    </div>

    <div class="mb-4">
        <label class="block font-semibold mb-1" for="image">Product Image</label>
        <input type="file" name="image" id="image" class="w-full" />
    </div>

    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700">Save Product</button>
    <a href="{{ route('products.index') }}" class="ml-4 text-gray-600 hover:underline">Cancel</a>
</form>
@endsection