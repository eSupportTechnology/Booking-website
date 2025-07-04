document
    .getElementById("profile-upload")
    .addEventListener("change", function () {
        const form = document.getElementById("auto-profile-upload");
        const formData = new FormData(form);

        fetch(form.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
            },
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                // Update preview if image URL is returned
                if (data.image_url) {
                    document.getElementById("profile-preview").src =
                        data.image_url;
                }

                // Optional: show success message
                console.log("Image uploaded successfully.");
            })
            .catch((error) => {
                console.error("Upload error:", error);
            });
    });

document.addEventListener("DOMContentLoaded", function () {
    const select = document.getElementById("country-select");
    const flagImg = document.getElementById("selected-flag");

    if (select && flagImg) {
        select.addEventListener("change", function () {
            const selectedOption = this.options[this.selectedIndex];
            const flagUrl = selectedOption.getAttribute("data-flag");
            flagImg.src = flagUrl;
        });
    }
});
