<style>
    /*----------- MAIN (Features) -----------*/
    main section.features-section {
        background: var(--color-background);
    }

    main section.features-section .features-cont {
        position: relative;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    main section.features-section .feature-card {
        background: var(--color-white);
        border: 1px solid transparent !important;
    }

    main section.features-section .feature-card:hover {
        transform: translateY(-5px);
        border: 1px solid var(--color-dark-variant) !important;
        cursor: pointer;
    }

    main section.features-section .feature-header {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    main section.features-section .feature-header span {
        font-size: 3.6rem;
        color: #6c9bcf;
    }

    main section.features-section .feature-header .feature-title {
        font-size: 1.6rem;
        color: var(--color-dark);
        text-wrap: nowrap;
    }

    main section.features-section .feature-description {
        color: var(--color-dark-variant);
        line-height: 1.6;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        line-clamp: 4;
        -webkit-box-orient: vertical;
        text-align: center;
    }
</style>

<section class="features-section">
    <div class="container-xl">
        <div class="section-title">
            <span class="sub-title">Features</span>
            <h2>Why Choose Us</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.</p>
        </div>
        <div class="features-cont">
            <div class="feature-card box">
                <div class="feature-header">
                    <img src="<?= asset('img/icons/fast.png'); ?>" alt="">
                    <h2 class="feature-title">Quick Setup</h2>
                </div>
                <p class="feature-description">Lorem ipsum dolor sit amet consectetur adipisicing
                    elit. Obcaecati amet illum facilis ut nihil ullam rerum consequuntur, dolorum et
                    itaque.</p>
            </div>
            <div class="feature-card box">
                <div class="feature-header">
                    <img src="<?= asset('img/icons/24hr.png'); ?>" alt="">
                    <h2 class="feature-title">24/hr Open</h2>
                </div>
                <p class="feature-description">Lorem ipsum dolor sit amet consectetur
                    adipisicing
                    elit. Dolorem dolorum eveniet tempore? Dignissimos ipsam, rerum eum
                    repudiandae
                    doloribus molestiae aliquam.</p>
            </div>
            <div class="feature-card box">
                <div class="feature-header">
                    <img src="<?= asset('img/icons/support.png'); ?>" alt="">
                    <h2 class="feature-title">Support</h2>
                </div>
                <p class="feature-description">Lorem ipsum, dolor sit amet consectetur
                    adipisicing
                    elit. Sunt saepe quia autem nostrum! Harum, illum cumque quod numquam
                    quasi
                    veritatis.</p>
            </div>
        </div>
    </div>
</section>