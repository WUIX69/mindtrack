<?php
/**
 * Doctor Schedule Page - Weekly Calendar View
 */
$pageTitle = "My Schedule - MindTrack Doctor";

$headerData = [
    'title' => 'Weekly Schedule',
    'actionLabel' => 'Add Event',
    'actionIcon' => 'add',
    'extraContent' => '
        <div class="flex items-center gap-4 ml-4">
            <div class="flex bg-muted rounded-lg p-1">
                <button class="px-3 py-1 text-xs font-semibold rounded-md transition-all hover:text-foreground/80">Day</button>
                <button class="px-3 py-1 text-xs font-semibold rounded-md bg-card shadow-sm text-foreground">Week</button>
                <button class="px-3 py-1 text-xs font-semibold rounded-md hover:text-foreground/80">Month</button>
            </div>
            <div class="flex items-center gap-2">
                <button class="p-1 hover:bg-muted rounded-full">
                    <span class="material-symbols-outlined text-lg">chevron_left</span>
                </button>
                <span class="text-sm font-bold">Oct 16 - 22, 2023</span>
                <button class="p-1 hover:bg-muted rounded-full">
                    <span class="material-symbols-outlined text-lg">chevron_right</span>
                </button>
            </div>
        </div>
        <button class="px-4 py-2 bg-muted text-foreground/80 rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-muted/80 transition-colors ml-auto mr-2">
            <span class="material-symbols-outlined text-lg">format_list_bulleted</span>
            View Daily List
        </button>'
];

include_once __DIR__ . '/layout.php';
?>

