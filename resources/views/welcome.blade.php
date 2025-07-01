@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="text-center py-5" id="hero" style="background: url('{{ asset('images/bg-hero.png') }}') no-repeat center center; background-size: cover;">
        <div class=" py-5">
            <h5 class="px-3 py-2 border btn-rounded bg-light d-inline-block">
                <img src="{{ asset('images/indo.png') }}" alt="SEA Catering Logo">
                Trusted delivery service across Indonesia
            </h5>
            <h1 class="display-4 fw-bold color-primary font-book">Healthy Meals, Anytime, Anywhere</h1>
            <p class="lead mt-3 w-50 mx-auto">Healthy, delicious, and customizable meals delivered directly to your door. Whether you're in Jakarta, Surabaya, or anywhere in Indonesia, we bring nutrition and convenience to your table.</p>            
            <a href="{{ route('subscription') }}" class="btn btn-rounded btn-primary btn-lg mt-4 fw-bold px-5 py-2 shadow">Subscribe Now</a>
        </div>
        
        <div class="container mt-5 ">
            <div class="card shadow-sm" id="hero-card">
                <div class="card-body">
                    <h5 class="px-3 py-2 border btn-rounded bg-light d-inline-block">
                        <img src="{{ asset('images/oke.png') }}" alt="SEA Catering Logo">
                        Personalized. Fast. Nutritious
                    </h5>
                    <h1 class="display-4 fw-bold color-primary font-book">Here’s Our Services</h1>
                    <p class="lead mt-3 w-70 mx-auto">Custom Meals, Fast Delivery, and Smart Meal Solutions for a Healthier You.</p>  
                    
                    
                    <div class="row g-4 mt-4 mx-3">
                        <div class="col-md-4">
                            <div class="p-3 border rounded-15 shadow-sm bg-light">
                                <img src="{{ asset('images/meal.png') }}" alt="SEA Catering Logo" style="width: 100px; height: 100px;">
                                <h5 class="mt-3 fw-bold">Meal Customization</h5>
                                <p>Choose meals based on your diet, preferences, and goals.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded-15 shadow-sm bg-light">
                                <img src="{{ asset('images/nation.png') }}" alt="SEA Catering Logo" style="width: 100px; height: 100px;">
                                <h5 class="mt-3 fw-bold">Nationwide Delivery</h5>
                                <p>Fast and fresh delivery to all major cities across Indonesia.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded-15 shadow-sm bg-light">
                                <img src="{{ asset('images/nutri.png') }}" alt="SEA Catering Logo" style="width: 100px; height: 100px;">
                                <h5 class="mt-3 fw-bold">Nutritional Information</h5>
                                <p>Each meal includes detailed macros and nutrition facts.</p>
                            </div>
                        </div>
                    </div>

                    <a href="tel:08123456789" class="btn btn-rounded btn-primary btn-lg mt-4 fw-bold px-5 py-2 shadow"><i class="bi bi-telephone-fill" style="margin-right: 10px;"></i> +62 812-3456-789</a>
                    <p class="mt-3">Call Us Now | Manager: <strong>Brian</strong></p>
                </div> 
            </div>
        </div>
    </div>
@endsection
