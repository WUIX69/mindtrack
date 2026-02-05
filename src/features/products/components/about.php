<style>
    /* main section.about {
        margin-top: 3rem;
    } */

    main section.about {
        border-top: 1px solid #eee;
    }

    main section.about h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--color-dark);
    }

    main section.about p {
        color: var(--color-text-muted);
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    main section.about .product-image {
        width: 100%;
        height: 100%;
        border-radius: 0;
        overflow: hidden;
        background-color: #FFF8BD;

        display: flex;
        align-items: center;
        justify-content: center;
    }

    main section.about .product-image img {
        object-fit: contain;
        object-position: center;
    }

    main section.about .product-description {
        margin-bottom: -0.9rem;
    }

    main section.about .details-tab {
        position: relative;
        padding: 0;
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    main section.about .details-tab .details-nav {
        display: flex;
        align-items: start;
        justify-content: start !important;
        gap: 1rem;

        margin-bottom: 0.9rem !important;
    }

    main section.about .details-tab .details-nav li a {
        color: var(--color-dark);
        border-bottom: 2px solid transparent !important;
    }

    main section.about .details-tab .details-nav li a.active,
    main section.about .details-tab .details-nav li a:hover {
        color: #f7ba01 !important;
        font-weight: 500;
        border-bottom: 2px solid #f7ba01 !important;
    }

    main section.about .details-tab .details-nav li a,
    main section.about .details-tab .details-nav li a:active {
        background: transparent !important;
    }

    main section.about .details-tab .details-content .features-list {
        list-style: none;
        padding: 0;
        margin: 0 0 2rem 0;
    }

    main section.about .details-tab .details-content .features-list li {
        padding: 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        color: var(--color-text-muted);
    }

    main section.about .details-tab .details-content .features-list li i {
        color: #FFC107;
        font-size: 0.5rem;
    }
</style>

<section class="about py-5">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-5">
                <div class="product-image">
                    <img src="<?= asset('img/contents/products/camera.jpg'); ?>" alt="Vintage camera">
                </div>
            </div>
            <div class="col-lg-7">
                <h2>The Christina Fashion</h2>
                <div class="product-description">
                    <p>Cramond Leopard & Pythong Print Anorak Jacket In Beige but also the leap into electronic
                        typesetting, remaining Lorem Ipsum is simply dummy text of the printing and typesetting
                        industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                        unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                </div>
                <div class="details-tab">
                    <ul class="nav nav-tabs mb-0 justify-content-center details-nav">
                        <li class="nav-item d-inline-block me-1">
                            <a href="#features" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                <span class="d-md-block">Features</span>
                            </a>
                        </li>
                        <li class="nav-item d-inline-block">
                            <a href="#specs" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                <span class="d-md-block">Specs</span>
                            </a>
                        </li>
                        <li class="nav-item d-inline-block">
                            <a href="#data" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                <span class="d-md-block">Data</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content details-content">

                        <div id="features" class="tab-pane fade show active">
                            <ul class="features-list">
                                <li><i class="circle icon"></i> 55% poly, 45% rayon</li>
                                <li><i class="circle icon"></i> Hand wash cold</li>
                                <li><i class="circle icon"></i> Partially lined</li>
                                <li><i class="circle icon"></i> Hidden front button closure with keyhole accents</li>
                                <li><i class="circle icon"></i> Button cuff sleeves</li>
                                <li><i class="circle icon"></i> Made in USA</li>
                            </ul>
                        </div>

                        <div id="specs" class="tab-pane fade">
                            <ul class="features-list">
                                <li><i class="circle icon"></i> 55% poly, 45% rayon</li>
                                <li><i class="circle icon"></i> Hand wash cold</li>
                                <li><i class="circle icon"></i> Partially lined</li>
                                <li><i class="circle icon"></i> Hidden front button closure with keyhole accents</li>
                                <li><i class="circle icon"></i> Button cuff sleeves</li>
                                <li><i class="circle icon"></i> Made in USA</li>
                            </ul>
                        </div>

                        <div id="data" class="tab-pane fade">
                            <ul class="features-list">
                                <li><i class="circle icon"></i> 55% poly, 45% rayon</li>
                                <li><i class="circle icon"></i> Hand wash cold</li>
                                <li><i class="circle icon"></i> Partially lined</li>
                                <li><i class="circle icon"></i> Hidden front button closure with keyhole accents</li>
                                <li><i class="circle icon"></i> Button cuff sleeves</li>
                                <li><i class="circle icon"></i> Made in USA</li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>