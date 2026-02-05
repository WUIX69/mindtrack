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
            <div class="location-map-cont">
                <div class="header">
                    <span class="material-icons-sharp">location_on</span>
                    <div class="title">003 DR Zone III Brgy. Graceville, San Jose Del
                        Monte Bulacan
                    </div>
                </div>
                <!-- Google Map Iframe -->
                <?= partial('components/ui/google-map'); ?>
            </div>
        </div>
    </div>
</section>