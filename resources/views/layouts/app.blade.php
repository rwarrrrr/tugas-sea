<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SEA Catering') }}</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                <img src="{{ asset('images/logo-nav.png') }}" alt="SEA Catering Logo" class="d-inline-block align-text-top" style="width: 100%; height: 100%;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">                   
                    @auth
                        @includeIf(Auth::user()->role == 'admin' ? 'layouts.nav.admin-nav' : 'layouts.nav.nav') 
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active fw-bold' : '' }}" href="{{ url('/') }}">
                                Home
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('menu') ? 'active fw-bold' : '' }}" href="{{ route('menu') }}">
                                Menu
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('subscription') ? 'active fw-bold' : '' }}" href="{{ route('subscription') }}">
                                Subscription
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('contacts') ? 'active fw-bold' : '' }}" href="{{ route('contacts.dashboard') }}">
                                Contact Us
                            </a>
                        </li>

                        <li class="nav-item" style="border-left: 2px solid #ddd; padding-left: 10px;">
                            <a class="nav-link {{ request()->is('login') ? 'active fw-bold' : '' }}" href="{{ route('login') }}">Login</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('register') ? 'active fw-bold' : '' }}" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    @endauth

                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class=" my-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center text-muted py-3 border-top border-left border-right  bg-light w-75 mx-auto shadow-sm fixed-bottom" style="border-top-right-radius: 20px;border-top-left-radius: 20px;">
        &copy; {{ date('Y') }} SEA Catering. All rights reserved.
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')
</body>
</html>