<style>
    .calendar-grid {
        display: grid;
        grid-template-columns: 80px repeat(7, 1fr);
    }

    .time-slot {
        height: 80px;
        border-bottom: 1px solid theme('colors.border');
        border-right: 1px solid theme('colors.border');
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<div class="flex flex-col lg:flex-row gap-8 min-h-0 h-full">
    <!-- Main Calendar Area -->
    <div class="flex-1 flex flex-col min-w-0 bg-card rounded-2xl border border-border shadow-sm overflow-hidden h-full">
        <!-- Calendar Header Row -->
        <div class="sticky top-0 z-20 calendar-grid bg-card border-b border-border shrink-0">
            <div class="h-12 flex items-center justify-center border-r border-border"></div>
            <?php
            $days = [
                ['label' => 'Mon', 'num' => '16'],
                ['label' => 'Tue', 'num' => '17'],
                ['label' => 'Wed', 'num' => '18', 'active' => true],
                ['label' => 'Thu', 'num' => '19'],
                ['label' => 'Fri', 'num' => '20'],
                ['label' => 'Sat', 'num' => '21'],
                ['label' => 'Sun', 'num' => '22'],
            ];
            foreach ($days as $day): ?>
                <div
                    class="h-12 flex flex-col items-center justify-center border-r border-border <?= isset($day['active']) ? 'bg-primary/5' : '' ?>">
                    <span
                        class="text-[10px] font-bold <?= isset($day['active']) ? 'text-primary' : 'text-muted-foreground' ?> uppercase">
                        <?= $day['label'] ?>
                    </span>
                    <span class="text-sm font-bold <?= isset($day['active']) ? 'text-primary' : 'text-foreground' ?>">
                        <?= $day['num'] ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Scrollable Grid -->
        <div class="flex-1 overflow-y-auto scrollbar-hide relative">
            <div class="calendar-grid relative">
                <!-- Time Column -->
                <div class="col-start-1 bg-muted/30">
                    <?php
                    $times = ['08:00 AM', '09:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM', '05:00 PM', '06:00 PM'];
                    foreach ($times as $index => $time): ?>
                        <div
                            class="time-slot flex justify-center pt-2 text-[11px] font-semibold text-muted-foreground <?= $index === count($times) - 1 ? 'border-b-0' : '' ?>">
                            <?= $time ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Days Columns Content -->
                <div class="col-span-7 grid grid-cols-7 relative">
                    <!-- Mesh background -->
                    <div class="contents">
                        <?php for ($i = 0; $i < 77; $i++): ?>
                            <div class="time-slot <?= ($i >= 70) ? 'border-b-0' : '' ?>"></div>
                        <?php endfor; ?>
                    </div>

                    <!-- Appointment Cards Overlay -->
                    <div class="absolute inset-0 grid grid-cols-7">
                        <!-- Monday -->
                        <div class="relative col-start-1">
                            <div
                                class="absolute top-[80px] left-1 right-1 h-[120px] bg-purple-100 dark:bg-purple-900/40 border-l-4 border-purple-500 rounded-r-lg p-3 cursor-pointer shadow-sm hover:z-10 transition-all group">
                                <p
                                    class="text-[10px] font-bold text-purple-700 dark:text-purple-300 uppercase truncate mb-0.5">
                                    Psychotherapy</p>
                                <p class="text-xs font-bold text-foreground truncate">Sarah Jenkins</p>
                                <p class="text-[10px] text-purple-600/70 dark:text-purple-300/70 mt-1">09:00 - 10:30</p>
                            </div>
                        </div>

                        <!-- Tuesday -->
                        <div class="relative col-start-2">
                            <div
                                class="absolute top-[240px] left-1 right-1 h-[80px] bg-sky-100 dark:bg-sky-900/40 border-l-4 border-sky-500 rounded-r-lg p-3 cursor-pointer shadow-sm hover:z-10 transition-all">
                                <p
                                    class="text-[10px] font-bold text-sky-700 dark:text-sky-300 uppercase truncate mb-0.5">
                                    Consultation</p>
                                <p class="text-xs font-bold text-foreground truncate">Michael Ross</p>
                                <p class="text-[10px] text-sky-600/70 dark:text-sky-300/70 mt-1">11:00 - 12:00</p>
                            </div>
                        </div>

                        <!-- Wednesday (Active) -->
                        <div class="relative col-start-3 bg-primary/5">
                            <div
                                class="absolute top-[160px] left-1 right-1 h-[60px] bg-emerald-100 dark:bg-emerald-900/40 border-l-4 border-emerald-500 rounded-r-lg p-3 cursor-pointer shadow-sm hover:z-10 transition-all">
                                <p
                                    class="text-[10px] font-bold text-emerald-700 dark:text-emerald-300 uppercase truncate mb-0.5">
                                    Follow-up</p>
                                <p class="text-xs font-bold text-foreground truncate">Elena Rodriguez</p>
                            </div>
                            <div
                                class="absolute top-[400px] left-1 right-1 h-[160px] bg-purple-100 dark:bg-purple-900/40 border-l-4 border-purple-500 rounded-r-lg p-3 cursor-pointer shadow-sm hover:z-10 transition-all">
                                <p
                                    class="text-[10px] font-bold text-purple-700 dark:text-purple-300 uppercase truncate mb-0.5">
                                    Psychotherapy</p>
                                <p class="text-xs font-bold text-foreground truncate">James Wilson</p>
                                <p class="text-[10px] text-purple-600/70 dark:text-purple-300/70 mt-1">01:00 - 03:00</p>
                            </div>
                        </div>

                        <!-- Thursday -->
                        <div class="relative col-start-4">
                            <div
                                class="absolute top-[0px] left-1 right-1 h-[160px] bg-amber-100 dark:bg-amber-900/40 border-l-4 border-amber-500 rounded-r-lg p-3 cursor-pointer shadow-sm hover:z-10 transition-all">
                                <p
                                    class="text-[10px] font-bold text-amber-700 dark:text-amber-300 uppercase truncate mb-0.5">
                                    Family Therapy</p>
                                <p class="text-xs font-bold text-foreground truncate">The Bakers</p>
                                <p class="text-[10px] text-amber-600/70 dark:text-amber-300/70 mt-1">08:00 - 10:00</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Side Panel -->
    <div class="w-full lg:w-80 shrink-0 space-y-8">
        <!-- Calendar Navigation -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold flex items-center justify-between text-foreground/80">
                Calendar Navigation
                <span class="material-symbols-outlined text-muted-foreground text-lg">calendar_month</span>
            </h3>
            <div class="bg-card p-5 rounded-2xl border border-border shadow-sm">
                <div class="grid grid-cols-7 gap-1 text-center">
                    <?php foreach (['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $dayName): ?>
                        <span class="text-[10px] font-bold text-muted-foreground">
                            <?= $dayName ?>
                        </span>
                    <?php endforeach; ?>

                    <div class="text-xs p-1.5 text-muted-foreground/30">14</div>
                    <div class="text-xs p-1.5 text-muted-foreground/30">15</div>
                    <div
                        class="text-xs p-1.5 font-semibold hover:bg-muted rounded-lg cursor-pointer transition-colors text-foreground">
                        16</div>
                    <div
                        class="text-xs p-1.5 font-semibold hover:bg-muted rounded-lg cursor-pointer transition-colors text-foreground">
                        17</div>
                    <div
                        class="text-xs p-1.5 font-bold bg-primary text-primary-foreground rounded-lg cursor-pointer shadow-md shadow-primary/20">
                        18</div>
                    <div
                        class="text-xs p-1.5 font-semibold hover:bg-muted rounded-lg cursor-pointer transition-colors text-foreground">
                        19</div>
                    <div
                        class="text-xs p-1.5 font-semibold hover:bg-muted rounded-lg cursor-pointer transition-colors text-foreground">
                        20</div>
                </div>
            </div>
        </div>

        <!-- Upcoming Requests -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold flex items-center justify-between text-foreground/80">
                Upcoming Requests
                <span class="bg-primary text-primary-foreground text-[10px] px-2.5 py-1 rounded-full shadow-sm">3</span>
            </h3>
            <div class="space-y-3">
                <div
                    class="bg-card p-3.5 rounded-xl border border-border shadow-sm hover:border-primary/30 transition-all group">
                    <div class="flex items-center gap-3">
                        <img class="size-9 rounded-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBgZ5O4ZeiQPnCeFCkYe9R3m93uFqwNopkzpiJynk9qOmfuKCC1itOjJLeeSdPVfsfQZqnCPSjbLuoCsuT9fdYKQMQt1yjzE2cEnPyAJNDCzRFZw9ygISxuTDUaOMdmmUGN6GvU6NugfqKxWA-A7FwAwgwb87PxrkwWlI8C_dVV_rp_sHn-H4h-HacOW4dmPDAM-H_gQIBo8a4g6Uy8XJubcEDh3QWk9j2xLIhLdAjQrPm92ckFuFpA_XLOWr27Xe4GPz1uMRWIiLI"
                            alt="David Miller">
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold truncate text-foreground">David Miller</p>
                            <p class="text-[10px] text-muted-foreground mt-0.5">Requested: Oct 23</p>
                        </div>
                        <button
                            class="size-7 bg-primary/10 text-primary rounded-lg flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </button>
                    </div>
                </div>
                <div
                    class="bg-card p-3.5 rounded-xl border border-border shadow-sm hover:border-primary/30 transition-all group">
                    <div class="flex items-center gap-3">
                        <img class="size-9 rounded-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCAfb22TAnfpkFg7hBndFFxjAHCzhjPkLiQ3bJ_VlbRTKvSbI01uiuiUYEiUgPpTaTMlNVlnrlxsoH1VxsPdT3t_hcX2lnC_2cwCHruuduLbBl9bTT3fLP9Carv1_XiyUXqmTfToc_trexOJ5YTbNlEAvadxkCrhhTfGG9OVAdnAooDBEIXzJiRsL-8tzWiYEPOzSBSZx4UC7pdZMjqfimzZYMalDe0wPrGqqU8c6eiuh_S8yXQQwFbESVr4gtI78RiCrgAgBC6U1g"
                            alt="Lucia Fernandez">
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold truncate text-foreground">Lucia Fernandez</p>
                            <p class="text-[10px] text-muted-foreground mt-0.5">Requested: Oct 24</p>
                        </div>
                        <button
                            class="size-7 bg-primary/10 text-primary rounded-lg flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </button>
                    </div>
                </div>
            </div>
            <button
                class="w-full py-2.5 text-[10px] font-bold text-muted-foreground uppercase tracking-widest hover:text-primary transition-colors">
                View All Requests
            </button>
        </div>

        <!-- Filters -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold text-foreground/80">Calendar Filters</h3>
            <div class="space-y-2.5">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input checked type="checkbox"
                        class="rounded border-border text-primary focus:ring-primary size-4 bg-muted">
                    <span
                        class="text-xs font-medium text-muted-foreground group-hover:text-foreground transition-colors">Confirmed
                        Sessions</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input checked type="checkbox"
                        class="rounded border-border text-primary focus:ring-primary size-4 bg-muted">
                    <span
                        class="text-xs font-medium text-muted-foreground group-hover:text-foreground transition-colors">Pending
                        Requests</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox"
                        class="rounded border-border text-primary focus:ring-primary size-4 bg-muted">
                    <span
                        class="text-xs font-medium text-muted-foreground group-hover:text-foreground transition-colors">Canceled/Postponed</span>
                </label>
            </div>
        </div>
    </div>
</div>