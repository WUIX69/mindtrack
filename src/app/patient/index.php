<?php
$pageTitle = "MindTrack Patient Dashboard";
$currentPage = 'dashboard';

// Using standard semantic classes from global.css theme:
// bg-background-light -> bg-muted (or bg-gray-50 if muted is too dark/white)
// bg-background-dark -> bg-background (in dark mode default)
// bg-surface-light -> bg-card
// border-border-light -> border-border
$bodyClass = "bg-muted/50 dark:bg-background text-foreground font-display transition-colors duration-200";

$headerData = [
    'title' => 'Hello, Alex',
    'description' => 'Welcome back to your health dashboard. Everything looks great today.',
    'searchPlaceholder' => 'Search records...',
    'actionLabel' => 'Book New Appointment',
    'actionUrl' => 'appointments/step-1-service.php',
];

include __DIR__ . '/layout.php';
?>

<!-- Metrics Cards -->
<?= featured('dashboard', 'components/patient-metric-cards') ?>

<!-- Content Grid: Table & Sidebar Cards -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Appointment History Table -->
    <?= featured('appointments', 'components/appointment-history') ?>

    <!-- Side Cards -->
    <div class="space-y-6">
        <!-- Clinic Announcements -->
        <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">campaign</span>
                <h3 class="font-bold">Clinic Announcements</h3>
            </div>
            <ul class="space-y-4">
                <li class="border-l-4 border-primary pl-3">
                    <p class="text-xs text-muted-foreground">Oct 20, 2023</p>
                    <p class="text-sm font-bold">Labor Day Closure</p>
                    <p class="text-xs text-muted-foreground leading-relaxed">The center will be closed
                        on Oct 31st for annual maintenance.</p>
                </li>
                <li class="border-l-4 border-green-500 pl-3">
                    <p class="text-xs text-muted-foreground">Oct 18, 2023</p>
                    <p class="text-sm font-bold">New Workshop</p>
                    <p class="text-xs text-muted-foreground leading-relaxed">Join our "Anxiety Relief"
                        group session starting next Tuesday.</p>
                </li>
            </ul>
        </div>
        <!-- Mental Health Tip of the Day -->
        <div
            class="relative overflow-hidden bg-primary p-6 rounded-xl text-primary-foreground shadow-lg shadow-primary/20">
            <div class="absolute -right-4 -bottom-4 opacity-20">
                <span class="material-symbols-outlined text-8xl">self_improvement</span>
            </div>
            <h3 class="text-xs font-bold uppercase tracking-widest opacity-80 mb-2">Tip of the Day</h3>
            <p class="text-lg font-medium leading-snug mb-4">"Remember to practice 5 minutes of deep breathing
                today
                to reset your nervous system."</p>
            <button
                class="bg-white/20 hover:bg-white/30 text-white text-xs font-bold px-4 py-2 rounded-lg transition-colors cursor-pointer">
                Read More Tips
            </button>
        </div>
        <!-- Resource Card -->
        <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
            <h3 class="font-bold mb-4">Quick Links</h3>
            <div class="grid grid-cols-2 gap-3">
                <a class="flex flex-col items-center justify-center p-3 rounded-lg border border-border hover:bg-muted transition-colors group"
                    href="#">
                    <span
                        class="material-symbols-outlined text-muted-foreground group-hover:text-primary transition-colors">library_books</span>
                    <span class="text-[11px] font-bold mt-1 text-muted-foreground">Guides</span>
                </a>
                <a class="flex flex-col items-center justify-center p-3 rounded-lg border border-border hover:bg-muted transition-colors group"
                    href="#">
                    <span
                        class="material-symbols-outlined text-muted-foreground group-hover:text-primary transition-colors">support_agent</span>
                    <span class="text-[11px] font-bold mt-1 text-muted-foreground">Support</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<?= featured('appointments', 'components/summary-modal') ?>
<script src="<?= shared('data', 'appointment-statuses.js', true) ?>"></script>
<script>
    $(document).ready(function () {
        // Code here...
    });
</script>