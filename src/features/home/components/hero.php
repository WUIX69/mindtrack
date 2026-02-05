<style>
    /*----------- MAIN (Hero) -----------*/
    main section.hero-section {
        height: 100vh;
    }

    main section.hero-section .bg-video {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    main section.hero-section .bg-video video {
        object-fit: cover;
        object-position: center;
    }

    main section.hero-section .hero-content {
        /* position: relative; */
        padding: 0;
        margin: 0;
        margin-top: 3.7rem;

        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        /* padding-top: 10rem; */

        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1;
    }

    main section.hero-section .row {
        justify-content: center;
        align-items: center;
    }

    main section.hero-section .hero-text {
        color: var(--color-white);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: start;
        gap: 1rem;
        text-shadow: var(--text-shadow);
    }

    main section.hero-section .hero-title {
        font-size: 4rem;
        font-weight: 700;
        line-height: 1.2;
        margin-bottom: 20px;
        color: var(--color-white);
    }

    main section.hero-section .hero-title .full-def {
        font-size: 2rem;
        position: relative;
        top: -0.45rem;
        color: #9ACBD0;
    }

    main section.hero-section .hero-title .sub {
        font-size: 4rem;
    }

    main section.hero-section .hero-description {
        font-size: 1.1rem;
        margin-bottom: 40px;
        color: rgba(255, 255, 255, 0.9);
        line-height: 1.6;
    }

    main section.hero-section .cta-buttons {
        display: flex;
        gap: 20px;
    }

    main section.hero-section .cta-button {
        padding: 15px 30px;
        border-radius: 30px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    main section.hero-section .cta-button.primary,
    main section.hero-section .cta-button.primary span {
        background-color: #006A71;
        color: #F2EFE7;
    }

    main section.hero-section .cta-button.secondary {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        backdrop-filter: blur(5px);
    }

    main section.hero-section .cta-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    main section.hero-section .hero-image {
        text-align: right;
        border-radius: 0.8rem !important;
        overflow: hidden;
    }

    main section.hero-section .hero-image img {
        max-width: 100%;
        height: auto;
    }

    @media (max-width: 768px) {

        /*######## MAIN ########*/
        /*--- MAIN (Hero) ---*/
        main section.hero-section {}

        main section.hero-section {
            padding: 0 !important;
            margin: 0;

            height: 89vh;
        }

        main section.hero-section .container-xl {
            padding: 0;
            margin: 0;
        }

        main section.hero-section .hero-content {
            padding: 0 !important;
            margin: 0 !important;
        }

        main section.hero-section .hero-content .hero-text {
            gap: 0 !important;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            align-items: center;
        }

        main section.hero-section .hero-title {
            text-align: center;
        }

        main section.hero-section .hero-title:not(span.full-def) {
            font-size: 3.4rem !important;
        }

        main section.hero-section .hero-title span.full-def {
            font-size: 1rem !important;
            color: teal;
            text-wrap: nowrap !important;
        }

        main section.hero-section .hero-description {
            text-align: center;
        }

        main section.hero-section .cta-buttons {
            font-size: 0.7rem;
            text-align: center;
            text-wrap: nowrap;
        }

        main section.hero-section .hero-image {
            text-align: center;
            margin-top: 3.5rem;
            display: none;
        }
    }
</style>

<section class="hero-section">
    <div class="bg-video">
        <video src="<?= asset('vids/montage.mp4'); ?>" autoplay muted loop></video>
    </div>
    <div class="hero-content">
        <div class="container-xl">
            <div class="row">
                <div class="col-md-6">
                    <div class="hero-text">
                        <div class="hero-title">
                            J.A.A <span class="full-def">(Josephine Ann Angeles)</span><br>
                            <div class="sub">Veterinary <span class="ui text" style="color: #006A71;">Clinic</span>
                            </div>
                        </div>
                        <p class="hero-description">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa nam sequi
                            officia
                            officiis deleniti! Est commodi impedit laborum adipisci quos quod id,
                            atque
                            exercitationem voluptas excepturi, aliquid sit ad magni quidem illo.
                        </p>
                        <div class="cta-buttons">
                            <a href="#" class="cta-button primary">
                                <span class="material-icons-sharp">pets</span>
                                Book Now
                            </a>
                            <a href="#" class="cta-button secondary">
                                Learn More
                                <span class="material-icons-sharp">exit_to_app</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="hero-image">
                        <img src="<?= asset('img/gallery/jaa-near.jpg'); ?>" alt="App Interface" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>