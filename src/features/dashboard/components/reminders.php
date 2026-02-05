<style>
    main section.reminders {
        margin-top: 1.7rem;
    }

    main section.reminders .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    main section.reminders .header span {
        padding: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        background-color: var(--color-white);
        border-radius: 50%;
    }

    main section.reminders .notification {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 0.6rem;
    }

    main section.reminders .notification .content {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    main section.reminders .notification .content .icon {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #ff4500;
        color: white;
        padding: 0.6rem;
        border-radius: 0.6rem;
    }

    main section.reminders .notification .details {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    main section.reminders .add-reminder {
        border: 2px dashed #6c9bcf !important;
        color: #6c9bcf;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        cursor: pointer;
    }

    main section.reminders .add-reminder h3 {
        color: inherit;
    }

    main section.reminders .add-reminder:hover {
        background-color: #6c9bcf;
        color: white;
    }
</style>
<section class="reminders">
    <div class="header">
        <h2 class="mt-2">Reminders</h2>
        <span class="material-icons-sharp">
            notifications_none
        </span>
    </div>

    <div class="notification box-tiny">
        <div class="content">
            <span class="material-icons-sharp icon">
                volume_up
            </span>
            <div class="info">
                <h3>Workshop</h3>
                <small class="text_muted">
                    08:00 AM - 12:00 PM
                </small>
            </div>
        </div>
        <div class="details">
            <span class="material-icons-sharp">
                more_vert
            </span>
        </div>
    </div>

    <div class="notification box-tiny deactive">
        <div class="content">
            <span class="material-icons-sharp icon">
                edit
            </span>
            <div class="info">
                <h3>Workshop</h3>
                <small class="text_muted">
                    08:00 AM - 12:00 PM
                </small>
            </div>
        </div>
        <div class="details">
            <span class="material-icons-sharp">
                more_vert
            </span>
        </div>
    </div>

    <div class="notification box-tiny add-reminder" data-open-modal="#reminderModal">
        <span class="material-icons-sharp"> add </span>
        <h3>Add Reminder</h3>
    </div>
</section>