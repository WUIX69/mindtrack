<?php
require_once __DIR__ . '/../../core/app.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>MindTrack - Wayside Psyche Resources Center</title>
    <?php shared('components/elements/styles'); ?>
</head>

<body class="bg-gradient-to-br from-blue-50 to-cyan-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <i class="fas fa-heartbeat text-3xl text-blue-600"></i>
                    <div>
                        <h1 class="text-xl font-semibold text-gray-800">MindTrack</h1>
                        <p class="text-xs text-gray-500">Health Management System</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <a href="<?= app('auth') ?>" class="ui primary button" tabindex="0">
                        <i class="sign in icon"></i>
                        Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl font-bold text-gray-900 mb-6">
                        Welcome to
                        <span class="text-blue-600">MindTrack</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Wayside Psyche Resources Center's comprehensive mental health management system.
                        Streamline patient care, appointments, and medical records all in one place.
                    </p>
                    <div class="flex gap-4">
                        <a href="<?= app('auth') ?>" class="ui big primary button" tabindex="0"
                            aria-label="Get Started">
                            <i class="rocket icon"></i>
                            Get Started
                        </a>
                        <a href="#features" class="ui big basic button" tabindex="0" aria-label="Learn More">
                            <i class="info circle icon"></i>
                            Learn More
                        </a>
                    </div>
                </div>
                <div class="hidden lg:block">
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-blue-50 rounded-xl p-6 text-center">
                                <i class="fas fa-users text-4xl text-blue-600 mb-3"></i>
                                <h3 class="text-2xl font-bold text-gray-800">500+</h3>
                                <p class="text-sm text-gray-600">Patients</p>
                            </div>
                            <div class="bg-cyan-50 rounded-xl p-6 text-center">
                                <i class="fas fa-user-md text-4xl text-cyan-600 mb-3"></i>
                                <h3 class="text-2xl font-bold text-gray-800">20+</h3>
                                <p class="text-sm text-gray-600">Doctors</p>
                            </div>
                            <div class="bg-indigo-50 rounded-xl p-6 text-center">
                                <i class="fas fa-calendar-check text-4xl text-indigo-600 mb-3"></i>
                                <h3 class="text-2xl font-bold text-gray-800">1000+</h3>
                                <p class="text-sm text-gray-600">Appointments</p>
                            </div>
                            <div class="bg-purple-50 rounded-xl p-6 text-center">
                                <i class="fas fa-clock text-4xl text-purple-600 mb-3"></i>
                                <h3 class="text-2xl font-bold text-gray-800">24/7</h3>
                                <p class="text-sm text-gray-600">Support</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Powerful Features</h2>
                <p class="text-xl text-gray-600">Everything you need to manage mental health care efficiently</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-calendar-alt text-3xl text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Appointment Management</h3>
                    <p class="text-gray-600">Schedule, track, and manage patient appointments with ease. Get reminders
                        and notifications.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-cyan-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-file-medical text-3xl text-cyan-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Patient Records</h3>
                    <p class="text-gray-600">Secure digital patient records with complete medical history and treatment
                        plans.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-3xl text-indigo-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Analytics & Reports</h3>
                    <p class="text-gray-600">Comprehensive analytics and reporting tools to track patient progress and
                        outcomes.</p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-user-md text-3xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Doctor Portal</h3>
                    <p class="text-gray-600">Dedicated portal for doctors to manage their schedules and patient
                        consultations.</p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-prescription text-3xl text-pink-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Prescription Management</h3>
                    <p class="text-gray-600">Digital prescription system with medication tracking and refill reminders.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-3xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Secure & Private</h3>
                    <p class="text-gray-600">HIPAA compliant security measures to protect sensitive patient information.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-cyan-600">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Ready to Get Started?</h2>
            <p class="text-xl text-blue-100 mb-8">
                Join Wayside Psyche Resources Center and experience modern mental health care management.
            </p>
            <a href="<?= app('auth') ?>" class="ui huge inverted button" tabindex="0" aria-label="Start Now">
                <i class="sign in icon"></i>
                Start Now
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <i class="fas fa-heartbeat text-2xl text-blue-500"></i>
                        <h3 class="text-xl font-semibold text-white">MindTrack</h3>
                    </div>
                    <p class="text-gray-400">
                        Wayside Psyche Resources Center's comprehensive mental health management system.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">About Us</a></li>
                        <li><a href="#features" class="text-gray-400 hover:text-white transition-colors">Features</a>
                        </li>
                        <li><a href="<?= app('auth') ?>"
                                class="text-gray-400 hover:text-white transition-colors">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-phone mr-2"></i> +1 (555) 123-4567</li>
                        <li><i class="fas fa-envelope mr-2"></i> info@waysidepsyche.com</li>
                        <li><i class="fas fa-map-marker-alt mr-2"></i> 123 Health Street</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-500">
                <p>&copy; <?= date('Y') ?> Wayside Psyche Resources Center. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <?php shared('components/elements/scripts'); ?>
</body>

</html>