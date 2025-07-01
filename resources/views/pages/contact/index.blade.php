@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4 fw-bold text-center">Contact Us</h2>

        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">SEA Catering</h5>
                        <p class="mb-1">We'd love to hear from you! Reach out to us for inquiries, feedback, or support.</p>

                        <hr>

                        <p><strong>{{ $contact['position'] }}:</strong> {{ $contact['name'] }}</p>
                        <p><strong>Phone Number:</strong> <a href="tel:{{ $contact['phone'] }}">{{ $contact['phone'] }}</a></p>
                        <p><strong>Email:</strong> <a href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a></p>
                        <p><strong>Office Hours:</strong> {{ $contact['open_hours'] }}</p>

                        <div class="mt-4">
                            <h6>Our Location</h6>
                            <div class="ratio ratio-16x9">
                                <iframe 
                                    src="{{ $contact['address'] }}"
                                    style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h6>Send us a message (coming soon)</h6>
                            <p class="text-muted">Form contact will be available in future updates.</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
