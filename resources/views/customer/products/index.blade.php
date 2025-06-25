@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
  <h1 class="display-4 fw-bold">Products</h1>
  @can('manage-products')
    <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg">
      <i class="bi bi-plus-lg"></i> Add Product
    </a>
  @endcan
</div>

@if($products->isEmpty())
  <p class="text-muted text-center fs-5 mt-5">No products found.</p>
@else
  <div class="row row-cols-1 row-cols-md-3 g-4">
    @foreach($products as $product)
      <div class="col">
        <div class="card shadow-sm h-100">
            @if($product->image)
              <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top object-fit-cover" style="height: 220px;" alt="{{ $product->name }}">
            @else
              <div class="bg-secondary text-white d-flex justify-content-center align-items-center" style="height: 220px; font-weight: 700;">
                No Image
              </div>
            @endif
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{ $product->name }}</h5>
              <p class="card-text text-primary fw-bold fs-5">${{ number_format($product->price, 2) }}</p>
              <p class="text-muted small mb-2">{{ Str::limit($product->description, 80) }}</p>
              <p class="mb-3 fw-semibold {{ $product->inventory > 0 ? 'text-success' : 'text-danger' }}">
                Inventory: {{ $product->inventory }}
              </p>
              <div class="mt-auto d-flex gap-2 flex-wrap">
                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary flex-grow-1">View</a>
                @can('manage-products')
                  <a href="{{ route('products.edit', $product) }}" class="btn btn-primary flex-grow-1">Edit</a>
                  <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="flex-grow-1 m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger w-100">Delete</button>
                  </form>
                @endcan
              </div>
            </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="mt-5 d-flex justify-content-center">
    {{ $products->links() }}
  </div>
@endif
@endsection