@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="row g-5 align-items-center">
  <div class="col-md-5">
    @if($product->image)
      <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm w-100" />
    @else
      <div class="bg-secondary text-white d-flex justify-content-center align-items-center rounded shadow-sm" style="height: 350px; font-weight: 800;">
        No Image Available
      </div>
    @endif
  </div>

  <div class="col-md-7">
    <h1 class="display-4 fw-bold">{{ $product->name }}</h1>
    <p class="fs-5 text-muted mb-4">{{ $product->description ?? 'No description available.' }}</p>
    <h3 class="text-primary fw-bold mb-3">${{ number_format($product->price, 2) }}</h3>
    <p class="fw-semibold fs-5 {{ $product->inventory > 0 ? 'text-success' : 'text-danger' }}">
      Inventory: {{ $product->inventory > 0 ? $product->inventory : 'Out of stock' }}
    </p>

    @if($product->inventory > 0)
      <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-4 d-flex gap-3 align-items-center flex-wrap">
        @csrf
        <div class="input-group" style="width: 130px;">
          <label for="qtyInput" class="input-group-text">Qty</label>
          <input type="number" id="qtyInput" name="quantity" class="form-control" value="1" min="1" max="{{ $product->inventory }}">
        </div>
        <button type="submit" class="btn btn-success btn-lg px-4">Add to Cart</button>
      </form>
    @else
      <button class="btn btn-secondary btn-lg mt-4" disabled>Out of Stock</button>
    @endif

    <div class="mt-4">
      <a href="{{ route('products.manage.index') }}" class="btn btn-outline-secondary">Back to Products</a>
    </div>
  </div>
</div>
@endsection