<?php
/**
 * Admin Layout - Specific layout for Administrative pages
 * 
 * Integrates with the universal Root Layout (src/app/layout.php)
 */



// Configure Root Layout
$pageTitle = $pageTitle ?? "Admin Dashboard - MindTrack";

// Register closure for admin wrapper tags (executes before root layout's shutdown)
register_shutdown_function(function () {
    echo '</div></section></div>';
});

// Include Root Layout (starts the HTML output)
include_once __DIR__ . '/../layout.php';

// Determine current page for sidebar active states
if (!isset($currentPage)) {
    $currentPage = 'dashboard';
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    foreach (['appointments', 'patients', 'doctors', 'logs', 'settings'] as $key) {
        if (strpos($uri, $key) !== false) {
            $currentPage = $key;
            break;
        }
    }
}
?>

<!-- Admin Layout Structure (Inside Root Layout Wrapper) -->
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar Navigation -->
    <?= shared('components', 'layout/sidebar', [
        'role' => 'admin',
        'currentPage' => $currentPage
    ]); ?>

    <!-- Scrollable content area -->
    <section class="flex-1 flex flex-col ml-64 w-full overflow-hidden">
        <div class="flex-1 overflow-y-auto p-4 md:p-8 space-y-8 scroll-smooth">
            <?php if (isset($headerData)): ?>
                <?= shared('components', 'layout/headbar', array_merge($headerData, ['role' => 'admin'])); ?>
            <?php endif; ?>