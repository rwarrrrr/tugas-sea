<!-- resources/views/admin/dashboard.blade.php -->
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
                    <h4 id="newSubs">-</h4>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-start border-success border-5">
                <div class="card-body">
                    <h6>Monthly Recurring Revenue</h6>
                    <h4 id="mrr">-</h4>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-start border-warning border-5">
                <div class="card-body">
                    <h6>Reactivations</h6>
                    <h4 id="reactivations">-</h4>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-start border-danger border-5">
                <div class="card-body">
                    <h6>Active Subscriptions</h6>
                    <h4 id="growth">-</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <!-- Card 1 -->
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <canvas id="subscriptionChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-body">
                    <canvas id="priceChart" width="400" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function () {
    const barCtx = document.getElementById('subscriptionChart').getContext('2d');
    const lineCtx = document.getElementById('priceChart').getContext('2d');

    const barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Jumlah Subscription',
                data: [],
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1000,
                easing: 'easeOutBounce'
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const lineChart = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Total Harga per Hari',
                data: [],
                borderColor: '#198754',
                backgroundColor: 'rgba(25,135,84,0.1)',
                fill: true,
                tension: 0.3,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            animation: {
                duration: 1200,
                easing: 'easeInOutQuart'
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    function fetchMetrics(start, end) {
        $.ajax({
            url: `{{ route('admin.dashboard.data') }}`,
            type: 'GET',
            data: { start, end },
            success: function (res) {
                $('#newSubs').text(res.new_subscriptions);
                $('#mrr').text('Rp ' + res.mrr.toLocaleString());
                $('#reactivations').text(res.reactivations);
                $('#growth').text(res.growth);

                // Bar Chart
                barChart.data.labels = res.chart.labels;
                barChart.data.datasets[0].data = res.chart.data;
                barChart.update();

                // Line Chart
                lineChart.data.labels = res.chart.labels;
                lineChart.data.datasets[0].data = res.chart.total_price;
                lineChart.update();
            }
        });
    }

    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        const start = $('#startDate').val();
        const end = $('#endDate').val();
        fetchMetrics(start, end);
    });

    // Initial load
    fetchMetrics($('#startDate').val(), $('#endDate').val());
});

</script>
@endpush
