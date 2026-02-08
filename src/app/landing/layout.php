<?php
/**
 * Landing Layout - Specific for public-facing pages
 * 
 * Includes the Root Layout shell and wraps content with public Navbar and Footer.
 */

// Prepare metadata if not set
$pageTitle = $pageTitle ?? "MindTrack";

// Include Root Layout Shell
include_once __DIR__ . '/../layout.php';
?>

<!-- Public Navigation -->
<?= shared('components', 'layout/navbar'); ?>

<!-- Page Content -->
<div class="max-w-[1200px] mx-auto w-full px-6 py-12 flex-1">
    <?php
    // Register footer and closing tags
    register_shutdown_function(function () {
        echo '</div>'; // Close max-width container
        echo shared('components', 'layout/footer');
    });
    ?>