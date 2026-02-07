/**
 * Dark Mode Support for MindTrack
 *
 * Handles theme initialization and toggle functionality.
 * This script is designed to be included in the <head> to prevent FOUC.
 */
(function () {
    // 1. Theme Initialization
    // Check localStorage or system preference and apply the theme immediately
    const applyTheme = () => {
        const theme = localStorage.getItem("theme");
        if (
            theme === "dark" ||
            (!theme &&
                window.matchMedia("(prefers-color-scheme: dark)").matches)
        ) {
            document.documentElement.classList.add("dark");
        } else {
            document.documentElement.classList.remove("dark");
        }
    };

    // Run initialization immediately
    applyTheme();

    // 2. Theme Toggle Logic
    // Attach event listener once the DOM is ready
    document.addEventListener("DOMContentLoaded", () => {
        const themeToggle = document.getElementById("theme-toggle");
        if (themeToggle) {
            themeToggle.addEventListener("click", () => {
                const isDark =
                    document.documentElement.classList.toggle("dark");
                localStorage.setItem("theme", isDark ? "dark" : "light");
            });
        }
    });
})();
