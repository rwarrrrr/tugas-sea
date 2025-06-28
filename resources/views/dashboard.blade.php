@extends('layouts.app')

@section('content')
{{-- Loop Active Subscriptions --}}
@php
    $subscriptions = [
        [
            'id' => 1,
            'plan' => 'Protein Plan',
            'meals' => ['Breakfast', 'Dinner'],
            'days' => ['Monday', 'Wednesday', 'Friday'],
            'price' => 1720000,
            'status' => 'active',
        ],
        [
            'id' => 2,
            'plan' => 'Diet Plan',
            'meals' => ['Lunch'],
            'days' => ['Tuesday', 'Thursday'],
            'price' => 860000,
            'status' => 'active',
        ]
    ];
@endphp

@foreach ($subscriptions as $sub)
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            {{ $sub['plan'] }} Subscription
        </div>
        <div class="card-body">
            <p><strong>Meal Types:</strong> {{ implode(', ', $sub['meals']) }}</p>
            <p><strong>Delivery Days:</strong> {{ implode(', ', $sub['days']) }}</p>
            <p><strong>Total Price:</strong> Rp{{ number_format($sub['price'], 0, ',', '.') }}</p>
            <p><strong>Status:</strong> <span class="badge bg-success text-uppercase">{{ $sub['status'] }}</span></p>

            {{-- Pause Subscription Form --}}
            <form class="pause-form mt-3" data-sub-id="{{ $sub['id'] }}">
                <div class="row g-2">
                    <div class="col">
                        <label class="form-label">Pause From</label>
                        <input type="date" class="form-control pause-start" required>
                    </div>
                    <div class="col">
                        <label class="form-label">Pause Until</label>
                        <input type="date" class="form-control pause-end" required>
                    </div>
                    <div class="col-auto align-self-end">
                        <button type="submit" class="btn btn-warning">Pause</button>
                    </div>
                </div>
                <small class="text-danger d-none mt-1 error-msg">Pause dates cannot be in the past.</small>
            </form>

            {{-- Cancel Button --}}
            <div class="mt-3">
                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirmCancelModal" data-sub-id="{{ $sub['id'] }}">
                    Cancel Subscription
                </button>
            </div>
        </div>
    </div>

    {{-- Modal Cancel --}}
<div class="modal fade" id="confirmCancelModal" tabindex="-1" aria-labelledby="confirmCancelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="#" id="cancelForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Cancellation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to cancel this subscription permanently?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes, Cancel It</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endforeach


@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const today = new Date().toISOString().split('T')[0];

    document.querySelectorAll('.pause-form').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const start = this.querySelector('.pause-start').value;
            const end = this.querySelector('.pause-end').value;
            const errorMsg = this.querySelector('.error-msg');

            if (start < today || end < today) {
                errorMsg.classList.remove('d-none');
                return;
            }

            if (start > end) {
                errorMsg.classList.remove('d-none');
                errorMsg.textContent = "End date must be after start date.";
                return;
            }

            errorMsg.classList.add('d-none');
            alert('Subscription will be paused from ' + start + ' to ' + end);
            // TODO: Send to backend
        });
    });

    // Inject subscription ID to cancel form
    const cancelModal = document.getElementById('confirmCancelModal');
    cancelModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const subId = button.getAttribute('data-sub-id');
        const form = this.querySelector('form#cancelForm');
        // Set action route dynamically if needed
        console.log('Cancel subscription ID:', subId);
    });
});
</script>
@endpush