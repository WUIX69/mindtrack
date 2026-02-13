<?php
/**
 * Admin - Services Management
 */
$pageTitle = "Service Management - MindTrack";
$headerData = [
    'title' => 'Service Management',
    'description' => 'Categorize and manage your clinical services and therapy offerings.',
    'actionLabel' => 'Add New Service',
    'actionIcon' => 'add',
    'mb' => '6' // Adjust bottom margin
];
$currentPage = 'services';

include_once __DIR__ . '/layout.php';

// --- Filter Configurations ---

// Categories Filter: Search + Add Button
$categoriesFilterConfig = [
    'mt' => 0,
    'mb' => 0,
    'isTransparent' => true,
    'secondary_filters' => [
        [
            'type' => 'search',
            'name' => 'search_categories',
            'placeholder' => 'Search categories...',
            'icon' => 'search'
        ]
    ],
    'actions' => [
        [
            'label' => 'Add Category',
            'icon' => 'add_circle',
            'id' => 'add-category-btn',
            'class' => 'text-primary hover:bg-primary/5 border border-primary/20' // Match reference outline style
        ]
    ]
];

// Services Filter: Search + Category Select
$servicesFilterConfig = [
    'mt' => 0,
    'mb' => 0,
    'isTransparent' => true,
    'secondary_filters' => [
        [
            'type' => 'search',
            'name' => 'search_services',
            'placeholder' => 'Search services...',
            'icon' => 'search'
        ],
        [
            'type' => 'select',
            'name' => 'filter_category',
            'placeholder' => 'All Categories',
            'icon' => 'category',
            'options' => [
                'therapy' => 'Therapy',
                'assessment' => 'Assessment',
                'consultation' => 'Consultation',
                'programs' => 'Programs',
                'general' => 'General'
            ]
        ]
    ]
];
?>

