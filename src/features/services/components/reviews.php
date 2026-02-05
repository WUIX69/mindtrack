<style>
    /* Reviews Section Styles */
    section.reviews {
        background: var(--color-background);
    }

    section.reviews .header {
        font-size: 2rem;
        font-weight: 800;
        text-align: left;

        border-bottom: 1px solid #eee !important;
        margin-bottom: 2rem;
        padding-bottom: 1.6rem;
    }

    section.reviews .reviews-count {
        display: none;

        font-size: 1.2rem;
        font-weight: 600;
        color: var(--color-text);
        margin-bottom: 1.5rem;
    }

    section.reviews .review-list {
        position: relative;
    }

    /* Review Item */
    section.reviews .review-list .review-item {
        border-bottom: 1px solid var(--bs-border-color) !important;
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;

        display: flex;
        align-items: start;
        justify-content: center;
    }

    section.reviews .review-list .review-item:last-child {
        border-bottom: none !important;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    section.reviews .review-list .review-item .reviewer-img img {
        width: 86px;
        height: 86px;

        border: 1px solid var(--color-dark-variant) !important;

        object-fit: cover;
        object-position: center;
    }

    section.reviews .review-list .review-item .reviewer-name {
        display: flex;
        align-items: center;
        justify-content: start;
    }

    section.reviews .review-list .review-item .reviewer-name h5 {
        font-weight: 600;
        color: var(--color-dark);
    }

    section.reviews .review-list .review-item .reviewer-name .review-date {
        font-size: 0.83rem;
        flex: 1;
    }

    section.reviews .review-list .review-item .reviewer-name .rating {
        font-size: 0.83rem;
    }

    section.reviews .review-list .review-item .review-content p {
        font-size: 0.95rem;
        color: var(--color-dark);
    }

    /* Add Review Form */
    section.reviews .add-review {
        position: relative;
        background: var(--color-background-variant);
        border-radius: 0.5rem;
        padding: 1.6rem;
        height: 100%;
    }

    section.reviews .add-review .form-header p {
        font-size: 0.95rem;
        color: var(--color-dark);
    }

    section.reviews .add-review h4 {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--color-dark);
    }

    section.reviews .add-review form label {
        font-size: 0.86rem !important;
        font-weight: 600;
        color: var(--color-dark);
    }

    section.reviews .add-review form .field label[for="rating"],
    section.reviews .add-review form .field .ui.rating {
        font-size: 1rem !important;
    }
</style>

