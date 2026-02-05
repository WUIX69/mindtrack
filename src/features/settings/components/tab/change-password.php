<div class="tab-pane fade" id="changePassword">
    <div class="tab-header">
        <h3 class="ui header">Change Password</h3>
        <p>Update your account password below.</p>
    </div>
    <div class="section-divider"></div>
    <form class="ui form" id="changePasswordForm">
        <!-- Current Password -->
        <div class="field">
            <label for="current_password">Current Password</label>
            <input type="password" name="current_password" id="current_password"
                placeholder="Enter your current password" required>
        </div>
        <!-- New Password -->
        <div class="field">
            <label for="new_password">New Password</label>
            <input type="password" name="new_password" id="new_password" placeholder="Enter your new password" required>
        </div>
        <!-- Confirm New Password -->
        <div class="field">
            <label for="confirm_new_password">Confirm New Password</label>
            <input type="password" name="confirm_new_password" id="confirm_new_password"
                placeholder="Re-enter your new password" required>
        </div>
        <div class="actions mt-4">
            <button class="ui primary submit button" type="submit">Change Password</button>
            <button class="ui basic clear button" type="reset" style="margin-left: 10px;">Clear</button>
        </div>
    </form>
</div>