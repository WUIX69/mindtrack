<?php
/**
 * Admin - Patients Management
 */
$pageTitle = "Patients Management - MindTrack";
$headerData = [
    'title' => 'Patients',
    'description' => 'Maintain comprehensive health records and track clinical progress.',
    'searchPlaceholder' => 'Find patient by name or ID...',
    'actionLabel' => 'Add New Patient',
    'actionIcon' => 'person_add',
    'mb' => 4
];
$currentPage = 'patients';

include_once __DIR__ . '/layout.php';
?>

<?php
$patientFilterConfig = [
    'primary' => [
        'name' => 'status',
        'label' => 'Status:',
        'options' => [
            ['value' => '', 'label' => 'All'],
            ['value' => 'active', 'label' => 'Active'],
            ['value' => 'inactive', 'label' => 'Inactive']
        ]
    ],
    'secondary_filters' => [
        [
            'type' => 'select',
            'name' => 'sort',
            'icon' => 'event_repeat',
            'placeholder' => 'Sort Order',
            'options' => [
                'recent' => 'Recent First',
                'oldest' => 'Oldest First',
                'last_visit' => 'Last Visit'
            ]
        ],
        [
            'type' => 'date',
            'name' => 'registration_date',
            'icon' => 'calendar_today',
            'placeholder' => 'Registration Date'
        ]
    ],
    'actions' => [
        [
            'label' => 'More Filters',
            'icon' => 'filter_list',
            'id' => 'more-filters',
            'class' => 'text-primary hover:opacity-80'
        ]
    ]
];
?>
<!-- Filter Sub-header -->
<?= shared('components', 'layout/filterbar', $patientFilterConfig) ?>

