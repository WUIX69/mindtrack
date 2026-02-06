<?php include_once __DIR__ . '/../../core/app.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= shared('elements/meta'); ?> <!-- rcs Meta -->
    <title>User Dashboard - Mindtrack</title>
    <?= shared('elements/styles'); ?> <!-- rcs Styles -->
    <link rel="stylesheet" href="<?= featured('dashboard/css/overview.css', true) ?>">
</head>

<body>

    <div class="shared-standalone-content">
        <?= shared('layouts/loader/window'); ?> <!-- Window Spinner -->
        <?= shared('layouts/top-redirect-btn'); ?> <!-- Top Redirect Button -->
        <?= featured('dashboard/components/modal/pet-flyout'); ?> <!-- Top Redirect Button -->
        <?= featured('dashboard/components/modal/add-pet-modal'); ?> <!-- Top Redirect Button -->
    </div>

    <div class="container-body">
        <!-- Site Header -->
        <?= partial('header'); ?>

        <main class="site-main">
            <!-- stats card section -->
            <?= featured('dashboard/components/stats-card'); ?>

            <!-- overview section -->
            <div class="overview">
                <div class="row">
                    <div class="col-lg-6">
                        <?= featured('dashboard/components/my-pets'); ?>
                    </div>
                    <div class="col-lg-3">
                        <?= featured('dashboard/components/popular'); ?>
                    </div>
                    <div class="col-lg-3">
                        <?= featured('dashboard/components/upcoming-events'); ?>
                    </div>
                </div>
            </div>
        </main>
    </div>


    <?= shared('elements/scripts'); ?> <!-- rcs Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= featured('dashboard/js/main.js', true); ?>"></script>
    <script src="<?= featured('dashboard/js/myPets.js', true); ?>"></script>

</body>

</html>