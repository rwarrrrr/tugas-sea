<!-- resources/views/admin/subscription/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Subscription Management</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <table id="subscriptionTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>User</th>
                        <th>Plan</th>
                        <th>Meals</th>
                        <th>Delivery Days</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="subscriptionDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Subscription Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="subscriptionDetail">
                    <!-- Populated via JS -->
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
function escapeHTML(str) {
    return $('<div>').text(str).html();
}
$(document).ready(function () {
    const table = $('#subscriptionTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('subscriptions.data') }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { 
                data: 'user', name: 'user' ,
                render: function (data) {
                    return escapeHTML(data);
                }
            },
            { 
                data: 'plan', name: 'plan' ,
                render: function (data) {
                    return escapeHTML(data);
                }
            },
            { data: 'meal_types', name: 'meal_types' },
            { data: 'delivery_days', name: 'delivery_days' },
            { data: 'total_price', name: 'total_price' },
            { data: 'status', name: 'status' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ]
    });

    // Cancel subscription (admin side)
    $(document).on('click', '.cancel-subscription', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("subscriptions.destroy", ":id") }}'.replace(':id', id),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        Swal.fire('Dihapus', res.message, 'success');
                        table.ajax.reload();
                    },
                    error: function () {
                        Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
                    }
                });
            }
        });
    });

    // Show detail modal
    $(document).on('click', '.show-detail', function () {
        const id = $(this).data('id');

        $.get('{{ route("subscriptions.detail", ":id") }}' .replace(':id', id) + '?_token={{ csrf_token() }}', function (res) {
            let html = `
                <li class="list-group-item"><strong>User:</strong> ${res.user}</li>
                <li class="list-group-item"><strong>Phone:</strong> ${res.phone}</li>
                <li class="list-group-item"><strong>Plan:</strong> ${res.plan}</li>
                <li class="list-group-item"><strong>Meal Types:</strong> ${res.meal_types}</li>
                <li class="list-group-item"><strong>Delivery Days:</strong> ${res.delivery_days}</li>
                <li class="list-group-item"><strong>Allergies:</strong> ${res.allergies ?? '-'}</li>
                <li class="list-group-item"><strong>Total Price:</strong> Rp ${parseInt(res.total_price).toLocaleString()}</li>
                <li class="list-group-item"><strong>Status:</strong> ${res.status}</li>
            `;
            $('#subscriptionDetail').html(html);
            $('#subscriptionDetailModal').modal('show');
        });
    });
});
</script>
@endpush
