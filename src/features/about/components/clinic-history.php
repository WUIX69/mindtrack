<style>
    /*----------- MAIN (Clinic History) -----------*/
    main section.clinic-history {
        background: var(--color-white);
    }

    main section.clinic-history .history-image {
        width: 100%;
        border-radius: 10px;
        box-shadow: var(--box-shadow);
    }

    main section.clinic-history .history-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    main section.clinic-history h2 {
        color: var(--color-dark);
        font-size: 2rem;
        margin-bottom: 25px;
        font-weight: 600;
    }

    main section.clinic-history p {
        color: var(--color-dark-variant);
        line-height: 1.8;
        font-size: 1.1rem;
        margin-bottom: 15px;
    }
</style>
<!-- Clinic History -->
<section class="clinic-history">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-6">
                <img src="<?= asset('img/contents/bg_log.jpg'); ?>" alt="Mindtrack Clinic" class="history-image">
            </div>
            <div class="col-md-6">
                <h2>Our Journey</h2>
                <p>Founded by Dr. Josephine Anne Angeles in 2010, Mindtrack has grown from a small
                    neighborhood clinic into a trusted veterinary care center in San Jose Del Monte,
                    Bulacan. Our commitment to providing exceptional care and building lasting
                    relationships with pets and their families has made us one of the most trusted
                    veterinary clinics in the region.</p>
                <p>We believe in combining modern veterinary medicine with compassionate care, ensuring
                    that every pet receives the highest quality treatment in a warm and welcoming
                    environment.</p>
            </div>
        </div>
    </div>
</section>