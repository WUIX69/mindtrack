<?php
require_once __DIR__ . '/../../core/app.php';

// Redirect if already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $role = $_SESSION['role'] ?? 'patient';
    $redirect = match ($role) {
        'admin' => app('patients'),
        'doctor' => app('doctors'),
        'patient' => app('patients'),
        default => app('patients')
    };
    header('Location: ' . $redirect);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>Register - MindTrack</title>
    <?php shared('components/elements/styles'); ?>
</head>

<body
    class="bg-gradient-to-br from-indigo-500 via-purple-500 to-purple-600 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden max-w-4xl w-full mx-8 my-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-8 text-white text-center">
            <h1 class="text-3xl font-bold m-0">
                <i class="user plus icon"></i> Create Account
            </h1>
            <p class="mt-2 opacity-90">Join MindTrack and start your journey to better mental health</p>
        </div>

        <!-- Body -->
        <div class="p-8">
            <!-- Success Message -->
            <div id="successMessage" class="ui positive message hidden">
                <i class="close icon"></i>
                <div class="header">Success!</div>
                <p id="successText">Registration successful!</p>
            </div>

            <!-- Error Message -->
            <div id="errorMessage" class="ui negative message hidden">
                <i class="close icon"></i>
                <div class="header">Registration Failed</div>
                <p id="errorText">Please check your information and try again.</p>
            </div>

            <!-- Registration Form -->
            <form id="registerForm" class="ui form">
                <!-- Personal Information -->
                <h4 class="ui dividing header">
                    <i class="user icon"></i>
                    Personal Information
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="field required">
                        <label>First Name</label>
                        <input type="text" name="first_name" placeholder="John" tabindex="1">
                    </div>
                    <div class="field required">
                        <label>Last Name</label>
                        <input type="text" name="last_name" placeholder="Doe" tabindex="2">
                    </div>
                </div>

                <!-- Contact Information -->
                <h4 class="ui dividing header">
                    <i class="mail icon"></i>
                    Contact Information
                </h4>

                <div class="field required">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="john.doe@example.com" tabindex="3">
                </div>

                <div class="field">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" placeholder="+1 (555) 123-4567" tabindex="4">
                </div>

                <!-- Account Information -->
                <h4 class="ui dividing header">
                    <i class="lock icon"></i>
                    Account Information
                </h4>

                <div class="field required">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="johndoe" tabindex="5">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="field required">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="••••••••" tabindex="6">
                    </div>
                    <div class="field required">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" placeholder="••••••••" tabindex="7">
                    </div>
                </div>

                <!-- Role Selection (Optional - can be hidden for public registration) -->
                <div class="field">
                    <label>I am registering as</label>
                    <select name="role" class="ui dropdown" tabindex="8">
                        <option value="patient">Patient</option>
                        <option value="doctor">Doctor</option>
                    </select>
                </div>

                <!-- Terms and Conditions -->
                <div class="field">
                    <div class="ui checkbox">
                        <input type="checkbox" name="terms" tabindex="9">
                        <label>I agree to the <a href="#" onclick="return false;">Terms and Conditions</a></label>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="ui large primary fluid button" tabindex="10">
                    <i class="user plus icon"></i>
                    Create Account
                </button>
            </form>

            <!-- Login Link -->
            <div class="relative text-center my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">Already have an account?</span>
                </div>
            </div>

            <div class="text-center">
                <a href="<?= app('auth') ?>" class="ui basic button" tabindex="11">
                    <i class="sign in icon"></i>
                    Sign In
                </a>
            </div>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        $(document).ready(function () {
            // Initialize dropdown
            $('.ui.dropdown').dropdown();

            // Close messages on click
            $('.message .close').on('click', function () {
                $(this).closest('.message').transition('fade');
            });

            // Validate registration form
            $('#registerForm').form({
                fields: {
                    first_name: {
                        identifier: 'first_name',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please enter your first name'
                            }
                        ]
                    },
                    last_name: {
                        identifier: 'last_name',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please enter your last name'
                            }
                        ]
                    },
                    email: {
                        identifier: 'email',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please enter your email'
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
                                prompt: 'Please enter a username'
                            },
                            {
                                type: 'minLength[3]',
                                prompt: 'Username must be at least 3 characters'
                            }
                        ]
                    },
                    password: {
                        identifier: 'password',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please enter a password'
                            },
                            {
                                type: 'minLength[6]',
                                prompt: 'Password must be at least 6 characters'
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
                                type: 'match[password]',
                                prompt: 'Passwords do not match'
                            }
                        ]
                    },
                    terms: {
                        identifier: 'terms',
                        rules: [
                            {
                                type: 'checked',
                                prompt: 'You must agree to the terms and conditions'
                            }
                        ]
                    }
                },
                inline: true,
                on: 'blur',
                onSuccess: function (event, fields) {
                    event.preventDefault();

                    const $submitBtn = $(this).find('button[type=submit]');

                    // Hide any previous messages
                    $('#errorMessage').addClass('hidden');
                    $('#successMessage').addClass('hidden');

                    // Submit registration request via AJAX
                    $.ajax({
                        url: apiURL('auth') + 'register.php',
                        method: 'POST',
                        data: fields,
                        dataType: 'json',
                        timeout: 10000,
                        beforeSend: function () {
                            $submitBtn.addClass('loading');
                        },
                        success: function (response) {
                            console.log('API Response:', response);

                            if (response.success) {
                                // Show success message
                                $('#successText').text(response.message);
                                $('#successMessage').removeClass('hidden');

                                // Redirect to login page after short delay
                                setTimeout(function () {
                                    window.location.replace(response.data.route);
                                }, 2000); // 2 seconds to show success message
                            } else {
                                // Show error message
                                $('#errorText').text(response.message);
                                $('#errorMessage').removeClass('hidden');
                            }
                        },
                        complete: function () {
                            $submitBtn.removeClass('loading');
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            let errorMessage = 'An error occurred during registration. Please try again.';

                            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                                errorMessage = jqXHR.responseJSON.message;
                            }

                            $('#errorText').text(errorMessage);
                            $('#errorMessage').removeClass('hidden');

                            // Log error for debugging
                            ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Registration Error');
                        }
                    });

                    return false;
                }
            });
        });
    </script>
</body>

</html>