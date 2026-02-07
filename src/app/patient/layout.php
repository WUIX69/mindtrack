<?php
/**
 * Patient Section Layout
 * 
 * Wraps the patient dashboard pages with the sidebar and custom structure.
 * Includes the root layout automatically.
 */

// Register shutdown function to close the patient wrapper BEFORE the root layout closes
register_shutdown_function(function () {
    echo '</section></div>';
});

// Configure Root Layout
$showNavbar = false;
$showFooter = false;

// Ensure page title is set
$pageTitle = $pageTitle ?? "MindTrack Patient Portal";

// Include Root Layout
include_once __DIR__ . '/../layout.php';

// Determine current page for sidebar
// Try to guess from script if not set
if (!isset($currentPage)) {
    if (strpos($_SERVER['REQUEST_URI'] ?? '', 'appointments') !== false) {
        $currentPage = 'appointments';
    } elseif (strpos($_SERVER['REQUEST_URI'] ?? '', 'records') !== false) {
        $currentPage = 'records';
    } elseif (strpos($_SERVER['REQUEST_URI'] ?? '', 'resources') !== false) {
        $currentPage = 'resources';
    } elseif (strpos($_SERVER['REQUEST_URI'] ?? '', 'settings') !== false) {
        $currentPage = 'settings';
    } else {
        $currentPage = 'dashboard';
    }
}
?>

<!-- Patient Layout Wrapper -->
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <?= shared('components', 'layout/sidebar', ['currentPage' => $currentPage]); ?>

    <!-- Main Content Area -->
    <section class="flex-1 ml-64 p-8 w-full">