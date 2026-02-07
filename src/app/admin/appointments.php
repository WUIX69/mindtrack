<?php
/**
 * Admin - Appointments Management
 */
$pageTitle = "Appointments Management - MindTrack";
$headerData = [
    'title' => 'Appointments',
    'description' => 'Manage and schedule clinical sessions for all providers.',
    'searchPlaceholder' => 'Search appointments...',
    'actionLabel' => 'New Appointment',
    'actionIcon' => 'add',
    'mb' => 4
];

include_once __DIR__ . '/layout.php';
?>

<!-- Filter Sub-header -->
<div class="bg-card rounded-xl border border-border p-4 flex flex-wrap items-center gap-4 mb-8">
    <div class="flex items-center gap-2">
        <span class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Status:</span>
        <div class="flex bg-muted p-1 rounded-lg">
            <button class="px-4 py-1.5 text-xs font-bold rounded-md bg-card shadow-sm text-primary">All</button>
            <button
                class="px-4 py-1.5 text-xs font-bold rounded-md text-muted-foreground hover:text-foreground transition-colors">Upcoming</button>
            <button
                class="px-4 py-1.5 text-xs font-bold rounded-md text-muted-foreground hover:text-foreground transition-colors">Pending</button>
            <button
                class="px-4 py-1.5 text-xs font-bold rounded-md text-muted-foreground hover:text-foreground transition-colors">Completed</button>
        </div>
    </div>
    <div class="h-8 w-px bg-border hidden md:block"></div>
    <div class="flex items-center gap-4 flex-1">
        <select
            class="bg-muted border-none p-2 rounded-lg text-xs font-bold text-foreground focus:ring-primary/20 cursor-pointer">
            <option>All Providers</option>
            <option>Dr. Aris Thorne</option>
            <option>Dr. Helena Smith</option>
            <option>Dr. Sarah Connor</option>
        </select>
        <div class="relative">
            <span
                class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-[18px] text-muted-foreground">calendar_today</span>
            <input
                class="pl-10 pr-4 py-2 bg-muted border-none rounded-lg text-xs font-bold text-foreground w-64 focus:ring-primary/20"
                placeholder="Schedule Range" type="text" value="Oct 12, 2023 - Oct 19, 2023" />
        </div>
    </div>
    <button class="flex items-center gap-1.5 text-xs font-bold text-primary hover:opacity-80 transition-opacity">
        <span class="material-symbols-outlined text-[18px]">filter_list</span>
        Reset Filters
    </button>
</div>

