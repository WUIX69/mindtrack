<?php
/**
 * Doctor Dashboard Index
 */
$pageTitle = "MindTrack Doctor Dashboard";
$headerData = [
    'title' => 'Greetings, Doc 👨🏻‍⚕️👋',
    'description' => "Welcome back to Wayside Psyche Resources Center",
    'searchPlaceholder' => 'Search patient records, sessions, or clinical files...',
    'actionLabel' => 'Export Report'
];
include_once __DIR__ . '/layout.php';
?>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div
                class="size-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                <span class="material-symbols-outlined">event_available</span>
            </div>
            <span class="text-xs font-bold text-green-600 bg-green-100 dark:bg-green-900/30 px-2 py-1 rounded-full">+2
                from yest.</span>
        </div>
        <p class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Today\'s Sessions</p>
        <h3 class="text-3xl font-extrabold mt-1 text-foreground">8</h3>
    </div>
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div
                class="size-10 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600">
                <span class="material-symbols-outlined">pending_actions</span>
            </div>
            <span class="text-xs font-bold text-amber-600 bg-amber-100 dark:bg-amber-900/30 px-2 py-1 rounded-full">High
                Priority</span>
        </div>
        <p class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Pending Notes</p>
        <h3 class="text-3xl font-extrabold mt-1 text-foreground">3</h3>
    </div>
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div
                class="size-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600">
                <span class="material-symbols-outlined">medical_services</span>
            </div>
            <span class="text-xs font-bold text-muted-foreground">Total this week</span>
        </div>
        <p class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Consultations</p>
        <h3 class="text-3xl font-extrabold mt-1 text-foreground">12</h3>
    </div>
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div
                class="size-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                <span class="material-symbols-outlined">timer</span>
            </div>
        </div>
        <p class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Weekly Hours</p>
        <h3 class="text-3xl font-extrabold mt-1 text-foreground">34.5</h3>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Today\'s Schedule -->
    <?= featured('appointments', 'components/todays-schedule') ?>

    <!-- Side Panels: Activity & Quick Links -->
    <div class="space-y-8">
        <!-- Quick Links -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-foreground">Clinical Tools</h2>
            <div class="grid grid-cols-2 gap-3">
                <button
                    class="p-4 bg-card border border-border rounded-xl hover:border-primary transition-all text-left flex flex-col gap-2 shadow-sm group">
                    <span
                        class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">pill</span>
                    <span class="text-xs font-bold text-foreground opacity-80 group-hover:opacity-100">New Rx</span>
                </button>
                <button
                    class="p-4 bg-card border border-border rounded-xl hover:border-primary transition-all text-left flex flex-col gap-2 shadow-sm group">
                    <span
                        class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">outgoing_mail</span>
                    <span class="text-xs font-bold text-foreground opacity-80 group-hover:opacity-100">Referral</span>
                </button>
                <button
                    class="p-4 bg-card border border-border rounded-xl hover:border-primary transition-all text-left flex flex-col gap-2 shadow-sm group">
                    <span
                        class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">history_edu</span>
                    <span class="text-xs font-bold text-foreground opacity-80 group-hover:opacity-100">History
                        Search</span>
                </button>
                <button
                    class="p-4 bg-card border border-border rounded-xl hover:border-primary transition-all text-left flex flex-col gap-2 shadow-sm group">
                    <span
                        class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">lab_profile</span>
                    <span class="text-xs font-bold text-foreground opacity-80 group-hover:opacity-100">Lab Portal</span>
                </button>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-foreground">Recent Patient Activity</h2>
            <div class="bg-card rounded-xl border border-border overflow-hidden shadow-sm">
                <div class="divide-y divide-border">
                    <div class="p-4 hover:bg-muted/50 transition-colors">
                        <div class="flex items-start gap-3">
                            <div
                                class="mt-1 size-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                                <span class="material-symbols-outlined text-base">upload_file</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm text-foreground opacity-90"><span class="font-bold">Lab results</span>
                                    uploaded for Sarah Jenkins</p>
                                <span class="text-[10px] text-muted-foreground font-medium uppercase tracking-widest">12
                                    minutes ago</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 hover:bg-muted/50 transition-colors">
                        <div class="flex items-start gap-3">
                            <div
                                class="mt-1 size-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                                <span class="material-symbols-outlined text-base">done_all</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm text-foreground opacity-90"><span
                                        class="font-bold">Prescription</span> confirmed for David Miller</p>
                                <span class="text-[10px] text-muted-foreground font-medium uppercase tracking-widest">2
                                    hours ago</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 hover:bg-muted/50 transition-colors">
                        <div class="flex items-start gap-3">
                            <div
                                class="mt-1 size-8 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600">
                                <span class="material-symbols-outlined text-base">priority_high</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm text-foreground opacity-90"><span class="font-bold">Missed
                                        session</span> alert for Kevin Bates</p>
                                <span class="text-[10px] text-muted-foreground font-medium uppercase tracking-widest">4
                                    hours ago</span>
                            </div>
                        </div>
                    </div>
                </div>
                <button
                    class="w-full py-3 bg-muted/30 text-[10px] font-bold text-muted-foreground uppercase tracking-widest hover:text-primary hover:bg-muted transition-all border-t border-border">
                    View All Activity
                </button>
            </div>
        </div>
    </div>
</div>