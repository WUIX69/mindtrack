<?php
/**
 * Admin Dashboard Index
 */
$pageTitle = "MindTrack Admin Dashboard";
$headerTitle = "Morning Overview";
include_once __DIR__ . '/layout.php';
?>

<!-- Header -->
<header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
    <div>
        <h2 class="text-3xl font-black tracking-tight text-foreground">Morning Overview</h2>
        <p class="text-muted-foreground mt-1">Here's what's happening at Wayside Psyche Center today.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="relative hidden sm:block">
            <span
                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground">search</span>
            <input
                class="pl-10 pr-4 py-2 bg-card border border-border rounded-lg text-sm focus:ring-primary focus:border-primary w-64 transition-all placeholder:text-muted-foreground"
                placeholder="Search patient or record..." type="text" />
        </div>
        <button
            class="bg-primary hover:bg-primary/90 text-primary-foreground px-5 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md shadow-primary/20 flex items-center gap-2 cursor-pointer">
            <span class="material-symbols-outlined text-[20px]">add_circle</span>
            Add New Record
        </button>
    </div>
</header>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total Patients -->
    <div class="bg-card p-6 rounded-2xl border border-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div
                class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-primary-foreground transition-all">
                <span class="material-symbols-outlined text-2xl">group</span>
            </div>
            <span
                class="flex items-center gap-1 text-xs font-bold text-green-500 bg-green-500/10 px-2 py-1 rounded-full text-nowrap">
                <span class="material-symbols-outlined text-sm">trending_up</span>
                12.5%
            </span>
        </div>
        <h3 class="text-muted-foreground text-sm font-medium">Total Online Support</h3>
        <p class="text-3xl font-black mt-1 text-foreground">1,284</p>
    </div>

    <!-- Active Doctors -->
    <div class="bg-card p-6 rounded-2xl border border-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div
                class="size-12 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 group-hover:bg-orange-500 group-hover:text-primary-foreground transition-all">
                <span class="material-symbols-outlined text-2xl">schedule</span>
            </div>
            <span
                class="flex items-center gap-1 text-xs font-bold text-orange-500 bg-orange-500/10 px-2 py-1 rounded-full text-nowrap">
                12 New
            </span>
        </div>
        <h3 class="text-muted-foreground text-sm font-medium">Pending Requests</h3>
        <p class="text-3xl font-black mt-1 text-foreground">12</p>
    </div>

    <!-- Appointments Today -->
    <div class="bg-card p-6 rounded-2xl border border-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div
                class="size-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-primary-foreground transition-all">
                <span class="material-symbols-outlined text-2xl">medical_services</span>
            </div>
            <span
                class="flex items-center gap-1 text-xs font-bold text-blue-500 bg-blue-500/10 px-2 py-1 rounded-full text-nowrap">
                Stable
            </span>
        </div>
        <h3 class="text-muted-foreground text-sm font-medium">Active Providers</h3>
        <p class="text-3xl font-black mt-1 text-foreground">24</p>
    </div>

    <!-- Revenue -->
    <div class="bg-card p-6 rounded-2xl border border-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div
                class="size-12 rounded-xl bg-green-500/10 flex items-center justify-center text-green-500 group-hover:bg-green-500 group-hover:text-primary-foreground transition-all">
                <span class="material-symbols-outlined text-2xl">forum</span>
            </div>
            <span
                class="flex items-center gap-1 text-xs font-bold text-green-500 bg-green-500/10 px-2 py-1 rounded-full text-nowrap">
                <span class="material-symbols-outlined text-sm">trending_up</span>
                8%
            </span>
        </div>
        <h3 class="text-muted-foreground text-sm font-medium">Monthly Stats</h3>
        <p class="text-3xl font-black mt-1 text-foreground">450</p>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <!-- Appointment Requests Table -->
    <div class="xl:col-span-2 space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold">Recent Appointment Requests</h3>
            <button class="text-sm text-primary font-semibold hover:underline">View All</button>
        </div>
        <div class="bg-card rounded-xl border border-border overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-muted/50 text-muted-foreground uppercase text-[11px] font-bold tracking-wider">
                        <th class="px-6 py-4">Patient Name</th>
                        <th class="px-6 py-4">Requested Time</th>
                        <th class="px-6 py-4">Provider</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    <tr class="hover:bg-muted/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-8 rounded-full bg-muted"></div>
                                <span class="text-sm font-semibold text-foreground">Sarah Jenkins</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-muted-foreground font-medium">Today, 10:30 AM
                        </td>
                        <td class="px-6 py-4 text-sm text-muted-foreground">Dr. Aris Thorne</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-400 uppercase tracking-wide">Pending</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center bg-green-600 text-white hover:bg-green-700 shadow-sm transition-all"
                                    title="Approve">
                                    <span class="material-symbols-outlined text-[18px]">check</span>
                                </button>
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center bg-red-600 text-white hover:bg-red-700 shadow-sm transition-all"
                                    title="Decline">
                                    <span class="material-symbols-outlined text-[18px]">close</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-muted/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-8 rounded-full bg-muted"></div>
                                <span class="text-sm font-semibold text-foreground">Michael Chen</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-muted-foreground font-medium">Tomorrow, 11:15 AM
                        </td>
                        <td class="px-6 py-4 text-sm text-muted-foreground">Dr. Helena Smith</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-orange-100 text-orange-700 dark:bg-orange-900/40 dark:text-orange-400 uppercase tracking-wide">Pending</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center bg-green-600 text-white hover:bg-green-700 transition-all">
                                    <span class="material-symbols-outlined text-[18px]">check</span>
                                </button>
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center bg-red-600 text-white hover:bg-red-700 transition-all">
                                    <span class="material-symbols-outlined text-[18px]">close</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-muted/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-8 rounded-full bg-muted"></div>
                                <span class="text-sm font-semibold text-foreground">Elena Rodriguez</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-muted-foreground font-medium">Today, 01:45 PM
                        </td>
                        <td class="px-6 py-4 text-sm text-muted-foreground">Dr. Aris Thorne</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-error/10 text-error uppercase tracking-wide">Urgent</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center bg-success text-white hover:bg-success/90 transition-all">
                                    <span class="material-symbols-outlined text-[18px]">check</span>
                                </button>
                                <button
                                    class="size-8 rounded-lg flex items-center justify-center bg-error text-white hover:bg-error/90 transition-all">
                                    <span class="material-symbols-outlined text-[18px]">close</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Today's Schedule Sidebar Widget -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold">Today's Schedule</h3>
            <button class="p-1.5 rounded-lg border border-border hover:bg-muted transition-all">
                <span class="material-symbols-outlined text-[18px]">calendar_today</span>
            </button>
        </div>
        <div class="bg-card rounded-xl border border-border p-5 shadow-sm">
            <div
                class="relative space-y-6 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-muted">
                <div class="relative pl-8 group">
                    <div
                        class="absolute left-0 top-1 size-[22px] rounded-full bg-card border-2 border-primary ring-4 ring-primary/5 z-10">
                    </div>
                    <div class="flex flex-col">
                        <span
                            class="text-[10px] font-bold text-primary uppercase tracking-widest leading-none mb-1">08:30
                            AM - Confirmed</span>
                        <h4 class="text-sm font-bold text-foreground">Initial Assessment</h4>
                        <p class="text-xs text-muted-foreground mt-0.5">Patient: Arthur Morgan</p>
                        <div class="mt-2 flex items-center gap-1.5 text-[10px] text-muted-foreground">
                            <span class="material-symbols-outlined text-[14px]">person</span> Dr. Aris Thorne
                        </div>
                    </div>
                </div>
                <div class="relative pl-8 group">
                    <div class="absolute left-0 top-1 size-[22px] rounded-full bg-card border-2 border-border z-10">
                    </div>
                    <div class="flex flex-col">
                        <span
                            class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest leading-none mb-1">10:00
                            AM - Confirmed</span>
                        <h4 class="text-sm font-bold text-foreground">CBT Therapy</h4>
                        <p class="text-xs text-muted-foreground mt-0.5">Patient: Sadie Adler</p>
                        <div class="mt-2 flex items-center gap-1.5 text-[10px] text-muted-foreground">
                            <span class="material-symbols-outlined text-[14px]">person</span> Dr. Helena Smith
                        </div>
                    </div>
                </div>
                <div class="relative pl-8 group">
                    <div class="absolute left-0 top-1 size-[22px] rounded-full bg-card border-2 border-orange-500 z-10">
                    </div>
                    <div class="flex flex-col">
                        <span
                            class="text-[10px] font-bold text-orange-500 uppercase tracking-widest leading-none mb-1">02:00
                            PM - Next Session</span>
                        <h4 class="text-sm font-bold text-foreground">Crisis Intervention</h4>
                        <p class="text-xs text-muted-foreground mt-0.5">Patient: Javier Escuella</p>
                        <div class="mt-2 flex items-center gap-1.5 text-[10px] text-muted-foreground">
                            <span class="material-symbols-outlined text-[14px]">person</span> Dr. Aris Thorne
                        </div>
                    </div>
                </div>
            </div>
            <button
                class="w-full mt-6 py-2.5 bg-muted text-muted-foreground text-xs font-bold rounded-lg hover:bg-muted/80 transition-all uppercase tracking-wider">
                VIEW FULL CALENDAR
            </button>
        </div>
    </div>
