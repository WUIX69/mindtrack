<?php
/**
 * Root Layout - Similar to Next.js RootLayout
 * 
 * This layout provides the common HTML structure, head, and body wrapper.
 * 
 * Usage in child pages (simple!):
 * 
 *   <?php
 *   $pageTitle = "About Us";
 *   include __DIR__ . '/../layout.php';
 *   ?>
 *   
 *   <!-- Your page content here (this becomes $slot) -->
 *   <section>...</section>
 */

include_once __DIR__ . '/../core/app.php';

// Page metadata (can be overridden by child pages before including this file)
$pageTitle = $pageTitle ?? "MindTrack";

$showNavbar = $showNavbar ?? true;
$showFooter = $showFooter ?? true;
$bodyClass = $bodyClass ?? '';

$headContent = $headContent ?? ''; // Custom styles/scripts for <head>

/**
 * Start the layout - outputs everything before the content slot
 */
function layout_start(): void
{
    global $pageTitle, $showNavbar, $bodyClass, $headContent;
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?= shared('components', 'elements/meta'); ?>
        <title><?= htmlspecialchars($pageTitle) ?></title>
        <?= shared('components', 'elements/head'); ?>
        <?= $headContent ?>
    </head>

    <body
        class="bg-background font-display text-foreground transition-colors duration-200 <?= htmlspecialchars($bodyClass) ?>">
        <div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">

            <?php if ($showNavbar): ?>
                <?= shared('components', 'layout/navbar'); ?>
            <?php endif; ?>

            <main class="flex-1">
                <?php
}

/**
 * End the layout - outputs everything after the content slot
 */
function layout_end(): void
{
    global $showFooter;
    ?>
            </main>

            <?php if ($showFooter): ?>
                <?= shared('components', 'layout/footer'); ?>
            <?php endif; ?>

        </div>
        <?= shared('components', 'elements/scripts'); ?>
    </body>

    </html>
    <?php
}

// Auto-start the layout when this file is included
layout_start();

// Register shutdown function to auto-close the layout
register_shutdown_function('layout_end');
