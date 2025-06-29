@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>Management Contact</h2>
        </div>
        <div class="card-body">
            <form id="contactForm">
                @csrf
                <input type="hidden" name="id" id="contact_id" value="{{ $contacts->id ?? '' }}">
                <div class="mb-2">
                    <label>Position</label>
                    <input type="text" name="position" class="form-control" value="{{ $contacts->position ?? '' }}" required>
                </div>
                <div class="mb-2">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $contacts->name ?? '' }}" required>
                </div>
                <div class="mb-2">
                    <label>Phone Number</label>
                    <input type="text" name="phone" class="form-control" value="{{ $contacts->phone ?? '' }}" required>
                </div>
                <div class="mb-2">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $contacts->email ?? '' }}" required>
                </div>
                <div class="mb-2">
                    <label>Open Hours</label>
                    <input type="text" name="open_hours" class="form-control" value="{{ $contacts->open_hours ?? '' }}" required>
                </div>
                <div class="mb-2">
                    <label>Link Embed Google Maps</label>
                    <input type="text" name="address" class="form-control" value="{{ $contacts->address ?? '' }}" placeholder="https://www.google.com/maps/embed?pb=..." />
                </div>
                <div class="mb-2">
                    @if($contacts->address)
                        <iframe src="{{ $contacts->address }}" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>           
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

    $('#contactForm').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('contacts.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: res => {
                $('#contactModal').modal('hide');
                Swal.fire({
                    title: 'Sukses',
                    text: res.message,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });

                
            },
            error: err => {
                Swal.fire('Gagal', 'Periksa kembali data yang diisi.', 'error');
            }
        });
    });


</script>
@endpush
