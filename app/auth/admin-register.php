<?php
require_once __DIR__ . '/../../core/app.php';

// If user is already logged in, redirect based on role
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $role = $_SESSION['role'] ?? 'patient';
    if ($role === 'admin') {
        header('Location: ' . app('admin'));
    } else {
        header('Location: ' . app($role . 's'));
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>Admin Registration - MindTrack</title>
    <?php shared('components/elements/styles'); ?>
</head>

<body class="positive-relative">
    <div
        class="min-h-screen flex items-center justify-center p-4 bg-gradient-to-br from-purple-200 via-indigo-100 to-indigo-300">
        <div class="w-full max-w-2xl">
            <!-- Security Notice -->
            <div class="ui info message">
                <div class="header">
                    <i class="shield icon"></i>
                    Admin Registration
                </div>
                <p>This page is for creating system administrator accounts. Use responsibly.</p>
            </div>

            <!-- Registration Card -->
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-purple-600 to-indigo-600 p-8 text-center">
                    <div class="w-20 h-20 bg-white rounded-full mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-user-shield text-4xl text-purple-600"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Admin Registration</h1>
                    <p class="text-purple-100">Create System Administrator Account</p>
                </div>

                <!-- Form -->
                <div class="p-8">
                    <!-- Success Message -->
                    <div id="successMessage" class="ui positive message hidden">
                        <i class="close icon"></i>
                        <div class="header">Registration Successful!</div>
                        <p id="successText"></p>
                    </div>

                    <!-- Error Message -->
                    <div id="errorMessage" class="ui negative message hidden">
                        <i class="close icon"></i>
                        <div class="header">Registration Failed</div>
                        <p id="errorText"></p>
                    </div>

                    <form class="ui form" id="adminRegisterForm">
                        <input type="hidden" name="role" value="admin">
                        <input type="hidden" name="status" value="active">

                        <!-- Personal Information -->
                        <h4 class="ui dividing header">
                            <i class="user icon"></i>
                            Personal Information
                        </h4>

                        <div class="two fields">
                            <div class="field required">
                                <label>First Name</label>
                                <div class="ui left icon input">
                                    <i class="user icon"></i>
                                    <input type="text" name="first_name" placeholder="Enter first name">
                                </div>
                            </div>
                            <div class="field required">
                                <label>Last Name</label>
                                <div class="ui left icon input">
                                    <i class="user icon"></i>
                                    <input type="text" name="last_name" placeholder="Enter last name">
                                </div>
                            </div>
                        </div>

                        <!-- Account Information -->
                        <h4 class="ui dividing header">
                            <i class="lock icon"></i>
                            Account Information
                        </h4>

                        <div class="field required">
                            <label>Email Address</label>
                            <div class="ui left icon input">
                                <i class="envelope icon"></i>
                                <input type="email" name="email" placeholder="admin@example.com">
                            </div>
                        </div>

                        <div class="field required">
                            <label>Username</label>
                            <div class="ui left icon input">
                                <i class="at icon"></i>
                                <input type="text" name="username" placeholder="Choose a username">
                            </div>
                        </div>

                        <div class="field">
                            <label>Phone Number <span class="text-gray-500">(Optional)</span></label>
                            <div class="ui left icon input">
                                <i class="phone icon"></i>
                                <input type="tel" name="phone" placeholder="+1 234 567 8900">
                            </div>
                        </div>

                        <!-- Password -->
                        <h4 class="ui dividing header">
                            <i class="key icon"></i>
                            Security
                        </h4>

                        <div class="field required">
                            <label>Password</label>
                            <div class="ui left icon input">
                                <i class="lock icon"></i>
                                <input type="password" name="password" id="password"
                                    placeholder="Create a strong password">
                            </div>
                        </div>

                        <div class="field required">
                            <label>Confirm Password</label>
                            <div class="ui left icon input">
                                <i class="lock icon"></i>
                                <input type="password" name="confirm_password" id="confirmPassword"
                                    placeholder="Re-enter password">
                            </div>
                        </div>

                        <!-- Admin-specific fields removed - can be added later in profile -->

                        <!-- Admin Confirmation -->
                        <div class="ui segment bg-yellow-100 border-l-4 border-yellow-400 !border-solid">
                            <div class="field">
                                <div class="ui checkbox">
                                    <input type="checkbox" id="adminConfirm">
                                    <label for="adminConfirm">
                                        <strong>I confirm that I am authorized to create an administrator
                                            account</strong>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="ui fluid large primary button" id="registerBtn">
                            <i class="user plus icon"></i>
                            Create Admin Account
                        </button>
                    </form>

                    <!-- Back to Login -->
                    <div class="text-center mt-6">
                        <a href="<?= app('auth') ?>" class="text-purple-600 hover:text-purple-800 font-medium">
                            <i class="arrow left icon"></i>
                            Back to Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        $(document).ready(function () {
            // Add custom matching rule for password confirmation
            $.fn.form.settings.rules.passwordMatch = function (value) {
                return value === $('#password').val();
            };

            // Form validation
            $('#adminRegisterForm').form({
                fields: {
                    first_name: {
                        identifier: 'first_name',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please enter your first name'
                            },
                            {
                                type: 'minLength[2]',
                                prompt: 'First name must be at least 2 characters'
                            }
                        ]
                    },
                    last_name: {
                        identifier: 'last_name',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please enter your last name'
                            },
                            {
                                type: 'minLength[2]',
                                prompt: 'Last name must be at least 2 characters'
                            }
                        ]
                    },
                    email: {
                        identifier: 'email',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please enter your email address'
                            },
                            {
                                type: 'email',
                                prompt: 'Please enter a valid email address'
                            }
                        ]
                    },
                    username: {
                        identifier: 'username',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please choose a username'
                            },
                            {
                                type: 'minLength[3]',
                                prompt: 'Username must be at least 3 characters'
                            },
                            {
                                type: 'regExp[/^[a-zA-Z0-9_]+$/]',
                                prompt: 'Username can only contain letters, numbers, and underscores'
                            }
                        ]
                    },
                    password: {
                        identifier: 'password',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please enter a password'
                            }
                        ]
                    },
                    confirm_password: {
                        identifier: 'confirm_password',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please confirm your password'
                            },
                            {
                                type: 'passwordMatch',
                                prompt: 'Passwords do not match'
                            }
                        ]
                    },
                    // Department/division is now optional - no validation needed
                },
                inline: true,
                on: 'blur',
                onSuccess: function (event, fields) {
                    event.preventDefault();
                    handleAdminRegistration();
                }
            });

            // Close message handlers
            $('.message .close').on('click', function () {
                $(this).closest('.message').transition('fade');
            });

            // Re-validate confirm password when password changes
            $('#password').on('input change', function () {
                if ($('#confirmPassword').val() !== '') {
                    $('#adminRegisterForm').form('validate field', 'confirm_password');
                }
            });
        });

        /**
         * Handle admin registration
         */
        function handleAdminRegistration() {
            // Check admin confirmation
            if (!$('#adminConfirm').is(':checked')) {
                showError('Please confirm that you are authorized to create an admin account');
                return;
            }

            // Get form data
            const formData = new URLSearchParams($('#adminRegisterForm').serialize());

            // Show loading state
            $('#registerBtn').addClass('loading disabled');

            // Submit registration
            $.ajax({
                url: apiURL('auth') + 'register.php',
                method: 'POST',
                data: formData.toString(),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        showSuccess('Admin account created successfully! Redirecting to login...');

                        // Clear form
                        $('#adminRegisterForm').form('clear');
                        $('#adminConfirm').prop('checked', false);

                        // Redirect to login page after short delay
                        setTimeout(function () {
                            window.location.replace(response.data.route);
                        }, 2000); // 2 seconds to show success message
                    } else {
                        showError(response.message || 'Registration failed. Please try again.');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Registration error:', textStatus, errorThrown);

                    let errorMsg = 'An error occurred during registration. Please try again.';

                    if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                        errorMsg = jqXHR.responseJSON.message;
                    }

                    showError(errorMsg);
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Admin Registration Error');
                },
                complete: function () {
                    $('#registerBtn').removeClass('loading disabled');
                }
            });
        }

        /**
         * Show success message
         */
        function showSuccess(message) {
            $('#successText').text(message);
            $('#successMessage').removeClass('hidden');
            $('#errorMessage').addClass('hidden');

            // Scroll to top to show message
            $('html, body').animate({ scrollTop: 0 }, 'fast');
        }

        /**
         * Show error message
         */
        function showError(message) {
            $('#errorText').text(message);
            $('#errorMessage').removeClass('hidden');
            $('#successMessage').addClass('hidden');

            // Scroll to top to show message
            $('html, body').animate({ scrollTop: 0 }, 'fast');
        }
    </script>
</body>

</html>