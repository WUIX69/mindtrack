<style>
    /* Most Booked Services Section - Card Style */
    main section.most-booked-services {
        margin: 2rem 0;
    }

    main section.most-booked-services .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--color-dark);
    }

    main section.most-booked-services .most-booked-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1.25rem;
    }

    main section.most-booked-services .most-booked-card {
        background-color: var(--color-white);
        border-radius: 0.6rem;
        padding: 1rem 1.25rem;
        box-shadow: 0 0.2rem 0.5rem rgba(0, 0, 0, 0.03);
        border-left: 4px solid var(--color-primary);
        display: flex;
        align-items: center;
        transition: transform 0.2s, box-shadow 0.2s;
        min-width: 0;
    }

    main section.most-booked-services .most-booked-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.3rem 0.8rem rgba(0, 0, 0, 0.08);
    }

    main section.most-booked-services .most-booked-card.top-service {
        border-left: 4px solid #1976d2;
        background: linear-gradient(90deg, #e3f2fd 0%, #fff 100%);
        box-shadow: 0 4px 24px rgba(25, 118, 210, 0.10);
        transform: scale(1.03);
        z-index: 1;
    }

    main section.most-booked-services .most-booked-icon {
        font-size: 2rem;
        margin-right: 1rem;
        color: #1976d2;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
    }

    main section.most-booked-services .most-booked-info {
        flex: 1;
        min-width: 0;
    }

    main section.most-booked-services .most-booked-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.2rem;
        color: var(--color-dark);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    main section.most-booked-services .most-booked-desc {
        font-size: 0.9rem;
        color: var(--color-dark-variant);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<section class="most-booked-services">
    <h2 class="title">Most Booked Services</h2>
    <div class="container most-booked-grid">
        <div class="most-booked-card">
            <div class="most-booked-icon"><i class="syringe icon"></i></div>
            <div class="most-booked-info">
                <div class="most-booked-title">Vaccination</div>
                <div class="most-booked-desc">86 bookings this month</div>
            </div>
        </div>
        <div class="most-booked-card">
            <div class="most-booked-icon"><i class="paw icon"></i></div>
            <div class="most-booked-info">
                <div class="most-booked-title">Pet Grooming</div>
                <div class="most-booked-desc">42 bookings this month</div>
            </div>
        </div>
        <div class="most-booked-card">
            <div class="most-booked-icon"><i class="tooth icon"></i></div>
            <div class="most-booked-info">
                <div class="most-booked-title">Dental Cleaning</div>
                <div class="most-booked-desc">29 bookings this month</div>
            </div>
        </div>
    </div>
</section>