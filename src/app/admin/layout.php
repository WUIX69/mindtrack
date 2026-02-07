<?php
/**
 * Admin Layout - Specific layout for Administrative pages
 */

include_once __DIR__ . '/../../core/app.php';

// Page metadata
$pageTitle = $pageTitle ?? "Admin Dashboard - MindTrack";
$bodyClass = $bodyClass ?? '';
$headContent = $headContent ?? '';

/**
 * Start the admin layout
 */
function admin_layout_start(): void
{
    global $pageTitle, $bodyClass, $headContent;
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?= shared('components', 'elements/meta'); ?>
        <title>
            <?= htmlspecialchars($pageTitle) ?>
        </title>
        <?= shared('components', 'elements/head'); ?>

        <!-- Google Fonts: Manrope -->
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap"
            rel="stylesheet" />

        <style>
            body {
                font-family: 'Manrope', sans-serif;
            }

            .sidebar-item-active {
                background-color: rgba(71, 82, 235, 0.1);
                color: #4752eb;
                border-right: 3px solid #4752eb;
            }
        </style>
        <?= $headContent ?>
    </head>

    <body class="bg-muted/50 dark:bg-background text-foreground font-display transition-colors duration-200">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar Navigation -->
            <?= shared('components', 'layout/sidebar', ['isAdmin' => true]); ?>

            <!-- Main Content Area -->
            <main class="flex-1 flex flex-col ml-64 w-full overflow-hidden">
                <!-- Dashboard Content Container (Headers now defined within pages) -->
                <div class="flex-1 overflow-y-auto p-4 md:p-8 space-y-8 scroll-smooth">
                    <?php
}

/**
 * End the admin layout
 */
function admin_layout_end(): void
{
    ?>
                </div>
            </main>
        </div>
        <?= shared('components', 'elements/scripts'); ?>
    </body>

    </html>
    <?php
}

// Auto-start
admin_layout_start();

// Auto-close
register_shutdown_function('admin_layout_end');
