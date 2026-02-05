// Dark mode toggle variable only
const urlParams = new URLSearchParams(window.location.search);
const isDark = urlParams.get("dark") === "1" ?? false;
const $darkMode = $(".dark-mode-toggle");

function darkModeToggle() {
    $darkMode.on("click", function () {
        $("body").toggleClass("dark-mode-variables");
        $darkMode.find("span.light").toggleClass("active");
        $darkMode.find("span.dark").toggleClass("active");
        setTimeout(() => {
            $(".ui.dropdown .menu, .ui.flyout").toggleClass("inverted");
        }, 900); // Fix dropdown menu late affects

        // Dark mode save on each sidebar link URL
        $(".sidebar .nav .nav-link").each(function () {
            let href = $(this).attr("href");
            if (href === "#") return;
            if (href.includes("?dark")) {
                $(this).attr("href", href.replace("?dark=1", ""));
            } else {
                $(this).attr("href", href + "?dark=1");
            }
        });
    });
}

$(function () {
    darkModeToggle();
    if (isDark) $darkMode.find("span.dark").click();
});
