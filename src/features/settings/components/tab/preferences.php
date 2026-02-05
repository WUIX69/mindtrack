<div class="tab-pane fade" id="preferences">
    <div class="tab-header">
        <h3 class="ui header">Preferences</h3>
        <p>Customize your experience.</p>
    </div>
    <div class="section-divider"></div>
    <form class="ui form">
        <!-- Theme Preferences -->
        <h4 class="ui header">Theme Settings</h4>
        <div class="field">
            <label>Display Mode</label>
            <div class="ui selection dropdown">
                <input type="hidden" name="theme_mode">
                <i class="dropdown icon"></i>
                <div class="default text">Select Mode</div>
                <div class="menu">
                    <div class="item" data-value="light">Light Mode</div>
                    <div class="item" data-value="dark">Dark Mode</div>
                    <div class="item" data-value="system">Use System Setting
                    </div>
                </div>
            </div>
        </div>

        <!-- Language Preferences -->
        <h4 class="ui header mt-4">Language & Region</h4>
        <div class="field">
            <label>Language</label>
            <div class="ui selection dropdown">
                <input type="hidden" name="language">
                <i class="dropdown icon"></i>
                <div class="default text">Select Language</div>
                <div class="menu">
                    <div class="item" data-value="en">English</div>
                    <div class="item" data-value="es">Spanish</div>
                    <div class="item" data-value="fr">French</div>
                    <div class="item" data-value="de">German</div>
                </div>
            </div>
        </div>

        <div class="field">
            <label>Time Format</label>
            <div class="ui selection dropdown">
                <input type="hidden" name="time_format">
                <i class="dropdown icon"></i>
                <div class="default text">Select Format</div>
                <div class="menu">
                    <div class="item" data-value="12h">12-hour (AM/PM)</div>
                    <div class="item" data-value="24h">24-hour</div>
                </div>
            </div>
        </div>

        <!-- Dashboard Preferences -->
        <h4 class="ui header mt-4">Dashboard Settings</h4>
        <div class="field">
            <div class="ui checkbox">
                <input type="checkbox" name="show_welcome" checked>
                <label>Show welcome message</label>
            </div>
        </div>
        <div class="field">
            <div class="ui checkbox">
                <input type="checkbox" name="show_quick_actions" checked>
                <label>Show quick action buttons</label>
            </div>
        </div>
        <div class="field">
            <div class="ui checkbox">
                <input type="checkbox" name="show_recent_activity" checked>
                <label>Show recent activity</label>
            </div>
        </div>

        <div class="field">
            <label>Default Dashboard View</label>
            <div class="ui selection dropdown">
                <input type="hidden" name="default_view">
                <i class="dropdown icon"></i>
                <div class="default text">Select View</div>
                <div class="menu">
                    <div class="item" data-value="summary">Summary</div>
                    <div class="item" data-value="detailed">Detailed</div>
                    <div class="item" data-value="compact">Compact</div>
                </div>
            </div>
        </div>

        <div class="actions mt-4">
            <button class="ui primary button" type="submit">Save
                Preferences</button>
            <button class="ui button" type="reset">Reset to Defaults</button>
        </div>
    </form>
</div>