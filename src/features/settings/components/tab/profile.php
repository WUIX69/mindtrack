<style>
    main section.settings .avatar-upload {
        position: relative;
        max-width: 200px;
        margin: 2rem auto;
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

    main section.settings .ui.form .field .url-inputs {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.3rem;
    }

    main section.settings .ui.form .field .add-url-btn,
    main section.settings .ui.form .field .remove-url-btn {
        /* background: var(--color-background) !important;
        color: var(--color-dark-variant) !important;
        border: 1px solid rgba(0, 0, 0, 0.1) !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 0.4rem; */
        font-size: 0.7rem !important;
    }
</style>
<div class="tab-pane fade show active" id="profile">
    <div class="tab-header">
        <h3 class="ui header">Profile</h3>
        <p>This is how others will see you on the site.</p>
    </div>
    <div class="section-divider"></div>
    <form class="ui form" id="profileForm">
        <!-- Profile Upload -->
        <div class="field">
            <div class="avatar-upload">
                <input type="file" class="filepond profile-pond ignore" name="profile">
            </div>
        </div>

        <div class="two fields">
            <!-- Firstname -->
            <div class="field">
                <label for="firstname">Firstname *</label>
                <input type="text" placeholder="Enter your first name" name="firstname" value="">
                <div class="ui small text">
                    This is your first name. It will be visible to others on your profile.
                </div>
            </div>
            <!-- Lastname -->
            <div class="field">
                <label for="lastname">Lastname *</label>
                <input type="text" placeholder="Enter your last name" name="lastname" value="">
                <div class="ui small text">
                    This is your last name. It will be visible to others on your profile.
                </div>
            </div>
        </div>

        <div class="two fields">
            <!-- Telephone -->
            <div class="field">
                <label>Telephone *</label>
                <input type="tel" placeholder="Enter your telephone" name="telephone" value="">
                <div class="ui small text">
                    Your telephone number will be visible to others on your profile.
                </div>
            </div>
            <!-- Date of Birth -->
            <div class="field">
                <label>Date of Birth *</label>
                <input type="date" placeholder="Enter your date of birth" name="dob" value="">
                <div class="ui small text">
                    Your date of birth will be visible to others on your profile.
                </div>
            </div>
        </div>

        <!-- Email -->
        <div class="field">
            <label for="email">Email Address *</label>
            <input type="email" placeholder="Enter your email" name="email" value="">
            <div class="ui small text">
                You can manage verified email addresses in your email settings.
            </div>
        </div>

        <!-- Address -->
        <div class="field">
            <label for="location">Location *</label>
            <input type="text" placeholder="Enter your location" name="location" value="">
            <div class="ui small text">
                Your location will be visible to others on your profile.
            </div>
        </div>

        <!-- Bio -->
        <div class="field">
            <label for="bio">Bio <small class="text-muted">(optional)</small></label>
            <textarea rows="4" placeholder="Enter your bio" name="bio"></textarea>
            <div class="ui small text">
                Tell us about yourself. You can @mention other users.
            </div>
        </div>

        <!-- URLs -->
        <div class="field">
            <label for="urls">URLs <small class="text-muted">(optional)</small></label>
            <div class="ui small text">Add links to your website or social media
                profiles.</div>
            <div class="fields mt-2">
                <div class="sixteen wide field url-inputs">
                    <input type="url" placeholder="Enter your URL" name="urls[]">
                    <!-- Dynamically add URL input fields -->
                </div>
            </div>
            <div>
                <button type="button" class="ui basic teal icon compact button add-url-btn">
                    <i class="plus icon"></i> Add URL
                </button>
                <button type="button" class="ui basic red icon compact button remove-url-btn">
                    <i class="trash icon"></i> Remove URL
                </button>
            </div>
        </div>

        <div class="actions mt-4">
            <button class="ui primary submit button" type="submit">Save
                Changes</button>
        </div>
    </form>
</div>