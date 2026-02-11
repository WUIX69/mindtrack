<?php
/**
 * Admin - Doctors Management
 */
$pageTitle = "Doctors Management - MindTrack";
$headerData = [
    'title' => 'Doctors',
    'description' => 'Manage clinical staff, specialties, and provider availability.',
    'searchPlaceholder' => 'Search providers by name, specialty, or ID...',
    'actionLabel' => 'Add New Doctor',
    'actionIcon' => 'add_moderator',
    'mb' => 4
];
$currentPage = 'doctors';

include_once __DIR__ . '/layout.php';
?>


<?php
$doctorFilterConfig = [
    'primary' => [
        'name' => 'specialty',
        'label' => 'Specialty:',
        'options' => [
            ['value' => '', 'label' => 'All'],
            ['value' => 'psychotherapy', 'label' => 'Psychotherapy'],
            ['value' => 'cbt', 'label' => 'CBT'],
            ['value' => 'ot', 'label' => 'OT']
        ]
    ],
    'secondary_filters' => [
        [
            'type' => 'select',
            'name' => 'status',
            'icon' => 'check_circle',
            'placeholder' => 'All Statuses',
            'options' => [
                'active' => 'Active',
                'on_leave' => 'On Leave',
                'inactive' => 'Inactive'
            ]
        ]
    ],
    'actions' => [
        [
            'label' => 'Advanced Filters',
            'icon' => 'tune',
            'id' => 'advanced-filters',
            'class' => 'text-primary hover:opacity-80'
        ]
    ]
];
?>
<!-- Filter Sub-header -->
<?= shared('components', 'layout/filterbar', $doctorFilterConfig) ?>

