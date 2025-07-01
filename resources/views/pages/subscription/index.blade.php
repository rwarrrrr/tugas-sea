@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card" style="border-radius: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);padding: 20px;">
            <div class="card-body">
                <div class="text-center">
                    <h5 class="px-3 py-2 border btn-rounded bg-light d-inline-block">
                        <img src="{{ asset('images/love.png') }}" alt="SEA Catering Logo">
                        Personalized meals, delivered your way
                    </h5>
                    <h1 class="mb-4 fw-bold font-book text-center">Subscribe to Your Custom Meal Plan</h1>
                    <p class="lead w-70 ">Tell us what you need, and we’ll bring it to your door.</p>
                </div>

                <form id="subscriptionForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">*Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label">*Active Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required pattern="[0-9]{10,}">
                        </div>
                    </div>

                    <!-- Plan Selection -->
                    <div class="mb-3">
                        <label class="form-label">*Plan Selection</label>
                        <select class="form-select" id="plan" name="plan" required>
                            <option value="" disabled selected>Select a Plan</option>
                            <option value="30000">Diet Plan – Rp30.000 per meal</option>
                            <option value="40000">Protein Plan – Rp40.000 per meal</option>
                            <option value="60000">Royal Plan – Rp60.000 per meal</option>
                        </select>
                    </div>

                    <!-- Meal Type -->
                    <div class="mb-3">
                        <label class="form-label">*Meal Type (Choose at least 1)</label>
                        <div class="form-check">
                            <input class="form-check-input meal-type" name="meal_types[]" type="checkbox" value="breakfast" id="breakfast">
                            <label class="form-check-label" for="breakfast">Breakfast</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input meal-type" name="meal_types[]" type="checkbox" value="lunch" id="lunch">
                            <label class="form-check-label" for="lunch">Lunch</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input meal-type" name="meal_types[]" type="checkbox" value="dinner" id="dinner">
                            <label class="form-check-label" for="dinner">Dinner</label>
                        </div>
                    </div>

                    <!-- Delivery Days -->
                    <div class="mb-3">
                        <label class="form-label">*Delivery Days (Choose at least 1)</label>
                        <div class="row">
                            @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input delivery-day" name="delivery_days[]" type="checkbox" value="{{ strtolower($day) }}" id="{{ strtolower($day) }}">
                                        <label class="form-check-label" for="{{ strtolower($day) }}">{{ $day }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Allergies -->
                    <div class="mb-3">
                        <label for="allergies" class="form-label">Allergies / Dietary Restrictions</label>
                        <textarea class="form-control" id="allergies" rows="3" placeholder="List any allergies or restrictions..."></textarea>
                    </div>

                    <!-- Price Output -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Estimated Total Price:</label>
                        <p id="totalPrice" class="fs-4">Rp0</p>
                    </div>

                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const formatRupiah = (value) => {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(value);
        }

        function calculateTotal() {
            const planPrice = parseInt(document.getElementById('plan').value) || 0;
            const mealTypes = document.querySelectorAll('.meal-type:checked').length;
            const deliveryDays = document.querySelectorAll('.delivery-day:checked').length;
            const factor = 4.3;

            if (planPrice && mealTypes && deliveryDays) {
                const total = planPrice * mealTypes * deliveryDays * factor;
                document.getElementById('totalPrice').textContent = formatRupiah(total);
            } else {
                document.getElementById('totalPrice').textContent = 'Rp0';
            }
        }

        // Recalculate price on input changes
        document.querySelectorAll('#plan, .meal-type, .delivery-day').forEach(el => {
            el.addEventListener('change', calculateTotal);
        });

        $('#subscriptionForm').submit(function (e) {
            e.preventDefault();

            let mealSelected = $("input[name='meal_types[]']:checked").length;
            let daysSelected = $("input[name='delivery_days[]']:checked").length;
            let phone        = $("input[name='phone']").val();

            if (mealSelected === 0) {
                Swal.fire('Gagal', 'Pilih minimal satu jenis makan.', 'error');
                return;
            }

            if (daysSelected === 0) {
                Swal.fire('Gagal', 'Pilih minimal satu hari pengantaran.', 'error');
                return;
            }

            const phoneRegex = /^(08|\+628)[0-9]{8,13}$/;
            if (!phoneRegex.test(phone)) {
                Swal.fire('Gagal', 'Format nomor HP tidak valid.', 'error');
                return;
            }

            $.ajax({
                url: "{{ route('subscription.store') }}",
                method: 'POST',
                data: $(this).serialize(),
                success: res => {
                    Swal.fire('Sukses', res.message, 'success').then(() => location.reload());
                },
                error: err => {
                    Swal.fire('Gagal', 'Periksa kembali isian Anda.', 'error');
                }
            });
        });

    </script>
@endpush
