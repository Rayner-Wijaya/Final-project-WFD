<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin - Hotel Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    @stack('styles')
</head>
<body>
    <div class="container-fluid" postion='absolute'>
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block bg-dark sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ Request::is('admin/kamar*') ? 'active' : '' }}" href="{{ route('kamar.index') }}">
                                <i class="bi bi-door-closed me-2"></i> Kamar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ Request::is('admin/reservasi*') ? 'active' : '' }}" href="{{ route('reservasi.index') }}">
                                <i class="bi bi-calendar-check me-2"></i> Reservasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white {{ Request::is('admin/direct-order') ? 'active' : '' }}" href="{{ route('admin.direct-order') }}">
                                <i class="bi bi-cart-plus me-2"></i> Direct Order
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>