<?php include_once __DIR__ . '/../../core/app.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= shared('elements/meta') ?>
    <title>Dashboard - VetSync</title>
    <?= shared('elements/styles') ?>
</head>

<body>

    <div class="shared-standalone-content">
        <?= shared('layouts/loader/window') ?> <!-- Window Spinner -->
        <?= featured('dashboard/components/reminder-modal') ?> <!-- Reminder Modal -->
        <?= shared('components/flyout') ?> <!-- Flyout -->
    </div>

    <div class="container-body pusher">
        <!-- Sidebar -->
        <?= partial('layouts/sidebar') ?>
        <!-- Navbar -->
        <?= partial('layouts/navbar') ?>

        <!-- Main Content -->
        <main class="container-main">
            <div class="row">
                <div class="col-lg-9">
                    <!-- Stats Cards -->
                    <?= featured('dashboard/components/stats-card-admin') ?>

                    <!-- New Users -->
                    <?= featured('dashboard/components/new-users') ?>

                    <!-- Recent Orders -->
                    <?= featured('dashboard/components/recent-orders') ?>
                </div>
                <!-- Right Section -->
                <div class="col-lg-3">
                    <!-- System Info -->
                    <?= featured('dashboard/components/sys-info') ?>

                    <!-- Reminders -->
                    <?= featured('dashboard/components/reminders') ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <?= shared('elements/scripts') ?>
    <script src="<?= featured('dashboard/js/reminderForm.js', true) ?>"></script>
    <script src="<?= featured('dashboard/js/recentOrders.js', true) ?>"></script>
</body>

</html>