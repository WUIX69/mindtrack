<?php
/**
 * Patient Medical Records Page
 */

$pageTitle = "My Medical Records";
$bodyClass = "bg-muted/50 dark:bg-background text-foreground font-display transition-colors duration-200";
// Set current page for sidebar highlighting
$headerData = [
    'title' => 'My Records',
    'description' => 'Access and manage your clinical documents and test results.',
    'searchPlaceholder' => 'Search by name or provider...',
    'actionLabel' => 'Upload New',
    'actionIcon' => 'upload'
];
$currentPage = 'records';

include __DIR__ . '/layout.php';
?>

<div class="flex flex-wrap items-center gap-2 mb-8 border-b border-border pb-px">
    <button class="px-6 py-3 text-sm font-semibold border-b-2 border-primary text-primary transition-all">All
        Records</button>
    <button
        class="px-6 py-3 text-sm font-semibold border-b-2 border-transparent text-muted-foreground hover:text-foreground dark:hover:text-white hover:border-border-hover dark:hover:border-gray-600 transition-all">Clinical
        Notes</button>
    <button
        class="px-6 py-3 text-sm font-semibold border-b-2 border-transparent text-muted-foreground hover:text-foreground dark:hover:text-white hover:border-border-hover dark:hover:border-gray-600 transition-all">Test
        Results</button>
    <button
        class="px-6 py-3 text-sm font-semibold border-b-2 border-transparent text-muted-foreground hover:text-foreground dark:hover:text-white hover:border-border-hover dark:hover:border-gray-600 transition-all">Prescriptions</button>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <div class="bg-card dark:bg-card rounded-xl border border-border overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs uppercase tracking-wider text-muted-foreground bg-muted/30 dark:bg-muted/10">
                            <th class="px-6 py-4 font-semibold">Document Name</th>
                            <th class="px-6 py-4 font-semibold">Date Added</th>
                            <th class="px-6 py-4 font-semibold">Provider</th>
                            <th class="px-6 py-4 font-semibold text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        <tr class="hover:bg-muted/10 dark:hover:bg-muted/5 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined text-[20px]">assignment</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold">Initial Evaluation Report</p>
                                        <p class="text-[11px] text-muted-foreground font-medium">PDF • 1.2 MB</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm font-medium">Oct 14, 2023</p>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-cover bg-center border border-border"
                                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAwNaISt-uuQ6MwqbUu4W9riQAALi05dkz7TlBceAuiGncVIY6Iy-FH_HyGHXGNHCJQYaD9nEDbuuqI3PgNONuLsN1jAEUwxNxCxRfzYrao7FfZcll9nYEuTBnr0_ZPz0D0paWUhXfDDCiGrCotMMGhlOe4SNCKd-xEm4UvhJXu5qIYlwoQOmKvYtJcJpx1JUBThFPJGdJRoiRnuh4WURoUnnO6jnJYkgthlN0jRc0Sagg9GmwhYqP_arsGwOPp2nsicIQXEXKUnlM')">
                                    </div>
                                    <span class="text-sm font-medium">Dr. Sarah Miller</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <button
                                        class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/5 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </button>
                                    <button
                                        class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/5 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined">download</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-muted/10 dark:hover:bg-muted/5 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center text-amber-600">
                                        <span class="material-symbols-outlined text-[20px]">prescriptions</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold">Renewal: Escitalopram 10mg</p>
                                        <p class="text-[11px] text-muted-foreground font-medium">Digital Copy</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm font-medium">Oct 10, 2023</p>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-cover bg-center border border-border"
                                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBCFBx3LjXS7ZS1hLtcdC1XKxw2ERXcJ5v4WCMLpXeEyEL55xbpQfdFMyaqaplEMQcJaRNyX--f-PCOA2UkbOq0HFPLvbd7kwsdkkZ5Rhyq3ANh7u5NDbLPEdPWk3nWUQ5fzv67W-P3t2vCbgzZDvMEsrKjvWUWuEOwngmivXeGMo-MO7JwpdgK26FxStcCB2bdc065MeSlg9g0fN_wIKNxMqvuBFmku_gg7eYWLzZhLxpPq_gRe7pkJvc02voVY7AHOj6pNQ6ro8E')">
                                    </div>
                                    <span class="text-sm font-medium">Dr. James Chen</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <button
                                        class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/5 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </button>
                                    <button
                                        class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/5 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined">download</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-muted/10 dark:hover:bg-muted/5 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-green-50 dark:bg-green-900/20 flex items-center justify-center text-green-600">
                                        <span class="material-symbols-outlined text-[20px]">biotech</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold">Blood Work Panel Results</p>
                                        <p class="text-[11px] text-muted-foreground font-medium">PDF • 2.4 MB</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm font-medium">Sep 28, 2023</p>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-cover bg-center border border-border"
                                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBNMpp18IwIrPN5Ru9UX3LP4D79qaKiAZh-grHt2TepPTmkmCb4wMBuW0A_jlQR4S680e-B7mV-XZK27SwxnEmeRvKF6Ftpk6sk8BXR5dJ3GD-GicQrmJ1IbdEHC0iPPWCgqQyoOdUelzIBedQewR6vXIUPnq2TKtIfIEXqFGGAsPNtJiIl1vn2QaEH0iyU0481XFD4F4A8Q2HZBG-W2fHA_2Z1gtT7by7ZFix40gI13e-Wx6-fEYRTXRDExjfxEWY3PxerwH82DWM')">
                                    </div>
                                    <span class="text-sm font-medium">Dr. Maria Garcia</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <button
                                        class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/5 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </button>
                                    <button
                                        class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/5 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined">download</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-muted/10 dark:hover:bg-muted/5 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-9 h-9 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center text-purple-600">
                                        <span class="material-symbols-outlined text-[20px]">clinical_notes</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold">Progress Session Notes</p>
                                        <p class="text-[11px] text-muted-foreground font-medium">DOCX • 500 KB</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm font-medium">Sep 15, 2023</p>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-cover bg-center border border-border"
                                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAwNaISt-uuQ6MwqbUu4W9riQAALi05dkz7TlBceAuiGncVIY6Iy-FH_HyGHXGNHCJQYaD9nEDbuuqI3PgNONuLsN1jAEUwxNxCxRfzYrao7FfZcll9nYEuTBnr0_ZPz0D0paWUhXfDDCiGrCotMMGhlOe4SNCKd-xEm4UvhJXu5qIYlwoQOmKvYtJcJpx1JUBThFPJGdJRoiRnuh4WURoUnnO6jnJYkgthlN0jRc0Sagg9GmwhYqP_arsGwOPp2nsicIQXEXKUnlM')">
                                    </div>
                                    <span class="text-sm font-medium">Dr. Sarah Miller</span>
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex justify-end gap-2">
                                    <button
                                        class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/5 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined">visibility</span>
                                    </button>
                                    <button
                                        class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/5 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined">download</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                class="px-6 py-4 bg-muted/30 dark:bg-muted/10 border-t border-border flex items-center justify-between">
                <p class="text-xs text-muted-foreground font-medium">Showing 1-4 of 12 records</p>
                <div class="flex gap-2">
                    <button
                        class="px-3 py-1.5 text-xs font-bold border border-border rounded bg-card hover:bg-muted/10 transition-colors disabled:opacity-50"
                        disabled="">Previous</button>
                    <button
                        class="px-3 py-1.5 text-xs font-bold border border-border rounded bg-card hover:bg-muted/10 transition-colors">Next</button>
                </div>
            </div>
        </div>
    </div>
    <div class="space-y-6">
        <div class="bg-card dark:bg-card p-6 rounded-xl border border-border shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">insights</span>
                <h3 class="font-bold">Quick Insights</h3>
            </div>
            <div class="space-y-4">
                <div class="p-4 bg-primary/5 rounded-lg border border-primary/10">
                    <p class="text-xs font-bold text-primary uppercase tracking-wider mb-1">Most Recent Diagnosis</p>
                    <p class="text-lg font-bold">Generalized Anxiety Disorder</p>
                    <p class="text-xs text-muted-foreground mt-1 font-medium">Confirmed on Oct 14, 2023</p>
                </div>
                <div class="space-y-3">
                    <h4 class="text-xs font-bold text-muted-foreground uppercase tracking-widest">Health Summary</h4>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium">Treatment Adherence</span>
                        <span class="text-sm font-bold text-green-600">92%</span>
                    </div>
                    <div class="w-full bg-muted/20 dark:bg-muted/10 rounded-full h-1.5">
                        <div class="bg-green-500 h-1.5 rounded-full" style="width: 92%"></div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium">Session Attendance</span>
                        <span class="text-sm font-bold text-primary">100%</span>
                    </div>
                    <div class="w-full bg-muted/20 dark:bg-muted/10 rounded-full h-1.5">
                        <div class="bg-primary h-1.5 rounded-full" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-card dark:bg-card p-6 rounded-xl border border-border shadow-sm">
            <div class="flex items-center gap-2 mb-3">
                <span class="material-symbols-outlined text-green-600">verified_user</span>
                <h3 class="font-bold">Privacy Protected</h3>
            </div>
            <p class="text-xs text-muted-foreground leading-relaxed font-medium">
                Your medical records are encrypted and HIPAA compliant. Only authorized providers can access your full
                medical history.
            </p>
            <button
                class="mt-4 w-full py-2 text-xs font-bold text-primary border border-primary/20 bg-primary/5 rounded-lg hover:bg-primary/10 transition-colors">
                Manage Permissions
            </button>
        </div>
        <div
            class="relative overflow-hidden bg-primary p-6 rounded-xl text-primary-foreground shadow-lg shadow-primary/20">
            <div class="absolute -right-4 -bottom-4 opacity-20">
                <span class="material-symbols-outlined text-8xl">help</span>
            </div>
            <h3 class="text-xs font-bold uppercase tracking-widest opacity-80 mb-2">Need Assistance?</h3>
            <p class="text-sm font-medium leading-relaxed mb-4">Can't find a specific document? Contact our support team
                or your provider directly.</p>
            <button
                class="bg-primary-foreground/20 hover:bg-primary-foreground/30 text-primary-foreground text-xs font-bold px-4 py-2 rounded-lg transition-colors">
                Contact Center
            </button>
        </div>
    </div>
</div>