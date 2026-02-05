<style>
    /* Recent Appointments Section */
    main section.recent-appointments .appointment-card {
        background-color: var(--color-white);
        border-radius: 0.6rem;
        padding: 1rem;
        margin-bottom: 1rem;
        border-left: 4px solid var(--color-primary);
        box-shadow: 0 0.2rem 0.5rem rgba(0, 0, 0, 0.03);
        transition: transform 0.2s ease;
    }

    main section.recent-appointments .appointment-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.3rem 0.8rem rgba(0, 0, 0, 0.08);
    }

    main section.recent-appointments .appointment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    main section.recent-appointments .appointment-time {
        font-size: 0.8rem;
        color: var(--color-dark-variant);
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    main section.recent-appointments .appointment-status {
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        border-radius: 1rem;
        font-weight: 500;
    }

    main section.recent-appointments .status-confirmed {
        background-color: #e3f2fd;
        color: #1976d2;
    }

    main section.recent-appointments .status-completed {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    main section.recent-appointments .status-cancelled {
        background-color: #ffebee;
        color: #c62828;
    }

    main section.recent-appointments .status-pending {
        background-color: #fff8e1;
        color: #f57c00;
    }

    main section.recent-appointments .appointment-patient {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    main section.recent-appointments .patient-avatar {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        background-color: var(--color-light);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    main section.recent-appointments .patient-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    main section.recent-appointments .patient-info h4 {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 0.2rem;
    }

    main section.recent-appointments .patient-info p {
        font-size: 0.8rem;
        color: var(--color-dark-variant);
    }

    main section.recent-appointments .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--color-dark);
    }
</style>
<section class="recent-appointments">
    <h3 class="section-title">Recent Appointments</h3>

    <div class="appointment-card">
        <div class="appointment-header">
            <div class="appointment-time">
                <i class="material-icons-sharp">today</i>
                Today, 10:00 AM
            </div>
            <span class="appointment-status status-completed">Completed</span>
        </div>
        <div class="appointment-patient">
            <div class="patient-avatar">
                <img src="<?= asset('img/avatars/jenny.jpg'); ?>" alt="Pet">
            </div>
            <div class="patient-info">
                <h4>Charlie (Beagle)</h4>
                <p>Vaccination</p>
            </div>
        </div>
    </div>

    <div class="appointment-card">
        <div class="appointment-header">
            <div class="appointment-time">
                <i class="material-icons-sharp">today</i>
                Today, 08:30 AM
            </div>
            <span class="appointment-status status-completed">Completed</span>
        </div>
        <div class="appointment-patient">
            <div class="patient-avatar">
                <img src="<?= asset('img/avatars/joe.jpg'); ?>" alt="Pet">
            </div>
            <div class="patient-info">
                <h4>Ruby (Maine Coon)</h4>
                <p>Check-up</p>
            </div>
        </div>
    </div>

    <div class="appointment-card">
        <div class="appointment-header">
            <div class="appointment-time">
                <i class="material-icons-sharp">event</i>
                Yesterday, 03:45 PM
            </div>
            <span class="appointment-status status-cancelled">Cancelled</span>
        </div>
        <div class="appointment-patient">
            <div class="patient-avatar">
                <img src="<?= asset('img/avatars/justen.jpg'); ?>" alt="Pet">
            </div>
            <div class="patient-info">
                <h4>Cooper (Bulldog)</h4>
                <p>Surgery</p>
            </div>
        </div>
    </div>

    <div class="appointment-card">
        <div class="appointment-header">
            <div class="appointment-time">
                <i class="material-icons-sharp">event</i>
                Yesterday, 11:30 AM
            </div>
            <span class="appointment-status status-completed">Completed</span>
        </div>
        <div class="appointment-patient">
            <div class="patient-avatar">
                <img src="<?= asset('img/avatars/nan.jpg'); ?>" alt="Pet">
            </div>
            <div class="patient-info">
                <h4>Daisy (Siamese Cat)</h4>
                <p>Grooming</p>
            </div>
        </div>
    </div>
</section>