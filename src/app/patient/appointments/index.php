<?php
include_once __DIR__ . '/../../core/app.php';
$pageTitle = "MindTrack Patient Appointments List";
$showNavbar = false;
$showFooter = false;
$bodyClass = "bg-muted/50 dark:bg-background text-foreground font-display transition-colors duration-200";
// Set current page for sidebar highlighting
$headerData = [
    'title' => 'Appointments',
    'description' => 'Manage and schedule your sessions with our specialists.',
    'searchPlaceholder' => 'Search appointments...',
    'actionLabel' => 'Book New Appointment',
    'actionIcon' => 'add',
    'actionUrl' => 'step-1-service.php',
    'mb' => 10
];
$currentPage = 'appointments';
include __DIR__ . '/../layout.php';
?>

<div class="border-b border-border mb-8">
    <nav class="flex gap-10">
        <button class="pb-4 px-1 border-b-2 border-primary text-primary font-semibold text-sm transition-all">Upcoming
            (2)</button>
        <button
            class="pb-4 px-1 text-muted-foreground hover:text-foreground dark:text-muted-foreground dark:hover:text-gray-200 text-sm transition-all font-medium">Pending
            Approval (1)</button>
        <button
            class="pb-4 px-1 text-muted-foreground hover:text-foreground dark:text-muted-foreground dark:hover:text-gray-200 text-sm transition-all font-medium">Past
            Sessions</button>
    </nav>
</div>

