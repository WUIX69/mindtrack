<?php
require_once __DIR__ . '/../../core/app.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: ' . app('auth'));
    exit;
}

// Fetch user information from session
$username = $_SESSION['username'] ?? 'Admin';
$userEmail = $_SESSION['email'] ?? 'admin@mindtrack.com';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>System Settings - Admin - MindTrack</title>
    <?php shared('components/elements/styles'); ?>
</head>

<body class="bg-gradient-to-br from-blue-100 via-cyan-50 to-blue-50 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php shared('components/layout/sidebar') ?>

        <!-- Main Content -->
        <div class="flex-1 p-8 overflow-y-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">System Settings</h1>
                    <p class="text-sm text-gray-600 mt-1">Configure system preferences and options</p>
                </div>
                <button class="ui primary button" id="saveAllSettings">
                    <i class="save icon"></i>
                    Save All Changes
                </button>
            </div>

            <!-- Success/Error Messages -->
            <div id="successMessage" class="ui positive message hidden">
                <i class="close icon"></i>
                <div class="header">Settings Saved!</div>
                <p>Your changes have been saved successfully.</p>
            </div>

            <div id="errorMessage" class="ui negative message hidden">
                <i class="close icon"></i>
                <div class="header">Error</div>
                <p id="errorText">An error occurred while saving settings.</p>
            </div>

            <!-- Settings Tabs -->
            <div class="ui top attached tabular menu">
                <a class="item active" data-tab="general">
                    <i class="cog icon"></i>
                    General
                </a>
                <a class="item" data-tab="email">
                    <i class="mail icon"></i>
                    Email
                </a>
                <a class="item" data-tab="security">
                    <i class="shield icon"></i>
                    Security
                </a>
                <a class="item" data-tab="backup">
                    <i class="database icon"></i>
                    Backup
                </a>
                <a class="item" data-tab="appearance">
                    <i class="paint brush icon"></i>
                    Appearance
                </a>
            </div>

            <!-- General Settings Tab -->
            <div class="ui bottom attached tab segment active" data-tab="general">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">General Settings</h3>
                <form class="ui form">
                    <div class="two fields">
                        <div class="field">
                            <label>System Name</label>
                            <input type="text" name="system_name" value="MindTrack" placeholder="System Name">
                        </div>
                        <div class="field">
                            <label>Organization Name</label>
                            <input type="text" name="org_name" value="Wayside Psyche Resources Center"
                                placeholder="Organization Name">
                        </div>
                    </div>

                    <div class="two fields">
                        <div class="field">
                            <label>Contact Email</label>
                            <input type="email" name="contact_email" value="contact@mindtrack.com"
                                placeholder="Contact Email">
                        </div>
                        <div class="field">
                            <label>Contact Phone</label>
                            <input type="tel" name="contact_phone" value="+1 (555) 123-4567"
                                placeholder="Contact Phone">
                        </div>
                    </div>

                    <div class="field">
                        <label>System Address</label>
                        <textarea name="address" rows="2"
                            placeholder="Full address">123 Mental Health St, Wellness City, WC 12345</textarea>
                    </div>

                    <div class="two fields">
                        <div class="field">
                            <label>Timezone</label>
                            <select name="timezone" class="ui dropdown">
                                <option value="UTC">UTC</option>
                                <option value="America/New_York">Eastern Time (ET)</option>
                                <option value="America/Chicago">Central Time (CT)</option>
                                <option value="America/Denver">Mountain Time (MT)</option>
                                <option value="America/Los_Angeles" selected>Pacific Time (PT)</option>
                            </select>
                        </div>
                        <div class="field">
                            <label>Date Format</label>
                            <select name="date_format" class="ui dropdown">
                                <option value="Y-m-d">YYYY-MM-DD</option>
                                <option value="m/d/Y" selected>MM/DD/YYYY</option>
                                <option value="d/m/Y">DD/MM/YYYY</option>
                            </select>
                        </div>
                    </div>

                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="maintenance_mode">
                            <label>Enable Maintenance Mode</label>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">When enabled, only admins can access the system</p>
                    </div>
                </form>
            </div>

            <!-- Email Settings Tab -->
            <div class="ui bottom attached tab segment" data-tab="email">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Email Configuration</h3>
                <form class="ui form">
                    <div class="two fields">
                        <div class="field required">
                            <label>SMTP Host</label>
                            <input type="text" name="smtp_host" placeholder="smtp.example.com">
                        </div>
                        <div class="field required">
                            <label>SMTP Port</label>
                            <input type="number" name="smtp_port" value="587" placeholder="587">
                        </div>
                    </div>

                    <div class="two fields">
                        <div class="field required">
                            <label>SMTP Username</label>
                            <input type="text" name="smtp_username" placeholder="your@email.com">
                        </div>
                        <div class="field required">
                            <label>SMTP Password</label>
                            <input type="password" name="smtp_password" placeholder="••••••••">
                        </div>
                    </div>

                    <div class="field">
                        <label>From Email</label>
                        <input type="email" name="from_email" value="noreply@mindtrack.com"
                            placeholder="noreply@mindtrack.com">
                    </div>

                    <div class="field">
                        <label>From Name</label>
                        <input type="text" name="from_name" value="MindTrack System" placeholder="MindTrack System">
                    </div>

                    <div class="field">
                        <label>Email Encryption</label>
                        <select name="smtp_encryption" class="ui dropdown">
                            <option value="none">None</option>
                            <option value="tls" selected>TLS</option>
                            <option value="ssl">SSL</option>
                        </select>
                    </div>

                    <div class="field">
                        <button type="button" class="ui button" id="testEmailBtn">
                            <i class="paper plane icon"></i>
                            Send Test Email
                        </button>
                    </div>
                </form>
            </div>

            <!-- Security Settings Tab -->
            <div class="ui bottom attached tab segment" data-tab="security">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Security Settings</h3>
                <form class="ui form">
                    <div class="field">
                        <label>Password Minimum Length</label>
                        <input type="number" name="min_password_length" value="8" min="6" max="20">
                        <p class="text-xs text-gray-500 mt-1">Minimum characters required for passwords</p>
                    </div>

                    <div class="field">
                        <label>Session Timeout (minutes)</label>
                        <input type="number" name="session_timeout" value="30" min="5" max="1440">
                        <p class="text-xs text-gray-500 mt-1">Auto-logout after inactivity</p>
                    </div>

                    <div class="field">
                        <label>Max Login Attempts</label>
                        <input type="number" name="max_login_attempts" value="5" min="3" max="10">
                        <p class="text-xs text-gray-500 mt-1">Lock account after failed attempts</p>
                    </div>

                    <div class="grouped fields">
                        <label>Password Requirements</label>
                        <div class="field">
                            <div class="ui checkbox">
                                <input type="checkbox" name="require_uppercase" checked>
                                <label>Require uppercase letters</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui checkbox">
                                <input type="checkbox" name="require_lowercase" checked>
                                <label>Require lowercase letters</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui checkbox">
                                <input type="checkbox" name="require_numbers" checked>
                                <label>Require numbers</label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui checkbox">
                                <input type="checkbox" name="require_special">
                                <label>Require special characters</label>
                            </div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="two_factor_auth">
                            <label>Enable Two-Factor Authentication (2FA)</label>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Require additional verification for login</p>
                    </div>
                </form>
            </div>

            <!-- Backup Settings Tab -->
            <div class="ui bottom attached tab segment" data-tab="backup">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Backup & Recovery</h3>

                <div class="ui info message">
                    <div class="header">Last Backup</div>
                    <p>Last backup was performed on <strong>October 22, 2024 at 12:00 AM</strong></p>
                </div>

                <form class="ui form">
                    <div class="field">
                        <label>Automatic Backup Schedule</label>
                        <select name="backup_schedule" class="ui dropdown">
                            <option value="disabled">Disabled</option>
                            <option value="daily" selected>Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Backup Time</label>
                        <input type="time" name="backup_time" value="00:00">
                    </div>

                    <div class="field">
                        <label>Retention Period (days)</label>
                        <input type="number" name="backup_retention" value="30" min="7" max="365">
                        <p class="text-xs text-gray-500 mt-1">How long to keep old backups</p>
                    </div>

                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="backup_email_notification" checked>
                            <label>Email notification on backup completion</label>
                        </div>
                    </div>

                    <div class="field">
                        <button type="button" class="ui primary button" id="backupNowBtn">
                            <i class="download icon"></i>
                            Backup Now
                        </button>
                        <button type="button" class="ui button">
                            <i class="upload icon"></i>
                            Restore from Backup
                        </button>
                    </div>
                </form>
            </div>

            <!-- Appearance Settings Tab -->
            <div class="ui bottom attached tab segment" data-tab="appearance">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Appearance Settings</h3>
                <form class="ui form">
                    <div class="field">
                        <label>Theme</label>
                        <select name="theme" class="ui dropdown">
                            <option value="light" selected>Light</option>
                            <option value="dark">Dark</option>
                            <option value="auto">Auto (System)</option>
                        </select>
                    </div>

                    <div class="field">
                        <label>Primary Color</label>
                        <input type="color" name="primary_color" value="#0077b6">
                    </div>

                    <div class="field">
                        <label>Logo Upload</label>
                        <input type="file" name="logo" accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">Recommended size: 200x200px</p>
                    </div>

                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="show_dashboard_widgets" checked>
                            <label>Show dashboard widgets</label>
                        </div>
                    </div>

                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="compact_sidebar">
                            <label>Compact sidebar</label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        $(document).ready(function () {
            // Initialize tabs
            $('.menu .item').tab();

            // Initialize dropdowns
            $('.ui.dropdown').dropdown();

            // Close messages
            $('.message .close').on('click', function () {
                $(this).closest('.message').transition('fade');
            });

            // Save all settings
            $('#saveAllSettings').on('click', function () {
                const $btn = $(this);
                $btn.addClass('loading');

                // TODO: Implement AJAX call to save all settings
                setTimeout(function () {
                    $btn.removeClass('loading');
                    $('#successMessage').removeClass('hidden');
                    setTimeout(function () {
                        $('#successMessage').addClass('hidden');
                    }, 3000);
                }, 1000);
            });

            // Test email
            $('#testEmailBtn').on('click', function () {
                const $btn = $(this);
                $btn.addClass('loading');

                // TODO: Implement AJAX call to test email
                setTimeout(function () {
                    $btn.removeClass('loading');
                    alert('Test email sent successfully!');
                }, 1000);
            });

            // Backup now
            $('#backupNowBtn').on('click', function () {
                const $btn = $(this);
                $btn.addClass('loading');

                // TODO: Implement AJAX call to trigger backup
                setTimeout(function () {
                    $btn.removeClass('loading');
                    alert('Backup completed successfully!');
                }, 2000);
            });
        });
    </script>
</body>

</html>