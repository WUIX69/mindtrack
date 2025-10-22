<?php
require_once __DIR__ . '/../../core/app.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    header('Location: ' . app('auth'));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>Logs - MindTrack</title>
    <?php shared('components/elements/styles'); ?>
</head>

<body class="bg-gradient-to-br from-blue-100 via-cyan-50 to-blue-50 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php shared('components/layout/sidebar') ?>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-file-alt"></i> System Logs
                </h1>
                <p class="text-gray-600 mb-6">View system activity and error logs</p>

                <div class="ui info message">
                    <div class="header">Coming Soon</div>
                    <p>This page is under development. Logs feature will be available soon.</p>
                </div>
            </div>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>
</body>

</html>