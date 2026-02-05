<style>
    /* Only style inside the custom-user-content area */
    .user-flyout .custom-user-content {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
        width: 100%;
        flex-direction: column;
        background: var(--color-background);
    }

    .user-flyout .custom-user-content .user-avatar {
        margin: 0 auto;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        border: 4px solid #e0e7ef;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .user-flyout .custom-user-content .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .user-flyout .custom-user-content .user-avatar .online-status {
        position: absolute;
        bottom: 10px;
        left: 18px;
        background: #21ba45;
        border-radius: 50%;
        border: 2px solid var(--color-background) !important;
        height: 30px;
        width: 30px;
    }

    .user-flyout .custom-user-content .user-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5em;
        margin-bottom: 1.2em;
    }


    .user-flyout .custom-user-content .user-header .user-name {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .user-flyout .custom-user-content .user-header .user-name span#name {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--color-dark);
        letter-spacing: -0.5px;
        text-align: center;
        text-transform: capitalize;
    }

    .user-flyout .custom-user-content .user-header .user-name #last-online {
        font-size: 0.8rem;
        color: #6b7280;
        font-weight: 500;
        text-align: center;
        text-transform: capitalize;
    }

    .user-flyout .custom-user-content .user-header .user-badges {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        gap: 0.5em;
    }


    .user-flyout .custom-user-content .user-meta {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        width: 100%;
        margin-bottom: 1.2em;
    }

    .user-flyout .custom-user-content .user-meta span {
        display: flex;
        align-items: center;
        gap: 0.5em;
        font-size: 1rem;
    }

    .user-flyout .custom-user-content .user-meta i {
        color: var(--color-dark-variant);
        font-size: 1.1em;
    }

    .user-flyout .custom-user-content .user-meta span[id] {
        color: var(--color-dark);
        font-weight: 500;
    }

    .user-flyout .custom-user-content .user-bio-section {
        width: 100%;
        background: var(--color-background);
        border-radius: 0.75rem;
        padding: 1.25rem 1rem;
        margin-top: 1.2rem;
        box-shadow: var(--box-shadow);
    }

    .user-flyout .custom-user-content .user-bio-header {
        font-size: 1.1rem;
        color: var(--color-dark-variant);
        font-weight: 600;
        margin-bottom: 0.5em;
        display: flex;
        align-items: center;
        gap: 0.5em;
    }

    .user-flyout .custom-user-content .user-bio-section p {
        color: var(--color-dark);
        font-size: 0.8rem;
        margin: 0;
        line-height: 1.6;
    }

    .user-flyout .custom-user-content .user-urls {
        width: 100%;
        background: var(--color-background);
        border-radius: 0.75rem;
        padding: 1.25rem 1rem;
        margin-top: 1.2rem;
        margin-bottom: 1.2rem;
        box-shadow: var(--box-shadow);
    }

    .user-flyout .custom-user-content .user-urls-header {
        font-size: 1.1rem;
        color: var(--color-dark-variant);
        font-weight: 600;
        margin-bottom: 0.5em;
        display: flex;
        align-items: center;
        gap: 0.5em;
    }

    .user-flyout .custom-user-content .user-urls-content {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75em;
    }
</style>
<div class="ui wide flyout user-flyout" id="userFlyout">
    <i class="close icon"></i>
    <div class="ui header">
        <!-- <i class="user icon"></i> -->
        <div class="content">View User</div>
    </div>
    <div class="scrolling content custom-user-content">
        <div class="user-avatar">
            <img id="profile" src="<?= asset('img/placeholders/image.png') ?>" alt="User Profile Image">
            <span class="online-status">
                <i class="circle icon" style="color: #21ba45;"></i>
            </span>
        </div>
        <div class="user-header">
            <div class="user-name">
                <span id="name">John Doe</span>
                <div id="last-online" title="Last Online">
                    <i class="circle icon" style="color: #a0aec0;"></i>
                    <span id="last-online-text">Last online: 2 mins ago</span>
                </div>
            </div>
            <div class="user-badges">
                <div title="Verified" class="ui mini label">
                    <i id="verified" class="check circle icon" style="color: #21ba45;"></i>
                    <span id="verified-text">Verified</span>
                </div>
                <div title="Top Contributor" class="ui mini label">
                    <i class="star icon" style="color: #fbbd08;"></i>
                    <span id="top-contributor-text">Top Contributor</span>
                </div>
                <div title="Premium User" class="ui mini label">
                    <i class="diamond icon" style="color: #a333c8;"></i>
                    <span id="premium-text">Premium User</span>
                </div>
            </div>
        </div>
        <div class="user-meta">
            <span><i class="user icon"></i><span id="role">Admin</span></span>
            <span><i class="envelope icon"></i><span id="email">john.doe@example.com</span></span>
            <span><i class="phone icon"></i><span id="telephone">+1234567890</span></span>
            <span><i class="birthday cake icon"></i><span id="dob">01/01/2000</span></span>
            <span><i class="map marker alternate icon"></i><span id="location">123 Main St, Anytown,
                    USA</span></span>
            <span><i class="clock outline icon"></i>Joined <span id="created_at">01/01/2000</span></span>
        </div>
        <div class="user-urls">
            <div class="user-urls-header">
                <i class="linkify icon"></i>
                <span>URLs</span>
            </div>
            <div class="user-urls-content">
                <a class="ui circular facebook icon button" target="_blank" href="javascript:void(0)">
                    <i class="facebook icon"></i>
                </a>
                <a class="ui circular twitter icon button" target="_blank" href="javascript:void(0)">
                    <i class="twitter icon"></i>
                </a>
                <a class="ui circular linkedin icon button" target="_blank" href="javascript:void(0)">
                    <i class="linkedin icon"></i>
                </a>
                <a class="ui circular google plus icon button" target="_blank" href="javascript:void(0)">
                    <i class="google plus icon"></i>
                </a>
            </div>
        </div>
        <div class="user-bio-section">
            <div class="user-bio-header">
                <i class="info circle icon"></i>
                <span>Bio</span>
            </div>
            <p><span id="bio">No bio provided.</span></p>
        </div>
    </div>
    <div class="actions">
        <div class="ui red cancel button">
            <i class="remove icon"></i>
            No
        </div>
        <div class="ui green ok button">
            <i class="checkmark icon"></i>
            Yes
        </div>
    </div>
</div>