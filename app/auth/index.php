<?php
require_once __DIR__ . '/../../core/app.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>MindTrack Login - Wayside Psyche Resources Center</title>
    <?php shared('components/elements/styles'); ?>
</head>

<body class="bg-gradient-to-br from-blue-100 via-cyan-50 to-blue-50 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4">
        <!-- Login Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-10">
            <!-- Header -->
            <div class="flex items-center justify-center mb-8">
                <img src="<?= asset('img/waysidelogo.jpg') ?>" alt="Wayside Logo"
                    class="w-12 h-12 mr-4 rounded-full object-cover" aria-label="Wayside Psyche Resources Center Logo">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 m-0">Login to MindTrack</h2>
                    <p class="text-sm text-gray-500 mt-1 m-0">Wayside Psyche Resources Center</p>
                </div>
            </div>

            <!-- Error Message -->
            <div class="ui negative message hidden" id="errorMessage">
                <i class="close icon"></i>
                <div class="header">Login Failed</div>
                <p id="errorText"></p>
            </div>

            <!-- Success Message -->
            <div class="ui positive message hidden" id="successMessage">
                <i class="close icon"></i>
                <div class="header">Login Successful</div>
                <p id="successText"></p>
            </div>

            <!-- Login Form -->
            <form class="ui form" id="loginForm">
                <div class="field">
                    <label for="username" class="text-gray-700 font-medium">Username</label>
                    <div class="ui left icon input">
                        <i class="user icon"></i>
                        <input type="text" name="username" id="username" placeholder="Enter your username" required
                            tabindex="0" aria-label="Username" class="focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="field">
                    <label for="password" class="text-gray-700 font-medium">Password</label>
                    <div class="ui left icon input">
                        <i class="lock icon"></i>
                        <input type="password" name="password" id="password" placeholder="Enter your password" required
                            tabindex="0" aria-label="Password" class="focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="field">
                    <div class="ui checkbox">
                        <input type="checkbox" id="remember" tabindex="0" aria-label="Remember me">
                        <label for="remember" class="text-gray-600">Remember me</label>
                    </div>
                </div>

                <button type="submit" class="ui primary fluid large button mt-4" tabindex="0"
                    aria-label="Login to MindTrack">
                    <i class="sign in icon"></i>
                    Login
                </button>
            </form>

            <!-- Additional Links -->
            <div class="text-center mt-6">
                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm transition-colors" tabindex="0"
                    aria-label="Forgot password">
                    Forgot password?
                </a>
            </div>

            <div class="border-t border-gray-200 mt-6 pt-6">
                <p class="text-center text-gray-600 text-sm">
                    Don't have an account?
                    <a href="<?= app('auth/register') ?>"
                        class="text-blue-600 hover:text-blue-800 font-medium transition-colors" tabindex="0"
                        aria-label="Create account">
                        Create Account
                    </a>
                </p>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="<?= baseURL() ?>"
                class="text-gray-600 hover:text-gray-800 transition-colors inline-flex items-center gap-2" tabindex="0"
                aria-label="Back to home">
                <i class="arrow left icon"></i>
                Back to Home
            </a>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        $(document).ready(function () {
            // Initialize Fomantic UI components
            $('.ui.checkbox').checkbox();

            // Close message
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
                                prompt: 'Please enter your username'
                            }
                        ]
                    },
                    password: {
                        identifier: 'password',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please enter your password'
                            },
                            {
                                type: 'minLength[6]',
                                prompt: 'Password must be at least 6 characters'
                            }
                        ]
                    }
                },
                onSuccess: function (event, fields) {
                    event.preventDefault();

                    const $submitBtn = $(this).find('button[type=submit]');

                    // Hide any previous messages
                    $('#errorMessage').addClass('hidden');
                    $('#successMessage').addClass('hidden');

                    // Submit login request via AJAX
                    $.ajax({
                        url: apiURL('auth') + 'login.php',
                        method: 'POST',
                        data: fields,
                        dataType: 'json',
                        timeout: 5000,
                        beforeSend: function () {
                            $submitBtn.addClass('loading');
                        },
                        success: function (response) {
                            console.log('API Response:', response);

                            if (response.success) {
                                // Show success message
                                $('#successText').text(response.message);
                                $('#successMessage').removeClass('hidden');

                                // Redirect to route from server
                                setTimeout(function () {
                                    window.location.replace(response.data.route);
                                }, 500);
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
                            let errorMessage = 'An error occurred during login. Please try again.';

                            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                                errorMessage = jqXHR.responseJSON.message;
                            }

                            $('#errorText').text(errorMessage);
                            $('#errorMessage').removeClass('hidden');

                            // Log error for debugging
                            ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Login Error');
                        }
                    });

                    return false;
                }
            });
        });
    </script>
</body>

</html>