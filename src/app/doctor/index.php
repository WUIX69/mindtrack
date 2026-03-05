<?php
/**
 * Doctor Dashboard Index
 */
$pageTitle = "MindTrack Doctor Dashboard";
$headerData = [
    'title' => 'Greetings, Dr.',
    'description' => "Welcome back to Wayside Psyche Resources Center",
    'searchPlaceholder' => 'Search patient records, sessions, or clinical files...',
    'actionLabel' => 'Export Report'
];
include_once __DIR__ . '/layout.php';
?>

<!-- Stats Cards -->
<?= featured('dashboard', 'components/doctor-stats') ?>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Today\'s Schedule -->
    <?= featured('dashboard', 'components/doctor-todays-schedule') ?>

    <!-- Side Panels: Activity & Quick Links -->
    <div class="space-y-8">
        <!-- Quick Links -->
        <?= featured('dashboard', 'components/doctor-quick-links') ?>

        <!-- Recent Activity -->
        <?= featured('dashboard', 'components/doctor-recent-activity') ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        // Code here...
    });
</script>