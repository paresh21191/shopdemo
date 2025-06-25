@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="container my-5">
  <h1 class="display-4 mb-4">Order #{{ $order->id }}</h1>

  <div class="mb-4">
    <strong>Status:</strong> 
    <span class="badge 
      @if($order->status === 'pending') bg-warning text-dark 
      @elseif($order->status === 'processing') bg-info text-white
      @elseif($order->status === 'completed') bg-success text-white
      @elseif($order->status === 'cancelled') bg-danger text-white
      @else bg-secondary text-white @endif">
      {{ ucfirst($order->status) }}
    </span>
  </div>

  <div class="mb-4">
    <strong>Placed on:</strong> {{ $order->created_at->format('F j, Y H:i') }}
  </div>

  <div class="table-responsive mb-5">
    <table class="table table-bordered align-middle">
      <thead class="table-light">
        <tr>
          <th>Product</th>
          <th class="text-end">Quantity</th>
          <th class="text-end">Price Each</th>
          <th class="text-end">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($order->items as $item)
          <tr>
            <td>{{ $item->product->name }}</td>
            <td class="text-end">{{ $item->quantity }}</td>
            <td class="text-end">${{ number_format($item->price_each, 2) }}</td>
            <td class="text-end">${{ number_format($item->price_each * $item->quantity, 2) }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th colspan="3" class="text-end">Total</th>
          <th class="text-end">${{ number_format($order->total_price, 2) }}</th>
        </tr>
      </tfoot>
    </table>
  </div>

  <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">Back to Orders</a>
</div>
@endsection