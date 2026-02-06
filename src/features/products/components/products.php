<style>
    /*----------- MAIN (Products) -----------*/
    main section.products {
        background: var(--color-background);
        padding-top: 1rem;
        padding-bottom: 3rem;
    }

    /* Header */
    main section.products .header {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        align-items: center;
        margin-bottom: 2.3rem;
        flex-wrap: nowrap;
    }

    @media screen and (max-width: 768px) {
        main section.products .header {
            /* flex-wrap: wrap; */
            flex-direction: column;
        }
    }

    /* Header - Filter Bar */
    main section.products .header .filter-bar {
        display: flex;
        justify-content: start;
        align-items: center;
        padding: 0;
        margin: 0;
        flex: 1;
    }

    @media screen and (max-width: 768px) {
        main section.products .header .filter-bar {
            padding: 0;
            margin: 0;

            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 0.6rem;
        }
    }

    main section.products .header .filter-bar button {
        padding: 0.8rem 1.5rem;
        margin: 0 0.3rem;
        border-radius: 0.3rem;
        background-color: var(--color-white);
        color: var(--color-dark);
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-wrap: nowrap;
    }

    main section.products .header .filter-bar button:hover {
        transform: translateY(-3px);
        box-shadow: var(--box-shadow);
    }

    main section.products .header .filter-bar button.active {
        background-color: var(--color-dark);
        color: var(--color-white);
    }

    /* Header - Filter Bar END */

    main section.products .header .ui.dropdown {
        background: var(--color-white) !important;
    }

    main section.products .header .ui.search input {
        background: var(--color-white) !important;
    }

    /* Header END */

    /* Product Card START */
    main section.products .product-listing {
        position: relative;
        border: 1px solid var(--bs-card-border-color) !important;
        height: 100%;

        border-radius: 0.8rem;
        padding: 0 !important;
        margin: 0;
    }

    /* Product Card - Content 1 */
    main section.products .product-listing .content-1 {
        height: 264px;
        overflow: hidden;
        position: relative;

        /* background: var(--color-background); */
        /* border-bottom: 1px solid var(--bs-card-border-color) !important; */
    }

    main section.products .product-listing .content-1 img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        transition: transform 0.5s ease;
    }

    main section.products .product-listing .content-1:hover img {
        transform: scale(1.1);
    }

    main section.products .product-listing .content-1 .product-tag {
        position: absolute;
        bottom: 15px;
        left: 15px;
    }

    main section.products .product-listing .content-1 .product-price {
        position: absolute;
        top: 15px;
        right: 15px;
        color: var(--color-dark);
        font-weight: 700;
        font-size: 1.2rem;
        background-color: var(--color-background-variant);
        padding: 5px 10px;
        border-radius: 3px;
    }

    /* Product Card - Content 1 END */

    /* Product Card - Content 2 */
    main section.products .product-listing .content-2 {
        padding: 1.3rem;

        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: start;
        gap: 1rem;
    }

    main section.products .product-listing .content-2 .meta {
        /* position: absolute;
        top: 15px;
        left: 15px;
        padding: 5px 10px; */
        display: flex;
        flex-direction: row;
        gap: 0.5rem;
        background-color: rgba(255, 255, 255, 0.85);
        border-radius: 3px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    main section.products .product-listing .content-2 .meta .vr-line {
        width: 1px;
        background-color: var(--color-dark);
    }

    main section.products .product-listing .content-2 .product-title {
        font-size: 1.4rem;
        font-weight: bold;
        color: var(--color-dark);
    }

    main section.products .product-listing .content-2 .paragraph {
        font-size: 0.95rem;
    }

    main section.products .product-listing .content-2 .product-specs {
        display: flex;
        flex-wrap: wrap;
        gap: 10px 20px;
        line-height: 1.3;

        border-bottom: 1px solid var(--bs-card-border-color) !important;
        padding-bottom: 1.6rem;
    }

    main section.products .product-listing .content-2 .product-spec-item {
        display: flex;
        align-items: center;
        font-size: 0.9rem;
        color: var(--color-text);
    }

    main section.products .product-listing .content-2 .product-spec-item i {
        margin-right: 5px;
        color: var(--color-primary);
    }

    main section.products .product-listing .content-2 .product-footer {
        margin-top: 0.6rem;
        border-top: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;

        width: 100%;
    }

    main section.products .product-listing .content-2 .product-footer .learnmore {
        text-wrap: nowrap;
        flex: 1;
    }

    main section.products .product-listing .content-2 .product-footer .add-to-cart-btn {
        text-wrap: nowrap;
        width: 26%;
        margin-left: 0.6rem;
    }

    /* Product Card - Content 2 END */
</style>

<!-- Products Section -->
<section class="products">
    <div class="container-xl">

        <!-- Only display section title if on the 'landing' app path -->
        <?php if (uriAppPath('landing')): ?>
            <div class="section-title">
                <span class="sub-title">Products</span>
                <h2>What We Offer</h2>
                <p>Comprehensive pet Supply for your beloved pets</p>
            </div>
        <?php endif; ?>

        <div class="header">
            <!-- Filter Bar -->
            <div class="filter-bar">
                <button class="ui mini button active">Show All</button>
                <button class="ui mini button">Dog Food</button>
                <button class="ui mini button">Cat Food</button>
                <button class="ui mini button">Supplements</button>
                <button class="ui mini button">Accessories</button>
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
                            <i class="sort amount down icon"></i>Price: Low to
                            High
                        </div>
                        <div class="item" data-value="price-high">
                            <i class="sort amount up icon"></i>Price: High to
                            Low
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
                    <input class="prompt" type="text" placeholder="Search for products...">
                    <i class="search icon"></i>
                </div>
                <div class="results"></div>
            </div>
        </div>
        <!-- Products Grid -->
        <div class="products-grid">
            <div class="row g-4">

                <!-- Product 1 -->
                <div class="col-md-4">
                    <div class="product-listing card">
                        <div class="card-body">
                            <div class="content-1">
                                <img src="<?= asset('img/contents/products/pdogfood.jpg'); ?>" alt="Premium Dog Food"
                                    class="product-image">
                                <div class="product-tag">
                                    <div class="ui tag label red">Hot</div>
                                    <!-- <div class="title">Premium Dry Dog Food</div> -->
                                </div>
                                <div class="product-price">₱22.99</div>
                            </div>
                            <div class="content-2">
                                <h3 class="product-title">Premium Dry Dog Food</h3>
                                <div class="meta">
                                    <div class="rating">
                                        Rating:&nbsp;
                                        <div class="ui yellow disabled rating" data-rating="3" data-max-rating="5">
                                        </div>
                                    </div>
                                    <div class="vr-line"></div>
                                    <div class="category">
                                        <i class="tag icon"></i>
                                        Dog Food
                                    </div>
                                </div>
                                <p class="paragraph">
                                    High-quality dry dog food with balanced nutrition for adult dogs.
                                    Contains chicken, rice, and essential vitamins.
                                </p>
                                <div class="product-specs">
                                    <div class="product-spec-item">
                                        <i class="weight icon"></i> Weight: 8 kg
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="heartbeat icon"></i> Life Stage: Adult
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="paw icon"></i> Breed: All
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="food icon"></i> Flavor: Chicken
                                    </div>
                                </div>
                                <div class="product-footer">
                                    <div class="learnmore">
                                        <a class="ui teal button learnmore-btn" href="#">Learn
                                            More</a>
                                    </div>
                                    <div class="ui mini icon buttons">
                                        <button class="ui button decrease-quantity">
                                            <i class="minus icon"></i>
                                        </button>
                                        <div class="ui disabled button quantity-value">1</div>
                                        <button class="ui button increase-quantity">
                                            <i class="plus icon"></i>
                                        </button>
                                    </div>
                                    <div class="ui vertical animated button add-to-cart-btn" tabindex="0">
                                        <div class="hidden content">Add to Cart</div>
                                        <div class="visible content">
                                            <i class="shop icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="col-md-4">
                    <div class="product-listing card">
                        <div class="card-body">
                            <div class="content-1">
                                <img src="<?= asset('img/contents/products/vitamins.jpg'); ?>" alt="Pet Vitamins"
                                    class="product-image">
                                <div class="product-tag">
                                    <div class="ui tag label teal">Popular</div>
                                </div>
                                <div class="product-price">₱18.50</div>
                            </div>
                            <div class="content-2">
                                <h3 class="product-title">Joint Health Supplements</h3>
                                <div class="meta">
                                    <div class="rating">
                                        Rating:&nbsp;
                                        <div class="ui yellow disabled rating" data-rating="4.5" data-max-rating="5">
                                        </div>
                                    </div>
                                    <div class="vr-line"></div>
                                    <div class="category">
                                        <i class="tag icon"></i>
                                        Supplements
                                    </div>
                                </div>
                                <p class="paragraph">
                                    Support your pet's joint health with these premium supplements.
                                    Ideal for senior pets or those with mobility issues.
                                </p>
                                <div class="product-specs">
                                    <div class="product-spec-item">
                                        <i class="tablets icon"></i> Count: 60 tablets
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="heartbeat icon"></i> Life Stage: Senior
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="paw icon"></i> For: Dogs & Cats
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="certificate icon"></i> Organic: Yes
                                    </div>
                                </div>
                                <div class="product-footer">
                                    <div class="learnmore">
                                        <a class="ui teal button learnmore-btn" href="#">Learn
                                            More</a>
                                    </div>
                                    <div class="ui mini icon buttons">
                                        <button class="ui button decrease-quantity">
                                            <i class="minus icon"></i>
                                        </button>
                                        <div class="ui disabled button quantity-value">1</div>
                                        <button class="ui button increase-quantity">
                                            <i class="plus icon"></i>
                                        </button>
                                    </div>
                                    <div class="ui vertical animated button add-to-cart-btn" tabindex="0">
                                        <div class="hidden content">Add to Cart</div>
                                        <div class="visible content">
                                            <i class="shop icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="col-md-4">
                    <div class="product-listing card">
                        <div class="card-body">
                            <div class="content-1">
                                <img src="<?= asset('img/contents/products/petcollar.jpg'); ?>" alt="Pet Collar"
                                    class="product-image">
                                <div class="product-tag">
                                    <div class="ui tag blue label">Featured</div>
                                </div>
                                <div class="product-price">₱14.99</div>
                            </div>
                            <div class="content-2">
                                <h3 class="product-title">Adjustable Comfort Collar</h3>
                                <div class="meta">
                                    <div class="rating">
                                        Rating:&nbsp;
                                        <div class="ui yellow disabled rating" data-rating="5" data-max-rating="5">
                                        </div>
                                    </div>
                                    <div class="vr-line"></div>
                                    <div class="category">
                                        <i class="tag icon"></i>
                                        Accessories
                                    </div>
                                </div>
                                <p class="paragraph">
                                    Comfortable, durable collar with adjustable sizing.
                                    Available in multiple colors to suit your pet's style. Lorem ipsum dolor sit amet.
                                </p>
                                <div class="product-specs">
                                    <div class="product-spec-item">
                                        <i class="ruler icon"></i> Size: Medium
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="palette icon"></i> Colors: 4 options
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="paw icon"></i> For: Dogs
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="tag icon"></i> Material: Nylon
                                    </div>
                                </div>
                                <div class="product-footer">
                                    <div class="learnmore">
                                        <a class="ui teal button learnmore-btn" href="#">Learn
                                            More</a>
                                    </div>
                                    <div class="ui mini icon buttons">
                                        <button class="ui button decrease-quantity">
                                            <i class="minus icon"></i>
                                        </button>
                                        <div class="ui disabled button quantity-value">1</div>
                                        <button class="ui button increase-quantity">
                                            <i class="plus icon"></i>
                                        </button>
                                    </div>
                                    <div class="ui vertical animated button add-to-cart-btn" tabindex="0">
                                        <div class="hidden content">Add to Cart</div>
                                        <div class="visible content">
                                            <i class="shop icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="col-md-4">
                    <div class="product-listing card">
                        <div class="card-body">
                            <div class="content-1">
                                <img src="<?= asset('img/contents/products/supplements.jpg'); ?>" alt="Cat Food"
                                    class="product-image">
                                <div class="product-tag">
                                    <div class="ui tag label">New</div>
                                </div>
                                <div class="product-price">₱25.75</div>
                            </div>
                            <div class="content-2">
                                <h3 class="product-title">Grain-Free Cat Food</h3>
                                <div class="meta">
                                    <div class="rating">
                                        Rating:&nbsp;
                                        <div class="ui yellow disabled rating" data-rating="3" data-max-rating="5">
                                        </div>
                                    </div>
                                    <div class="vr-line"></div>
                                    <div class="category">
                                        <i class="tag icon"></i>
                                        Cat Food
                                    </div>
                                </div>
                                <p class="paragraph">
                                    Premium grain-free formula specially designed for cats of all ages.
                                    Rich in salmon for a healthy coat and optimal nutrition.
                                </p>
                                <div class="product-specs">
                                    <div class="product-spec-item">
                                        <i class="weight icon"></i> Weight: 5 kg
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="heartbeat icon"></i> Life Stage: All Ages
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="paw icon"></i> Breed: All
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="food icon"></i> Flavor: Salmon
                                    </div>
                                </div>
                                <div class="product-footer">
                                    <div class="learnmore">
                                        <a class="ui teal button learnmore-btn" href="#">Learn
                                            More</a>
                                    </div>
                                    <div class="ui mini icon buttons">
                                        <button class="ui button decrease-quantity">
                                            <i class="minus icon"></i>
                                        </button>
                                        <div class="ui disabled button quantity-value">1</div>
                                        <button class="ui button increase-quantity">
                                            <i class="plus icon"></i>
                                        </button>
                                    </div>
                                    <div class="ui vertical animated button add-to-cart-btn" tabindex="0">
                                        <div class="hidden content">Add to Cart</div>
                                        <div class="visible content">
                                            <i class="shop icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 5 -->
                <div class="col-md-4">
                    <div class="product-listing card">
                        <div class="card-body">
                            <div class="content-1">
                                <img src="<?= asset('img/contents/products/pet-accessories.jpg'); ?>" alt="Pet Bed"
                                    class="product-image">
                                <div class="product-tag">
                                    <div class="ui tag label orange">Limited</div>
                                </div>
                                <div class="product-price">₱49.99</div>
                            </div>
                            <div class="content-2">
                                <h3 class="product-title">Orthopedic Pet Bed</h3>
                                <div class="meta">
                                    <div class="rating">
                                        Rating:&nbsp;
                                        <div class="ui yellow disabled rating" data-rating="3.5" data-max-rating="5">
                                        </div>
                                    </div>
                                    <div class="vr-line"></div>
                                    <div class="category">
                                        <i class="tag icon"></i>
                                        Accessories
                                    </div>
                                </div>
                                <p class="paragraph">
                                    Luxurious orthopedic bed that provides superior comfort and support.
                                    Perfect for pets with joint issues or senior animals.
                                </p>
                                <div class="product-specs">
                                    <div class="product-spec-item">
                                        <i class="ruler icon"></i> Size: Large
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="palette icon"></i> Colors: Beige
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="paw icon"></i> For: Dogs & Cats
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="home icon"></i> Washable: Yes
                                    </div>
                                </div>
                                <div class="product-footer">
                                    <div class="learnmore">
                                        <a class="ui teal button learnmore-btn" href="#">Learn
                                            More</a>
                                    </div>
                                    <div class="ui mini icon buttons">
                                        <button class="ui button decrease-quantity">
                                            <i class="minus icon"></i>
                                        </button>
                                        <div class="ui disabled button quantity-value">1</div>
                                        <button class="ui button increase-quantity">
                                            <i class="plus icon"></i>
                                        </button>
                                    </div>
                                    <div class="ui vertical animated button add-to-cart-btn" tabindex="0">
                                        <div class="hidden content">Add to Cart</div>
                                        <div class="visible content">
                                            <i class="shop icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product 6 -->
                <div class="col-md-4">
                    <div class="product-listing card">
                        <div class="card-body">
                            <div class="content-1">
                                <img src="<?= asset('img/contents/products/petfood.jpg'); ?>" alt="Puppy Food"
                                    class="product-image">
                                <div class="product-tag">
                                    <div class="ui tag label teal">Popular</div>
                                </div>
                                <div class="product-price">₱28.50</div>
                            </div>
                            <div class="content-2">
                                <h3 class="product-title">Puppy Growth Formula</h3>
                                <div class="meta">
                                    <div class="rating">
                                        Rating:&nbsp;
                                        <div class="ui yellow disabled rating" data-rating="5" data-max-rating="5">
                                        </div>
                                    </div>
                                    <div class="vr-line"></div>
                                    <div class="category">
                                        <i class="tag icon"></i>
                                        Dog Food
                                    </div>
                                </div>
                                <p class="paragraph">
                                    Specially formulated for growing puppies with essential nutrients
                                    to support healthy development and strong immune systems.
                                </p>
                                <div class="product-specs">
                                    <div class="product-spec-item">
                                        <i class="weight icon"></i> Weight: 6 kg
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="heartbeat icon"></i> Life Stage: Puppy
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="paw icon"></i> Breed: Small/Medium
                                    </div>
                                    <div class="product-spec-item">
                                        <i class="food icon"></i> Flavor: Beef & Rice
                                    </div>
                                </div>
                                <div class="product-footer">
                                    <div class="learnmore">
                                        <a class="ui teal button learnmore-btn" href="#">Learn
                                            More</a>
                                    </div>
                                    <div class="ui mini icon buttons">
                                        <button class="ui button decrease-quantity">
                                            <i class="minus icon"></i>
                                        </button>
                                        <div class="ui disabled button quantity-value">1</div>
                                        <button class="ui button increase-quantity">
                                            <i class="plus icon"></i>
                                        </button>
                                    </div>
                                    <div class="ui vertical animated button add-to-cart-btn" tabindex="0">
                                        <div class="hidden content">Add to Cart</div>
                                        <div class="visible content">
                                            <i class="shop icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagination START -->
            <?= shared('pagination'); ?>
            <!-- Pagination END -->
        </div>
    </div>
</section>