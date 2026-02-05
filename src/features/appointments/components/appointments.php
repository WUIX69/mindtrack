<style>
    /**
     * Appointments Navigation START
     */
    main section.appointments .navigation {
        padding: 1.6rem !important;
    }

    main section.appointments .navigation .nav-pills {
        background: var(--color-white);
        display: flex !important;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin: 0;
    }

    main section.appointments .navigation .nav-pills .nav-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.7rem;

        padding: 1rem 1.5rem;
        border-radius: 1rem;
        transition: all 0.3s ease;
        text-align: center;
        cursor: pointer;
        width: 100%;
        color: var(--color-dark);
    }

    main section.appointments .navigation .nav-pills .nav-link:hover {
        background-color: rgba(0, 0, 0, .03);
    }

    main section.appointments .navigation .nav-pills .nav-link.active {
        background-color: var(--color-dark-variant);
        color: var(--color-white);
        box-shadow: 0 4px 15px rgba(33, 186, 69, 0.2);
    }

    main section.appointments .navigation .nav-pills .nav-link i {
        font-size: 1.4rem;
    }

    /**
     * Appointments Navigation END
     */

    /**
     * Upcoming Appointments Section START
     */
    main section.appointments .date-separator {
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--color-dark-variant);
        margin: 1rem 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    main section.appointments .date-separator::after {
        content: "";
        flex: 1;
        height: 1px;
        background-color: var(--color-light);
    }

    main section.appointments .appointment-card {
        background-color: var(--color-white);
        border-radius: 0.6rem;
        padding: 1rem;
        margin-bottom: 1rem;
        border-left: 4px solid var(--color-primary);
        box-shadow: 0 0.2rem 0.5rem rgba(0, 0, 0, 0.03);
        transition: transform 0.2s ease;
    }

    main section.appointments .appointment-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.3rem 0.8rem rgba(0, 0, 0, 0.08);
    }

    main section.appointments .appointment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    main section.appointments .appointment-time {
        font-size: 0.8rem;
        color: var(--color-dark-variant);
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    main section.appointments .appointment-status {
        font-size: 0.7rem;
        padding: 0.2rem 0.5rem;
        border-radius: 1rem;
        font-weight: 500;
    }

    main section.appointments .status-confirmed {
        background-color: #e3f2fd;
        color: #1976d2;
    }

    main section.appointments .status-completed {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    main section.appointments .status-cancelled {
        background-color: #ffebee;
        color: #c62828;
    }

    main section.appointments .status-pending {
        background-color: #fff8e1;
        color: #f57c00;
    }

    main section.appointments .appointment-patient {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    main section.appointments .patient-avatar {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        background-color: var(--color-light);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    main section.appointments .patient-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    main section.appointments .patient-info h4 {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 0.2rem;
    }

    main section.appointments .patient-info p {
        font-size: 0.8rem;
        color: var(--color-dark-variant);
    }

    main section.appointments .appointment-service {
        font-size: 0.85rem;
        color: var(--color-dark);
        margin-bottom: 0.75rem;
    }

    main section.appointments .appointment-actions {
        display: flex;
        gap: 0.5rem;
    }

    main section.appointments .action-btn {
        border: none;
        background-color: var(--color-light);
        border-radius: 0.4rem;
        padding: 0.4rem 0.6rem;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    main section.appointments .action-btn:hover {
        background-color: var(--color-primary-light);
    }

    main section.appointments .action-btn.primary {
        background-color: var(--color-primary);
        color: white;
    }

    main section.appointments .action-btn.primary:hover {
        background-color: var(--color-primary-dark);
    }

    main section.appointments .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--color-dark);
    }

    /**
     * Upcoming Appointments Section END
     */
</style>

<section class="appointments">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card navigation">
                <div class="nav flex-column nav-pills card-body" role="tablist">
                    <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#all">
                        <i class="bx bx-calendar"></i>All Appointments
                    </button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pending">
                        <i class="bx bx-time-five"></i>Pending
                    </button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#confirmed">
                        <i class="bx bx-check-circle"></i>Confirmed
                    </button>
                    <button class="nav-link" data-bs-toggle="pill" data-bs-target="#cancelled">
                        <i class="bx bx-x-circle"></i>Cancelled
                    </button>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="tab-content container">
                <!-- All Appointments -->
                <div class="tab-pane fade show active" id="all">
                    <h3 class="section-title">All Appointments</h3>
                    <div class="date-separator">Morning</div>

                    <div class="appointment-card">
                        <div class="appointment-header">
                            <div class="appointment-time">
                                <i class="material-icons-sharp">schedule</i>
                                09:00 AM
                            </div>
                            <span class="appointment-status status-confirmed">Confirmed</span>
                        </div>
                        <div class="appointment-patient">
                            <div class="patient-avatar">
                                <img src="<?= asset('img/avatars/chris.jpg'); ?>" alt="Pet">
                            </div>
                            <div class="patient-info">
                                <h4>Max (Golden Retriever)</h4>
                                <p>Owner: John Smith</p>
                            </div>
                        </div>
                        <div class="appointment-service">
                            <strong>Service:</strong> Vaccination
                        </div>
                        <div class="appointment-actions">
                            <button class="ui action-btn green button">Confirm</button>
                            <button class="ui action-btn blue button">Reschedule</button>
                            <button class="ui action-btn red button">Cancel</button>
                        </div>
                    </div>

                    <div class="appointment-card">
                        <div class="appointment-header">
                            <div class="appointment-time">
                                <i class="material-icons-sharp">schedule</i>
                                10:30 AM
                            </div>
                            <span class="appointment-status status-pending">Pending</span>
                        </div>
                        <div class="appointment-patient">
                            <div class="patient-avatar">
                                <img src="<?= asset('img/avatars/elliot.jpg'); ?>" alt="Pet">
                            </div>
                            <div class="patient-info">
                                <h4>Luna (Persian Cat)</h4>
                                <p>Owner: Sarah Johnson</p>
                            </div>
                        </div>
                        <div class="appointment-service">
                            <strong>Service:</strong> Routine Check-up
                        </div>
                        <div class="appointment-actions">
                            <button class="ui action-btn green button">Confirm</button>
                            <button class="ui action-btn blue button">Reschedule</button>
                            <button class="ui action-btn red button">Cancel</button>
                        </div>
                    </div>

                    <div class="date-separator">Afternoon</div>

                    <div class="appointment-card">
                        <div class="appointment-header">
                            <div class="appointment-time">
                                <i class="material-icons-sharp">schedule</i>
                                01:15 PM
                            </div>
                            <span class="appointment-status status-confirmed">Confirmed</span>
                        </div>
                        <div class="appointment-patient">
                            <div class="patient-avatar">
                                <img src="<?= asset('img/avatars/helen.jpg'); ?>" alt="Pet">
                            </div>
                            <div class="patient-info">
                                <h4>Bella (Labrador)</h4>
                                <p>Owner: Michael Brown</p>
                            </div>
                        </div>
                        <div class="appointment-service">
                            <strong>Service:</strong> Dental Cleaning
                        </div>
                        <div class="appointment-actions">
                            <button class="ui action-btn green button">Confirm</button>
                            <button class="ui action-btn blue button">Reschedule</button>
                            <button class="ui action-btn red button">Cancel</button>
                        </div>
                    </div>
                </div>

                <!-- Pending Appointments -->
                <div class="tab-pane fade" id="pending">
                    <h3 class="section-title">Pending Appointments</h3>
                    <div class="date-separator">Morning</div>
                    <div class="appointment-card">
                        <div class="appointment-header">
                            <div class="appointment-time">
                                <i class="material-icons-sharp">schedule</i>
                                09:00 AM
                            </div>
                            <span class="appointment-status status-confirmed">Confirmed</span>
                        </div>
                        <div class="appointment-patient">
                            <div class="patient-avatar">
                                <img src="<?= asset('img/avatars/chris.jpg'); ?>" alt="Pet">
                            </div>
                            <div class="patient-info">
                                <h4>Max (Golden Retriever)</h4>
                                <p>Owner: John Smith</p>
                            </div>
                        </div>
                        <div class="appointment-service">
                            <strong>Service:</strong> Vaccination
                        </div>
                        <div class="appointment-actions">
                            <button class="ui action-btn green button">Confirm</button>
                            <button class="ui action-btn blue button">Reschedule</button>
                            <button class="ui action-btn red button">Cancel</button>
                        </div>
                    </div>
                </div>

                <!-- Confirmed Appointments -->
                <div class="tab-pane fade" id="confirmed">
                    <h3 class="section-title">Confirmed Appointments</h3>
                    <div class="date-separator">Morning</div>
                    <div class="appointment-card">
                        <div class="appointment-header">
                            <div class="appointment-time">
                                <i class="material-icons-sharp">schedule</i>
                                09:00 AM
                            </div>
                            <span class="appointment-status status-confirmed">Confirmed</span>
                        </div>
                        <div class="appointment-patient">
                            <div class="patient-avatar">
                                <img src="<?= asset('img/avatars/chris.jpg'); ?>" alt="Pet">
                            </div>
                            <div class="patient-info">
                                <h4>Max (Golden Retriever)</h4>
                                <p>Owner: John Smith</p>
                            </div>
                        </div>
                        <div class="appointment-service">
                            <strong>Service:</strong> Vaccination
                        </div>
                        <div class="appointment-actions">
                            <button class="ui action-btn green button">Confirm</button>
                            <button class="ui action-btn blue button">Reschedule</button>
                            <button class="ui action-btn red button">Cancel</button>
                        </div>
                    </div>
                </div>

                <!-- Cancelled Appointments -->
                <div class="tab-pane fade" id="cancelled">
                    <h3 class="section-title">Cancelled Appointments</h3>
                    <div class="date-separator">Morning</div>
                    <div class="appointment-card">
                        <div class="appointment-header">
                            <div class="appointment-time">
                                <i class="material-icons-sharp">schedule</i>
                                09:00 AM
                            </div>
                            <span class="appointment-status status-confirmed">Confirmed</span>
                        </div>
                        <div class="appointment-patient">
                            <div class="patient-avatar">
                                <img src="<?= asset('img/avatars/chris.jpg'); ?>" alt="Pet">
                            </div>
                            <div class="patient-info">
                                <h4>Max (Golden Retriever)</h4>
                                <p>Owner: John Smith</p>
                            </div>
                        </div>
                        <div class="appointment-service">
                            <strong>Service:</strong> Vaccination
                        </div>
                        <div class="appointment-actions">
                            <button class="ui action-btn green button">Confirm</button>
                            <button class="ui action-btn blue button">Reschedule</button>
                            <button class="ui action-btn red button">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pagination START -->
    <?= shared('components/pagination'); ?>
    <!-- Pagination END -->
</section>