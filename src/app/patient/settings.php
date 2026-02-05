<?php include_once __DIR__ . '/../../core/app.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?= shared('elements/meta'); ?> <!-- rcs Meta -->
    <title>Settings - VetSync</title>
    <?= shared('elements/styles'); ?> <!-- rcs Styles -->
    <link rel="stylesheet" href="<?= featured('settings/css/settings.css', true); ?>">
    <?= shared('elements/filepond/styles'); ?><!-- Filepond -->
</head>

<body>
    <div class="shared-standalone-content">
        <?= shared('layouts/loader/window'); ?>
        <?= shared('layouts/top-redirect-btn'); ?>
    </div>

    <div class="container-body">
        <!-- Site Header -->
        <?= partial('layouts/header'); ?>

        <main class="site-main">
            <!-- Header -->
            <?= featured('settings/components/header'); ?>

            <!-- Settings -->
            <section class="settings pb-5">
                <div class="container-xl">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <!-- Settings Nav -->
                            <?= featured('settings/components/settings-nav'); ?>
                        </div>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="tab-content card-body">
                                    <!-- Profile Tab Start -->
                                    <?= featured('settings/components/tab/profile'); ?>
                                    <!-- Profile Tab End -->

                                    <!-- Change Password Tab Start -->
                                    <?= featured('settings/components/tab/change-password'); ?>
                                    <!-- Change Password Tab End -->

                                    <!-- Notification Tab Start -->
                                    <?= featured('settings/components/tab/notification'); ?>
                                    <!-- Notification Tab End -->

                                    <!-- Preferences Tab Start -->
                                    <?= featured('settings/components/tab/preferences'); ?>
                                    <!-- Preferences Tab End -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- rcs Scripts -->
    <?= shared('elements/scripts'); ?>
    <!-- Filepond -->
    <?= shared('elements/filepond/scripts'); ?>
    <!-- Profile -->
    <script src="<?= featured('settings/js/profileUrlInputs.js', true); ?>"></script>
    <script src="<?= featured('settings/js/profileFetch.js', true); ?>"></script>
    <script src="<?= featured('settings/js/profileForm.js', true); ?>"></script>
    <script src="<?= featured('settings/js/profileUpload.js', true); ?>"></script>
    <!-- Change Password -->
    <script src="<?= featured('settings/js/changePasswordForm.js', true); ?>"></script>
</body>

</html>