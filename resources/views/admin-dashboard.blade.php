@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Admin Dashboard</h2>

    {{-- Date Range Filter --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form id="filterForm" class="row g-3">
                <div class="col-md-4">
                    <label for="startDate" class="form-label">Start Date</label>
                    <input type="date" id="startDate" class="form-control" value="{{ date('Y-m-01') }}">
                </div>
                <div class="col-md-4">
                    <label for="endDate" class="form-label">End Date</label>
                    <input type="date" id="endDate" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Metrics Display --}}
    <div class="row g-4" id="metrics">
        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-start border-primary border-5">
                <div class="card-body">
                    <h6>New Subscriptions</h6>
                    <h4 id="newSubs">12</h4>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-start border-success border-5">
                <div class="card-body">
                    <h6>Monthly Recurring Revenue</h6>
                    <h4 id="mrr">Rp 4.860.000</h4>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-start border-warning border-5">
                <div class="card-body">
                    <h6>Reactivations</h6>
                    <h4 id="reactivations">3</h4>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-start border-danger border-5">
                <div class="card-body">
                    <h6>Active Subscriptions</h6>
                    <h4 id="growth">27</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('filterForm');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        if (startDate > endDate) {
            alert('Start date must be before end date');
            return;
        }

        // TODO: Replace with real fetch to backend
        console.log('Filter from:', startDate, 'to:', endDate);

        // Simulasi update data
        document.getElementById('newSubs').innerText = Math.floor(Math.random() * 20);
        document.getElementById('mrr').innerText = "Rp " + (Math.floor(Math.random() * 10) * 100000).toLocaleString();
        document.getElementById('reactivations').innerText = Math.floor(Math.random() * 5);
        document.getElementById('growth').innerText = 27 + Math.floor(Math.random() * 10);
    });
});
</script>
@endpush