<!-- Main Grid Layout -->
<div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
    <!-- Patients Table Section -->
    <div class="xl:col-span-3">
        <div class="bg-card rounded-xl border border-border overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-muted/50 text-muted-foreground uppercase text-[11px] font-bold tracking-wider">
                        <th class="px-6 py-4">Patient</th>
                        <th class="px-6 py-4">Contact</th>
                        <th class="px-6 py-4">Last Appointment</th>
                        <th class="px-6 py-4 text-center">Total Sessions</th>
                        <th class="px-6 py-4">Medical Alerts</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/50">
                    <?php
                    $patients = [
                        [
                            'id' => '#PAT-8821',
                            'name' => 'Sarah Jenkins',
                            'email' => 's.jenkins@email.com',
                            'phone' => '(555) 123-4567',
                            'lastAppt' => 'Oct 14, 2023',
                            'service' => 'CBT Therapy',
                            'sessions' => 12,
                            'alerts' => ['error', 'warning'],
                            'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBuSrDgvGssA8-kTcQGexMFtKyom0cr0TCWzs71Ix8e7M7Y1fLdhfsIcXy7xQrd3x0eePT9Ab0dS6oG9keYC5AMKahT3C1XTFA4QU5LJD7fs0PrXK7VH7JFB22oKlh4Nx_wxRC6vcp_U7PrqEx-w_tUaX9gOGV4aSNQtSkgkWaAaZw5ixd14J52RVzID34DfL7Pau3p21BoT-VTZehYcWycXutX-5UUE3fq-wgLyvN-QAgqPjfeLLy2PaGdG89DgPEKvLGUs3bUTGs'
                        ],
                        [
                            'id' => '#PAT-9012',
                            'name' => 'Michael Chen',
                            'email' => 'm.chen@outlook.com',
                            'phone' => '(555) 987-6543',
                            'lastAppt' => 'Oct 10, 2023',
                            'service' => 'General Consultation',
                            'sessions' => 4,
                            'alerts' => [],
                            'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAVXJ6b8SIotbSiUkAdvVNjZ6nAmoAGYH6fjncvXZWAme6aXuCa2EYSDqT84oAaU1JQWwRpWOnJXQ_ot45YwJHACcdMwtWOrF-NsRD4Ty3T3DlvH4q1T6PvXm9kj3aOh53QIbUQ0oE4g-N_PW1kIteYRUNpmQWpvDNdr01Bh0DXMH_HGFM5KcMX2tRR_WBp33F2lk2wkb5jTUD29VuyMp_hH87Y5SVOeQhodxhjKHAD7cl2q0vFIi4ISw8gXAyhbJw2suveumoNfm0'
                        ],
                        [
                            'id' => '#PAT-4432',
                            'name' => 'Elena Rodriguez',
                            'email' => 'elena.rod@gmail.com',
                            'phone' => '(555) 444-5566',
                            'lastAppt' => 'Sep 28, 2023',
                            'service' => 'Child Psychology',
                            'sessions' => 28,
                            'alerts' => ['success'],
                            'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCGJcNjizzbrsZ4iYpZ47NpngDiw7By5VdzhAWqEOO8o0NQyPAcS-Uw-R2Nwh5gYJ1U-BD1Px98XMmIaUMyQ660k6uXjIxTWDgpUih3v5mub1RSIKpgOiJCOZZzobFQuNo7PLMqheAhskHP7Sv4-dGGB9qgP7vmZJ-ovuolFx41dOCgQg-1Dg-5ViI9ad7cO2Se9gUn9_TO-gdBtXGX06Xl62UA07aEv5yv2IHem4Tri7N4wrRSVLPhS-Y0ylBoL0TELAeJ7VfBvX0'
                        ],
                    ];

                    foreach ($patients as $p):
                        ?>
                        <tr class="hover:bg-muted/30 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-9 rounded-full bg-muted bg-cover bg-center"
                                        style="background-image: url('<?= $p['img'] ?>')"></div>
                                    <div>
                                        <p class="text-sm font-semibold text-foreground">
                                            <?= $p['name'] ?>
                                        </p>
                                        <p class="text-[10px] text-muted-foreground uppercase">
                                            <?= $p['id'] ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs space-y-0.5">
                                    <p class="text-foreground font-medium">
                                        <?= $p['email'] ?>
                                    </p>
                                    <p class="text-muted-foreground">
                                        <?= $p['phone'] ?>
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-xs">
                                    <p class="font-bold text-foreground">
                                        <?= $p['lastAppt'] ?>
                                    </p>
                                    <p class="text-muted-foreground">
                                        <?= $p['service'] ?>
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-bold text-foreground">
                                    <?= $p['sessions'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-1">
                                    <?php if (empty($p['alerts'])): ?>
                                        <span class="size-2 rounded-full bg-muted"></span>
                                    <?php else: ?>
                                        <?php foreach ($p['alerts'] as $alert): ?>
                                            <span class="size-2 rounded-full bg-<?= $alert ?>"
                                                title="<?= ucfirst($alert) ?> Priority Alert"></span>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button
                                        class="px-3 py-1.5 bg-primary/10 text-primary text-xs font-bold rounded hover:bg-primary hover:text-white transition-all">Manage</button>
                                    <button
                                        class="size-8 rounded-lg flex items-center justify-center text-muted-foreground hover:bg-muted transition-all">
                                        <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="p-4 border-t border-border flex items-center justify-between">
                <p class="text-xs text-muted-foreground font-medium">Showing 1-3 of 284 patients</p>
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
        <!-- Demographics Widget -->
        <div class="bg-card rounded-xl border border-border p-6 shadow-sm">
            <h3 class="text-sm font-bold mb-4 flex items-center gap-2 uppercase tracking-tight text-foreground">
                <span class="material-symbols-outlined text-primary text-[20px]">analytics</span>
                Patient Demographics
            </h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">Adults (18-65)</span>
                        <span class="text-foreground">65%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full w-[65%]"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">Adolescents (12-17)</span>
                        <span class="text-foreground">22%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-blue-400 rounded-full w-[22%]"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">Seniors (65+)</span>
                        <span class="text-foreground">13%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-warning rounded-full w-[13%]"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Growth Widget -->
        <div class="bg-card rounded-xl border border-border p-6 shadow-sm">
            <h3 class="text-sm font-bold mb-4 flex items-center gap-2 uppercase tracking-tight text-foreground">
                <span class="material-symbols-outlined text-success text-[20px]">person_add_alt</span>
                New Patients This Month
            </h3>
            <div class="flex items-end gap-2 mb-4">
                <span class="text-3xl font-bold text-foreground">42</span>
                <span class="text-xs font-bold text-success mb-1 flex items-center">
                    <span class="material-symbols-outlined text-[16px]">trending_up</span>
                    +12%
                </span>
            </div>
            <div class="flex items-center gap-1 h-12">
                <div class="flex-1 bg-primary/20 rounded-t h-[40%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[60%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[30%]"></div>
                <div class="flex-1 bg-primary rounded-t h-[90%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[50%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[75%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[85%]"></div>
            </div>
            <p class="mt-4 text-[11px] text-muted-foreground font-medium leading-relaxed">
                Registration rate is <span class="text-foreground font-bold">trending higher</span> than the previous
                3-month average.
            </p>
        </div>

        <!-- Compliance Card -->
        <div class="bg-primary/5 rounded-xl border border-primary/10 p-5">
            <h4 class="text-sm font-bold text-primary mb-2 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">info</span>
                Data Compliance
            </h4>
            <p class="text-xs text-muted-foreground leading-relaxed">
                Ensure all patient records are updated within <span class="font-bold text-foreground">24 hours</span> of
                their last consultation to maintain HIPAA compliance.
            </p>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
        // Event Listeners for Filters
        $(document).on('filter:change', function (e, filters) {
            console.log("Patient Filters changed:", filters);
            // Implement filtering logic here
        });
    });
</script>