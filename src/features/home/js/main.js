$(function () {
    let swiperThumbView = new Swiper(".swiper-thumb-view", {
        loop: true,
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
    });

    let swiperMainView = new Swiper(".swiper-main-view", {
        loop: true,
        spaceBetween: 10,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            dynamicBullets: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiperThumbView, // Use swiperThumbView as its thumbs
        },
    });
});
