<style>
    /* Grooming Service Offers */
    main section.about .offers-list {
        position: relative;
        margin: 0;
        padding: 0;
    }

    main section.about .offer .offers-list .item {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        border: 1px solid #f3f3f3;
        border-radius: 12px;
        overflow: visible;
        padding: 0 !important;
    }

    main section.about .offer .offers-list .item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    main section.about .offer .offers-list .item .content {
        padding: 1.5rem;
    }

    main section.about .offer .offers-list .item .header {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--color-dark);
    }

    main section.about .offer .offers-list .item .meta {
        margin-top: 0.5rem;
        font-size: 0.9rem;
        color: var(--color-text-muted);
    }

    main section.about .offer .offers-list .item .description {
        margin-top: 1rem;
        color: var(--color-text-muted);
        font-size: 0.9rem;
        line-height: 1.5;
    }

    main section.about .offer .ui.ribbon.label {
        position: absolute;
        left: -0.8rem;
        top: 1rem;
        padding: 0.5rem 1.2rem;
        font-weight: 500;
        z-index: 1;
    }

    main section.about .offer .ui.ribbon.label i {
        margin-right: 0.3rem;
    }

    main section.about .offer .ui.button {
        margin-top: 0.5rem;
        padding: 0.8rem 0;
        font-weight: 500;
    }

    main section.about .offer .offers-list .item .image {
        height: auto;
        overflow: visible;
        background-color: var(--color-light);
        position: relative;
    }

    main section.about .offer .offers-list .item .ui.blue.ribbon.label {
        border-color: #1a69a4 !important;
    }

    main section.about .offer .offers-list .item .ui.orange.ribbon.label {
        border-color: #cf590c !important;
    }

    main section.about .offer .offers-list .item .image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    main section.about .offer .offers-list .item:hover .image img {
        transform: scale(1.05);
    }

    main section.about .offer .ui.segment {
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #f3f3f3;
    }

    main section.about .offer .ui.segment h3 {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--color-dark);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    main section.about .offer .ui.segment h3 i {
        margin-right: 0.5rem;
        color: var(--color-primary);
    }

    main section.about .offer .ui.relaxed.list .item {
        padding: 0.7rem 0;
    }

    main section.about .offer .ui.relaxed.list .item .header {
        font-size: 1rem;
        font-weight: 500;
        color: var(--color-dark);
        margin-bottom: 0.2rem;
    }

    main section.about .offer .ui.relaxed.list .item .description {
        font-size: 0.9rem;
        color: var(--color-primary);
        font-weight: 600;
    }

    main section.about .offer .ui.info.message {
        border-radius: 12px;
        box-shadow: none;
        border: 1px solid rgba(var(--color-primary-rgb), 0.15);
    }

    main section.about .offer .ui.info.message .header {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    main section.about .offer .ui.info.message .header i {
        margin-right: 0.5rem;
        font-size: 1.2rem;
    }

    main section.about .offer .ui.info.message ul.list li {
        padding: 0.3rem 0;
        font-size: 0.9rem;
    }
</style>
<div class="offer">
    <h2>Service Offer</h2>
    <p>Our professional grooming services help keep your pet comfortable, healthy, and looking their
        best. Each grooming treatment is provided by our trained specialists using premium products
        and equipment.</p>

    <div class="ui two stackable horizontal mini cards offers-list mt-4">
        <div class="ui card item">
            <div class="image">
                <div class="ui blue ribbon label">
                    <i class="bx bx-cut"></i> Popular
                </div>
                <img src="/assets/img/services/nail-trim.jpg" alt="Nail Trimming">
            </div>
            <div class="content">
                <div class="header">Nail Trimming</div>
                <div class="meta">
                    <span>$15</span>
                </div>
                <div class="description">
                    Professional trimming of your pet's nails to maintain proper length and prevent
                    discomfort.
                </div>
                <div class="actions">
                    <a href="#" class="ui fluid mini teal button" data-open-modal="#groomingModal">Book
                        Now</a>
                </div>
            </div>
        </div>

        <div class="ui card item">
            <div class="image">
                <img src="/assets/img/services/haircut.jpg" alt="Haircut">
            </div>
            <div class="content">
                <div class="header">Haircut</div>
                <div class="meta">
                    <span>$35-50</span>
                </div>
                <div class="description">
                    Breed-specific or custom haircuts tailored to your pet's needs and your
                    preferences.
                </div>
                <div class="actions">
                    <a href="#" class="ui fluid mini teal button" data-open-modal="#groomingModal">Book
                        Now</a>
                </div>
            </div>
        </div>

        <div class="ui card item">
            <div class="image">
                <img src="/assets/img/services/bath.jpg" alt="Bath & Brush">
            </div>
            <div class="content">
                <div class="header">Bath & Brush</div>
                <div class="meta">
                    <span>$25-40</span>
                </div>
                <div class="description">
                    Complete bath with premium shampoo, blow dry, and thorough brush out to reduce
                    shedding.
                </div>
                <div class="actions">
                    <a href="#" class="ui fluid mini teal button" data-open-modal="#groomingModal">Book
                        Now</a>
                </div>
            </div>
        </div>

        <div class="ui card item">
            <div class="image">
                <div class="ui orange ribbon label">
                    <i class="bx bx-trending-up"></i> New
                </div>
                <img src="/assets/img/services/teeth.jpg" alt="Teeth Cleaning">
            </div>
            <div class="content">
                <div class="header">Teeth Cleaning</div>
                <div class="meta">
                    <span>$20</span>
                </div>
                <div class="description">
                    Gentle cleaning to remove plaque and tartar, promoting better oral health for
                    your pet.
                </div>
                <div class="actions">
                    <a href="#" class="ui fluid mini teal button" data-open-modal="#groomingModal">Book
                        Now</a>
                </div>
            </div>
        </div>
    </div>

    <?= shared('pagination'); ?>
</div>