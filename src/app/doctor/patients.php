<?php
/**
 * Doctor Patients Page - Patient Directory
 */
$pageTitle = "My Patients - MindTrack Doctor";

$headerData = [
    'title' => 'My Patients',
    'description' => 'Manage and monitor patient treatment progress',
    'searchPlaceholder' => 'Search patients by name, ID, or treatment type...',
    'actionLabel' => 'Add New Patient',
    'actionIcon' => 'person_add'
];

include_once __DIR__ . '/layout.php';
?>

<div class="flex flex-col lg:flex-row gap-8 min-h-0 h-full">
    <!-- Patient Directory Section -->
    <div class="flex-1 flex flex-col min-w-0 bg-card rounded-2xl border border-border shadow-sm overflow-hidden h-full">
        <!-- Filter Tabs -->
        <div class="px-6 pt-4 border-b border-border shrink-0">
            <div class="flex gap-8">
                <button class="px-1 py-3 text-sm font-bold text-primary border-b-2 border-primary transition-all">Active
                    Patients (24)</button>
                <button
                    class="px-1 py-3 text-sm font-medium text-muted-foreground hover:text-foreground transition-all">Past
                    Patients (112)</button>
                <button
                    class="px-1 py-3 text-sm font-medium text-muted-foreground hover:text-foreground transition-all">Waitlist
                    (3)</button>
            </div>
        </div>

        <!-- Data Table Container -->
        <div class="flex-1 overflow-y-auto overflow-x-auto scrollbar-hide">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-muted/30 sticky top-0 z-10 border-b border-border">
                        <th class="px-6 py-4 text-[10px] font-black text-muted-foreground uppercase tracking-widest">
                            Patient</th>
                        <th class="px-6 py-4 text-[10px] font-black text-muted-foreground uppercase tracking-widest">
                            Status</th>
                        <th class="px-6 py-4 text-[10px] font-black text-muted-foreground uppercase tracking-widest">
                            Last Session</th>
                        <th class="px-6 py-4 text-[10px] font-black text-muted-foreground uppercase tracking-widest">
                            Next Session</th>
                        <th class="px-6 py-4 text-[10px] font-black text-muted-foreground uppercase tracking-widest">
                            Primary Service</th>
                        <th
                            class="px-6 py-4 text-[10px] font-black text-muted-foreground uppercase tracking-widest text-right">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    <?php
                    $patients = [
                        [
                            'name' => 'John Doe',
                            'id' => 'MT-8821',
                            'status' => 'Active',
                            'last' => 'Oct 12, 2023',
                            'next' => 'Oct 26, 2023',
                            'next_time' => '2:00 PM',
                            'service' => 'CBT',
                            'service_color' => 'bg-primary/10 text-primary',
                            'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuASQTgSN2E9_GfT5Tu5FHdj2BSyu9CISJB5ng0T5kWBiMltyf-o2uBWVcPz9BZEIRPFvgmOY-7mF1tW-jcxBu6Pk_DMCkIFNP48XwKcO2zt4m-GUZOvqEv6KoW_itbrhv8TWxLo8s1grU37PYKnYI9_WaZHZlVqQjW647nnD8HJmXdh5q7WoUVSLW0TWgKshzeIC_ipj981kZOvCpGh5sihCzMzAy2kkuMJVzJlj5TSrslPPI94bTkAC4ejG7-tdkW00C5PuPTTdCA'
                        ],
                        [
                            'name' => 'Jane Smith',
                            'id' => 'MT-9042',
                            'status' => 'Active',
                            'last' => 'Oct 14, 2023',
                            'next' => 'Oct 28, 2023',
                            'next_time' => '10:30 AM',
                            'service' => 'DBT',
                            'service_color' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400',
                            'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuASpx9ZoZNk3x3o8p6CXbfWBmhi6RxiNvXKYYPKkFuAydYIcKBs6m-FXxM12sr7RCmUlC9q9Bi5VWya3Jq70xjVHeoNivhPi2fFrEKISCyrg6HWYSVKwJrELP69LJQyYH5onTeim9-hUg1t0jBoCxgw5UpV-U87sKfT0UgXjcZotKepaShpolp8fyGZ95zSJv_5-r6YooDoXIFrzKVa-iNtiKVSMWdi1wk51GGt7pGwT6IbUb5ME6x00Y1WxIIGsbcgijU2JCPnEP0'
                        ],
                        [
                            'name' => 'Robert Brown',
                            'id' => 'MT-7712',
                            'status' => 'Pending',
                            'last' => 'Oct 15, 2023',
                            'next' => 'Nov 02, 2023',
                            'next_time' => '4:15 PM',
                            'service' => 'General',
                            'service_color' => 'bg-muted text-muted-foreground',
                            'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuDtIrdPAyD_KYwREhU3xXrZgRi4PVw8zsBEEx33kFmCNouP6l9XT_fazrKliBMPf_LC9QJO0RuL-UUaPVyCFDQTf-lpMCiE8lSZSL4qYZfBMBQFREK6AzMISAwqf7jAGIJcTdezyJwrzkZ9wdFrXzp3v8hPl8i-rhZe7WnprsL0mOGRM1zG3p-EsXtyzAcPkBcN2pV4OIoTsxUi0GaIRe7xCUu-5gtDHANkAx9kBc84BNZ93DztGhBVnkNmSH40NUjVz2SkBwbe3H4'
                        ],
                        [
                            'name' => 'Emily Davis',
                            'id' => 'MT-6623',
                            'status' => 'Active',
                            'last' => 'Oct 11, 2023',
                            'next' => 'Oct 25, 2023',
                            'next_time' => '9:00 AM',
                            'service' => 'CBT',
                            'service_color' => 'bg-primary/10 text-primary',
                            'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCTycWMJ6SGOmhnHIYF6T-PUFCYoXmw4IQc5YrLSVc0eSzWhfovHs0rWRWQ_5EnRPchlt9AhOw9Bxy5tX77WLzRO8HOmha8xvVHMrSSfVKObNjGrjwA-4liW75Xgrwd2Uoxa6qR6V0ajEs_J8nMqZfoqUUplYXF-NdPSfFKTdBgRryFZAWsx2PIWfZw01GZBMpZR_QuasYRbJatoLoeUoRtgr1_tUj4bo-CGy_ztvU_9RTXoLzFuwvdT3iN_IPfFI_kCicLfTa2Gzg'
                        ],
                        [
                            'name' => 'Michael Wilson',
                            'id' => 'MT-1129',
                            'status' => 'Active',
                            'last' => 'Oct 16, 2023',
                            'next' => 'Oct 30, 2023',
                            'next_time' => '1:45 PM',
                            'service' => 'EMDR',
                            'service_color' => 'bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400',
                            'avatar' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuBJHZRn6dzPsM-aQtLOxF4HnDKHLJdPpgu2vjZLjpK5j1U3W0xLJlwqLBGlh5QNZMYB3gMRl3_P6BJ0YUEGcaxZNNugFs1SCKkPBr7FthX6TcjOAaRVWvdibOIlPxBUev3DV8FxLRfLBA2uuq3x8fgIpCvA1TdSK-Dmlh3PmrPPQ7b1CXzuz2E1cAsbuePeOYCLT_8qsiLs-TuiPqM9Q7Dnnn8wqoK3lHKS2KRcxcVZRElrPwRGA141a2fBBPzOcBton_-Fj3GoTPU'
                        ]
                    ];

                    foreach ($patients as $p): ?>
                        <tr class="group hover:bg-muted/30 transition-all">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-10 rounded-full overflow-hidden border border-border shadow-sm p-0.5">
                                        <div class="size-full rounded-full bg-cover bg-center"
                                            style="background-image: url('<?= $p['avatar'] ?>')"></div>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-foreground">
                                            <?= $p['name'] ?>
                                        </p>
                                        <p
                                            class="text-[10px] font-bold text-muted-foreground uppercase flex items-center gap-1">
                                            ID:
                                            <?= $p['id'] ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest <?= $p['status'] === 'Active' ? 'text-emerald-500' : 'text-amber-500' ?>">
                                    <span
                                        class="size-1.5 rounded-full <?= $p['status'] === 'Active' ? 'bg-emerald-500' : 'bg-amber-500' ?> animate-pulse"></span>
                                    <?= $p['status'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-xs font-semibold text-muted-foreground">
                                    <?= $p['last'] ?>
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <p class="text-xs font-black text-foreground">
                                        <?= $p['next'] ?>
                                    </p>
                                    <p class="text-[10px] font-bold text-primary mt-1 opacity-80">
                                        <?= $p['next_time'] ?>
                                    </p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider <?= $p['service_color'] ?>">
                                    <?= $p['service'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div
                                    class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all">
                                    <button
                                        class="p-2 text-muted-foreground hover:bg-primary/10 hover:text-primary rounded-lg transition-all"
                                        title="Add Clinical Note">
                                        <span class="material-symbols-outlined text-lg">edit_note</span>
                                    </button>
                                    <button
                                        class="px-4 py-1.5 text-[10px] font-black text-primary border-2 border-primary/20 hover:border-primary hover:bg-primary hover:text-primary-foreground rounded-lg transition-all uppercase tracking-widest">
                                        View Records
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        <div class="px-6 py-4 bg-muted/20 border-t border-border flex items-center justify-between shrink-0">
            <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Showing 5 of 24 patients
            </p>
            <div class="flex gap-2">
                <button
                    class="p-2 border border-border rounded-lg bg-card text-muted-foreground hover:bg-muted disabled:opacity-30 transition-all"
                    disabled>
                    <span class="material-symbols-outlined text-sm">chevron_left</span>
                </button>
                <button
                    class="p-2 border border-border rounded-lg bg-card text-muted-foreground hover:bg-muted transition-all">
                    <span class="material-symbols-outlined text-sm">chevron_right</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Right Sidebar Widget -->
    <div class="w-full lg:w-80 shrink-0 space-y-8 flex flex-col h-full overflow-y-auto pr-2 scrollbar-hide">
        <!-- Caseload Summary -->
        <div class="space-y-4">
            <h3
                class="text-sm font-bold text-foreground/80 uppercase tracking-widest flex items-center justify-between">
                Caseload Summary
                <span class="material-symbols-outlined text-muted-foreground text-lg">donut_large</span>
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <div
                    class="bg-card p-4 rounded-2xl border border-border shadow-sm group hover:border-primary/30 transition-all">
                    <p class="text-[10px] font-bold text-muted-foreground uppercase opacity-70">Active</p>
                    <p class="text-3xl font-black text-foreground mt-1 tracking-tight">24</p>
                </div>
                <div
                    class="bg-card p-4 rounded-2xl border border-border shadow-sm group hover:border-primary/30 transition-all">
                    <p class="text-[10px] font-bold text-muted-foreground uppercase opacity-70">Sessions/Wk</p>
                    <p class="text-3xl font-black text-foreground mt-1 tracking-tight">18</p>
                </div>
            </div>
            <div class="mt-4 p-5 bg-primary/5 border border-primary/10 rounded-2xl shadow-sm">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-black text-primary uppercase tracking-widest">Global Capacity</p>
                    <p class="text-xs font-black text-primary">80%</p>
                </div>
                <div class="h-2 w-full bg-border rounded-full overflow-hidden">
                    <div class="h-full bg-primary shadow-sm shadow-primary/20" style="width: 80%"></div>
                </div>
            </div>
        </div>

        <!-- Recent Highlights -->
        <div class="space-y-4">
            <h3
                class="text-sm font-bold text-foreground/80 uppercase tracking-widest flex items-center justify-between">
                Progress Highlights
                <span class="material-symbols-outlined text-muted-foreground text-lg">auto_awesome</span>
            </h3>
            <div class="flex flex-col gap-4">
                <div class="flex gap-4 items-start group">
                    <div class="size-2 rounded-full bg-emerald-500 mt-2 shrink-0 shadow-sm shadow-emerald-500/30"></div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-foreground group-hover:text-primary transition-colors">John Doe
                            completed PHQ-9</p>
                        <p class="text-[10px] text-muted-foreground font-medium mt-1">Score improved by 4 points. View
                            analysis.</p>
                        <p class="text-[9px] font-black text-muted-foreground/50 uppercase tracking-tighter mt-1.5">2
                            hours ago</p>
                    </div>
                </div>
                <div class="flex gap-4 items-start group">
                    <div class="size-2 rounded-full bg-primary mt-2 shrink-0 shadow-sm shadow-primary/30"></div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-foreground group-hover:text-primary transition-colors">Emily
                            Davis: New goal set</p>
                        <p class="text-[10px] text-muted-foreground font-medium mt-1">"Reduce social anxiety in
                            workplace settings."</p>
                        <p class="text-[9px] font-black text-muted-foreground/50 uppercase tracking-tighter mt-1.5">5
                            hours ago</p>
                    </div>
                </div>
                <div class="flex gap-4 items-start group">
                    <div class="size-2 rounded-full bg-muted mt-2 shrink-0 shadow-sm border border-border"></div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-foreground group-hover:text-primary transition-colors">Waitlist
                            updated</p>
                        <p class="text-[10px] text-muted-foreground font-medium mt-1">2 new referrals pending initial
                            screening.</p>
                        <p class="text-[9px] font-black text-muted-foreground/50 uppercase tracking-tighter mt-1.5">
                            Yesterday</p>
                    </div>
                </div>
            </div>
            <button
                class="w-full mt-4 py-3 text-[10px] font-black text-muted-foreground hover:text-primary transition-all border border-dashed border-border hover:border-primary/50 rounded-xl uppercase tracking-widest">
                View Activity Log
            </button>
        </div>

        <!-- Quick Tools -->
        <div class="space-y-4">
            <h3
                class="text-sm font-bold text-foreground/80 uppercase tracking-widest flex items-center justify-between">
                Clinical Tools
                <span class="material-symbols-outlined text-muted-foreground text-lg">handyman</span>
            </h3>
            <div class="flex flex-col gap-2">
                <button
                    class="flex items-center gap-4 w-full p-3.5 rounded-xl hover:bg-muted group transition-all text-left">
                    <div
                        class="size-9 bg-primary/10 rounded-lg flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
                        <span class="material-symbols-outlined text-xl">analytics</span>
                    </div>
                    <div>
                        <p class="text-xs font-black text-foreground">Bulk Progress Report</p>
                        <p class="text-[10px] text-muted-foreground font-bold">Generate monthly analytics</p>
                    </div>
                </button>
                <button
                    class="flex items-center gap-4 w-full p-3.5 rounded-xl hover:bg-muted group transition-all text-left">
                    <div
                        class="size-9 bg-primary/10 rounded-lg flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
                        <span class="material-symbols-outlined text-xl">inventory_2</span>
                    </div>
                    <div>
                        <p class="text-xs font-black text-foreground">Assessment Library</p>
                        <p class="text-[10px] text-muted-foreground font-bold">Forms and questionnaires</p>
                    </div>
                </button>
                <button
                    class="flex items-center gap-4 w-full p-3.5 rounded-xl hover:bg-muted group transition-all text-left border border-dashed border-border">
                    <div
                        class="size-9 bg-primary/10 rounded-lg flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-all">
                        <span class="material-symbols-outlined text-xl">ios_share</span>
                    </div>
                    <div>
                        <p class="text-xs font-black text-foreground">Secure Record Share</p>
                        <p class="text-[10px] text-muted-foreground font-bold">HIPAA compliant export</p>
                    </div>
                </button>
            </div>
        </div>
    </div>
</div>