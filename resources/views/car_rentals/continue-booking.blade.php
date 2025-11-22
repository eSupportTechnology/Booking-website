@extends('frontend.master')

@section('content')
@php
    use Carbon\Carbon;

    $pickup = request('pickup_location');
    $destination = request('dropoff_location');
    $checkin = request('pickup_datetime');
    $checkout = request('dropoff_datetime');

    function fmtShort($dt) {
        return $dt ? Carbon::parse($dt)->format('D, d M Y • h:i A') : null;
    }

    $pickupFormatted = $checkin ? Carbon::parse($checkin)->format('Y-m-d\TH:i') : null;
    $dropoffFormatted = $checkout ? Carbon::parse($checkout)->format('Y-m-d\TH:i') : null;

    $pricePerDay = $car->price_per_day ?? 0;

    $days = 1;
    try {
        if ($checkin && $checkout) {
            $s = Carbon::parse($checkin);
            $e = Carbon::parse($checkout);
            $d = $s->diffInDays($e);
            $days = $d > 0 ? $d : 1;
        }
    } catch (\Throwable $e) {
        $days = 1;
    }

$subTotal = $pricePerDay * $days;


@endphp

<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- LEFT: Car gallery + short info -->
        <div class="lg:col-span-2 space-y-6">
            <a href="{{ route('customer.carsearch') }}" class="text-blue-600 inline-block mb-2">← Back to results</a>

            <div class="bg-white rounded-xl shadow border p-4">
                <div class="flex gap-4">
                    <img src="{{ $car->car_front ? asset('storage/' . $car->car_front) : 'https://placehold.co/600x400' }}"
                         alt="Car"
                         class="w-1/3 object-cover rounded-md">

                    <div class="flex-1">
                        <h1 class="text-2xl font-bold">{{ $car->brand->brand_name ?? '' }} {{ $car->model->model_name ?? '' }}</h1>
                        <p class="text-sm text-gray-600 mt-1">{{ $car->carType->name ?? '' }}</p>

                        <div class="mt-4 grid grid-cols-3 gap-3 text-sm text-gray-700">
                            <div class="bg-gray-50 p-3 rounded border">
                                <div class="text-xs text-gray-500">Seats</div>
                                <div class="font-semibold">{{ $car->seats ?? '—' }}</div>
                            </div>
                            <div class="bg-gray-50 p-3 rounded border">
                                <div class="text-xs text-gray-500">Transmission</div>
                                <div class="font-semibold">{{ ucfirst($car->transmission ?? '—') }}</div>
                            </div>
                            <div class="bg-gray-50 p-3 rounded border">
                                <div class="text-xs text-gray-500">Fuel</div>
                                <div class="font-semibold">{{ ucfirst($car->fuel_type ?? '—') }}</div>
                            </div>
                        </div>

                        <p class="text-sm mt-4 text-gray-700">Pickup city: <strong>{{ $car->nearest_city ?? '—' }}</strong></p>
                    </div>
                </div>
            </div>

            <!-- Important notes & included -->
            <div class="bg-white p-6 rounded-xl shadow border">
                <h2 class="text-lg font-bold mb-3">Included & Important info</h2>

                <ul class="space-y-2 text-sm text-gray-700">
                    <li>- {{ $car->mileage_type === 'unlimited' ? 'Unlimited mileage' : 'Limited mileage' }}</li>
                    <li>- {{ $car->pricing_type === 'perKm' ? 'Pricing per km' : 'Pricing per day' }}</li>
                    <li>- Driver included: <strong>{{ $car->with_driver === 'yes' ? 'Yes' : 'No' }}</strong></li>
                </ul>
            </div>
        </div>

        <!-- RIGHT: Booking widget -->
        <aside class="space-y-6">

            <div class="bg-white p-6 rounded-xl shadow border">
                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-sm text-gray-500">Price per day</div>
                        <div class="text-2xl font-bold">US$ {{ number_format($pricePerDay, 2) }}</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Rating</div>
                        <div class="inline-flex items-center bg-green-600 text-white px-2 py-1 rounded font-bold">
                            {{ $car->review_score ?? '—' }}
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('customer.car.book.store', $car->id) }}" class="mt-4">
                    @csrf

                    <!-- Pick-up location -->
                    <div class="mb-3">
                        <label class="text-sm font-semibold">Pickup location</label>
                        <input type="text" name="pickup_location" value="{{ $pickup }}" class="w-full mt-1 border rounded p-2 text-sm" required>
                        @error('pickup_location') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                    </div>

                    <!-- Drop-off toggle + location -->
                    <div class="mb-3">
                        <label class="flex items-center gap-2">
                            <input id="toggleDropoff" type="checkbox" class="rounded" />
                            <span class="text-sm">Drop car off at different location</span>
                        </label>

                        <input id="dropoffInput" type="text" name="dropoff_location"
                            value="{{ $destination ?: $pickup }}"
                            class="w-full mt-2 border rounded p-2 text-sm disabled:opacity-50"
                            placeholder="Drop-off location"
                            {{ $destination ? '' : 'disabled' }}>

                    </div>

                    <!-- Dates -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="text-sm font-semibold">Pickup Date & Time</label>
                            <input type="datetime-local" name="pickup_datetime" value="{{ $pickupFormatted }}" class="w-full mt-1 border rounded p-2 text-sm" required>
                            @error('pickup_datetime') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold">Dropoff Date & Time</label>
                            <input type="datetime-local" name="dropoff_datetime" value="{{ $dropoffFormatted }}" class="w-full mt-1 border rounded p-2 text-sm" required>
                            @error('dropoff_datetime') <div class="text-red-500 text-xs mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Price summary -->
                    <div class="mt-4 border-t pt-3 text-sm text-gray-700">
                        <div class="flex justify-between">
                            <span>{{ $days }} day(s)</span>
                            <span>US$ {{ number_format($subTotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between font-bold mt-2">
                            <span>Total</span>
                            <span>US$ {{ number_format($subTotal, 2) }}</span>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="mt-4 mb-4">
                        <label class="text-sm font-semibold">Payment Method</label>
                        <div class="mt-2 space-y-2">

                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="payment_method" value="card" class="h-4 w-4" required>
                                <span class="text-sm">Credit / Debit Card (Visa, MasterCard, Amex)</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="payment_method" value="paypal" class="h-4 w-4">
                                <span class="text-sm">PayPal</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="payment_method" value="stripe" class="h-4 w-4">
                                <span class="text-sm">Stripe</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="payment_method" value="bank" class="h-4 w-4">
                                <span class="text-sm">Bank Transfer</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="payment_method" value="driver" class="h-4 w-4">
                                <span class="text-sm font-semibold text-green-700">Pay to Driver (Cash at Pickup)</span>
                            </label>

                        </div>
                    </div>


                    <!-- Hidden extras (if you want to carry search context) -->
                    <input type="hidden" name="car_id" value="{{ $car->id }}">

                    <button type="submit" class="w-full mt-4 bg-blue-600 text-white p-3 rounded-lg font-semibold hover:bg-blue-700">
                        Confirm Booking
                    </button>
                </form>
            </div>

            <!-- Supplier short -->
            <div class="bg-white p-4 rounded-xl shadow border text-sm">
                <h4 class="font-semibold mb-2">Supplier</h4>
                <div>{{ $car->company->name ?? '—' }}</div>
                <div class="mt-2 text-xs text-gray-500">Pickup city: {{ $car->nearest_city ?? '—' }}</div>
            </div>

        </aside>

    </div>
</div>

<script>
    // Enable/disable dropoff input and keep space visible
    document.addEventListener('DOMContentLoaded', function () {
        const toggle = document.getElementById('toggleDropoff');
        const dropoffInput = document.getElementById('dropoffInput');

        // If there was a value in the field (server-side), ensure checkbox matches
       if (dropoffInput.value.trim() !== '') {
            toggle.checked = true;
            dropoffInput.disabled = false;
        } else {
            toggle.checked = false;
            dropoffInput.disabled = true;
            dropoffInput.classList.add('opacity-50');
        }

        toggle.addEventListener('change', function () {
            dropoffInput.disabled = !toggle.checked;
            dropoffInput.classList.toggle('opacity-50', !toggle.checked);
        });


        toggle.addEventListener('change', function () {
            if (toggle.checked) {
                dropoffInput.disabled = false;
                dropoffInput.focus();
            } else {
                // keep the input visible but disabled (so space remains)
                dropoffInput.disabled = true;
            }
        });
    });
</script>
@endsection
