@extends('layouts.app')

<style>
    .modal.fade .modal-dialog {
        transform: scale(0.9);
        transition: transform 0.3s ease-out;
    }

    .modal.fade.show .modal-dialog {
        transform: scale(1);
    }

    .star {
        cursor: pointer;
        transition: transform 0.2s;
    }

    .star:hover {
        transform: scale(1.2);
    }
</style>


@section('content')
    <section class="text-center mb-5">
        <h2 class="fw-bold">Our Meal Plans</h2>
        <p class="text-muted">Choose the perfect plan that fits your healthy lifestyle</p>
    </section>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @php
            $mealPlans = [
                [
                    'id' => 1,
                    'name' => 'Basic Plan',
                    'price' => 'Rp 150.000 / week',
                    'desc' => 'Perfect for individuals who want to start eating healthy.',
                    'details' => 'Includes 7 meals/week. Balanced macros. Ideal for beginners.',
                    'image' => 'https://source.unsplash.com/400x250/?healthy,food'
                ],
                [
                    'id' => 2,
                    'name' => 'Family Plan',
                    'price' => 'Rp 500.000 / week',
                    'desc' => 'Healthy meals for the whole family.',
                    'details' => 'Includes 28 meals/week. Family-sized portions with balanced nutrients.',
                    'image' => 'https://source.unsplash.com/400x250/?family,meal'
                ],
                [
                    'id' => 3,
                    'name' => 'Keto Plan',
                    'price' => 'Rp 250.000 / week',
                    'desc' => 'Low-carb, high-fat meals to support your keto goals.',
                    'details' => 'Includes 14 keto meals/week with precise macronutrient breakdown.',
                    'image' => 'https://source.unsplash.com/400x250/?keto,diet'
                ],
            ];
        @endphp

        @foreach ($mealPlans as $plan)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="{{ $plan['image'] }}" class="card-img-top" alt="{{ $plan['name'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $plan['name'] }}</h5>
                        <p class="text-success fw-semibold">{{ $plan['price'] }}</p>
                        <p class="card-text">{{ $plan['desc'] }}</p>
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#planModal{{ $plan['id'] }}">
                            See More Details
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="planModal{{ $plan['id'] }}" tabindex="-1" aria-labelledby="planModalLabel{{ $plan['id'] }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="planModalLabel{{ $plan['id'] }}">{{ $plan['name'] }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="{{ $plan['image'] }}" alt="{{ $plan['name'] }}" class="img-fluid mb-3 rounded">
                            <p><strong>Price:</strong> {{ $plan['price'] }}</p>
                            <p>{{ $plan['details'] }}</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <a href="#" class="btn btn-primary">Subscribe Now</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <hr class="my-5">

    <section class="py-5 bg-light">
        <div class="container">
            <h3 class="text-center mb-4 fw-bold">What Our Customers Say</h3>

            <!-- Testimonial Carousel -->
            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <!-- Testimonial 1 -->
                    <div class="carousel-item active">
                        <div class="text-center">
                            <blockquote class="blockquote">
                                <p>"The food is amazing and I feel healthier already!"</p>
                            </blockquote>
                            <figcaption class="blockquote-footer">
                                Sarah <cite title="Source Title">⭐⭐⭐⭐⭐</cite>
                            </figcaption>
                        </div>
                    </div>
                    <!-- Testimonial 2 -->
                    <div class="carousel-item">
                        <div class="text-center">
                            <blockquote class="blockquote">
                                <p>"Great service and flexible delivery. Highly recommend!"</p>
                            </blockquote>
                            <figcaption class="blockquote-footer">
                                Andi <cite title="Source Title">⭐⭐⭐⭐</cite>
                            </figcaption>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>

            <!-- Add Testimonial Form -->
            <div class="mt-5">
                <h5 class="mb-3">Share your experience</h5>
                <form id="testimonialForm">
                    <div class="mb-3">
                        <label for="customerName" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="customerName" required>
                    </div>
                    <div class="mb-3">
                        <label for="reviewMessage" class="form-label">Your Review</label>
                        <textarea class="form-control" id="reviewMessage" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div id="starRating" class="d-flex gap-1">
                            <i class="bi bi-star fs-4 text-warning star" data-value="1" role="button"></i>
                            <i class="bi bi-star fs-4 text-warning star" data-value="2" role="button"></i>
                            <i class="bi bi-star fs-4 text-warning star" data-value="3" role="button"></i>
                            <i class="bi bi-star fs-4 text-warning star" data-value="4" role="button"></i>
                            <i class="bi bi-star fs-4 text-warning star" data-value="5" role="button"></i>
                        </div>
                        <input type="hidden" id="rating" required>
                    </div>


                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const stars = document.querySelectorAll('#starRating .star');
            const ratingInput = document.getElementById('rating');
            let selectedRating = 0;

            function highlightStars(tempRating) {
                stars.forEach(star => {
                    const starValue = parseInt(star.getAttribute('data-value'));
                    if (starValue <= tempRating) {
                        star.classList.remove('bi-star');
                        star.classList.add('bi-star-fill');
                    } else {
                        star.classList.remove('bi-star-fill');
                        star.classList.add('bi-star');
                    }
                });
            }

            stars.forEach(star => {
                star.addEventListener('mouseenter', function () {
                    const hoverValue = parseInt(this.getAttribute('data-value'));
                    highlightStars(hoverValue);
                });

                star.addEventListener('mouseleave', function () {
                    highlightStars(selectedRating);
                });

                star.addEventListener('click', function () {
                    selectedRating = parseInt(this.getAttribute('data-value'));
                    ratingInput.value = selectedRating;
                    highlightStars(selectedRating);
                });
            });
        });
    </script>
@endpush