<!-- Main Grid Layout -->
<div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
    <!-- Doctors Table Section -->
    <div class="xl:col-span-3">
        <div class="bg-card rounded-xl border border-border overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-muted/50 text-muted-foreground uppercase text-[11px] font-bold tracking-wider">
                        <th class="px-6 py-4">Doctor</th>
                        <th class="px-6 py-4">Contact</th>
                        <th class="px-6 py-4 text-center">Assigned Patients</th>
                        <th class="px-6 py-4">Availability</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/50">
                    <?php
                    $doctors = [
                        [
                            'name' => 'Dr. Julian Vance',
                            'specialty' => 'CBT Specialist',
                            'specialtyClass' => 'text-primary',
                            'email' => 'j.vance@mindtrack.com',
                            'phone' => '(555) 012-4455',
                            'patients' => 24,
                            'days' => 'Mon-Fri',
                            'hours' => '09:00 - 17:00',
                            'status' => 'Active',
                            'statusColor' => 'emerald',
                            'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAVXJ6b8SIotbSiUkAdvVNjZ6nAmoAGYH6fjncvXZWAme6aXuCa2EYSDqT84oAaU1JQWwRpWOnJXQ_ot45YwJHACcdMwtWOrF-NsRD4Ty3T3DlvH4q1T6PvXm9kj3aOh53QIbUQ0oE4g-N_PW1kIteYRUNpmQWpvDNdr01Bh0DXMH_HGFM5KcMX2tRR_WBp33F2lk2wkb5jTUD29VuyMp_hH87Y5SVOeQhodxhjKHAD7cl2q0vFIi4ISw8gXAyhbJw2suveumoNfm0'
                        ],
                        [
                            'name' => 'Dr. Sarah Laine',
                            'specialty' => 'Psychotherapist',
                            'specialtyClass' => 'text-indigo-500',
                            'email' => 's.laine@mindtrack.com',
                            'phone' => '(555) 012-9988',
                            'patients' => 18,
                            'days' => 'Tue, Thu, Sat',
                            'hours' => '10:00 - 18:00',
                            'status' => 'On Leave',
                            'statusColor' => 'amber',
                            'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBuSrDgvGssA8-kTcQGexMFtKyom0cr0TCWzs71Ix8e7M7Y1fLdhfsIcXy7xQrd3x0eePT9Ab0dS6oG9keYC5AMKahT3C1XTFA4QU5LJD7fs0PrXK7VH7JFB22oKlh4Nx_wxRC6vcp_U7PrqEx-w_tUaX9gOGV4aSNQtSkgkWaAaZw5ixd14J52RVzID34DfL7Pau3p21BoT-VTZehYcWycXutX-5UUE3fq-wgLyvN-QAgqPjfeLLy2PaGdG89DgPEKvLGUs3bUTGs'
                        ],
                        [
                            'name' => 'Dr. Michael Thorne',
                            'specialty' => 'Occupational Therapy',
                            'specialtyClass' => 'text-emerald-500',
                            'email' => 'm.thorne@mindtrack.com',
                            'phone' => '(555) 012-3322',
                            'patients' => 32,
                            'days' => 'Mon-Fri',
                            'hours' => '08:00 - 16:00',
                            'status' => 'Active',
                            'statusColor' => 'emerald',
                            'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCGJcNjizzbrsZ4iYpZ47NpngDiw7By5VdzhAWqEOO8o0NQyPAcS-Uw-R2Nwh5gYJ1U-BD1Px98XMmIaUMyQ660k6uXjIxTWDgpUih3v5mub1RSIKpgOiJCOZZzobFQuNo7PLMqheAhskHP7Sv4-dGGB9qgP7vmZJ-ovuolFx41dOCgQg-1Dg-5ViI9ad7cO2Se9gUn9_TO-gdBtXGX06Xl62UA07aEv5yv2IHem4Tri7N4wrRSVLPhS-Y0ylBoL0TELAeJ7VfBvX0'
                        ],
                    ];

                    foreach ($doctors as $d):
                        ?>
                        <tr class="hover:bg-muted/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-10 rounded-full bg-muted bg-cover bg-center border-2 border-card shadow-sm"
                                        style="background-image: url('<?= $d['img'] ?>')"></div>
                                    <div>
                                        <p class="text-sm font-semibold text-foreground">
                                            <?= $d['name'] ?>
                                        </p>
                                        <p class="text-[10px] <?= $d['specialtyClass'] ?> font-bold uppercase">
                                            <?= $d['specialty'] ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs space-y-0.5">
                                    <p class="text-foreground font-medium">
                                        <?= $d['email'] ?>
                                    </p>
                                    <p class="text-muted-foreground">
                                        <?= $d['phone'] ?>
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 bg-muted rounded-full text-xs font-bold text-foreground">
                                    <?= $d['patients'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs font-medium text-muted-foreground">
                                    <?= $d['days'] ?>
                                    <p class="text-[10px] text-muted-foreground/60">
                                        <?= $d['hours'] ?>
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-<?= $d['statusColor'] ?>-100 text-<?= $d['statusColor'] ?>-700 dark:bg-<?= $d['statusColor'] ?>-900/30 dark:text-<?= $d['statusColor'] ?>-400">
                                    <span class="size-1.5 rounded-full bg-<?= $d['statusColor'] ?>-500"></span>
                                    <?= $d['status'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button
                                        class="px-3 py-1.5 bg-primary/10 text-primary text-xs font-bold rounded hover:bg-primary hover:text-white transition-all">Manage</button>
                                    <button
                                        class="px-3 py-1.5 bg-muted text-muted-foreground text-xs font-bold rounded hover:bg-muted/80 transition-all">Edit</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="p-4 border-t border-border flex items-center justify-between">
                <p class="text-xs text-muted-foreground font-medium">Showing 1-3 of 42 doctors</p>
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
        <!-- Specialty Distribution Widget -->
        <div class="bg-card rounded-xl border border-border p-6 shadow-sm">
            <h3 class="text-sm font-bold mb-4 flex items-center gap-2 uppercase tracking-tight text-foreground">
                <span class="material-symbols-outlined text-primary text-[20px]">pie_chart</span>
                Specialty Distribution
            </h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">Psychotherapy</span>
                        <span class="text-foreground">42%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full w-[42%]"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">CBT Therapy</span>
                        <span class="text-foreground">35%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full w-[35%]"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">Occupational Therapy</span>
                        <span class="text-foreground">23%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-success rounded-full w-[23%]"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Capacity Widget -->
        <div class="bg-card rounded-xl border border-border p-6 shadow-sm">
            <h3 class="text-sm font-bold mb-4 flex items-center gap-2 uppercase tracking-tight text-foreground">
                <span class="material-symbols-outlined text-success text-[20px]">group_add</span>
                Provider Capacity
            </h3>
            <div class="flex items-end gap-2 mb-4">
                <span class="text-3xl font-bold text-foreground">88%</span>
                <span class="text-xs font-bold text-success mb-1 flex items-center">
                    <span class="material-symbols-outlined text-[16px]">trending_up</span>
                    Optimal
                </span>
            </div>
            <div class="flex items-center gap-1 h-12">
                <div class="flex-1 bg-primary/20 rounded-t h-[70%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[85%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[75%]"></div>
                <div class="flex-1 bg-primary rounded-t h-[95%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[80%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[90%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[85%]"></div>
            </div>
            <p class="mt-4 text-[11px] text-muted-foreground font-medium leading-relaxed">
                Current clinic capacity is at <span class="text-foreground font-bold">high utilization</span>. Consider
                onboarding new specialists.
            </p>
        </div>

        <!-- Quality Control Card -->
        <div class="bg-primary/5 rounded-xl border border-primary/10 p-5">
            <h4 class="text-sm font-bold text-primary mb-2 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">verified</span>
                Quality Control
            </h4>
            <p class="text-xs text-muted-foreground leading-relaxed">
                Monthly performance reviews are due for <span class="font-bold text-foreground">8 providers</span>.
                Please update session feedback reports by Friday.
            </p>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
        // Event Listeners for Filters
        $(document).on('filter:change', function (e, filters) {
            console.log("Filters changed:", filters);
            // Implement simple client-side filtering for demonstration, 
            // or trigger DataTables redraw if this was a DataTable (it's a static table currently in this view)

            // For now, since the table is hardcoded in PHP, we just log it.
            // In a real app, this would trigger an AJAX reload or filter the DOM rows.

            // Example Client-side row filtering:
            // const specialty = filters.specialty;
            // const status = filters.status;
            // $('tbody tr').each(function() {
            //    ... matching logic ...
            // });
        });
    });
</script>