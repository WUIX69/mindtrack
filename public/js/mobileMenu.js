const $body = $("html body");
const $header = $("site-header");

$(function () {
    // Handle mobile menu
    const $mobileMenuBtn = $header.find(".mobile-menu-btn");
    const $navLinks = $header.find("nav .nav-links");
    $mobileMenuBtn.on("click", function () {
        $navLinks.toggleClass("active");
    });
});
