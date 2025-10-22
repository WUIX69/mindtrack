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
    <title>Sign In - MindTrack</title>
    <?php shared('components/elements/styles'); ?>
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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
                    Welcome Back!<br>Let's Continue Your Journey
                </h2>
                <p class="text-lg opacity-90 mb-12">
                    Sign in to access your appointments, prescriptions, lab results, and more.
                </p>

                <!-- Stats/Features -->
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white bg-opacity-10 rounded-lg p-4 backdrop-blur-sm">
                        <div class="text-3xl font-bold mb-1">1000+</div>
                        <div class="text-sm opacity-80">Active Patients</div>
                    </div>
                    <div class="bg-white bg-opacity-10 rounded-lg p-4 backdrop-blur-sm">
                        <div class="text-3xl font-bold mb-1">50+</div>
                        <div class="text-sm opacity-80">Healthcare Professionals</div>
                    </div>
                    <div class="bg-white bg-opacity-10 rounded-lg p-4 backdrop-blur-sm">
                        <div class="text-3xl font-bold mb-1">24/7</div>
                        <div class="text-sm opacity-80">Support Available</div>
                    </div>
                    <div class="bg-white bg-opacity-10 rounded-lg p-4 backdrop-blur-sm">
                        <div class="text-3xl font-bold mb-1">100%</div>
                        <div class="text-sm opacity-80">Secure & Private</div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-sm opacity-75">
                <p>© 2025 Wayside Psyche Resources Center. All rights reserved.</p>
            </div>
        </div>

        <!-- Right Side - Login Form -->
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
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign In</h2>
                    <p class="text-gray-600">Welcome back! Please enter your credentials</p>
                </div>

                <!-- Messages -->
                <div id="successMessage" class="ui positive message hidden mb-4">
                    <i class="close icon"></i>
                    <div class="header">Login Successful</div>
                    <p id="successText">Redirecting...</p>
                </div>

                <div id="errorMessage" class="ui negative message hidden mb-4">
                    <i class="close icon"></i>
                    <div class="header">Login Failed</div>
                    <p id="errorText">Invalid credentials</p>
                </div>

                <!-- Login Form -->
                <form id="loginForm" class="ui form">
                    <!-- Username/Email -->
                    <div class="field required">
                        <label class="text-sm font-medium text-gray-700">Username or Email</label>
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" name="username" placeholder="Enter your username or email" tabindex="1"
                                autofocus>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="field required">
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-sm font-medium text-gray-700">Password</label>
                            <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium"
                                onclick="return false;">Forgot password?</a>
                        </div>
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" placeholder="Enter your password" tabindex="2">
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="field">
                        <div class="ui checkbox">
                            <input type="checkbox" name="remember" tabindex="3">
                            <label class="text-sm text-gray-700">Remember me for 30 days</label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="ui large primary fluid button" tabindex="4"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); margin-top: 1.5rem;">
                        <i class="sign in icon"></i>
                        Sign In
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-gray-50 text-gray-500">New to MindTrack?</span>
                    </div>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                    <a href="<?= app('auth/register') ?>" class="ui basic large fluid button" tabindex="5">
                        <i class="user plus icon"></i>
                        Create an Account
                    </a>
                </div>

                <!-- Help Text -->
                <p class="text-center text-sm text-gray-500 mt-6">
                    Having trouble? <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium">Contact
                        Support</a>
                </p>
            </div>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        $(document).ready(function () {
            // Initialize checkbox
            $('.ui.checkbox').checkbox();

            // Close messages on click
            $('.message .close').on('click', function () {
                $(this).closest('.message').transition('fade');
            });

            // Form validation and submission
            $('#loginForm').form({
                fields: {
                    username: {
                        identifier: 'username',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please enter your username or email'
                            }
                        ]
                    },
                    password: {
                        identifier: 'password',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please enter your password'
                            }
                        ]
                    }
                },
                inline: true,
                on: 'blur',
                onSuccess: function (event, fields) {
                    event.preventDefault();

                    const $submitBtn = $(this).find('button[type=submit]');

                    // Hide previous messages
                    $('#errorMessage').addClass('hidden');
                    $('#successMessage').addClass('hidden');

                    // Submit login request via AJAX
                    $.ajax({
                        url: apiURL('auth') + 'login.php',
                        method: 'POST',
                        data: fields,
                        dataType: 'json',
                        timeout: 10000,
                        beforeSend: function () {
                            $submitBtn.addClass('loading disabled');
                        },
                        success: function (response) {
                            console.log('Login Response:', response);

                            if (response.success) {
                                // Show success message
                                $('#successText').text(response.message);
                                $('#successMessage').removeClass('hidden');

                                window.scrollTo({ top: 0, behavior: 'smooth' });

                                // Redirect to appropriate dashboard
                                setTimeout(function () {
                                    window.location.replace(response.data.route);
                                }, 1000);
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
                            let errorMessage = 'Unable to connect to server. Please try again.';

                            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                                errorMessage = jqXHR.responseJSON.message;
                            } else if (textStatus === 'timeout') {
                                errorMessage = 'Request timed out. Please check your connection.';
                            }

                            $('#errorText').text(errorMessage);
                            $('#errorMessage').removeClass('hidden');
                            window.scrollTo({ top: 0, behavior: 'smooth' });

                            // Log error for debugging
                            ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Login Error');
                        }
                    });

                    return false;
                }
            });

            // Enter key support
            $('#loginForm input').on('keypress', function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $('#loginForm').submit();
                }
            });
        });
    </script>
</body>

</html>