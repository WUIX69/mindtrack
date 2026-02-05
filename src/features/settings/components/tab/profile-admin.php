<style>
    main section.settings .avatar-upload {
        position: relative;
        max-width: 200px;
        margin: 0 auto 2rem;
    }

    main section.settings .avatar-upload img {
        width: 200px;
        height: 200px;
        border-radius: 50% !important;
        object-fit: cover !important;
        border: 3px solid #fff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    main section.settings .avatar-upload .upload-button {
        position: absolute;
        right: 10px;
        bottom: 10px;
        width: 40px;
        height: 40px;
        background: #21BA45;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    main section.settings .avatar-upload .upload-button i {
        margin: 0;
    }

    main section.settings .avatar-upload .upload-button:hover {
        transform: scale(1.1);
    }
</style>
<div class="tab-pane fade show active" id="profile">
    <div class="tab-header">
        <h3 class="ui header">Profile</h3>
        <p>This is how others will see you on the site.</p>
    </div>
    <div class="section-divider"></div>
    <form class="ui form">
        <!-- Profile Picture -->
        <div class="avatar-upload">
            <img src="<?= asset('img/profiles/user-1.jpg'); ?>" alt="Profile Picture">
            <div class="upload-button">
                <i class="camera icon"></i>
            </div>
        </div>

        <!-- Username -->
        <div class="field">
            <label>Username</label>
            <input type="text" placeholder="Enter your username">
            <div class="ui small text">
                This is your public display name. It can be your real name or a
                pseudonym.
            </div>
        </div>

        <!-- Password -->
        <div class="field">
            <label>Password</label>
            <input type="password" placeholder="Enter new password">
            <div class="ui small text">
                Your password must be at least 8 characters long.
            </div>
        </div>

        <!-- Email -->
        <div class="field">
            <label>Email Address</label>
            <input type="email" placeholder="Enter your email">
            <div class="ui small text">
                You can manage verified email addresses in your email settings.
            </div>
        </div>

        <!-- Bio -->
        <div class="field">
            <label>Bio</label>
            <textarea rows="4" placeholder="Enter your bio"></textarea>
            <div class="ui small text">
                Tell us about yourself. You can @mention other users.
            </div>
        </div>

        <!-- URLs -->
        <div class="field">
            <label>URLs</label>
            <div class="ui small text">Add links to your website or social media
                profiles.</div>
            <div class="fields mt-2">
                <div class="sixteen wide field url-inputs">
                    <input type="url" placeholder="Enter your URL">
                    <input type="url" placeholder="Enter your URL">
                    <input type="url" placeholder="Enter your URL">
                </div>
            </div>
            <button type="button" class="ui basic teal icon compact button add-url-btn">
                <i class="plus icon"></i> Add URL
            </button>
        </div>
        <div class="actions mt-4">
            <button class="ui primary submit button" type="submit">Save
                Changes</button>
        </div>
    </form>
</div>