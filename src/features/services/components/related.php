<style>
    main section.related .service-card {
        background: var(--color-white);
        padding: 0 !important;
        border-radius: 0.6rem;
        border: 1px solid var(--bs-card-border-color) !important;
        transition: all 0.3s ease;
        height: 100%;
    }

    main section.related .header .related-tag {
        display: inline-block;
        background: var(--color-dark-variant);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 5px;
        text-transform: uppercase;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    main section.related .header .related-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 2rem;
        line-height: 1.3;
    }

    main section.related .service-card .card-img {
        position: relative;
        overflow: hidden;
        height: 260px;
        border-radius: 0;
    }

    main section.related .service-card .card-img .service-status {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }

    main section.related .service-card .card-img .service-status span {
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
        border-radius: 60px;
        background: var(--bs-primary);
        color: var(--bs-white);

        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.3rem;
    }

    main section.related .service-card .card-img .service-status span i {
        font-size: 1rem;
    }

    main section.related .service-card .card-img .service-tag {
        position: absolute;
        bottom: 1rem;
        left: 1rem;
    }

    main section.related .service-card .card-img .service-tag span {
        font-size: 0.8rem;
    }

    main section.related .service-card .card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    main section.related .service-card .card-body {
        padding: 1.6rem;
        font-size: 0.95rem;

        display: flex;
        flex-direction: column;
    }

    main section.related .service-card .card-body .service-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    main section.related .service-card .card-body .service-header h4 {
        font-weight: bold;
        margin: 0;
        font-size: 1.4rem;
    }

    main section.related .service-card .card-body .service-header i {
        font-size: 24px;
        background: #eff6ff;
        padding: 10px;
        border-radius: 50%;
        color: #031224;
    }

    main section.related .service-card .card-body .service-details {
        margin-bottom: 20px;
    }

    main section.related .service-card .card-body .service-details p {
        color: #667;
        /* font-size: 14px; */
        line-height: 1.5;
        margin-bottom: 15px;
    }

    main section.related .service-card .card-body .service-meta {
        flex: 1;

        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #f3f3f3;
    }

    main section.related .service-card .card-body .service-meta .price {
        font-weight: 600;
        font-size: 18px;
        color: #031224;
    }

    main section.related .service-card .card-body .service-meta button {
        border: none;
        color: #fff;
        background: #031224;
        padding: 10px 20px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    main section.related .service-card .card-body .service-meta button:hover {
        background: #062451;
    }
</style>
<section class="related py-5">
    <div class="container-xl">
        <div class="header">
            <div class="related-tag">RELATED SERVICES</div>
            <h2 class="related-title">You May Also Be Interested In</h2>
        </div>
        <!-- Services -->
        <div class="row g-4">
            <!-- Vaccination Service -->
            <div class="col-lg-4">
                <div class="service-card card">
                    <div class="card-img">
                        <div class="service-status">
                            <span class="ui green label status-avail available">
                                <i class='bx bx-check-circle'></i> Available</span>
                        </div>
                        <img src="<?= asset('img/contents/services/vaccination.jpg'); ?>" alt="Vaccination Services">
                        <div class="service-tag">
                            <span class="ui primary tag label">Featured</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="service-header">
                            <h4>Vaccination</h4>
                            <i class='bx bx-injection'></i>
                        </div>
                        <div class="service-details">
                            <p>Essential vaccinations to protect your pet against common diseases. Includes
                                consultation and vaccine administration.</p>
                            <p>Duration: 20-30 minutes</p>
                        </div>
                        <div class="service-meta">
                            <span class="price">₱75.00</span>
                            <button>Book Now <i class='bx bx-right-arrow-alt'></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Surgery Service -->
            <div class="col-lg-4">
                <div class="service-card card">
                    <div class="card-img">
                        <div class="service-status">
                            <span class="ui red label status-avail unavailable">
                                <i class='bx bx-x-circle'></i> Unavailable</span>
                        </div>
                        <img src="<?= asset('img/contents/services/surgery.jpg'); ?>" alt="Surgery Services">
                        <div class="service-tag">
                            <span class="ui primary tag label">Featured</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="service-header">
                            <h4>Surgery</h4>
                            <i class='bx bx-plus-medical'></i>
                        </div>
                        <div class="service-details">
                            <p>Professional surgical procedures performed by experienced veterinarians in a
                                state-of-the-art facility. Lorem ipsum dolor sit amet consectetur
                                adipisicing elit.</p>
                            <p>Duration: Varies by procedure</p>
                        </div>
                        <div class="service-meta">
                            <span class="price">From ₱200.00</span>
                            <button>Consult Now <i class='bx bx-right-arrow-alt'></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grooming Service -->
            <div class="col-lg-4">
                <div class="service-card card">
                    <div class="card-img">
                        <div class="service-status">
                            <span class="ui yellow label status-avail busy">
                                <i class='bx bx-time'></i> Busy</span>
                        </div>
                        <img src="<?= asset('img/contents/services/grooming.jpg'); ?>" alt="Pet Grooming">
                        <div class="service-tag">
                            <span class="ui primary tag label">Featured</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="service-header">
                            <h4>Grooming</h4>
                            <i class='bx bx-cut'></i>
                        </div>
                        <div class="service-details">
                            <p>Professional grooming services including bath, haircut, nail trimming, and
                                ear
                                cleaning. Lorem, ipsum dolor. Lorem ipsum dolor sit amet.</p>
                            <p>Duration: 60-120 minutes</p>
                        </div>
                        <div class="service-meta">
                            <span class="price">From ₱65.00</span>
                            <button>Book Now <i class='bx bx-right-arrow-alt'></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>