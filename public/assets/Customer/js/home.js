document.addEventListener("DOMContentLoaded", () => {
    // Scroll: Beach
    const scrollBeachContainer = document.getElementById("scrollBeach");
    const scrollLeftBeachBtn = document.getElementById("scrollLeftBeach");
    const scrollRightBeachBtn = document.getElementById("scrollRightBeach");

    if (scrollLeftBeachBtn && scrollRightBeachBtn && scrollBeachContainer) {
        scrollRightBeachBtn.addEventListener("click", () => {
            scrollBeachContainer.scrollBy({
                left: 300,
                behavior: "smooth",
            });
        });

        scrollLeftBeachBtn.addEventListener("click", () => {
            scrollBeachContainer.scrollBy({
                left: -300,
                behavior: "smooth",
            });
        });
    }

    // Scroll: General Container
    const scrollContainer = document.getElementById("scrollContainer");
    const scrollLeftBtn = document.getElementById("scrollLeft");
    const scrollRightBtn = document.getElementById("scrollRight");

    if (scrollLeftBtn && scrollRightBtn && scrollContainer) {
        scrollLeftBtn.addEventListener("click", () => {
            scrollContainer.scrollBy({
                left: -250,
                behavior: "smooth",
            });
        });

        scrollRightBtn.addEventListener("click", () => {
            scrollContainer.scrollBy({
                left: 250,
                behavior: "smooth",
            });
        });
    }

    // Tabs: Property Type
    function togglePtypeTab(tabName) {
        const tabButtons = document.querySelectorAll(".ptype-tab-button");
        const tabContents = document.querySelectorAll(
            "#ptype-tab-content > div"
        );

        tabButtons.forEach((btn) => {
            btn.classList.remove(
                "bg-blue-100",
                "text-black",
                "active-ptype-tab"
            );
        });

        tabContents.forEach((content) => {
            content.classList.add("hidden");
        });

        document
            .getElementById(`ptype-tab-${tabName}`)
            .classList.add("bg-blue-100", "text-black", "active-ptype-tab");
        document
            .getElementById(`ptype-content-${tabName}`)
            .classList.remove("hidden");
    }

    // Activate default tab
    togglePtypeTab("city");

    // Tabs: General Tabs
    window.toggleTab = function (tabName) {
        const panels = document.querySelectorAll("#tab-content > div");
        panels.forEach((panel) => panel.classList.add("hidden"));

        const selectedPanel = document.getElementById(`content-${tabName}`);
        if (selectedPanel) selectedPanel.classList.remove("hidden");

        const tabs = document.querySelectorAll(".tab-button");
        tabs.forEach((tab) => tab.classList.remove("active-tab"));

        const selectedTab = document.getElementById(`tab-${tabName}`);
        if (selectedTab) selectedTab.classList.add("active-tab");
    };

    // Make togglePtypeTab globally available too (if used inline)
    window.togglePtypeTab = togglePtypeTab;
});

document.addEventListener("DOMContentLoaded", () => {
    const scrollSections = document.querySelectorAll(".scroll-section");
    const scrollAmount = 648;

    scrollSections.forEach((section) => {
        const scrollContainer = section.querySelector(".scroll-container");
        const scrollLeftBtn = section.querySelector(".scroll-left");
        const scrollRightBtn = section.querySelector(".scroll-right");

        function toggleArrows() {
            const maxScrollLeft =
                scrollContainer.scrollWidth - scrollContainer.clientWidth;
            scrollLeftBtn.classList.toggle(
                "hidden",
                scrollContainer.scrollLeft <= 0
            );
            scrollRightBtn.classList.toggle(
                "hidden",
                scrollContainer.scrollLeft >= maxScrollLeft - 10
            );
        }

        scrollLeftBtn.addEventListener("click", () => {
            scrollContainer.scrollBy({
                left: -scrollAmount,
                behavior: "smooth",
            });
            setTimeout(toggleArrows, 400);
        });

        scrollRightBtn.addEventListener("click", () => {
            scrollContainer.scrollBy({
                left: scrollAmount,
                behavior: "smooth",
            });
            setTimeout(toggleArrows, 400);
        });

        scrollContainer.addEventListener("scroll", toggleArrows);

        // Initial visibility check
        toggleArrows();
    });
});
