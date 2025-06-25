<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Ecomm')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optionally Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
    <style>
      body {
        font-family: 'Inter', sans-serif;
      }
      h1,h2,h3,h4,h5,h6 {
        font-family: 'Playfair Display', serif;
      }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold fs-3" href="{{ route('dashboard') }}">Ecomm demo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="{{ route('dashboard') }}">Home</a>
        </li>
        
        @auth
        <li class="nav-item">
          @if(Auth::User()->is_admin == 1)
          <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.manage.index') }}">Products</a>
          @else
          <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="{{ route('products.cust.index') }}">Products</a>
          @endif
        </li> 
        <li class="nav-item">
          <a class="nav-link {{ request()->is('orders*') ? 'active' : '' }}" href="{{ route('orders.index') }}">Orders</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('cart*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
            Cart
            @php
              $cartCount = session('cart') ? array_sum(session('cart')) : 0;
            @endphp
            @if($cartCount > 0)
              <span class="badge bg-danger">{{ $cartCount }}</span>
            @endif
          </a>
        </li>
        @can('manage-cms')
        <li class="nav-item">
          <a class="nav-link {{ request()->is('cms*') ? 'active' : '' }}" href="{{ route('cms.index') }}">CMS</a>
        </li>
        @endcan
        @endauth
      </ul>

      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="btn btn-primary ms-2" href="{{ route('register') }}">Register</a></li>
        @else
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" 
               role="button" data-bs-toggle="dropdown" aria-expanded="false">
              {{ auth()->user()->name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
              <li><hr class="dropdown-divider" /></li>
              <li>
                <form method="POST" action="{{ route('logout') }}" class="px-3">
                  @csrf
                  <button type="submit" class="btn btn-link dropdown-item text-danger p-0">Logout</button>
                </form>
              </li>
            </ul>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>

<main class="flex-grow container py-5">
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  @yield('content')
</main>

<footer class="bg-white text-center py-4 border-top mt-auto text-muted" style="font-size: 0.9rem;">
  &copy; {{ date('Y') }} E-comm.
</footer>

<!-- Bootstrap JS, Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>