@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<h1 class="display-4 fw-bold mb-4">Shopping Cart</h1>

@if(session('success'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if(empty($cartItems))
  <p class="text-center text-muted fs-5 my-5">Your cart is empty.</p>
  <div class="text-center">
    <a href="{{ route('products.manage.index') }}" class="btn btn-primary btn-lg">Go Shopping</a>
  </div>
@else
  <form method="POST" action="{{ route('cart.checkout') }}">
    @csrf
    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center shadow-sm rounded mb-4">
        <thead class="table-light">
          <tr>
            <th class="text-start">Product</th>
            <th>Price</th>
            <th style="width: 110px;">Quantity</th>
            <th>Subtotal</th>
            <th style="width: 110px;">Action</th>
          </tr>
        </thead>
        <tbody>
          @php $total = 0; @endphp
          @foreach($cartItems as $item)
            @php $subtotal = $item['product']->price * $item['quantity']; $total += $subtotal; @endphp
            <tr>
              <td class="text-start fs-5 fw-semibold">{{ $item['product']->name }}</td>
              <td>${{ number_format($item['product']->price, 2) }}</td>
              <td>
                <div class="input-group input-group-sm">
                  <input type="number" name="quantity" form="form-update-{{ $item['product']->id }}" min="0" max="{{ $item['product']->inventory }}"
                         value="{{ $item['quantity'] }}" class="form-control text-center" />
                </div>
                <form id="form-update-{{ $item['product']->id }}" method="POST" action="{{ route('cart.update', $item['product']) }}"></form>
              </td>
              <td>${{ number_format($subtotal, 2) }}</td>
              <td>
                <form method="POST" action="{{ route('cart.remove', $item['product']) }}" onsubmit="return confirm('Remove this item from cart?');">
                  @csrf
                  <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr class="fw-bold">
            <td colspan="3" class="text-end fs-5">Total</td>
            <td colspan="2" class="fs-5">${{ number_format($total, 2) }}</td>
          </tr>
        </tfoot>
      </table>
    </div>

    <div class="d-flex justify-content-between">
      <a href="{{ route('products.manage.index') }}" class="btn btn-outline-primary btn-lg">Continue Shopping</a>
      <button type="submit" class="btn btn-primary btn-lg">Checkout</button>
    </div>
  </form>
@endif
@endsection