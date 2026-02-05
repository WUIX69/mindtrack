<?php
$services = [
    [
        'name' => 'Vaccination',
        'description' => 'Essential vaccinations to protect your pet against common diseases. 
                            Includes consultation and vaccine administration.',
        'duration' => '20-30 minutes',
        'price' => '₱75.00',
        'status' => [
            'label' => 'Available',
            'color' => 'green',
            'icon' => 'bx-check-circle',
        ],
        'tag' => [
            'label' => 'Hot',
            'color' => 'red'
        ],
        'icon' => 'bx-injection',
        'image' => asset('img/contents/services/vaccination.jpg'),
    ],
    [
        'name' => 'Surgery',
        'description' => 'Professional surgical procedures performed by experienced 
                            veterinarians in a state-of-the-art facility.',
        'duration' => 'Varies by procedure',
        'price' => 'From ₱200.00',
        'status' => [
            'label' => 'Unavailable',
            'color' => 'red',
            'icon' => 'bx-x-circle',
        ],
        'tag' => [
            'label' => 'Featured',
            'color' => 'primary',
        ],
        'icon' => 'bx-plus-medical',
        'image' => asset('img/contents/services/surgery.jpg'),
    ],
    [
        'name' => 'Grooming',
        'description' => 'Professional grooming services including bath, haircut, 
                            nail trimming, and ear cleaning.',
        'duration' => '60-120 minutes',
        'price' => 'From ₱65.00',
        'status' => [
            'label' => 'Busy',
            'color' => 'orange',
            'icon' => 'bx-time',
        ],
        'tag' => [
            'label' => 'Popular',
            'color' => 'green'
        ],
        'icon' => 'bx-cut',
        'image' => asset('img/contents/services/grooming.jpg'),
    ],
    [
        'name' => 'Foods & Accessories',
        'description' => 'Premium quality pet foods, nutritional supplements, and a wide range 
                            of accessories including collars, leashes, beds, toys, and care products.',
        'duration' => 'In-store & Online Shopping Available',
        'price' => 'Varies',
        'status' => [
            'label' => 'Available',
            'color' => 'green',
            'icon' => 'bx-check-circle',
        ],
        'tag' => [
            'label' => 'Hot',
            'color' => 'red'
        ],
        'icon' => 'bx-store',
        'image' => asset('img/contents/services/accessories.jpg'),
    ],
    [
        'name' => 'Boarding',
        'description' => 'Safe and comfortable boarding facilities for your pets while you\'re away. 
                            Includes feeding, daily exercise, and medical monitoring if needed.',
        'duration' => 'Coming in September 2023',
        'price' => 'From ₱45.00/night',
        'status' => [
            'label' => 'Soon',
            'color' => 'teal',
            'icon' => 'bx-time-five',
        ],
        'tag' => [
            'label' => 'New',
            'color' => 'black'
        ],
        'icon' => 'bx-home-heart',
        'image' => asset('img/contents/services/boarding.jpg'),
    ],
];
?>
<style>
    main section.services {
        position: relative;
        /* padding-top: 0.3rem; */
        padding-bottom: 3rem;
        margin: 0;
    }

    /* Header */
    main section.services .header {
        display: flex;
        justify-content: end;
        gap: 1rem;
        align-items: center;
        margin-bottom: 2.3rem;
        flex-wrap: nowrap;
    }

    @media screen and (max-width: 768px) {
        main section.services .header {
            /* flex-wrap: wrap; */
            flex-direction: column;
        }
    }

    main section.services .header .ui.dropdown {
        background: var(--color-white) !important;
    }

    main section.services .header .ui.search input {
        background: var(--color-white) !important;
    }

    /* Header END */

    main section.services .service-card {
        background: var(--color-white);
        padding: 0 !important;
        border-radius: 0.6rem;
        border: 1px solid var(--bs-card-border-color) !important;
        transition: all 0.3s ease;
        height: 100%;
    }

    main section.services .service-card .card-img {
        position: relative;
        overflow: hidden;
        height: 260px;
        border-radius: 0;
    }

    main section.services .service-card .card-img .service-status {
        position: absolute;
        top: 1rem;
        right: 1rem;
    }

    main section.services .service-card .card-img .service-status span {
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

    main section.services .service-card .card-img .service-status span i {
        font-size: 1rem;
    }

    main section.services .service-card .card-img .service-tag {
        position: absolute;
        bottom: 1rem;
        left: 1rem;
    }

    main section.services .service-card .card-img .service-tag span {
        font-size: 0.8rem;
    }

    main section.services .service-card .card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    main section.services .service-card .card-body {
        padding: 1.6rem;
        font-size: 0.95rem;

        display: flex;
        flex-direction: column;
    }

    main section.services .service-card .card-body .service-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    main section.services .service-card .card-body .service-header h4 {
        font-weight: bold;
        margin: 0;
        font-size: 1.4rem;
    }

    main section.services .service-card .card-body .service-header i {
        font-size: 24px;
        background: #eff6ff;
        padding: 10px;
        border-radius: 50%;
        color: #031224;
    }

    main section.services .service-card .card-body .service-details {
        margin-bottom: 20px;
    }

    main section.services .service-card .card-body .service-details p {
        color: #667;
        /* font-size: 14px; */
        line-height: 1.5;
        margin-bottom: 15px;
    }

    main section.services .service-card .card-body .service-meta {
        flex: 1;

        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid #f3f3f3;
    }

    main section.services .service-card .card-body .service-meta .price {
        font-weight: 600;
        font-size: 18px;
        color: #031224;
    }

    main section.services .service-card .card-body .service-meta button {
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

    main section.services .service-card .card-body .service-meta button:hover {
        background: #062451;
    }

    main section.services .service-card .card-body .service-meta .service-view-btn {
        background: linear-gradient(90deg, #2e7d4f 0%, #1de9b6 100%);
        border: none;
        border-radius: 6px;
        padding: 0.5rem 1.2rem;
        color: #fff;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        margin-right: 0.5rem;
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        justify-content: center;
        box-shadow: 0 2px 8px 0 rgba(46, 125, 79, 0.10);
        margin-bottom: 0.5rem;
    }

    main section.services .service-card .card-body .service-meta .service-view-btn:hover {
        background: linear-gradient(90deg, #1de9b6 0%, #2e7d4f 100%);
        color: #b2dfdb;
        text-decoration: none;
        box-shadow: 0 4px 16px 0 rgba(46, 125, 79, 0.18);
    }

    main section.services .service-card .card-body .service-meta .service-view-btn .eye.icon {
        margin-right: 0.4em;
        color: #b2dfdb;
    }

    main section.services .service-card .card-body .service-meta .service-view-btn-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }
</style>
<section class="services">
    <div class="container-xl">

        <!-- Only section-title if its /landing -->
        <?php if (uriAppPath('landing')): ?>
            <div class="section-title">
                <span class="sub-title">Services</span>
                <h2>What We Offer</h2>
                <p>Comprehensive veterinary care for your beloved pets</p>
            </div>
        <?php endif; ?>

        <!-- Header -->
        <div class="header">
            <!-- Status -->
            <div class="sort-container">
                <div class="ui tiny floating selection compact clearable dropdown status-dropdown">
                    <input type="hidden" name="filter">
                    <i class="dropdown icon"></i>
                    <div class="default text">Status By</div>
                    <div class="menu">
                        <div class="item" data-value="available">
                            <i class="check circle icon"></i>Available
                        </div>
                        <div class="item" data-value="unavailable">
                            <i class="times circle icon"></i>Unavailable
                        </div>
                        <div class="item" data-value="busy">
                            <i class="clock icon"></i>Busy
                        </div>
                        <div class="item" data-value="soon">
                            <i class="calendar plus icon"></i>Coming Soon
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sort -->
            <div class="sort-container">
                <div class="ui tiny floating selection compact clearable dropdown sort-dropdown">
                    <input type="hidden" name="sort">
                    <i class="dropdown icon"></i>
                    <div class="default text">Sort By</div>
                    <div class="menu">
                        <div class="item" data-value="newest">
                            <i class="calendar alternate outline icon"></i>Newest
                        </div>
                        <div class="item" data-value="price-low">
                            <i class="sort amount down icon"></i>Price: Low to High
                        </div>
                        <div class="item" data-value="price-high">
                            <i class="sort amount up icon"></i>Price: High to Low
                        </div>
                        <div class="item" data-value="popular">
                            <i class="fire icon"></i>Most Popular
                        </div>
                        <div class="item" data-value="rating">
                            <i class="star icon"></i>Highest Rated
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search -->
            <div class="ui tiny search">
                <div class="ui icon input">
                    <input class="prompt" type="text" placeholder="Search for services...">
                    <i class="search icon"></i>
                </div>
                <div class="results"></div>
            </div>
        </div>

        <!-- Services -->
        <div class="row g-4">
            <!-- Display Services -->
            <?php foreach ($services as $service): ?>
                <div class="col-lg-4">
                    <div class="service-card card">
                        <div class="card-img">
                            <div class="service-status">
                                <span class="ui <?= $service['status']['color']; ?> label status-avail">
                                    <i class='bx <?= $service['status']['icon']; ?>'></i>
                                    <?= $service['status']['label']; ?>
                                </span>
                            </div>
                            <img src="<?= $service['image']; ?>" alt="<?= $service['name']; ?>">
                            <div class="service-tag">
                                <span class="ui <?= $service['tag']['color']; ?> tag label">
                                    <?= $service['tag']['label']; ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="service-header">
                                <h4><?= $service['name']; ?></h4>
                                <i class='bx <?= $service['icon']; ?>'></i>
                            </div>
                            <div class="service-details">
                                <p><?= $service['description']; ?></p>
                                <p>Duration: <?= $service['duration']; ?></p>
                            </div>
                            <div class="service-meta">
                                <span class="price"><?= $service['price']; ?></span>
                                <div class="actions">

                                    <div class="service-view-btn-wrapper">
                                        <a href="<?= app('user/service-single-view') ?>"
                                            class="service-view-btn ui eye icon" title="View Service">
                                            <i class="eye icon"></i>View
                                        </a>
                                    </div>

                                    <button>Book Now <i class='bx bx-right-arrow-alt'></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Pagination START -->
        <?= shared('components/pagination'); ?>
        <!-- Pagination END -->
    </div>
</section>