</div>

<!-- Doctor Workload Summary -->
<section class="bg-card rounded-xl border border-border p-6 shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-foreground">Provider Capacity Overview</h3>
        <div class="flex gap-2">
            <span class="flex items-center gap-1.5 text-xs font-medium text-muted-foreground">
                <span class="size-2 rounded-full bg-primary"></span> High
            </span>
            <span class="flex items-center gap-1.5 text-xs font-medium text-muted-foreground">
                <span class="size-2 rounded-full bg-primary/30"></span> Low
            </span>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="space-y-3">
            <div class="flex justify-between text-xs font-bold uppercase tracking-wide">
                <span class="text-muted-foreground">Dr. Aris Thorne</span>
                <span class="text-primary">85%</span>
            </div>
            <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                <div class="h-full bg-primary rounded-full w-[85%]"></div>
            </div>
        </div>
        <div class="space-y-3">
            <div class="flex justify-between text-xs font-bold uppercase tracking-wide">
                <span class="text-muted-foreground">Dr. Helena Smith</span>
                <span class="text-primary">62%</span>
            </div>
            <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                <div class="h-full bg-primary rounded-full w-[62%]"></div>
            </div>
        </div>
        <div class="space-y-3">
            <div class="flex justify-between text-xs font-bold uppercase tracking-wide">
                <span class="text-muted-foreground">Dr. James Taylor</span>
                <span class="text-primary">45%</span>
            </div>
            <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                <div class="h-full bg-primary rounded-full w-[45%]"></div>
            </div>
        </div>
        <div class="space-y-3">
            <div class="flex justify-between text-xs font-bold uppercase tracking-wide">
                <span class="text-muted-foreground">Dr. Sarah Connor</span>
                <span class="text-red-600">92%</span>
            </div>
            <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                <div class="h-full bg-red-600 rounded-full w-[92%]"></div>
            </div>
        </div>
    </div>
</section>