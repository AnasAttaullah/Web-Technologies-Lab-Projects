<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Commerce Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/modern-style.css') }}">
</head>
<body>
    <div class="app-shell">
        <aside class="app-sidebar" id="appSidebar">
            <a class="sidebar-brand" href="{{ route('customers.index') }}">
                <span class="brand-icon"><i class="bi bi-grid-3x3-gap-fill"></i></span>
                <span class="brand-text">Atlas Commerce</span>
            </a>

            <nav class="sidebar-nav">
                <a class="sidebar-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                    <i class="bi bi-people-fill"></i>
                    <span>Customers</span>
                </a>
                <a class="sidebar-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>Products</span>
                </a>
                <a class="sidebar-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                    <i class="bi bi-cart-check-fill"></i>
                    <span>Orders</span>
                </a>
                <a class="sidebar-link {{ request()->routeIs('order-details.*') ? 'active' : '' }}" href="{{ route('order-details.index') }}">
                    <i class="bi bi-list-check"></i>
                    <span>Order Details</span>
                </a>
            </nav>

            <div class="sidebar-foot">
                <span>Minimal Admin Panel</span>
            </div>
        </aside>

        <main class="app-main">
            <header class="app-topbar">
                <button class="btn btn-secondary btn-sm d-lg-none" type="button" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="topbar-title">@yield('title', 'Dashboard')</div>
                <div class="topbar-chip">Live Workspace</div>
            </header>

            <section class="app-content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="content-wrapper">
                    @yield('content')
                </div>
            </section>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function () {
                document.body.classList.toggle('sidebar-open');
            });
        }
    </script>
</body>
</html>
