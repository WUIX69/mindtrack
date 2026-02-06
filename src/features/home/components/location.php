<style>
    /*----------- MAIN (Locations) -----------*/
    main section.locations-section {
        background: var(--color-background);
    }

    main section.locations-section .location-container {
        position: relative;
    }

    main section.locations-section .location-map-cont .header,
    main section.locations-section .location-gallery-cont .header {
        display: flex;
        justify-content: start;
        align-items: center;
        gap: 0.2rem;
    }

    main section.locations-section .location-map-cont .header span,
    main section.locations-section .location-gallery-cont .header span {
        position: relative;
        font-size: 3rem;
        /* top: -0.2rem; */
        animation: upDown 1.5s infinite;
    }

    main section.locations-section .location-map-cont .header .title,
    main section.locations-section .location-gallery-cont .header .title {
        font-size: 1.5rem;
        font-weight: 800;
    }

    /*----------- MAIN (Locations)[Map] -----------*/
    main section.locations-section .location-map-cont .header span {
        color: #ea4335;
    }

    main section.locations-section .location-map-cont .google-map {
        position: relative;
        margin-top: 1rem;
        width: 100%;
        height: 100%;
    }

    main section.locations-section .location-map-cont .google-map iframe {
        width: 100%;
        height: 71vh;
        border: 0;
        border-radius: 0.8rem !important;
        box-shadow: var(--box-shadow);
    }

    /*----------- MAIN (Locations)[Gallery] -----------*/
    main section.locations-section .location-gallery-cont {
        position: relative;
    }

    main section.locations-section .location-gallery-cont .header {
        gap: 1rem;
        align-items: center;
    }

    main section.locations-section .location-gallery-cont .header span {
        color: #5985e1;
    }

    main section.locations-section .location-gallery-cont .swiper-clinic-gallery {
        position: relative;
        margin-top: 1rem;
    }

    /*----------- MAIN (Locations)[Gallery] Main View -----------*/
    main section.locations-section .swiper-clinic-gallery .swiper-main-view {
        width: 100%;
        height: 400px;
        margin-left: auto;
        margin-right: auto;
        --swiper-navigation-color: var(--color-white);
        --swiper-pagination-color: var(--color-white);
    }

    main section.locations-section .swiper-clinic-gallery .swiper-main-view .swiper-slide {
        background-size: cover;
        background-position: center;

        border-radius: 0.8rem !important;
        overflow: hidden;
    }

    main section.locations-section .swiper-clinic-gallery .swiper-main-view .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    /*----------- MAIN (Locations)[Gallery] Thumb View -----------*/
    main section.locations-section .swiper-clinic-gallery .swiper-thumb-view {
        width: 100%;
        height: 20%;
        box-sizing: border-box;
        padding: 10px 0;
    }

    main section.locations-section .swiper-clinic-gallery .swiper-thumb-view .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;

        border-radius: 0.8rem !important;
        overflow: hidden;

        width: 25%;
        height: 100%;
        opacity: 0.4;
    }

    main section.locations-section .swiper-clinic-gallery .swiper-thumb-view .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        min-height: 140px;
        object-fit: cover;
        object-position: center;
    }

    main section.locations-section .swiper-clinic-gallery .swiper-thumb-view .swiper-slide-thumb-active {
        opacity: 1;
    }
</style>
<section class="locations-section">
    <div class="container-xl">
        <div class="section-title">
            <span class="sub-title">Locations</span>
            <h2>Visit Our Clinic</h2>
            <p>Our state-of-the-art facility is equipped with the latest technology to provide the
                best care for
                your pets.</p>
        </div>
        <div class="location-container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="location-gallery-cont">
                        <div class="header">
                            <span class="material-icons-sharp">photo_library</span>
                            <div class="title">
                                Clinic's Gallery
                            </div>
                        </div>
                        <div class="swiper-clinic-gallery">
                            <div class="swiper swiper-main-view">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="<?= asset('img/gallery/jaa-front.jpg'); ?>" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="<?= asset('img/gallery/jaa-worms.jpg'); ?>" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="<?= asset('img/gallery/jaa-near.jpg'); ?>" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="<?= asset('img/gallery/jaa-in.jpg'); ?>" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="https://swiperjs.com/demos/images/nature-5.jpg" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="https://swiperjs.com/demos/images/nature-6.jpg" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="https://swiperjs.com/demos/images/nature-7.jpg" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="https://swiperjs.com/demos/images/nature-8.jpg" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="https://swiperjs.com/demos/images/nature-10.jpg" />
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-pagination"></div>
                            </div>
                            <div thumbsSlider="" class="swiper swiper-thumb-view">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="<?= asset('img/gallery/jaa-front.jpg'); ?>" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="<?= asset('img/gallery/jaa-worms.jpg'); ?>" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="<?= asset('img/gallery/jaa-near.jpg'); ?>" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="<?= asset('img/gallery/jaa-in.jpg'); ?>" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="https://swiperjs.com/demos/images/nature-5.jpg" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="https://swiperjs.com/demos/images/nature-6.jpg" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="https://swiperjs.com/demos/images/nature-7.jpg" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="https://swiperjs.com/demos/images/nature-8.jpg" />
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="https://swiperjs.com/demos/images/nature-10.jpg" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="location-map-cont">
                        <div class="header">
                            <span class="material-icons-sharp">location_on</span>
                            <div class="title">003 DR Zone III Brgy. Graceville, San Jose Del
                                Monte Bulacan
                            </div>
                        </div>
                        <!-- Google Map Iframe -->
                        <?= partial('ui/google-map'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>