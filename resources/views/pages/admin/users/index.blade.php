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
    <h2>Management Users</h2>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">+ Add User</button>
    <button class="btn btn-danger mb-3" id="bulk-delete">Delete Selection</button>

    <table class="table table-bordered" id="userTable">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="select-all">
                </th>
                <th>No</th> 
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

</div>

<!-- Modal Tambah -->
@include('pages.admin.users.create')

<!-- Modal Edit -->
@include('pages.admin.users.edit')


@endsection

@push('scripts')
    <script>
        function escapeHTML(str) {
            return $('<div>').text(str).html();
        }
        $(document).ready(function () {
            const table = $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("users.data") }}',
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
                    { 
                        data: 'name' ,
                        render: function (data) {
                            return escapeHTML(data);
                        }
                    },
                    { data: 'email' },
                    { data: 'role', render: function (data) {
                        return data === 'admin' ? '<span class="badge bg-primary">Admin</span>' : '<span class="badge bg-secondary">User</span>';
                    }},
                    { data: 'action', orderable: false, searchable: false }
                ],
                language: {
                    emptyTable: "No users available",
                }
            });

            $('#select-all').on('click', function () {
                let isChecked = $(this).is(':checked');
                $('.row-checkbox').prop('checked', isChecked);
            });

            $('#userTable').on('change', '.row-checkbox', function () {
                let total = $('.row-checkbox').length;
                let checked = $('.row-checkbox:checked').length;
                $('#select-all').prop('checked', total === checked);
            });

            $('#addUserForm').submit(function (e) {
                e.preventDefault();
                const form = this;
                const formData = new FormData(form);

                $.ajax({
                    url: '{{ route("users.store") }}',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function () {
                        $('#addUserModal').modal('hide');
                        $('#addUserForm')[0].reset();
                        $('#userTable').DataTable().ajax.reload(null, false);

                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: 'User berhasil ditambahkan.'
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

            $('#addUserForm input[name="name"]').on('input', function () {
                if ($(this).val().trim() === '') {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            $('#userTable').on('click', '.edit-btn', function () {
                let data = $(this).data();

                $('#edit_id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_email').val(data.email);

                $('#editUserModal').modal('show');
            });

            $('#editUserForm').on('submit', function (e) {
                e.preventDefault();
                const id = $('#edit_id').val();
                const formData = new FormData(this);

                $.ajax({
                    url: '{{ route("users.update", ":id") }}'.replace(':id', id), 
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function () {
                        $('#editUserModal').modal('hide');
                        $('#userTable').DataTable().ajax.reload(null, false);

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'User berhasil diperbarui.'
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

            $('#userTable').on('click', '.delete-btn', function () {
                const userId = $(this).data('id');

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
                            url: '{{ route("users.destroy", ":id") }}' .replace(':id', userId),
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function () {
                                $('#userTable').DataTable().ajax.reload(null, false);
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
                            url: '{{ route("users.bulkDelete") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                ids: ids
                            },
                            success: function () {
                                $('#userTable').DataTable().ajax.reload(null, false);
                                Swal.fire('Sukses', 'Data berhasil dihapus.', 'success');
                            }
                        });
                    }
                });
            });

            $('#userTable').on('click', '.reset-password', function () {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Reset password user ini?',
                    text: 'Password akan direset ke "Password123!"',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Ya, Reset!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `{{ route("users.reset-password", ":id") }}`.replace(':id', id),
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function (res) {
                                Swal.fire('Sukses', res.message, 'success');
                            },
                            error: function (xhr) {
                                let msg = xhr.status === 403
                                    ? xhr.responseJSON.message
                                    : 'Terjadi kesalahan saat reset password.';
                                Swal.fire('Gagal', msg, 'error');
                            }
                        });
                    }
                });
            });

        });
        
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