<?php
require_once __DIR__ . '/../../core/app.php';

// Redirect if already logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $role = $_SESSION['role'] ?? 'patient';
    $redirect = match ($role) {
        'admin' => app('admin'),
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
    <title>Create Account - MindTrack</title>
    <?php shared('components/elements/styles'); ?>
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .feature-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
        }

        @media (max-width: 768px) {
            .split-screen-left {
                display: none;
            }
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Left Side - Brand/Info Section -->
        <div
            class="split-screen-left hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 via-purple-600 to-purple-700 p-12 text-white flex-col justify-between">
            <!-- Logo & Brand -->
            <div>
                <div class="flex items-center gap-3 mb-12">
                    <i class="fas fa-heartbeat text-4xl"></i>
                    <div>
                        <h1 class="text-3xl font-bold m-0">MindTrack</h1>
                        <p class="text-sm opacity-90 m-0">Mental Health Management</p>
                    </div>
                </div>

                <h2 class="text-4xl font-bold mb-6">
                    Welcome to Your<br>Mental Health Journey
                </h2>
                <p class="text-lg opacity-90 mb-12">
                    Join thousands of people taking control of their mental health with our comprehensive platform.
                </p>

                <!-- Features -->
                <div class="space-y-6">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar-check text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg mb-1">Easy Appointment Scheduling</h3>
                            <p class="text-sm opacity-80">Book and manage appointments with healthcare professionals</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-prescription-bottle-alt text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg mb-1">Track Prescriptions</h3>
                            <p class="text-sm opacity-80">Keep all your prescriptions and medications organized</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-flask text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg mb-1">Access Lab Results</h3>
                            <p class="text-sm opacity-80">View your test results and medical records anytime</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shield-alt text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg mb-1">Secure & Private</h3>
                            <p class="text-sm opacity-80">Your health data is encrypted and completely confidential</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-sm opacity-75">
                <p>© 2025 Wayside Psyche Resources Center. All rights reserved.</p>
            </div>
        </div>

        <!-- Right Side - Registration Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden flex items-center gap-3 mb-8">
                    <i class="fas fa-heartbeat text-3xl text-indigo-600"></i>
                    <div>
                        <h1 class="text-2xl font-bold m-0 gradient-text">MindTrack</h1>
                        <p class="text-sm text-gray-600 m-0">Mental Health Management</p>
                    </div>
                </div>

                <!-- Header -->
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h2>
                    <p class="text-gray-600">Start your journey to better mental health today</p>
                </div>

                <!-- Messages -->
                <div id="successMessage" class="ui positive message hidden mb-4">
                    <i class="close icon"></i>
                    <div class="header">Success!</div>
                    <p id="successText">Registration successful!</p>
                </div>

                <div id="errorMessage" class="ui negative message hidden mb-4">
                    <i class="close icon"></i>
                    <div class="header">Registration Failed</div>
                    <p id="errorText">Please check your information and try again.</p>
                </div>

                <!-- Registration Form -->
                <form id="registerForm" class="ui form">
                    <!-- Name Fields -->
                    <div class="two fields">
                        <div class="field required">
                            <label class="text-sm font-medium text-gray-700">First Name</label>
                            <div class="ui left icon input">
                                <i class="user icon"></i>
                                <input type="text" name="first_name" placeholder="John" tabindex="1">
                            </div>
                        </div>
                        <div class="field required">
                            <label class="text-sm font-medium text-gray-700">Last Name</label>
                            <div class="ui left icon input">
                                <i class="user icon"></i>
                                <input type="text" name="last_name" placeholder="Doe" tabindex="2">
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="field required">
                        <label class="text-sm font-medium text-gray-700">Email Address</label>
                        <div class="ui left icon input">
                            <i class="envelope icon"></i>
                            <input type="email" name="email" placeholder="john.doe@example.com" tabindex="3">
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="field">
                        <label class="text-sm font-medium text-gray-700">Phone Number <span
                                class="text-gray-400 font-normal">(Optional)</span></label>
                        <div class="ui left icon input">
                            <i class="phone icon"></i>
                            <input type="tel" name="phone" placeholder="+1 (555) 123-4567" tabindex="4">
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="field required">
                        <label class="text-sm font-medium text-gray-700">Username</label>
                        <div class="ui left icon input">
                            <i class="at icon"></i>
                            <input type="text" name="username" placeholder="johndoe" tabindex="5">
                        </div>
                    </div>

                    <!-- Password Fields -->
                    <div class="two fields">
                        <div class="field required">
                            <label class="text-sm font-medium text-gray-700">Password</label>
                            <div class="ui left icon input">
                                <i class="lock icon"></i>
                                <input type="password" name="password" placeholder="••••••••" tabindex="6">
                            </div>
                        </div>
                        <div class="field required">
                            <label class="text-sm font-medium text-gray-700">Confirm</label>
                            <div class="ui left icon input">
                                <i class="lock icon"></i>
                                <input type="password" name="confirm_password" placeholder="••••••••" tabindex="7">
                            </div>
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div class="field">
                        <label class="text-sm font-medium text-gray-700">I am registering as</label>
                        <select name="role" class="ui fluid dropdown" tabindex="8" id="roleSelect">
                            <option value="patient">Patient</option>
                            <option value="doctor">Doctor</option>
                        </select>
                    </div>

                    <!-- Patient-specific fields removed - can be added later in profile -->

                    <!-- Role-specific fields removed - can be added later in profile -->

                    <!-- Terms -->
                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="terms" tabindex="9">
                            <label class="text-sm text-gray-700">
                                I agree to the <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium"
                                    onclick="return false;">Terms of Service</a> and <a href="#"
                                    class="text-indigo-600 hover:text-indigo-800 font-medium"
                                    onclick="return false;">Privacy Policy</a>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="ui large primary fluid button" tabindex="10"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); margin-top: 1.5rem;">
                        <i class="user plus icon"></i>
                        Create Account
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-gray-50 text-gray-500">Already have an account?</span>
                    </div>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <a href="<?= app('auth') ?>" class="ui basic large fluid button" tabindex="11">
                        <i class="sign in icon"></i>
                        Sign In Instead
                    </a>
                </div>

                <!-- Help Text -->
                <p class="text-center text-sm text-gray-500 mt-6">
                    Need help? <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium">Contact Support</a>
                </p>
            </div>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        $(document).ready(function () {
            // Initialize dropdown
            $('.ui.dropdown').dropdown();

            // Initialize checkbox
            $('.ui.checkbox').checkbox();

            // Close messages on click
            $('.message .close').on('click', function () {
                $(this).closest('.message').transition('fade');
            });

            // Role selection no longer shows/hides fields - all fields are now basic

            // Validate registration form
            $('#registerForm').form({
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
                    },
                    // Role-specific fields are now optional - no validation needed
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
                            $submitBtn.addClass('loading disabled');
                        },
                        success: function (response) {
                            console.log('API Response:', response);

                            if (response.success) {
                                // Show success message
                                $('#successText').text(response.message);
                                $('#successMessage').removeClass('hidden');

                                // Scroll to top to show message
                                window.scrollTo({ top: 0, behavior: 'smooth' });

                                // Redirect to login page after short delay
                                setTimeout(function () {
                                    window.location.replace(response.data.route);
                                }, 2000); // 2 seconds to show success message
                            } else {
                                // Show error message
                                $('#errorText').text(response.message);
                                $('#errorMessage').removeClass('hidden');
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                            }
                        },
                        complete: function () {
                            $submitBtn.removeClass('loading disabled');
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            let errorMessage = 'An error occurred during registration. Please try again.';

                            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                                errorMessage = jqXHR.responseJSON.message;
                            } else if (textStatus === 'timeout') {
                                errorMessage = 'Request timed out. Please check your connection and try again.';
                            }

                            $('#errorText').text(errorMessage);
                            $('#errorMessage').removeClass('hidden');
                            window.scrollTo({ top: 0, behavior: 'smooth' });

                            // Log error for debugging
                            ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Registration Error');
                        }
                    });

                    return false;
                }
            });

            // Password strength indicator (optional enhancement)
            $('input[name="password"]').on('input', function () {
                const password = $(this).val();
                let strength = 0;

                if (password.length >= 6) strength++;
                if (password.length >= 10) strength++;
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
                if (/\d/.test(password)) strength++;
                if (/[^a-zA-Z0-9]/.test(password)) strength++;

                // You can add visual feedback here if desired
            });
        });
    </script>
</body>

</html>