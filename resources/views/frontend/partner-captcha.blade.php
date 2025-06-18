<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CAPTCHA Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Store selected images (can connect to backend later)
        function toggleSelection(button, value) {
            const input = document.getElementById('input-' + value);
            if (button.classList.contains('ring-4')) {
                button.classList.remove('ring-4', 'ring-orange-500');
                input.disabled = true;
            } else {
                button.classList.add('ring-4', 'ring-orange-500');
                input.disabled = false;
            }
        }
    </script>
</head>
<body class="bg-white text-gray-800">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-8">
        <div class="w-full max-w-3xl bg-white shadow-md border rounded-lg p-6 space-y-4">
            <!-- Header -->
            <div class="flex items-center justify-between border-b pb-4">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/7e/Booking.com_logo.svg" class="h-6" alt="Booking.com" />
                <img src="https://flagcdn.com/gb.svg" class="h-5 w-8" alt="UK Flag" />
            </div>

            <!-- Title -->
            <div>
                <h2 class="text-xl font-semibold">Let's make sure you're human</h2>
                <p>Choose all the <span class="text-blue-600 underline cursor-pointer">chairs</span></p>
            </div>

            <!-- CAPTCHA Form -->
            <form action="/verify-captcha" method="POST">
                @csrf
                <!-- Image Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @php
                        $images = [
                            ['src' => 'https://via.placeholder.com/100x100?text=Bag1', 'name' => 'img1'],
                            ['src' => 'https://via.placeholder.com/100x100?text=Bag2', 'name' => 'img2'],
                            ['src' => 'https://via.placeholder.com/100x100?text=Hat', 'name' => 'img3'],
                            ['src' => 'https://via.placeholder.com/100x100?text=Chair1', 'name' => 'img4'],
                            ['src' => 'https://via.placeholder.com/100x100?text=Chair2', 'name' => 'img5'],
                            ['src' => 'https://via.placeholder.com/100x100?text=Bag3', 'name' => 'img6'],
                            ['src' => 'https://via.placeholder.com/100x100?text=Chair3', 'name' => 'img7'],
                            ['src' => 'https://via.placeholder.com/100x100?text=Chair4', 'name' => 'img8'],
                            ['src' => 'https://via.placeholder.com/100x100?text=Chair5', 'name' => 'img9'],
                        ];
                    @endphp

                    @foreach($images as $img)
                        <div class="relative">
                            <img
                                src="{{ $img['src'] }}"
                                alt="CAPTCHA image"
                                class="w-full rounded-lg cursor-pointer transition-all"
                                onclick="toggleSelection(this, '{{ $img['name'] }}')"
                            />
                            <input type="checkbox" name="selected[]" value="{{ $img['name'] }}" id="input-{{ $img['name'] }}" class="hidden" disabled>
                        </div>
                    @endforeach
                </div>

                <!-- Controls and Confirm -->
                <div class="mt-6 flex items-center justify-between">
                    <div class="text-gray-600 text-xl space-x-4">
                        <span class="cursor-pointer" title="Reload">&#x21bb;</span>
                        <span class="cursor-pointer" title="Audio">&#x1F50A;</span>
                    </div>

                    <select class="border border-gray-300 rounded p-1 text-sm">
                        <option>English</option>
                    </select>
                </div>

                <button
                    type="submit"
                    class="mt-4 w-full bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 rounded"
                >
                    Confirm
                </button>
            </form>

            <!-- Footer -->
            <p class="text-xs text-gray-500 text-center">
                By signing in or creating an account, you agree with our 
                <a href="#" class="underline">Terms & conditions</a> and 
                <a href="#" class="underline">Privacy statement</a>.
            </p>
        </div>
    </div>
</body>
</html>
