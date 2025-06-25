@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
  <h1 class="display-4 fw-bold">My Orders</h1>
  <a href="{{ route('orders.create') }}" class="btn btn-primary btn-lg">
    <i class="bi bi-cart-plus"></i> Place New Order
  </a>
</div>

@if($orders->isEmpty())
  <p class="text-muted text-center fs-5 mt-5">No orders placed yet.</p>
@else
  <div class="table-responsive">
    <table class="table table-hover shadow-sm rounded">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Date</th>
          <th>Status</th>
          <th class="text-end">Total</th>
          @can('manage-products')
          <th class="text-end">Actions</th>
          @endcan
        </tr>
      </thead>
      <tbody>
        @foreach ($orders as $order)
        <tr class="align-middle">
          <td>{{ $order->id }}</td>
          <td>{{ $order->created_at->format('F j, Y') }}</td>
          <td>
            <span class="badge 
              @if($order->status === 'pending') bg-warning text-dark 
              @elseif($order->status === 'processing') bg-info text-white
              @elseif($order->status === 'completed') bg-success text-white
              @elseif($order->status === 'cancelled') bg-danger text-white
              @else bg-secondary text-white @endif">
              {{ ucfirst($order->status) }}
            </span>
          </td>
          <td class="text-end">${{ number_format($order->total_price, 2) }}</td>
          @can('manage-products')
          <td class="text-end">
            
            <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm">View</a>
          </td>
          @endcan
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <nav class="d-flex justify-content-center mt-4">
    {{ $orders->links() }}
  </nav>
@endif
@endsection