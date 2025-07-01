@extends('layouts.app')

@section('content')
<div class="container">
    @if(count($subscriptions) > 0)
        @foreach ($subscriptions as $sub)
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    {{ $sub['plan'] }} Subscription
                </div>
                <div class="card-body">
                    <p><strong>Meal Types:</strong> {{ implode(', ', $sub['meal_types']) }}</p>
                    <p><strong>Delivery Days:</strong> {{ implode(', ', $sub['delivery_days']) }}</p>
                    <p><strong>Total Price:</strong> Rp{{ number_format($sub['total_price'], 0, ',', '.') }}</p>
                    <p><strong>Status:</strong> 
                    @if ($sub['status'] == 'active')
                        <span class="badge bg-success text-uppercase">{{ $sub['status'] }}</span></p>
                    @elseif ($sub['status'] == 'paused')
                        <span class="badge bg-warning text-uppercase">{{ $sub['status'] }}</span></p>            
                        <p><strong>Start Date:</strong> {{ $sub['pause_start'] }}</p>
                        <p><strong>End Date:</strong> {{ $sub['pause_end'] }}</p>
                    @else 
                        <span class="badge bg-danger text-uppercase">{{ $sub['status'] }}</span></p>
                    @endif
    
                    @if ($sub['status'] == 'paused')
                        <form class="resume-form" data-id="{{ $sub->id }}">
                            <div class="row mb-2">
                                <div class="col">
                                    <button type="submit" class="btn btn-sm btn-success">Resume</button>
                                </div>
                            </div>
                        </form>
                    @elseif ($sub['status'] == 'active')
                        <form class="pause-form" data-id="{{ $sub->id }}">
                            <div class="row mb-2">
                                <div class="col">
                                    <input type="date" class="form-control pause-start" required>
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control pause-end" required>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-sm btn-warning">Pause</button>
                                </div>
                            </div>
                            <div class="text-danger small error-msg d-none">Tanggal tidak valid.</div>
                        </form>
                    @else 
                    @endif
    
                    <div class="mt-3">
                        <button class="btn btn-sm btn-danger cancel-subscription" 
                                data-id="{{ $sub->id }}" >Cancel</button>
                    </div>
                </div>
            </div>
    
    
    
        @endforeach
    @else
        <div class="alert alert-info">
            Tidak ada langganan yang ditemukan.
        </div>
    @endif

</div>

<div class="modal fade" id="confirmCancelModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="POST" id="cancelForm">
      @csrf
      @method('DELETE')
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Konfirmasi Pembatalan</h5>
        </div>
        <div class="modal-body">
          Yakin ingin membatalkan langganan ini?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger">Batalkan</button>
        </div>
      </div>
    </form>
  </div>
</div>


@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $('.pause-form').on('submit', function (e) {
            e.preventDefault();

            const form = $(this);
            const id = form.data('id');
            const start = form.find('.pause-start').val();
            const end = form.find('.pause-end').val();
            const today = new Date().toISOString().split('T')[0];

            if (!start || !end || start < today || end < start) {
                Swal.fire('Error', 'Tanggal tidak valid!', 'error');
                return;
            }

            Swal.fire({
                title: 'Pause Langganan?',
                html: `Mulai: <strong>${start}</strong><br>Selesai: <strong>${end}</strong><br><br>Tidak akan ada pengiriman selama periode ini.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Pause',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#f0ad4e'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("subscription.pause", ":id") }}' .replace(':id', id),
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            pause_start: start,
                            pause_end: end,
                        },
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function (err) {
                            Swal.fire('Gagal', err.responseJSON.message || 'Terjadi kesalahan', 'error');
                        }
                    });
                }
            });
        });
        
        $('.resume-form').on('submit', function (e) {
            e.preventDefault();

            const form = $(this);
            const id = form.data('id');
            
            swal.fire({
                title: 'Resume Langganan?',
                text: 'Langganan akan dilanjutkan dan pengiriman akan kembali normal.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya, Resume',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#28a745'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("subscription.resume", ":id") }}'.replace(':id', id),
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function (res) {
                            Swal.fire('Berhasil', res.message, 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function (err) {
                            Swal.fire('Gagal', err.responseJSON.message || 'Terjadi kesalahan', 'error');
                        }
                    });
                }
            })
        });

        $('.cancel-subscription').on('click', function () {
            const id = $(this).data('id');

            Swal.fire({
                title: 'Yakin ingin membatalkan langganan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("subscription.cancel", ":id") }}'.replace(':id', id),
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'POST'
                        },
                        success: function (res) {
                            Swal.fire('Dibatalkan', res.message, 'success').then(() => {
                                location.reload();
                            });
                        },
                        error: function () {
                            Swal.fire('Gagal', 'Tidak bisa membatalkan langganan.', 'error');
                        }
                    });
                }
            });
        });
    });

</script>
@endpush