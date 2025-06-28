@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="text-center bg-dark text-white py-5" style="background: url('https://images.unsplash.com/photo-1604909052868-73c1a003e6fd?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80') no-repeat center center; background-size: cover;">
        <div class="container py-5">
            <h1 class="display-4 fw-bold">Healthy Meals, Anytime, Anywhere</h1>
            <p class="lead mt-3">Your trusted customizable healthy meal delivery service across Indonesia.</p>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5 text-center">
        <div class="container">
            <h2 class="mb-4">Welcome to SEA Catering</h2>
            <p class="lead">SEA Catering offers healthy, delicious, and customizable meals delivered directly to your door. Whether you're in Jakarta, Surabaya, or anywhere in Indonesia — we bring nutrition and convenience to your table.</p>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light text-center">
        <div class="container">
            <h3 class="mb-4">Our Services</h3>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-3 border rounded shadow-sm">
                        <i class="bi bi-gear-fill fs-1 text-success"></i>
                        <h5 class="mt-3">Meal Customization</h5>
                        <p>Choose meals based on your diet, preferences, and goals.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded shadow-sm">
                        <i class="bi bi-truck fs-1 text-success"></i>
                        <h5 class="mt-3">Nationwide Delivery</h5>
                        <p>Fast and fresh delivery to all major cities across Indonesia.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded shadow-sm">
                        <i class="bi bi-info-circle fs-1 text-success"></i>
                        <h5 class="mt-3">Nutritional Information</h5>
                        <p>Each meal includes detailed macros and nutrition facts.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5 text-center">
        <div class="container">
            <h4>Contact Us</h4>
            <p class="mb-1">Manager: <strong>Brian</strong></p>
            <p>Phone: <a href="tel:08123456789">08123456789</a></p>
        </div>
    </section>
@endsection
