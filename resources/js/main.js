// Simple fade animation for page load
document.addEventListener("DOMContentLoaded", () => {
    document.body.style.opacity = 0;
    setTimeout(() => {
        document.body.style.transition = "opacity 0.6s";
        document.body.style.opacity = 1;
    }, 50);
});
