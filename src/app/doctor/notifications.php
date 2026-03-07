<?php
$pageTitle = "Notifications - MindTrack Doctor";
$bodyClass = "bg-muted/50 dark:bg-background text-foreground font-display transition-colors duration-200";
$currentPage = 'notifications';
$headerData = [
    'title' => 'Notifications',
    'description' => 'Stay on top of your patient activity and schedule updates.',
    'actionLabel' => 'Mark all as read',
    'actionIcon' => 'done_all',
    'actionId' => 'btn-mark-all-read',
    'actionClass' => 'bg-card hover:bg-muted border border-border text-foreground',
];

include __DIR__ . '/layout.php';
?>

<!-- Notification List -->
<?= featured('notifications', 'components/notification-list', ['role' => 'doctor']) ?>