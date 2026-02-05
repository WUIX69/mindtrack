<style>
    /* Calendar View Section */
    main section.calendar-view .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    main section.calendar-view .calendar-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--color-dark);
    }

    main section.calendar-view .calendar-nav {
        display: flex;
        gap: 0.5rem;
    }

    main section.calendar-view .calendar-nav-btn {
        background-color: var(--color-light);
        border: none;
        border-radius: 0.4rem;
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    main section.calendar-view .calendar-nav-btn:hover {
        background-color: var(--color-primary-light);
    }

    main section.calendar-view .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.5rem;
    }

    main section.calendar-view .calendar-weekday {
        text-align: center;
        font-weight: 500;
        color: var(--color-dark-variant);
        padding: 0.5rem;
    }

    main section.calendar-view .calendar-day {
        aspect-ratio: 1/1;
        border-radius: 0.5rem;
        padding: 0.5rem;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        cursor: pointer;
        border: 1px solid var(--color-light);
        transition: all 0.2s ease;
    }

    main section.calendar-view .calendar-day:hover {
        background-color: var(--color-light);
    }

    main section.calendar-view .calendar-day.has-appointments {
        border-color: var(--color-primary-light);
    }

    main section.calendar-view .calendar-day.active {
        background-color: var(--color-primary-light);
        color: var(--color-primary);
        font-weight: 500;
    }

    main section.calendar-view .calendar-day-number {
        font-size: 0.9rem;
        font-weight: 500;
        margin-bottom: 0.3rem;
    }

    main section.calendar-view .appointment-count {
        font-size: 0.7rem;
        background-color: var(--color-primary);
        color: white;
        border-radius: 1rem;
        padding: 0.1rem 0.4rem;
    }
</style>

<section class="calendar-view box">
    <div class="calendar-header">
        <h2 class="calendar-title">June 2023</h2>
        <div class="calendar-nav">
            <button class="calendar-nav-btn">
                <i class="material-icons-sharp">chevron_left</i>
            </button>
            <button class="calendar-nav-btn">
                <i class="material-icons-sharp">chevron_right</i>
            </button>
        </div>
    </div>
    <div class="calendar-grid">
        <!-- Weekday Headers -->
        <div class="calendar-weekday">Sun</div>
        <div class="calendar-weekday">Mon</div>
        <div class="calendar-weekday">Tue</div>
        <div class="calendar-weekday">Wed</div>
        <div class="calendar-weekday">Thu</div>
        <div class="calendar-weekday">Fri</div>
        <div class="calendar-weekday">Sat</div>

        <!-- Calendar Days -->
        <div class="calendar-day">
            <span class="calendar-day-number">28</span>
        </div>
        <div class="calendar-day">
            <span class="calendar-day-number">29</span>
        </div>
        <div class="calendar-day">
            <span class="calendar-day-number">30</span>
        </div>
        <div class="calendar-day">
            <span class="calendar-day-number">31</span>
        </div>
        <div class="calendar-day has-appointments">
            <span class="calendar-day-number">1</span>
            <span class="appointment-count">3</span>
        </div>
        <div class="calendar-day">
            <span class="calendar-day-number">2</span>
        </div>
        <div class="calendar-day">
            <span class="calendar-day-number">3</span>
        </div>

        <div class="calendar-day">
            <span class="calendar-day-number">4</span>
        </div>
        <div class="calendar-day has-appointments">
            <span class="calendar-day-number">5</span>
            <span class="appointment-count">2</span>
        </div>
        <div class="calendar-day">
            <span class="calendar-day-number">6</span>
        </div>
        <div class="calendar-day has-appointments">
            <span class="calendar-day-number">7</span>
            <span class="appointment-count">1</span>
        </div>
        <div class="calendar-day active">
            <span class="calendar-day-number">8</span>
            <span class="appointment-count">5</span>
        </div>
        <div class="calendar-day">
            <span class="calendar-day-number">9</span>
        </div>
        <div class="calendar-day">
            <span class="calendar-day-number">10</span>
        </div>

        <!-- Additional rows would continue... -->
    </div>
</section>