<div class="space-y-6">
    <!-- Appointment Card 1 -->
    <div class="bg-card p-6 rounded-[2rem] border border-border shadow-sm hover:shadow-md transition-shadow">
        <div class="flex flex-col lg:flex-row lg:items-center gap-6">
            <div class="lg:w-1/4">
                <div class="flex items-center gap-3 mb-2">
                    <div
                        class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">psychology</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Psychotherapy</h3>
                        <p class="text-xs text-muted-foreground font-medium">Regular Session</p>
                    </div>
                </div>
                <span
                    class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">Approved</span>
            </div>
            <div class="lg:w-1/4 flex items-center gap-4">
                <div class="flex flex-col">
                    <span class="text-sm font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">calendar_today</span>
                        October 24, 2023
                    </span>
                    <span class="text-sm font-bold mt-1 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">schedule</span>
                        02:00 PM - 03:00 PM
                    </span>
                </div>
            </div>
            <div class="lg:w-1/4 flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-cover bg-center border-2 border-muted"
                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAwNaISt-uuQ6MwqbUu4W9riQAALi05dkz7TlBceAuiGncVIY6Iy-FH_HyGHXGNHCJQYaD9nEDbuuqI3PgNONuLsN1jAEUwxNxCxRfzYrao7FfZcll9nYEuTBnr0_ZPz0D0paWUhXfDDCiGrCotMMGhlOe4SNCKd-xEm4UvhJXu5qIYlwoQOmKvYtJcJpx1JUBThFPJGdJRoiRnuh4WURoUnnO6jnJYkgthlN0jRc0Sagg9GmwhYqP_arsGwOPp2nsicIQXEXKUnlM')">
                </div>
                <div>
                    <p class="text-xs text-muted-foreground font-medium">Assigned Doctor</p>
                    <p class="text-sm font-bold">Dr. Sarah Miller</p>
                </div>
            </div>
            <div class="lg:w-1/4 flex flex-col sm:flex-row gap-3 lg:justify-end">
                <button
                    class="px-5 py-2.5 rounded-xl border border-border text-sm font-bold hover:bg-muted transition-colors">
                    Reschedule
                </button>
                <button
                    class="px-5 py-2.5 rounded-xl border border-red-100 dark:border-red-900/30 text-red-600 dark:text-red-400 text-sm font-bold hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- Appointment Card 2 -->
    <div class="bg-card p-6 rounded-[2rem] border border-border shadow-sm hover:shadow-md transition-shadow">
        <div class="flex flex-col lg:flex-row lg:items-center gap-6">
            <div class="lg:w-1/4">
                <div class="flex items-center gap-3 mb-2">
                    <div
                        class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600">
                        <span class="material-symbols-outlined">neurology</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Cognitive Therapy</h3>
                        <p class="text-xs text-muted-foreground font-medium">Follow-up</p>
                    </div>
                </div>
                <span
                    class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">Approved</span>
            </div>
            <div class="lg:w-1/4 flex items-center gap-4">
                <div class="flex flex-col">
                    <span class="text-sm font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">calendar_today</span>
                        October 30, 2023
                    </span>
                    <span class="text-sm font-bold mt-1 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">schedule</span>
                        10:30 AM - 11:30 AM
                    </span>
                </div>
            </div>
            <div class="lg:w-1/4 flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-cover bg-center border-2 border-muted"
                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBCFBx3LjXS7ZS1hLtcdC1XKxw2ERXcJ5v4WCMLpXeEyEL55xbpQfdFMyaqaplEMQcJaRNyX--f-PCOA2UkbOq0HFPLvbd7kwsdkkZ5Rhyq3ANh7u5NDbLPEdPWk3nWUQ5fzv67W-P3t2vCbgzZDvMEsrKjvWUWuEOwngmivXeGMo-MO7JwpdgK26FxStcCB2bdc065MeSlg9g0fN_wIKNxMqvuBFmku_gg7eYWLzZhLxpPq_gRe7pkJvc02voVY7AHOj6pNQ6ro8E')">
                </div>
                <div>
                    <p class="text-xs text-muted-foreground font-medium">Assigned Doctor</p>
                    <p class="text-sm font-bold">Dr. James Chen</p>
                </div>
            </div>
            <div class="lg:w-1/4 flex flex-col sm:flex-row gap-3 lg:justify-end">
                <button
                    class="px-5 py-2.5 rounded-xl border border-border text-sm font-bold hover:bg-muted transition-colors">
                    Reschedule
                </button>
                <button
                    class="px-5 py-2.5 rounded-xl border border-red-100 dark:border-red-900/30 text-red-600 dark:text-red-400 text-sm font-bold hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <div class="pt-8 pb-4">
        <h3 class="text-lg font-bold flex items-center gap-2">
            <span class="material-symbols-outlined text-amber-500">pending_actions</span>
            Pending Confirmation
        </h3>
    </div>

    <!-- Pending Appointment Card -->
    <div class="bg-card p-6 rounded-[2rem] border border-border shadow-sm opacity-90">
        <div class="flex flex-col lg:flex-row lg:items-center gap-6">
            <div class="lg:w-1/4">
                <div class="flex items-center gap-3 mb-2">
                    <div
                        class="w-10 h-10 rounded-xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-muted-foreground">
                        <span class="material-symbols-outlined">medical_services</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Consultation</h3>
                        <p class="text-xs text-muted-foreground font-medium">Initial Assessment</p>
                    </div>
                </div>
                <span
                    class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">Pending
                    Approval</span>
            </div>
            <div class="lg:w-1/4 flex items-center gap-4">
                <div class="flex flex-col">
                    <span class="text-sm font-bold flex items-center gap-2">
                        <span class="material-symbols-outlined text-muted-foreground text-lg">calendar_today</span>
                        November 05, 2023
                    </span>
                    <span class="text-sm font-bold mt-1 flex items-center gap-2">
                        <span class="material-symbols-outlined text-muted-foreground text-lg">schedule</span>
                        09:15 AM - 10:00 AM
                    </span>
                </div>
            </div>
            <div class="lg:w-1/4 flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-cover bg-center border-2 border-muted"
                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBNMpp18IwIrPN5Ru9UX3LP4D79qaKiAZh-grHt2TepPTmkmCb4wMBuW0A_jlQR4S680e-B7mV-XZK27SwxnEmeRvKF6Ftpk6sk8BXR5dJ3GD-GicQrmJ1IbdEHC0iPPWCgqQyoOdUelzIBedQewR6vXIUPnq2TKtIfIEXqFGGAsPNtJiIl1vn2QaEH0iyU0481XFD4F4A8Q2HZBG-W2fHA_2Z1gtT7by7ZFix40gI13e-Wx6-fEYRTXRDExjfxEWY3PxerwH82DWM')">
                </div>
                <div>
                    <p class="text-xs text-muted-foreground font-medium">Assigned Doctor</p>
                    <p class="text-sm font-bold">Dr. Maria Garcia</p>
                </div>
            </div>
            <div class="lg:w-1/4 flex flex-col sm:flex-row gap-3 lg:justify-end">
                <button
                    class="px-5 py-2.5 rounded-xl border border-red-100 dark:border-red-900/30 text-red-600 dark:text-red-400 text-sm font-bold hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors">
                    Withdraw Request
                </button>
            </div>
        </div>
    </div>
</div>

<div
    class="mt-12 p-8 bg-primary/5 rounded-[2rem] border border-primary/10 flex flex-col md:flex-row items-center justify-between gap-6">
    <div class="flex items-center gap-4 text-primary">
        <span class="material-symbols-outlined text-3xl">info</span>
        <p class="text-sm font-medium">Need to change an appointment within 24 hours? Please contact the clinic
            directly at <span class="font-bold underline">(555) 0123-4567</span>.</p>
    </div>
    <button class="text-primary font-bold text-sm flex items-center gap-2 hover:underline">
        View Cancellation Policy
        <span class="material-symbols-outlined text-sm">arrow_forward</span>
    </button>
</div>