<?php
/**
 * Auth Layout - Specific for Authentication pages (Login, Signup)
 * 
 * Includes the Root Layout shell.
 */



// Prepare metadata if not set
$pageTitle = $pageTitle ?? "MindTrack Auth";

// Include Root Layout Shell
include_once __DIR__ . '/../layout.php';
?>

<!-- Auth Content Wrapper (if needed) -->
<div class="auth-wrapper min-h-screen flex flex-col justify-center">
    <?php
    // Register closing tags
    register_shutdown_function(function () {
        echo '</div>';
    });
    ?>