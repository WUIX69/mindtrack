<div class="tab-pane fade" id="notification">
    <div class="tab-header">
        <h3 class="ui header">Notifications</h3>
        <p>Control your notification preferences.</p>
    </div>
    <div class="section-divider"></div>
    <form class="ui form">
        <!-- Email Notifications -->
        <h4 class="ui header">Email Notifications</h4>
        <div class="field">
            <div class="ui checkbox">
                <input type="checkbox" name="email_appointments" checked>
                <label>Appointment reminders</label>
            </div>
        </div>
        <div class="field">
            <div class="ui checkbox">
                <input type="checkbox" name="email_updates" checked>
                <label>System updates and announcements</label>
            </div>
        </div>
        <div class="field">
            <div class="ui checkbox">
                <input type="checkbox" name="email_marketing">
                <label>Marketing and promotional emails</label>
            </div>
        </div>

        <!-- Push Notifications -->
        <h4 class="ui header mt-4">Push Notifications</h4>
        <div class="field">
            <div class="ui checkbox">
                <input type="checkbox" name="push_messages" checked>
                <label>New messages</label>
            </div>
        </div>
        <div class="field">
            <div class="ui checkbox">
                <input type="checkbox" name="push_appointments" checked>
                <label>Appointment alerts</label>
            </div>
        </div>
        <div class="field">
            <div class="ui checkbox">
                <input type="checkbox" name="push_updates">
                <label>System updates</label>
            </div>
        </div>

        <!-- Notification Frequency -->
        <h4 class="ui header mt-4">Notification Frequency</h4>
        <div class="field">
            <label>Email Digest Frequency</label>
            <div class="ui selection dropdown">
                <input type="hidden" name="email_frequency">
                <i class="dropdown icon"></i>
                <div class="default text">Select Frequency</div>
                <div class="menu">
                    <div class="item" data-value="immediately">Immediately</div>
                    <div class="item" data-value="daily">Daily Digest</div>
                    <div class="item" data-value="weekly">Weekly Digest</div>
                    <div class="item" data-value="never">Never</div>
                </div>
            </div>
        </div>

        <div class="actions mt-4">
            <button class="ui primary button" type="submit">Save Notification
                Settings</button>
        </div>
    </form>
</div>