<?php include_once __DIR__ . '/../../core/app.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= shared('elements/meta') ?>
    <title>Users Management - Admin</title>
    <?= shared('elements/styles') ?>

    <!-- Required for DataTables -->
    <link rel="stylesheet" href="<?= asset('lib/DataTables/datatables.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('lib/DataTables/dataTables.semanticui.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('lib/DataTables/responsive.semanticui.min.css') ?>">
</head>

<body>

    <div class="shared-standalone-content">
        <?= shared('layouts/loader/window') ?> <!-- Window Spinner -->
        <?= featured('dashboard/components/user-modal-admin') ?> <!-- User Modal -->
    </div>

    <div class="container-body pusher">
        <!-- Sidebar -->
        <?= partial('layouts/sidebar') ?>

        <!-- Main Content -->
        <main class="container-main">
            <!-- Header -->
            <?= featured('dashboard/components/header-admin') ?>

            <div class="row">
                <div class="col-lg-9">
                    <!-- User Stats -->
                    <?= featured('admin/users/components/user-stats-admin') ?>

                    <!-- New Users -->
                    <?= featured('admin/users/components/new-users-admin') ?>

                    <!-- Users List -->
                    <?= featured('admin/users/components/users-list-admin') ?>
                </div>
                <div class="col-lg-3">
                    <!-- Recent Activity -->
                    <?= featured('admin/users/components/recent-act-admin') ?>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <?= shared('elements/scripts') ?>
    <!-- Required for DataTables -->
    <script src="<?= asset('lib/DataTables/datatables.min.js') ?>"></script>
    <script src="<?= asset('lib/DataTables/dataTables.semanticui.min.js') ?>"></script>
    <script src="<?= asset('lib/DataTables/dataTables.responsive.min.js') ?>"></script>
    <script src="<?= asset('lib/DataTables/responsive.semanticui.min.js') ?>"></script>

    <!-- Required for tables -->
    <script src="<?= shared('utils', 'formatters.php', true) ?>"></script>
    <script src="<?= shared('utils', 'tableListFilters.php', true) ?>"></script>

    <!-- Page Scripts -->
    <script src="<?= featured('users/js/usersDataTable.js', true) ?>"></script>
    <script src="<?= featured('users/js/validateUserForm.js', true) ?>"></script>
</body>

</html>