<!-- service  Reviews Section -->
<section class="reviews py-5">
    <div class="container-xl">
        <div class="header">
            Service Reviews
        </div>

        <div class="row">
            <!-- Left Column - Reviews List -->
            <div class="col-md-7">
                <div class="reviews-count">
                    4 reviews for Premium Grooming
                </div>

                <!-- Review List -->
                <div class="review-list">
                    <!-- Review 1 -->
                    <div class="review-item">
                        <div class="reviewer-img">
                            <img src="<?= asset('img/avatars/chris.jpg'); ?>" alt="Sarah Johnson"
                                class="rounded-circle">
                        </div>
                        <div class="review-content ms-3">
                            <div class="reviewer-name">
                                <h5 class="mb-0">Sarah Johnson</h5>
                                <span class="review-date ms-2 text-muted">- November 12, 2022</span>
                                <div class="ui yellow disabled rating ms-3" data-rating="4.5" data-max-rating="5">
                                </div>
                            </div>
                            <p class="mt-2">
                                The Premium Grooming service was fantastic! My golden retriever came out looking and
                                smelling amazing. The staff was gentle and attentive, and I appreciated the extra care
                                they took with his sensitive skin. Will definitely book again!
                            </p>
                        </div>
                    </div>

                    <!-- Review 2 -->
                    <div class="review-item">
                        <div class="reviewer-img">
                            <img src="<?= asset('img/avatars/elliot.jpg'); ?>" alt="Michael Davis"
                                class="rounded-circle">
                        </div>
                        <div class="review-content ms-3">
                            <div class="reviewer-name">
                                <h5 class="mb-0">Michael Davis</h5>
                                <span class="review-date ms-2 text-muted">- November 10, 2022</span>
                                <div class="ui yellow disabled rating ms-3" data-rating="5" data-max-rating="5"></div>
                            </div>
                            <p class="mt-2">
                                I brought my cat in for the dental cleaning service. The vet explained everything
                                clearly and made sure my cat was comfortable throughout. The results were great—her
                                teeth look so much healthier now. Highly recommend this clinic for dental care!
                            </p>
                        </div>
                    </div>

                    <!-- Review 3 -->
                    <div class="review-item">
                        <div class="reviewer-img">
                            <img src="<?= asset('img/avatars/helen.jpg'); ?>" alt="Emily Wilson" class="rounded-circle">
                        </div>
                        <div class="review-content ms-3">
                            <div class="reviewer-name">
                                <h5 class="mb-0">Emily Wilson</h5>
                                <span class="review-date ms-2 text-muted">- November 8, 2022</span>
                                <div class="ui yellow disabled rating ms-3" data-rating="4" data-max-rating="5"></div>
                            </div>
                            <p class="mt-2">
                                The vaccination service was quick and easy. The staff answered all my questions and made
                                my puppy feel at ease. The only downside was a short wait, but otherwise a great
                                experience!
                            </p>
                        </div>
                    </div>

                    <!-- Review 4 -->
                    <div class="review-item">
                        <div class="reviewer-img">
                            <img src="<?= asset('img/avatars/jenny.jpg'); ?>" alt="Robert Chen" class="rounded-circle">
                        </div>
                        <div class="review-content ms-3">
                            <div class="reviewer-name">
                                <h5 class="mb-0">Robert Chen</h5>
                                <span class="review-date ms-2 text-muted">- November 5, 2022</span>
                                <div class="ui yellow disabled rating ms-3" data-rating="4.5" data-max-rating="5"></div>
                            </div>
                            <p class="mt-2">
                                I used the boarding service for my dog while I was on vacation. The facility was clean
                                and the staff sent me daily updates and photos. My dog seemed happy and well cared for
                                when I picked him up. Would use this service again!
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Pagination Start -->
                <?= shared('components/pagination'); ?>
                <!-- Pagination End -->
            </div>

            <!-- Right Column - Review Form -->
            <div class="col-md-5">
                <!-- Add Review Form -->
                <div class="add-review">
                    <div class="form-header mb-4">
                        <h4>Add Your Review</h4>
                        <p class="text-muted">Your email address will not be published. Required fields are marked *</p>
                    </div>

                    <form action="#" method="post" class="ui form">
                        <div class="field">
                            <label for="rating">YOUR RATING</label>
                            <div class="ui yellow large star rating" data-max-rating="5"></div>
                        </div>

                        <div class="required field">
                            <label for="review-text">YOUR REVIEW</label>
                            <textarea name="review-text" rows="5"></textarea>
                        </div>

                        <div class="two fields">
                            <div class="required field">
                                <label for="name">YOUR NAME</label>
                                <input type="text" name="name" placeholder="Your Name">
                            </div>
                            <div class="required field">
                                <label for="email">YOUR EMAIL</label>
                                <input type="email" name="email" placeholder="Your Email">
                            </div>
                        </div>

                        <div class="two fields">
                            <div class="field">
                                <label for="subject">SUBJECT</label>
                                <input type="text" name="subject" placeholder="Subject">
                            </div>
                            <div class="field">
                                <label for="website">WEBSITE</label>
                                <input type="url" name="website" placeholder="Website">
                            </div>
                        </div>

                        <div class="actions mt-4">
                            <button type="submit" class="ui yellow button">Submit</button>
                            <button type="reset" class="ui clear basic button">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>