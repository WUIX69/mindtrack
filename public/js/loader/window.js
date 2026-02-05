function hidePreloader() {
    var preloader = $(".window-spinner");
    var overlay = $(".window-spinner-overlay");
    var preloaderFadeOutTime = 500;

    // Show both spinner and overlay
    preloader.show();
    overlay.show();

    setTimeout(function () {
        preloader.fadeOut(preloaderFadeOutTime);
        overlay.fadeOut(preloaderFadeOutTime);
    }, 500);
}

$(window).on("load", function () {
    hidePreloader();
    // console.clear();
});