<!-- Main Grid Layout -->
<div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
    <!-- Appointments Table Section -->
    <div class="xl:col-span-3">
        <div class="bg-card rounded-xl border border-border overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-muted/50 text-muted-foreground uppercase text-[11px] font-bold tracking-wider">
                        <th class="px-6 py-4">Patient</th>
                        <th class="px-6 py-4">Service</th>
                        <th class="px-6 py-4">Schedule</th>
                        <th class="px-6 py-4">Provider</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/50">
                    <?php
                    $appointments = [
                        [
                            'id' => '#PAT-8821',
                            'name' => 'Sarah Jenkins',
                            'service' => 'Cognitive Behavioral Therapy',
                            'date' => 'Oct 14, 2023',
                            'time' => '10:30 AM',
                            'provider' => 'Dr. Aris Thorne',
                            'status' => 'Upcoming',
                            'statusClass' => 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400',
                            'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBuSrDgvGssA8-kTcQGexMFtKyom0cr0TCWzs71Ix8e7M7Y1fLdhfsIcXy7xQrd3x0eePT9Ab0dS6oG9keYC5AMKahT3C1XTFA4QU5LJD7fs0PrXK7VH7JFB22oKlh4Nx_wxRC6vcp_U7PrqEx-w_tUaX9gOGV4aSNQtSkgkWaAaZw5ixd14J52RVzID34DfL7Pau3p21BoT-VTZehYcWycXutX-5UUE3fq-wgLyvN-QAgqPjfeLLy2PaGdG89DgPEKvLGUs3bUTGs'
                        ],
                        [
                            'id' => '#PAT-9012',
                            'name' => 'Michael Chen',
                            'service' => 'Psychotherapy Session',
                            'date' => 'Oct 15, 2023',
                            'time' => '01:45 PM',
                            'provider' => 'Dr. Helena Smith',
                            'status' => 'Pending',
                            'statusClass' => 'bg-warning/10 text-warning',
                            'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAVXJ6b8SIotbSiUkAdvVNjZ6nAmoAGYH6fjncvXZWAme6aXuCa2EYSDqT84oAaU1JQWwRpWOnJXQ_ot45YwJHACcdMwtWOrF-NsRD4Ty3T3DlvH4q1T6PvXm9kj3aOh53QIbUQ0oE4g-N_PW1kIteYRUNpmQWpvDNdr01Bh0DXMH_HGFM5KcMX2tRR_WBp33F2lk2wkb5jTUD29VuyMp_hH87Y5SVOeQhodxhjKHAD7cl2q0vFIi4ISw8gXAyhbJw2suveumoNfm0'
                        ],
                        [
                            'id' => '#PAT-4432',
                            'name' => 'Elena Rodriguez',
                            'service' => 'Child Psychology',
                            'date' => 'Oct 12, 2023',
                            'time' => '09:00 AM',
                            'provider' => 'Dr. Sarah Connor',
                            'status' => 'Completed',
                            'statusClass' => 'bg-success/10 text-success',
                            'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCGJcNjizzbrsZ4iYpZ47NpngDiw7By5VdzhAWqEOO8o0NQyPAcS-Uw-R2Nwh5gYJ1U-BD1Px98XMmIaUMyQ660k6uXjIxTWDgpUih3v5mub1RSIKpgOiJCOZZzobFQuNo7PLMqheAhskHP7Sv4-dGGB9qgP7vmZJ-ovuolFx41dOCgQg-1Dg-5ViI9ad7cO2Se9gUn9_TO-gdBtXGX06Xl62UA07aEv5yv2IHem4Tri7N4wrRSVLPhS-Y0ylBoL0TELAeJ7VfBvX0'
                        ],
                    ];

                    foreach ($appointments as $appt):
                        ?>
                        <tr class="hover:bg-muted/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-9 rounded-full bg-muted bg-cover bg-center"
                                        style="background-image: url('<?= $appt['img'] ?>')"></div>
                                    <div>
                                        <p class="text-sm font-semibold text-foreground">
                                            <?= $appt['name'] ?>
                                        </p>
                                        <p class="text-[10px] text-muted-foreground uppercase">
                                            <?= $appt['id'] ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-muted-foreground font-medium">
                                    <?= $appt['service'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <p class="font-bold text-foreground">
                                        <?= $appt['date'] ?>
                                    </p>
                                    <p class="text-xs text-muted-foreground">
                                        <?= $appt['time'] ?>
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-muted-foreground">
                                    <?= $appt['provider'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold <?= $appt['statusClass'] ?> uppercase tracking-wide">
                                    <?= $appt['status'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <?php if ($appt['status'] === 'Upcoming'): ?>
                                        <button
                                            class="size-8 rounded-lg flex items-center justify-center bg-muted text-muted-foreground hover:text-primary transition-all border border-border"
                                            title="Reschedule">
                                            <span class="material-symbols-outlined text-[18px]">calendar_add_on</span>
                                        </button>
                                    <?php elseif ($appt['status'] === 'Pending'): ?>
                                        <button
                                            class="size-8 rounded-lg flex items-center justify-center bg-success text-white hover:bg-success/90 shadow-sm transition-all"
                                            title="Confirm">
                                            <span class="material-symbols-outlined text-[18px]">check</span>
                                        </button>
                                        <button
                                            class="size-8 rounded-lg flex items-center justify-center bg-error text-white hover:bg-error/90 shadow-sm transition-all"
                                            title="Cancel">
                                            <span class="material-symbols-outlined text-[18px]">close</span>
                                        </button>
                                    <?php else: ?>
                                        <button
                                            class="size-8 rounded-lg flex items-center justify-center bg-muted text-muted-foreground hover:text-primary transition-all border border-border"
                                            title="View Records">
                                            <span class="material-symbols-outlined text-[18px]">description</span>
                                        </button>
                                    <?php endif; ?>
                                    <button
                                        class="size-8 rounded-lg flex items-center justify-center bg-muted text-muted-foreground hover:text-primary transition-all border border-border"
                                        title="View Details">
                                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="p-4 border-t border-border flex items-center justify-between">
                <p class="text-xs text-muted-foreground font-medium">Showing 1-3 of 42 appointments</p>
                <div class="flex gap-2">
                    <button
                        class="px-3 py-1 text-xs font-bold rounded bg-muted text-muted-foreground cursor-not-allowed border border-border">Prev</button>
                    <button
                        class="px-3 py-1 text-xs font-bold rounded bg-primary text-white border border-primary">1</button>
                    <button
                        class="px-3 py-1 text-xs font-bold rounded bg-muted text-foreground hover:bg-muted/80 transition-all border border-border">2</button>
                    <button
                        class="px-3 py-1 text-xs font-bold rounded bg-muted text-foreground hover:bg-muted/80 transition-all border border-border">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Stats Content -->
    <div class="space-y-6">
        <!-- Daily Load Widget -->
        <div class="bg-card rounded-xl border border-border p-6 shadow-sm">
            <h3 class="text-sm font-bold mb-4 flex items-center gap-2 uppercase tracking-tight text-foreground">
                <span class="material-symbols-outlined text-primary text-[20px]">leaderboard</span>
                Daily Appointment Load
            </h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">Morning (8AM-12PM)</span>
                        <span class="text-foreground">85%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full w-[85%]"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">Afternoon (12PM-4PM)</span>
                        <span class="text-foreground">62%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full w-[62%]"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">Evening (4PM-8PM)</span>
                        <span class="text-foreground">34%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-warning rounded-full w-[34%]"></div>
                    </div>
                </div>
            </div>
            <div class="mt-6 pt-6 border-t border-border">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs text-muted-foreground font-medium">Avg. Appt. Duration</span>
                    <span class="text-xs font-bold text-foreground">52 Mins</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-muted-foreground font-medium">Clinician Utilization</span>
                    <span class="text-[10px] font-bold px-2 py-0.5 bg-success/10 text-success rounded-full">High</span>
                </div>
            </div>
        </div>

        <!-- Efficiency Card -->
        <div class="bg-primary/5 rounded-xl border border-primary/10 p-5">
            <h4 class="text-sm font-bold text-primary mb-2 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">info</span>
                Schedule Efficiency
            </h4>
            <p class="text-xs text-muted-foreground leading-relaxed">
                To maintain optimal clinic flow, ensure at least <span class="font-bold text-foreground">15-minute
                    buffers</span> between back-to-back psychotherapy sessions.
            </p>
        </div>
    </div>
</div>