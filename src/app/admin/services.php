<?php
/**
 * Admin - Services Management
 */
$pageTitle = "Clinical Services - MindTrack";
$headerData = [
    'title' => 'Services',
    'description' => 'Manage clinical programs, therapy types, and consultation sessions.',
    'actionLabel' => 'Add New Service',
    'actionIcon' => 'add'
];
$currentPage = 'services';

include_once __DIR__ . '/layout.php';
?>

<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm flex items-center gap-4">
        <div class="bg-primary/10 text-primary p-3 rounded-xl size-12 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">list_alt</span>
        </div>
        <div>
            <p class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Total Services</p>
            <p class="text-2xl font-black text-foreground">24</p>
        </div>
    </div>
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm flex items-center gap-4">
        <div class="bg-success/10 text-success p-3 rounded-xl size-12 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">check_circle</span>
        </div>
        <div>
            <p class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Active Programs</p>
            <p class="text-2xl font-black text-foreground">18</p>
        </div>
    </div>
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm flex items-center gap-4">
        <div class="bg-muted text-muted-foreground p-3 rounded-xl size-12 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">pause_circle</span>
        </div>
        <div>
            <p class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Inactive Services</p>
            <p class="text-2xl font-black text-foreground">6</p>
        </div>
    </div>
</div>

<?php
$serviceFilterConfig = [
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
            'type' => 'search',
            'name' => 'search',
            'placeholder' => 'Search services...',
            'icon' => 'search'
        ],
        [
            'type' => 'select',
            'name' => 'category',
            'icon' => 'category',
            'placeholder' => 'All Categories',
            'options' => [
                'therapy' => 'Therapy',
                'consultation' => 'Consultation',
                'program' => 'Clinical Program',
                'group' => 'Group Session'
            ]
        ]
    ]
];
?>

<?= shared('components', 'layout/filterbar', $serviceFilterConfig) ?>

<!-- Services Table Section -->
<section class="bg-card rounded-xl border border-border shadow-sm overflow-hidden mb-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-muted/50 text-muted-foreground uppercase text-[11px] font-bold tracking-wider">
                    <th class="px-6 py-4">Service Name</th>
                    <th class="px-6 py-4 whitespace-nowrap">Description</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Duration</th>
                    <th class="px-6 py-4">Base Rate</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border/50">
                <?php
                $services = [
                    [
                        'name' => 'CBT',
                        'desc' => 'Individual Cognitive Behavioral Therapy sessions for anxiety and depression.',
                        'category' => 'Therapy',
                        'catColor' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                        'duration' => '60 mins',
                        'rate' => '$120.00',
                        'active' => true
                    ],
                    [
                        'name' => 'Psychotherapy',
                        'desc' => 'General psychotherapy assessment and long-term care plans.',
                        'category' => 'Consultation',
                        'catColor' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                        'duration' => '90 mins',
                        'rate' => '$180.00',
                        'active' => true
                    ],
                    [
                        'name' => 'DBT Intensive',
                        'desc' => 'Dialectical Behavior Therapy 12-week specialized program.',
                        'category' => 'Clinical Program',
                        'catColor' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
                        'duration' => '120 mins',
                        'rate' => '$250.00',
                        'active' => false
                    ],
                    [
                        'name' => 'Mindfulness Group',
                        'desc' => 'Weekly group session focused on grounding techniques.',
                        'category' => 'Group Session',
                        'catColor' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
                        'duration' => '45 mins',
                        'rate' => '$45.00',
                        'active' => true
                    ],
                ];

                foreach ($services as $s):
                    ?>
                    <tr class="hover:bg-muted/30 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-foreground">
                                <?= $s['name'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <p class="text-xs text-muted-foreground truncate">
                                <?= $s['desc'] ?>
                            </p>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider <?= $s['catColor'] ?>">
                                <?= $s['category'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-muted-foreground">
                                <?= $s['duration'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-foreground">
                                <?= $s['rate'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input <?= $s['active'] ? 'checked' : '' ?> class="sr-only peer" type="checkbox" />
                                <div
                                    class="w-10 h-5 bg-border peer-focus:outline-none rounded-full peer dark:bg-muted/50 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary">
                                </div>
                            </label>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-3 text-muted-foreground">
                                <button
                                    class="hover:text-primary transition-colors flex items-center justify-center size-8 rounded-lg hover:bg-primary/10">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>
                                <button
                                    class="hover:text-primary transition-colors flex items-center justify-center size-8 rounded-lg hover:bg-primary/10">
                                    <span class="material-symbols-outlined text-[20px]">content_copy</span>
                                </button>
                                <button
                                    class="hover:text-error transition-colors flex items-center justify-center size-8 rounded-lg hover:bg-error/10">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="px-6 py-4 bg-muted/50 border-t border-border flex items-center justify-between">
        <p class="text-xs text-muted-foreground font-medium">Showing 1 to 4 of 24 services</p>
        <div class="flex items-center gap-2">
            <button
                class="p-1 px-2 rounded border border-border text-muted-foreground hover:bg-card hover:text-foreground disabled:opacity-50 transition-all font-bold text-xs flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">chevron_left</span> Previous
            </button>
            <div class="flex gap-1">
                <button
                    class="size-8 flex items-center justify-center rounded bg-primary text-primary-foreground text-xs font-bold">1</button>
                <button
                    class="size-8 flex items-center justify-center rounded hover:bg-muted text-foreground text-xs font-bold transition-all border border-border">2</button>
                <button
                    class="size-8 flex items-center justify-center rounded hover:bg-muted text-foreground text-xs font-bold transition-all border border-border">3</button>
            </div>
            <button
                class="p-1 px-2 rounded border border-border text-muted-foreground hover:bg-card hover:text-foreground transition-all font-bold text-xs flex items-center gap-1">
                Next <span class="material-symbols-outlined text-sm">chevron_right</span>
            </button>
        </div>
    </div>
</section>

<!-- Footnote Info -->
<div class="p-6 bg-primary/5 rounded-xl border border-primary/10 flex items-start gap-4">
    <span class="material-symbols-outlined text-primary">info</span>
    <div>
        <h4 class="text-sm font-bold text-primary">Service Catalog Optimization</h4>
        <p class="text-xs text-primary/80 mt-1 leading-relaxed">
            Updates to base rates or standard durations will only affect new appointments booked from this point
            forward.
            Existing appointments will maintain their original pricing and time allocation.
        </p>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Event Listeners for Filters
        $(document).on('filter:change', function (e, filters) {
            console.log("Service Filters changed:", filters);
            // Implement filtering logic here
        });
    });
</script>