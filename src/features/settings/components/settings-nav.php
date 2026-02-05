<style>
    main section.settings .settings-nav {
        background: var(--color-white);
        display: flex !important;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin: 0;
    }

    main section.settings .settings-nav .nav-link {
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

    main section.settings .settings-nav .nav-link:hover {
        background-color: rgba(0, 0, 0, .03);
    }

    main section.settings .settings-nav .nav-link.active {
        background-color: var(--color-dark-variant);
        color: var(--color-white);
        box-shadow: 0 4px 15px rgba(33, 186, 69, 0.2);
    }

    main section.settings .settings-nav .nav-link i {
        font-size: 1.4rem;
    }
</style>
<div class="card">
    <div class="nav flex-column nav-pills card-body settings-nav" role="tablist">
        <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#profile">
            <i class="bx bx-user-circle"></i>Profile
        </button>
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#changePassword">
            <i class="bx bx-shield-alt"></i>Change Password
        </button>
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#notification">
            <i class="bx bx-bell"></i>Notifications
        </button>
        <button class="nav-link" data-bs-toggle="pill" data-bs-target="#preferences">
            <i class="bx bx-cog"></i>Preferences
        </button>
    </div>
</div>