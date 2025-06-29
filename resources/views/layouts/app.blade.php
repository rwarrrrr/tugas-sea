<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SEA Catering') }}</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ url('/') }}">SEA Catering</a>
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
                            <a class="nav-link {{ request()->is('menu') ? 'active fw-bold' : '' }}" href="{{ url('/menu') }}">
                                Menu
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('subscription') ? 'active fw-bold' : '' }}" href="{{ url('/subscription') }}">
                                Subscription
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('contact') ? 'active fw-bold' : '' }}" href="{{ url('/contact') }}">
                                Contact Us
                            </a>
                        </li>

                        <li class="nav-item">
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
    <main class="container my-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center text-muted py-3 border-top  bg-light">
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
