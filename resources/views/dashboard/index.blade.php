@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container my-5">
  <h1 class="display-4 fw-bold mb-5">Dashboard</h1>

  <div class="row g-4">

    <div class="col-6 col-md-3">
      <div class="card shadow-sm border-primary h-100">
        <div class="card-body text-center">
          <div class="mb-3 text-primary">
            <i class="bi bi-file-earmark-text-fill fs-1"></i>
          </div>
          <h5 class="card-title">Total Posts</h5>
          <p class="fs-4 fw-bold">{{ $totalPosts }}</p>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="card shadow-sm border-success h-100">
        <div class="card-body text-center">
          <div class="mb-3 text-success">
            <i class="bi bi-bag-check-fill fs-1"></i>
          </div>
          <h5 class="card-title">Total Orders</h5>
          <p class="fs-4 fw-bold">{{ $totalOrders }}</p>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="card shadow-sm border-info h-100">
        <div class="card-body text-center">
          <div class="mb-3 text-info">
            <i class="bi bi-box-seam fs-1"></i>
          </div>
          <h5 class="card-title">Total Products</h5>
          <p class="fs-4 fw-bold">{{ $totalProducts }}</p>
        </div>
      </div>
    </div>

    <div class="col-6 col-md-3">
      <div class="card shadow-sm border-warning h-100">
        <div class="card-body text-center">
          <div class="mb-3 text-warning">
            <i class="bi bi-people-fill fs-1"></i>
          </div>
          <h5 class="card-title">Total Users</h5>
          <p class="fs-4 fw-bold">{{ $totalUsers }}</p>
        </div>
      </div>
    </div>

  </div>



@push('scripts')
<script>
const ctx = document.getElementById('ordersChart').getContext('2d');
const chart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: @json($last7DaysLabels),
    datasets: [{
      label: 'Orders',
      data: @json($ordersLast7Days),
      backgroundColor: 'rgba(54, 162, 235, 0.7)',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: { beginAtZero: true }
    }
  }
});
</script>
@endpush
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
@endsection