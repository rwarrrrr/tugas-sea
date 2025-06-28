@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h3 class="mb-4">Register</h3>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input id="name" type="text"
                       class="form-control @error('name') is-invalid @enderror" name="name"
                       value="{{ old('name') }}" required autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror" name="email"
                       value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror" name="password" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input id="password_confirmation" type="password" class="form-control"
                       name="password_confirmation" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100">Register</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        function togglePassword(fieldId) {
            const input = document.getElementById(fieldId);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
@endpush