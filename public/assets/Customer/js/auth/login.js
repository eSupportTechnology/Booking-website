// Language Modal Script
document.addEventListener("DOMContentLoaded", () => {
    const languageButton = document.getElementById("language-button");
    const languageModal = document.getElementById("language-modal");
    const closeBtn = languageModal?.querySelector(".close-btn");

    if (languageButton && languageModal && closeBtn) {
        languageButton.addEventListener("click", () => {
            languageModal.classList.remove("hidden");
        });

        closeBtn.addEventListener("click", () => {
            languageModal.classList.add("hidden");
        });

        window.addEventListener("click", (event) => {
            if (event.target === languageModal) {
                languageModal.classList.add("hidden");
            }
        });
    }
});

// Add loading state to Google auth button
    document.getElementById('google-auth-btn').addEventListener('click', function(e) {
        const btn = e.currentTarget;
        const originalText = btn.innerHTML;

        btn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span style="font-family: 'Noto Sans', sans-serif;">Connecting to Google...</span>
    `;

        btn.classList.add('pointer-events-none');

        // Reset after 10 seconds in case of issues
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('pointer-events-none');
        }, 10000);
    });

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (() => {
        'use strict'

        const forms = document.querySelectorAll('.needs-validation')

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                // Hide all feedback messages first
                form.querySelectorAll('.invalid-feedback').forEach(el => el.classList.add('hidden'))

                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()

                    // Show feedback messages
                    form.querySelectorAll(':invalid').forEach(input => {
                        const feedback = input.parentElement.querySelector(
                            '.invalid-feedback')
                        if (feedback) feedback.classList.remove('hidden')
                    })
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
