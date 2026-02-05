<style>
    /*----------- MAIN (Product) -----------*/
    main section.highlights {
        /* padding: 4rem 0; */
        background: var(--color-background-variant);
    }

    main section.highlights .product-title {
        margin-bottom: 1.5rem;
    }

    main section.highlights .product-title h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        color: var(--color-dark);
    }

    main section.highlights .product-category-tag {
        display: inline-block;
        background: var(--color-primary);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 4px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    main section.highlights .product-image-main {
        border-radius: 0;
        overflow: hidden;
        margin-bottom: 1rem;
        background-color: #FFF8BD;
        height: 500px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    main section.highlights .product-image-main img {
        max-width: 80%;
        max-height: 80%;
        object-fit: contain;
        object-position: center;
    }

    main section.highlights .product-thumbnails {
        display: flex;
        gap: 0.5rem;
        /* margin-bottom: 2rem; */
        justify-content: center;
    }

    main section.highlights .thumbnail {
        width: 30px;
        height: 6px;
        border-radius: 3px;
        overflow: hidden;
        cursor: pointer;
        background-color: #E5E5E5;
        transition: all 0.3s ease;
    }

    main section.highlights .thumbnail.active {
        background-color: var(--color-primary);
    }

    main section.highlights .product-info-card {
        background-color: transparent;
        border-radius: 0;
        padding: 0;
        box-shadow: none;
        border: none;
    }

    main section.highlights .product-rating {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        color: #FFC107;
    }

    main section.highlights .review-count {
        margin-left: 0.5rem;
        font-weight: 500;
        color: var(--color-dark);
    }

    main section.highlights .product-price {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--color-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
    }

    main section.highlights .original-price {
        text-decoration: line-through;
        color: var(--color-text-muted);
        font-size: 1.2rem;
        margin-left: 1rem;
    }

    main section.highlights .stock-status {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 4px;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    main section.highlights .stock-status.in-stock {
        background-color: #FFC107;
        color: #fff;
    }

    main section.highlights .stock-status.out-stock {
        background-color: #ffebee;
        color: #c62828;
    }

    main section.highlights .product-description {
        margin-bottom: 1.5rem;
        color: var(--color-text-muted);
        line-height: 1.6;
    }

    main section.highlights .size-selector {
        margin-bottom: 1.5rem;
    }

    main section.highlights .size-label {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.6rem;
    }

    main section.highlights .size-label span {
        font-weight: 600;
    }

    main section.highlights .size-label a {
        color: var(--color-text-muted);
        text-decoration: none;
    }

    main section.highlights .size-options {
        display: flex;
        gap: 0.5rem;
    }

    main section.highlights .size-option {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #ddd !important;
        cursor: pointer;
    }

    main section.highlights .size-option:hover {
        background: #FFC107 !important;
        color: var(--color-white) !important;
    }

    main section.highlights .size-option.active {
        border-color: #FFC107 !important;
        color: #FFC107;
    }

    main section.highlights .product-actions {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: start;
        align-items: center;
        gap: 0.5rem;

        margin-bottom: 1rem;
        padding-bottom: 1.3rem;
        border-bottom: 1px solid #ddd !important;

        width: 100%;
    }

    main section.highlights .product-actions .quantity-selector {
        width: 30%;
        border-right: 1px solid #ddd !important;
        padding-right: 1rem;
        margin-right: 0.5rem;
    }

    main section.highlights .product-actions .ui.button {
        padding: 1rem;
        width: 30%;
        text-wrap: nowrap;
    }

    main section.highlights .wishlist-button {
        display: flex;
        align-items: center;
        justify-content: center;
        background: none;
        border: none;
        color: var(--color-text-muted);
        cursor: pointer;
    }

    main section.highlights .wishlist-button i {
        margin-right: 0.5rem;
    }

    main section.highlights .product-meta {
        position: relative;
    }

    main section.highlights .meta-item {
        display: flex;
        flex-direction: row;
        justify-content: start;
        align-items: start;
        gap: 1rem;

        margin-bottom: 0.5rem;
        color: var(--color-dark);
    }

    main section.highlights .meta-item span {
        text-wrap: nowrap;
    }

    main section.highlights .ui.labels {
        display: flex;
        justify-content: start;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.6rem;
    }

    main section.highlights .ui.labels>.label {
        margin: 0;
    }
</style>
<!-- Product Section -->
<section class="highlights py-5">
    <div class="container-xl">
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-7">
                <div class="product-image-main">
                    <img src="<?= asset('img/contents/products/collagen.png'); ?>" alt="Collagen Peptides">
                </div>
                <div class="product-thumbnails">
                    <div class="thumbnail active"></div>
                    <div class="thumbnail"></div>
                    <div class="thumbnail"></div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-5">
                <div class="product-info-card">
                    <div class="stock-status in-stock">In Stock</div>
                    <div class="product-title">
                        <h1>Lorem Ipsum Dolor</h1>
                    </div>

                    <div class="product-rating">
                        <i class="star icon"></i>
                        <i class="star icon"></i>
                        <i class="star icon"></i>
                        <i class="star icon"></i>
                        <i class="star outline icon"></i>
                        <span class="review-count">- 2 Customer Reviews</span>
                    </div>

                    <div class="product-price">
                        ₱69.00 <span class="original-price text-decoration-line-through text-muted fs-6">₱78.00</span>
                    </div>

                    <div class="product-description">
                        Cramond Leopard & Pythong Print Anorak Jacket in Beige but also the leap into electronic
                        typesetting, remaining, Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis, eos!
                    </div>

                    <!-- <div class="product-specs">
                        <div class="specs-list">
                            <div class="spec-item">
                                <span class="spec-label">Material:</span>
                                <span class="spec-value">Premium Cotton Blend</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">Weight:</span>
                                <span class="spec-value">250g</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">Dimensions:</span>
                                <span class="spec-value">30 x 20 x 5 cm</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">Country of Origin:</span>
                                <span class="spec-value">USA</span>
                            </div>
                            <div class="spec-item">
                                <span class="spec-label">Care Instructions:</span>
                                <span class="spec-value">Machine wash cold, tumble dry low</span>
                            </div>
                        </div>
                    </div> -->

                    <div class="size-selector">
                        <div class="size-label">
                            <span>Size : </span>
                            <a href="#">Guide Can't Find Your Size?</a>
                        </div>
                        <div class="size-options">
                            <div class="size-option">S</div>
                            <div class="size-option">M</div>
                            <div class="size-option">L</div>
                            <div class="size-option active">XL</div>
                        </div>
                    </div>

                    <div class="product-actions">
                        <div class="ui input quantity-selector">
                            <input type="number" value="1" min="1">
                        </div>
                        <button class="ui primary compact mini button">
                            ADD TO CART
                        </button>
                        <button class="ui basic compact mini button wishlist-button">
                            <i class="heart outline icon"></i> Add To Wishlist
                        </button>
                    </div>

                    <div class="product-meta">
                        <div class="meta-item tags">
                            <span><i class="tag icon"></i>Tags :</span>
                            <div class="ui circular labels">
                                <a class="ui mini grey basic label">
                                    CLOTHING
                                </a>
                                <a class="ui mini grey basic label">
                                    FASHION
                                </a>
                                <a class="ui mini grey basic label">
                                    JACKET
                                </a>
                                <a class="ui mini grey basic label">
                                    LEOPARD PRINT
                                </a>
                                <a class="ui mini grey basic label">
                                    PYTHON PRINT
                                </a>
                                <a class="ui mini grey basic label">
                                    ANORAK
                                </a>
                                <a class="ui mini grey basic label">
                                    BEIGE
                                </a>
                                <a class="ui mini grey basic label">
                                    OUTERWEAR
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>