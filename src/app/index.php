<?php include_once __DIR__ . '/../../core/app.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= shared('elements/meta'); ?> <!-- rcs Meta -->
    <title>Landing - Mindtrack</title>
    <?= shared('elements/styles'); ?> <!-- rcs Styles -->
    <link rel="stylesheet" href="<?= asset('lib/swiper/swiper-bundle.min.css'); ?>" /><!-- Link Swiper's CSS -->
</head>

<body>

    <div class="shared-standalone-content">
        <?= shared('layouts/loader/window'); ?> <!-- Window Spinner -->
        <?= shared('layouts/top-redirect-btn'); ?> <!-- Top Redirect Button -->
        <?= shared('booknow-modal'); ?> <!-- Book Now Modal -->
        <?= partial('header'); ?> <!-- SpecificHeader for landing -->
    </div>

    <div class="container-body">
        <div class="row">
            <div class="col-12">
                <main class="container-main">
                    <!-- Hero -->
                    <?= featured('home/components/hero'); ?>

                    <!-- Features -->
                    <?= featured('home/components/features'); ?>

                    <!-- Services -->
                    <?= featured('home/components/services'); ?>

                    <!-- Testimonials -->
                    <?= partial('testimonials'); ?>

                    <!-- Separator -->
                    <?= partial('separator'); ?>

                    <!-- Locations -->
                    <?= featured('home/components/location'); ?>

                    <!-- Reserve -->
                    <?= partial('reserve'); ?>
                </main>
            </div>
            <div class="col-12">
                <?= partial('footer'); ?> <!-- Specific Footer for landing -->
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <?= shared('elements/scripts'); ?> <!-- rcs Scripts -->
    <script src="<?= asset('lib/swiper/swiper-bundle.min.js'); ?>"></script><!-- Swiper JS -->
    <script src="<?= featured('home/js/main.js', true); ?>"></script>
    <!-- More scripts to be added for home page here -->
</body>

</html>