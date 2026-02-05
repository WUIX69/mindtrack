<style>
    main section.new-users .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }

    main section.new-users .user {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    main section.new-users .user img {
        width: 90px;
        border: var(--img-border) !important;
    }

    main section.new-users .user label {
        font-weight: 600;
    }
</style>
<section class="new-users">
    <h2 class="title">New Users</h2>
    <div class="container box">
        <div class="user">
            <img src="<?= asset('img/profiles/user-1.jpg'); ?>" class="rounded-circle" alt="User avatar" />
            <label class="mt-2 name">John Doe</label>
            <small class="text-muted time-ago">2 mins ago</small>
        </div>
        <div class="user">
            <img src="<?= asset('img/profiles/user-2.jpg'); ?>" class="rounded-circle" alt="User avatar" />
            <label class="mt-2">John Doe</label>
            <small class="text-muted">5 mins ago</small>
        </div>
        <div class="user">
            <img src="<?= asset('img/profiles/user-3.jpg'); ?>" class="rounded-circle" alt="User avatar" />
            <label class="mt-2">John Doe</label>
            <small class="text-muted">15 mins ago</small>
        </div>
        <div class="user">
            <img src="<?= asset('img/profiles/user-4.jpg'); ?>" class="rounded-circle" alt="User avatar" />
            <label class="mt-2">John Doe</label>
            <small class="text-muted">42 mins ago</small>
        </div>
    </div>
</section>