<div class="space-y-8">

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Categories Stat -->
        <div class="bg-card p-6 rounded-xl border border-border shadow-sm flex items-center gap-4">
            <div class="bg-primary/10 text-primary p-3 rounded-lg">
                <span class="material-symbols-outlined">category</span>
            </div>
            <div>
                <p class="text-sm font-medium text-muted-foreground">Categories</p>
                <p class="text-2xl font-bold text-foreground">5</p>
            </div>
        </div>
        <!-- Active Services Stat -->
        <div class="bg-card p-6 rounded-xl border border-border shadow-sm flex items-center gap-4">
            <div class="bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400 p-3 rounded-lg">
                <span class="material-symbols-outlined">list_alt</span>
            </div>
            <div>
                <p class="text-sm font-medium text-muted-foreground">Active Services</p>
                <p class="text-2xl font-bold text-foreground">18</p>
            </div>
        </div>
        <!-- Inactive Services Stat -->
        <div class="bg-card p-6 rounded-xl border border-border shadow-sm flex items-center gap-4">
            <div class="bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 p-3 rounded-lg">
                <span class="material-symbols-outlined">pause_circle</span>
            </div>
            <div>
                <p class="text-sm font-medium text-muted-foreground">Total Inactive</p>
                <p class="text-2xl font-bold text-foreground">6</p>
            </div>
        </div>
    </div>

    <!-- Service Categories Section -->
    <section class="space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-foreground flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">folder_open</span>
                Service Categories
            </h3>
            <!-- Filter Bar for Categories -->
            <?= shared('components', 'layout/filterbar', $categoriesFilterConfig) ?>
        </div>

        <div class="bg-card rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-muted/50 border-b border-border">
                            <th class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                Category
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                Description</th>
                            <th class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                Associated Services</th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50">
                        <?php
                        $categories = [
                            ['name' => 'Therapy', 'icon' => 'psychology', 'color' => 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400', 'desc' => 'Various therapeutic interventions for mental health.', 'count' => '12 Services'],
                            ['name' => 'Assessment', 'icon' => 'clinical_notes', 'color' => 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/20 dark:text-indigo-400', 'desc' => 'Diagnostic and psychological testing services.', 'count' => '4 Services'],
                            ['name' => 'Consultation', 'icon' => 'medical_services', 'color' => 'bg-purple-50 text-purple-600 dark:bg-purple-900/20 dark:text-purple-400', 'desc' => 'Initial and follow-up clinical consultations.', 'count' => '8 Services'],
                            ['name' => 'Programs', 'icon' => 'groups', 'color' => 'bg-orange-50 text-orange-600 dark:bg-orange-900/20 dark:text-orange-400', 'desc' => 'Training and development programs.', 'count' => '4 Services'],
                            ['name' => 'General', 'icon' => 'local_hospital', 'color' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400', 'desc' => 'General Services', 'count' => '2 Services'],
                        ];
                        foreach ($categories as $cat):
                            ?>
                            <tr class="hover:bg-muted/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="p-1.5 rounded <?= $cat['color'] ?>">
                                            <span class="material-symbols-outlined text-lg"><?= $cat['icon'] ?></span>
                                        </div>
                                        <span class="text-sm font-bold text-foreground"><?= $cat['name'] ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-xs text-muted-foreground max-w-md truncate"><?= $cat['desc'] ?></p>
                                </td>
                                <td class="px-6 py-4 text-sm text-muted-foreground"><?= $cat['count'] ?></td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2 text-muted-foreground">
                                        <button class="hover:text-primary transition-colors"><span
                                                class="material-symbols-outlined text-lg">edit</span></button>
                                        <button class="hover:text-error transition-colors"><span
                                                class="material-symbols-outlined text-lg">delete</span></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Individual Services Section -->
    <section class="space-y-4">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-foreground flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">medical_services</span>
                All Individual Services
            </h3>
            <!-- Filter Bar for Categories -->
            <?= shared('components', 'layout/filterbar', $servicesFilterConfig) ?>
        </div>

        <div class="bg-card rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-muted/50 border-b border-border">
                            <th class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                Service Name
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                Description</th>
                            <th class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                Category
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                Duration
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">Base
                                Rate
                            </th>
                            <th class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                Status
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50">
                        <?php
                        $services = [
                            [
                                'name' => 'CBT',
                                'desc' => 'Individual Cognitive Behavioral Therapy sessions for anxiety and depression.',
                                'cat' => 'Therapy',
                                'catColor' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                'dur' => '60 mins',
                                'rate' => '$120.00',
                                'active' => true
                            ],
                            [
                                'name' => 'Psychotherapy',
                                'desc' => 'General psychotherapy assessment and long-term care plans.',
                                'cat' => 'Consultation',
                                'catColor' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
                                'dur' => '90 mins',
                                'rate' => '$180.00',
                                'active' => true
                            ]
                        ];
                        foreach ($services as $svc):
                            ?>
                            <tr class="hover:bg-muted/30 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-foreground"><?= $svc['name'] ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-xs text-muted-foreground max-w-xs truncate"><?= $svc['desc'] ?></p>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider <?= $svc['catColor'] ?>">
                                        <?= $svc['cat'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-muted-foreground"><?= $svc['dur'] ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-foreground"><?= $svc['rate'] ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input <?= $svc['active'] ? 'checked' : '' ?> class="sr-only peer" type="checkbox" />
                                        <div
                                            class="w-10 h-5 bg-border peer-focus:outline-none rounded-full peer dark:bg-muted/50 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary">
                                        </div>
                                    </label>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2 text-muted-foreground">
                                        <button class="hover:text-primary transition-colors"><span
                                                class="material-symbols-outlined text-lg">edit</span></button>
                                        <button class="hover:text-primary transition-colors"><span
                                                class="material-symbols-outlined text-lg">content_copy</span></button>
                                        <button class="hover:text-error transition-colors"><span
                                                class="material-symbols-outlined text-lg">delete</span></button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-muted/50 border-t border-border flex items-center justify-between">
                <p class="text-xs text-muted-foreground">Showing 1 to 2 of 18 active services</p>
                <div class="flex items-center gap-2">
                    <button
                        class="p-1 rounded border border-border hover:bg-card disabled:opacity-50 transition-colors text-muted-foreground">
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </button>
                    <button
                        class="size-8 flex items-center justify-center rounded bg-primary text-primary-foreground text-xs font-bold">1</button>
                    <button
                        class="size-8 flex items-center justify-center rounded hover:bg-muted text-xs font-medium text-foreground transition-colors">2</button>
                    <button
                        class="p-1 rounded border border-border hover:bg-card transition-colors text-muted-foreground">
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footnote Info -->
    <div class="p-6 bg-primary/5 rounded-xl border border-primary/10 flex items-start gap-4">
        <span class="material-symbols-outlined text-primary">info</span>
        <div>
            <h4 class="text-sm font-bold text-primary">Service Catalog Management</h4>
            <p class="text-xs text-primary/80 mt-1">Changes to service categories will immediately update the filtering
                options for all administrative and patient-facing views. Deleting a category will move its services to
                'Uncategorized'.</p>
        </div>
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