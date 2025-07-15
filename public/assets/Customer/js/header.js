document.addEventListener("DOMContentLoaded", () => {
    // Currency modal logic
    const currentCurrency = document.getElementById("current-currency");
    const currencyModal = document.getElementById("currency-modal");
    const currencyCloseBtn = document.getElementById("currency-close-btn");

    if (currentCurrency && currencyModal && currencyCloseBtn) {
        // Open currency modal on clicking the currency span
        currentCurrency.addEventListener("click", () => {
            currencyModal.classList.remove("hidden");
        });

        // Close currency modal on close button click
        currencyCloseBtn.addEventListener("click", () => {
            currencyModal.classList.add("hidden");
        });

        // Close currency modal on clicking outside the modal content
        window.addEventListener("click", (e) => {
            if (e.target === currencyModal) {
                currencyModal.classList.add("hidden");
            }
        });

        // Change currency when a currency button is clicked
        currencyModal
            .querySelectorAll("button[data-currency]")
            .forEach((btn) => {
                btn.addEventListener("click", () => {
                    const selectedCurrency = btn.getAttribute("data-currency");
                    currentCurrency.textContent = selectedCurrency;
                    currencyModal.classList.add("hidden");
                });
            });
    }

    // Language modal logic
    const languageButton = document.getElementById("language-button");
    const languageModal = document.getElementById("language-modal");
    const closeBtn = languageModal
        ? languageModal.querySelector(".close-btn")
        : null;

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
});
