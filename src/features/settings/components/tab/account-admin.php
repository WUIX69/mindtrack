<div class="tab-pane fade" id="account">
    <div class="tab-header">
        <h3 class="ui header">Account</h3>
        <p>Manage your account settings and preferences.</p>
    </div>
    <div class="section-divider"></div>
    <form class="ui form">
        <!-- Account Type -->
        <div class="field">
            <label>Account Type</label>
            <div class="ui selection dropdown">
                <input type="hidden" name="account_type">
                <i class="dropdown icon"></i>
                <div class="default text">Select Account Type</div>
                <div class="menu">
                    <div class="item" data-value="personal">Personal</div>
                    <div class="item" data-value="business">Business</div>
                    <div class="item" data-value="professional">Professional
                    </div>
                </div>
            </div>
        </div>

        <!-- Language -->
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

        <!-- Time Zone -->
        <div class="field">
            <label>Time Zone</label>
            <div class="ui selection dropdown">
                <input type="hidden" name="timezone">
                <i class="dropdown icon"></i>
                <div class="default text">Select Time Zone</div>
                <div class="menu">
                    <div class="item" data-value="utc">UTC (GMT)</div>
                    <div class="item" data-value="est">Eastern Time (ET)</div>
                    <div class="item" data-value="cst">Central Time (CT)</div>
                    <div class="item" data-value="pst">Pacific Time (PT)</div>
                </div>
            </div>
        </div>



        <div class="actions mt-4">
            <button class="ui primary button" type="submit">Save Account
                Settings</button>
        </div>
    </form>
</div>