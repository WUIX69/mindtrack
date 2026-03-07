<?php
$pageTitle = "Notifications - MindTrack Patient";
$bodyClass = "bg-muted/50 dark:bg-background text-foreground font-display transition-colors duration-200";
$currentPage = 'notifications';
$headerData = [
    'title' => 'Notifications',
    'description' => 'Stay updated with your latest health journey activities.',
    'actionLabel' => 'Mark all as read',
    'actionIcon' => 'done_all',
    'actionId' => 'btn-mark-all-read',
    'actionClass' => 'bg-card hover:bg-muted border border-border text-foreground',
];

include __DIR__ . '/layout.php';
?>

<!-- Notification List -->
<?= featured('notifications', 'components/notification-list', ['role' => 'patient']) ?>