@extends('layouts.app')

@push('styles')
<style>
    .row-checkbox {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .row-checkbox:checked {
        transform: scale(1.2);
        box-shadow: 0 0 0 2px #0d6efd44;
    }
</style>
@endpush

@section('content')
<div class="container">
    <h2>Our Plans</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPlanModal">+ Add Plan</button>
    <button class="btn btn-danger mb-3" id="bulk-delete">Delete Selection</button>
    <button class="btn btn-success mb-3" id="bulk-activate">Activate</button>
    <button class="btn btn-secondary mb-3" id="bulk-deactivate">Non-Active</button>
    <button class="btn btn-outline-success mb-3" id="bulk-export-excel">Export Excel</button>
    <button class="btn btn-outline-danger mb-3" id="bulk-export-pdf">Export PDF</button>

    <table class="table table-bordered" id="planTable">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="select-all">
                </th>
                <th>No</th> 
                <th>Name</th>
                <th>Price (Rp)</th>
                <th>Highlight</th>
                <th>Duration</th>
                <th>Description</th>
                <th>Image</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

</div>

<!-- Modal Tambah -->
@include('pages.admin.plans.create')

<!-- Modal Edit -->
@include('pages.admin.plans.edit')


@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            const table = $('#planTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("plans.data") }}',
                columns: [
                    {
                        data: 'id',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return `<input type="checkbox" class="row-checkbox" value="${data}">`;
                        }
                    },
                    {
                        data: null,
                        name: 'no',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'name' },
                    { data: 'price', render: $.fn.dataTable.render.number(',', '.', 0, 'Rp') },
                    { data: 'highlight' },
                    { data: 'duration' },
                    { data: 'description' },
                    { data: 'image', orderable: false, searchable: false },
                    { data: 'is_active', render: function (data) {
                        return data ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
                    }},
                    { data: 'action', orderable: false, searchable: false }
                ],
                language: {
                    emptyTable: "No plans available",
                }
            });

            $('#select-all').on('click', function () {
                let isChecked = $(this).is(':checked');
                $('.row-checkbox').prop('checked', isChecked);
            });

            $('#planTable').on('change', '.row-checkbox', function () {
                let total = $('.row-checkbox').length;
                let checked = $('.row-checkbox:checked').length;
                $('#select-all').prop('checked', total === checked);
            });

            $('#addPlanForm').submit(function (e) {
                e.preventDefault();
                const form = this;
                const formData = new FormData(form);

                $.ajax({
                    url: '{{ route("plans.store") }}',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function () {
                        $('#addPlanModal').modal('hide');
                        $('#addPlanForm')[0].reset();
                        $('#planTable').DataTable().ajax.reload(null, false);

                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: 'Plan berhasil ditambahkan.'
                        });
                    },
                    error: function (xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            for (const key in errors) {
                                Swal.fire('Validasi Gagal', errors[key][0], 'error');
                                break;
                            }
                        } else {
                            Swal.fire('Error', 'Terjadi kesalahan server.', 'error');
                        }
                    }
                });
            });

            $('#addPlanForm input[name="price"]').on('input', function () {
                if (this.value < 10000) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            $('#addPlanForm input[name="name"]').on('input', function () {
                if ($(this).val().trim() === '') {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            $('#addPlanForm textarea[name="description"]').on('input', function () {
                if ($(this).val().trim() === '') {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            
            $('#planTable').on('click', '.edit-btn', function () {
                let data = $(this).data();

                $('#edit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_price').val(data.price);
                $('#edit_highlight').val(data.highlight);
                $('#edit_duration').val(data.duration);
                $('#edit_description').val(data.description);
                $('#editPlanForm').find('select[name="is_active"]').val(data.is_active ? 1 : 0);

                if (data.image) {
                    $('#edit_preview').attr('src', '/storage/' + data.image).show();
                } else {
                    $('#edit_preview').hide();
                }

                $('#editPlanModal').modal('show');
            });

            $('#edit_image').on('change', function () {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#edit_preview').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(this.files[0]);
            });

            $('#editPlanForm').on('submit', function (e) {
                e.preventDefault();
                const id = $('#edit_id').val();
                const formData = new FormData(this);

                $.ajax({
                    url: '{{ route("plans.update", ":id") }}'.replace(':id', id), 
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function () {
                        $('#editPlanModal').modal('hide');
                        $('#planTable').DataTable().ajax.reload(null, false);

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Plan berhasil diperbarui.'
                        });
                    },

                    error: function (xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            for (const key in errors) {
                                Swal.fire('Validasi Gagal', errors[key][0], 'error');
                                break;
                            }
                        } else {
                            Swal.fire('Error', 'Terjadi kesalahan server.', 'error');
                        }
                    }
                });
            });

            $('#planTable').on('click', '.delete-btn', function () {
                const planId = $(this).data('id');

                Swal.fire({
                    title: 'Yakin hapus?',
                    text: "Data ini tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("plans.destroy", ":id") }}' .replace(':id', planId),
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function () {
                                $('#planTable').DataTable().ajax.reload(null, false);
                                Swal.fire('Terhapus!', 'Data berhasil dihapus.', 'success');
                            },
                            error: function () {
                                Swal.fire('Gagal', 'Data tidak bisa dihapus.', 'error');
                            }
                        });
                    }
                });
            });

            $('#bulk-delete').on('click', function () {
                let ids = $('.row-checkbox:checked').map(function () {
                    return $(this).val();
                }).get();

                if (ids.length === 0) {
                    Swal.fire('Peringatan', 'Pilih minimal satu data.', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Yakin hapus data terpilih?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    confirmButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("plans.bulkDelete") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: ids
                            },
                            success: function () {
                                $('#planTable').DataTable().ajax.reload(null, false);
                                Swal.fire('Sukses', 'Data berhasil dihapus.', 'success');
                            }
                        });
                    }
                });
            });

            $('#bulk-activate').on('click', function () {
                bulkUpdateStatus('1');
            });

            $('#bulk-deactivate').on('click', function () {
                bulkUpdateStatus('0');
            });

            $('#bulk-export-excel').on('click', function () {
                let ids = $('.row-checkbox:checked').map(function () {
                    return $(this).val();
                }).get();

                if (ids.length === 0) {
                    Swal.fire('Peringatan', 'Pilih minimal satu plan untuk diekspor.', 'warning');
                    return;
                }

                let query = $.param({ ids: ids });
                window.location.href = '{{ route("plans.exportExcel") }}?' + query;
            });

            $('#bulk-export-pdf').on('click', function () {
                let ids = $('.row-checkbox:checked').map(function () {
                    return $(this).val();
                }).get();

                if (ids.length === 0) {
                    Swal.fire('Peringatan', 'Pilih minimal satu plan untuk diekspor.', 'warning');
                    return;
                }

                let query = $.param({ ids: ids });
                window.open('{{ route("plans.exportPdf") }}?' + query, '_blank');
            });

        });

        function bulkUpdateStatus(status) {
            let ids = $('.row-checkbox:checked').map(function () {
                return $(this).val();
            }).get();

            if (ids.length === 0) {
                Swal.fire('Peringatan', 'Pilih minimal satu plan.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Yakin ubah status plan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjut!',
                confirmButtonColor: '#198754'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("plans.bulkStatus") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ids: ids,
                            status: status
                        },
                        success: function () {
                            $('#planTable').DataTable().ajax.reload(null, false);
                            Swal.fire('Berhasil', 'Status berhasil diperbarui.', 'success');
                        }
                    });
                }
            });
        }
    </script>
@endpush