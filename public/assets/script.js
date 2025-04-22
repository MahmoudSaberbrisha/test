document.addEventListener("DOMContentLoaded", () => {
    const starsContainer = document.querySelector(".stars-container");
    if (!starsContainer) return;

    const starCount = 100; // Number of stars to generate
    const starSizes = ["small", "medium", "large"];

    for (let i = 0; i < starCount; i++) {
        const star = document.createElement("div");
        star.classList.add("star");

        // Randomly assign size class
        const sizeClass =
            starSizes[Math.floor(Math.random() * starSizes.length)];
        star.classList.add(sizeClass);

        // Random position within viewport
        star.style.top = Math.random() * 100 + "vh";
        star.style.left = Math.random() * 100 + "vw";

        // Random animation delay to stagger twinkle effect
        star.style.animationDelay = Math.random() * 5 + "s";

        starsContainer.appendChild(star);
    }

    // Sidebar submenu toggle with smooth slide and icon rotation
    const slideToggles = document.querySelectorAll('a[data-toggle="slide"]');
    slideToggles.forEach((toggle) => {
        toggle.addEventListener("click", (e) => {
            e.preventDefault();
            const parentLi = toggle.parentElement;
            const submenu = parentLi.querySelector(".slide-menu");
            if (!submenu) return;

            if (parentLi.classList.contains("is-expanded")) {
                // Collapse submenu
                submenu.style.maxHeight = null;
                parentLi.classList.remove("is-expanded");
            } else {
                // Expand submenu
                submenu.style.maxHeight = submenu.scrollHeight + "px";
                parentLi.classList.add("is-expanded");
            }
        });
    });

    // Initialize expanded submenus on page load
    document
        .querySelectorAll(".slide.is-expanded .slide-menu")
        .forEach((submenu) => {
            submenu.style.maxHeight = submenu.scrollHeight + "px";
        });
});
