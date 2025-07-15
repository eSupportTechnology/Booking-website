
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })
        })()


        function handleInput(element, index) {
            const inputs = document.querySelectorAll('.code-input');
            const verifyBtn = document.getElementById('verify-btn');
            const fullOtpInput = document.getElementById('full-otp');

            // Only allow numeric input
            element.value = element.value.replace(/[^0-9]/g, '');

            // Move to next input if current is filled
            if (element.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }

            // Move to previous input on backspace
            if (element.value.length === 0 && index > 0) {
                inputs[index - 1].focus();
            }

            // Collect all input values
            let otp = '';
            inputs.forEach(input => {
                otp += input.value;
            });

            // Update hidden input
            fullOtpInput.value = otp;

            // Enable/disable verify button
            if (otp.length === 6) {
                verifyBtn.disabled = false;
                verifyBtn.classList.remove('bg-gray-300', 'cursor-not-allowed');
                verifyBtn.classList.add('bg-blue-500', 'hover:bg-blue-600');
                verifyBtn.style.backgroundColor = '#3CC0E9';
            } else {
                verifyBtn.disabled = true;
                verifyBtn.classList.add('bg-gray-300', 'cursor-not-allowed');
                verifyBtn.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                verifyBtn.style.backgroundColor = '';
            }
        }

        // Handle paste event
        document.addEventListener('paste', function(e) {
            const inputs = document.querySelectorAll('.code-input');
            const paste = (e.clipboardData || window.clipboardData).getData('text');

            if (paste.length === 6 && /^\d{6}$/.test(paste)) {
                e.preventDefault();
                for (let i = 0; i < 6; i++) {
                    inputs[i].value = paste[i];
                }
                handleInput(inputs[5], 5); // Trigger the handler for the last input
            }
        });

        // Handle backspace key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace') {
                const inputs = document.querySelectorAll('.code-input');
                const currentIndex = Array.from(inputs).indexOf(document.activeElement);

                if (currentIndex > -1 && inputs[currentIndex].value === '' && currentIndex > 0) {
                    inputs[currentIndex - 1].focus();
                }
            }
        });

        // Countdown timer
        // Replace the existing countdown and resend functionality with this updated version

        // Countdown timer
        let countdown = 60;
        const countdownElement = document.getElementById('countdown');

        function updateCountdown() {
            if (countdown > 0) {
                countdownElement.textContent = countdown + ' seconds';
                countdown--;
                setTimeout(updateCountdown, 1000);
            } else {
                countdownElement.innerHTML = `
            <button type="button" onclick="resendOtp()" class="text-blue-500 hover:underline focus:outline-none">
                {{ __('messages.Request new code') }}
            </button>
        `;
            }
        }

        function resendOtp() {
            // Disable the button to prevent multiple clicks
            const resendButton = document.querySelector('button[onclick="resendOtp()"]');
            resendButton.disabled = true;
            resendButton.textContent = 'Sending...';

            fetch("{{ route('customer.request.otp') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: "{{ session('customer_email') }}"
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success || data.message) {
                        // Reset countdown
                        countdown = 60;
                        updateCountdown();

                        // Show success message
                        showMessage('New OTP sent to your email', 'success');

                        // Clear existing OTP inputs
                        document.querySelectorAll('.code-input').forEach(input => {
                            input.value = '';
                        });
                        document.getElementById('full-otp').value = '';

                        // Focus on first input
                        document.querySelector('.code-input').focus();

                        // Reset verify button
                        const verifyBtn = document.getElementById('verify-btn');
                        verifyBtn.disabled = true;
                        verifyBtn.classList.add('bg-gray-300', 'cursor-not-allowed');
                        verifyBtn.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                        verifyBtn.style.backgroundColor = '';
                    } else {
                        showMessage('Failed to send OTP. Please try again.', 'error');
                        resendButton.disabled = false;
                        resendButton.textContent = 'Request new code';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showMessage('Network error. Please try again.', 'error');
                    resendButton.disabled = false;
                    resendButton.textContent = 'Request new code';
                });
        }

        function showMessage(message, type) {
            // Remove existing messages
            document.querySelectorAll('.flash-message').forEach(msg => msg.remove());

            // Create new message element
            const messageDiv = document.createElement('div');
            messageDiv.className =
                `flash-message px-4 py-3 rounded mb-4 ${type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'}`;
            messageDiv.textContent = message;

            // Insert message at the top of the form
            const form = document.getElementById('otp-form');
            form.insertBefore(messageDiv, form.firstChild);

            // Auto-remove message after 5 seconds
            setTimeout(() => {
                messageDiv.remove();
            }, 5000);
        }

        // Start countdown when page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateCountdown();
        });

        // Language modal logic
        const languageButton = document.getElementById("language-button");
        const languageModal = document.getElementById("language-modal");
        const closeBtn = languageModal ? languageModal.querySelector(".close-btn") : null;

        if (languageButton && languageModal && closeBtn) {
            // Open the language modal
            languageButton.addEventListener("click", () => {
                languageModal.classList.remove("hidden");
            });

            // Close language modal on close button click
            closeBtn.addEventListener("click", () => {
                languageModal.classList.add("hidden");
            });

            // Close language modal on clicking outside the modal content
            window.addEventListener("click", (event) => {
                if (event.target === languageModal) {
                    languageModal.classList.add("hidden");
                }
            });
        }
