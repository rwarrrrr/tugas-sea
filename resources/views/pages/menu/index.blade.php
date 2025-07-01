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

        @foreach ($plans as $plan)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <img src="{{ asset('storage/'.$plan['image']) }}" class="card-img-top" alt="{{ $plan['name'] }}" style="height: 200px; width: 200px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $plan['name'] }}</h5>
                        <p class="text-success fw-semibold">{{ $plan['price'] }}</p>
                        <p class="card-text">{{ $plan['highlight'] }}</p>
                        <button class="btn btn-outline-primary show-detail-btn"
                            data-id="{{ $plan['id'] }}"
                            data-name="{{ $plan['name'] }}"
                            data-price="{{ $plan['price'] }}"
                            data-image="{{ $plan['image'] }}"
                            data-description="{{ $plan['description'] }}">
                            See More Details
                        </button>

                    </div>
                </div>
            </div>

        @endforeach
    </div>

    <!-- Global Modal for Plan Detail + Subscription Form -->
    <div class="modal fade" id="planDetailModal" tabindex="-1" aria-labelledby="planModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="subscribeForm">
                    @csrf
                    <input type="hidden" name="plan_id" id="plan_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="planModalLabel">Plan Name</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img id="planModalImage" src="" alt="" class="img-fluid mb-3 rounded">
                        <p><strong>Price:</strong> <span id="planModalPrice"></span></p>
                        <p id="planModalDescription"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="submitSubscribe">Subscribe Now</button>
                    </div>
                </form>

            </div>
        </div>
    </div>



    <hr class="my-5">

    <section class="py-5 bg-light">
        <div class="container">
            <h3 class="text-center mb-4 fw-bold">What Our Customers Say</h3>

            <div class="mt-5">
                <h4 class="mb-3">Customer Testimonials</h4>
                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($testimonials as $key => $testimonial)
                            <div class="carousel-item @if($key == 0) active @endif">
                                <div class="text-center">
                                    <blockquote class="blockquote">
                                        <p>"{{ $testimonial->message }}"</p>
                                    </blockquote>
                                    <figcaption class="blockquote-footer">
                                        {{ $testimonial->customer_name }} <cite>({{ str_repeat('⭐', $testimonial->rating) }})</cite>
                                    </figcaption>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
            </div>


            <div class="mt-5">
                <h5 class="mb-3">Share your experience</h5>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('testimonials.store') }}" id="testimonialForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input type="text" name="customer_name" id="customerName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Review Message</label>
                        <textarea name="message" id="reviewMessage" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div id="starRating" class="d-flex gap-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star fs-4 text-warning star" data-value="{{ $i }}" role="button"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="rating" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Testimonial</button>
                </form>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.show-detail-btn').on('click', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');
                const price = $(this).data('price');
                const image = $(this).data('image');
                const description = $(this).data('description');

                $('#planModalLabel').text(name);
                $('#planModalPrice').text(price);
                $('#planModalImage').attr('src', image).attr('alt', name);
                $('#planModalDescription').text(description);
                $('#plan_id').val(id); // <-- SET plan_id untuk form

                $('#planDetailModal').modal('show');
            });
            
            $('#submitSubscribe').on('click', function () {
                $('#submitSubscribe').prop('disabled', true).text('Submitting...');

                let formData = {
                    _token: $('input[name="_token"]').val(),
                    plan_id: $('#plan_id').val(),
                };

                $.ajax({
                    url: "{{ route('menu.store') }}",
                    method: "POST",
                    data: formData,
                    success: function (response) {
                        $('#planDetailModal').modal('hide');
                        $('#submitSubscribe').prop('disabled', false).text('Subscribe Now');
                        Swal.fire({
                            icon: 'success',
                            title: 'Subscribed!',
                            text: response.message || 'Subscription successful.',
                            timer: 2000,
                            showConfirmButton: false,
                            willClose: () => {
                                location.href = "{{ route('dashboard') }}"; 
                            }
                        });
                    },
                    error: function (xhr) {
                        let errMsg = xhr.responseJSON?.message || 'Something went wrong.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: errMsg
                        });
                    }
                });
            });
        });

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


