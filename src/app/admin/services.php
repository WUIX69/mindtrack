<?php
/**
 * Admin - Services Management
 */
$pageTitle = "Clinical Services - MindTrack";
$headerTitle = "Services";
$currentPage = 'services';

include_once __DIR__ . '/layout.php';
?>

<!-- Header -->
<header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h2 class="text-3xl font-black tracking-tight text-foreground">Services</h2>
        <p class="text-muted-foreground mt-1">Manage clinical programs, therapy types, and consultation sessions.</p>
    </div>
    <div class="flex items-center gap-3">
        <button
            class="bg-primary hover:bg-primary/90 text-primary-foreground px-5 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md shadow-primary/20 flex items-center gap-2 cursor-pointer">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Add New Service
        </button>
    </div>
</header>

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

<!-- Services Table Section -->
<section class="bg-card rounded-xl border border-border shadow-sm overflow-hidden mb-8">
    <div class="p-6 border-b border-border flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="relative max-w-sm w-full">
            <span
                class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-muted-foreground text-xl">search</span>
            <input
                class="w-full pl-10 pr-4 py-2 bg-muted border border-border rounded-lg text-sm focus:ring-primary focus:border-primary placeholder:text-muted-foreground/60 transition-all"
                placeholder="Search services..." type="text" />
        </div>
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Category:</span>
            <select
                class="rounded-lg p-2 bg-muted border-border text-xs font-bold text-foreground focus:ring-primary focus:border-primary min-w-[150px] cursor-pointer">
                <option>All Categories</option>
                <option>Therapy</option>
                <option>Consultation</option>
                <option>Clinical Program</option>
                <option>Group Session</option>
            </select>
        </div>
    </div>
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