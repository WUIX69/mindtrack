<?php
include_once __DIR__ . '/../../core/app.php';

$pageTitle = "MindTrack Patient Dashboard";
$showNavbar = false;
$showFooter = false;

// Using standard semantic classes from global.css theme:
// bg-background-light -> bg-muted (or bg-gray-50 if muted is too dark/white)
// bg-background-dark -> bg-background (in dark mode default)
// bg-surface-light -> bg-card
// border-border-light -> border-border
$bodyClass = "bg-muted/50 dark:bg-background text-foreground font-display transition-colors duration-200";

include __DIR__ . '/layout.php';
?>

<!-- Header -->
<header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
    <div>
        <h2 class="text-3xl font-black tracking-tight text-foreground">Hello, Alex</h2>
        <p class="text-muted-foreground mt-1">Welcome back to your health dashboard. Everything looks
            great today.</p>
    </div>
    <div class="flex items-center gap-3">
        <div class="relative hidden sm:block">
            <span
                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground">search</span>
            <input
                class="pl-10 pr-4 py-2 bg-card border border-border rounded-lg text-sm focus:ring-primary focus:border-primary w-64 transition-all placeholder:text-muted-foreground"
                placeholder="Search records..." type="text" />
        </div>
        <button
            class="bg-primary hover:bg-primary/90 text-primary-foreground px-5 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md shadow-primary/20 flex items-center gap-2 cursor-pointer">
            <span class="material-symbols-outlined text-[20px]">add_circle</span>
            Book New Appointment
        </button>
    </div>
</header>

<!-- Metrics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <span class="text-muted-foreground text-sm font-medium">Upcoming Appointment</span>
            <div
                class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined">event</span>
            </div>
        </div>
        <p class="text-2xl font-bold mb-1">Oct 24, 2:00 PM</p>
        <p class="text-sm text-primary font-semibold flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">schedule</span>
            In 2 days • In Person
        </p>
    </div>
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <span class="text-muted-foreground text-sm font-medium">Recent Status</span>
            <div
                class="w-10 h-10 rounded-lg bg-green-50 dark:bg-green-900/30 flex items-center justify-center text-green-600">
                <span class="material-symbols-outlined">trending_up</span>
            </div>
        </div>
        <p class="text-2xl font-bold mb-1">Mood: Improving</p>
        <p class="text-sm text-green-600 font-semibold flex items-center gap-1">
            <span class="material-symbols-outlined text-sm">keyboard_arrow_up</span>
            +5% from last week
        </p>
    </div>
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <span class="text-muted-foreground text-sm font-medium">Mental Health Tip</span>
            <div
                class="w-10 h-10 rounded-lg bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600">
                <span class="material-symbols-outlined">lightbulb</span>
            </div>
        </div>
        <p class="text-2xl font-bold mb-1">Mindfulness</p>
        <p class="text-sm text-muted-foreground">Daily practice reduces anxiety.</p>
    </div>
</div>

<!-- Content Grid: Table & Sidebar Cards -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Appointment History Table -->
    <div class="lg:col-span-2">
        <div class="bg-card rounded-xl border border-border overflow-hidden shadow-sm">
            <div class="px-6 py-5 border-b border-border flex items-center justify-between">
                <h3 class="font-bold text-lg">Recent Appointment History</h3>
                <a class="text-primary text-sm font-bold hover:underline" href="#">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-xs uppercase tracking-wider text-muted-foreground bg-muted/50">
                            <th class="px-6 py-3 font-semibold">Date</th>
                            <th class="px-6 py-3 font-semibold">Service</th>
                            <th class="px-6 py-3 font-semibold">Provider</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        <tr class="hover:bg-muted/30 transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold">Oct 12, 2023</p>
                                <p class="text-xs text-muted-foreground">10:30 AM</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm">Psychotherapy</span>
                            </td>
                            <td class="px-6 py-4 flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-cover bg-center" data-alt="Doctor headshot avatar"
                                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAwNaISt-uuQ6MwqbUu4W9riQAALi05dkz7TlBceAuiGncVIY6Iy-FH_HyGHXGNHCJQYaD9nEDbuuqI3PgNONuLsN1jAEUwxNxCxRfzYrao7FfZcll9nYEuTBnr0_ZPz0D0paWUhXfDDCiGrCotMMGhlOe4SNCKd-xEm4UvhJXu5qIYlwoQOmKvYtJcJpx1JUBThFPJGdJRoiRnuh4WURoUnnO6jnJYkgthlN0jRc0Sagg9GmwhYqP_arsGwOPp2nsicIQXEXKUnlM')">
                                </div>
                                <span class="text-sm font-medium">Dr. Sarah Miller</span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400">Completed</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-muted/30 transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold">Oct 24, 2023</p>
                                <p class="text-xs text-muted-foreground">02:00 PM</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm">Cognitive Therapy</span>
                            </td>
                            <td class="px-6 py-4 flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-cover bg-center" data-alt="Doctor headshot avatar"
                                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBCFBx3LjXS7ZS1hLtcdC1XKxw2ERXcJ5v4WCMLpXeEyEL55xbpQfdFMyaqaplEMQcJaRNyX--f-PCOA2UkbOq0HFPLvbd7kwsdkkZ5Rhyq3ANh7u5NDbLPEdPWk3nWUQ5fzv67W-P3t2vCbgzZDvMEsrKjvWUWuEOwngmivXeGMo-MO7JwpdgK26FxStcCB2bdc065MeSlg9g0fN_wIKNxMqvuBFmku_gg7eYWLzZhLxpPq_gRe7pkJvc02voVY7AHOj6pNQ6ro8E')">
                                </div>
                                <span class="text-sm font-medium">Dr. James Chen</span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400">Approved</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-muted/30 transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold">Nov 02, 2023</p>
                                <p class="text-xs text-muted-foreground">09:15 AM</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm">Initial Consultation</span>
                            </td>
                            <td class="px-6 py-4 flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-cover bg-center" data-alt="Doctor headshot avatar"
                                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBNMpp18IwIrPN5Ru9UX3LP4D79qaKiAZh-grHt2TepPTmkmCb4wMBuW0A_jlQR4S680e-B7mV-XZK27SwxnEmeRvKF6Ftpk6sk8BXR5dJ3GD-GicQrmJ1IbdEHC0iPPWCgqQyoOdUelzIBedQewR6vXIUPnq2TKtIfIEXqFGGAsPNtJiIl1vn2QaEH0iyU0481XFD4F4A8Q2HZBG-W2fHA_2Z1gtT7by7ZFix40gI13e-Wx6-fEYRTXRDExjfxEWY3PxerwH82DWM')">
                                </div>
                                <span class="text-sm font-medium">Dr. Maria Garcia</span>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">Pending</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Side Cards -->
    <div class="space-y-6">
        <!-- Clinic Announcements -->
        <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary">campaign</span>
                <h3 class="font-bold">Clinic Announcements</h3>
            </div>
            <ul class="space-y-4">
                <li class="border-l-4 border-primary pl-3">
                    <p class="text-xs text-muted-foreground">Oct 20, 2023</p>
                    <p class="text-sm font-bold">Labor Day Closure</p>
                    <p class="text-xs text-muted-foreground leading-relaxed">The center will be closed
                        on Oct 31st for annual maintenance.</p>
                </li>
                <li class="border-l-4 border-green-500 pl-3">
                    <p class="text-xs text-muted-foreground">Oct 18, 2023</p>
                    <p class="text-sm font-bold">New Workshop</p>
                    <p class="text-xs text-muted-foreground leading-relaxed">Join our "Anxiety Relief"
                        group session starting next Tuesday.</p>
                </li>
            </ul>
        </div>
        <!-- Mental Health Tip of the Day -->
        <div
            class="relative overflow-hidden bg-primary p-6 rounded-xl text-primary-foreground shadow-lg shadow-primary/20">
            <div class="absolute -right-4 -bottom-4 opacity-20">
                <span class="material-symbols-outlined text-8xl">self_improvement</span>
            </div>
            <h3 class="text-xs font-bold uppercase tracking-widest opacity-80 mb-2">Tip of the Day</h3>
            <p class="text-lg font-medium leading-snug mb-4">"Remember to practice 5 minutes of deep breathing
                today
                to reset your nervous system."</p>
            <button
                class="bg-white/20 hover:bg-white/30 text-white text-xs font-bold px-4 py-2 rounded-lg transition-colors cursor-pointer">
                Read More Tips
            </button>
        </div>
        <!-- Resource Card -->
        <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
            <h3 class="font-bold mb-4">Quick Links</h3>
            <div class="grid grid-cols-2 gap-3">
                <a class="flex flex-col items-center justify-center p-3 rounded-lg border border-border hover:bg-muted transition-colors group"
                    href="#">
                    <span
                        class="material-symbols-outlined text-muted-foreground group-hover:text-primary transition-colors">library_books</span>
                    <span class="text-[11px] font-bold mt-1 text-muted-foreground">Guides</span>
                </a>
                <a class="flex flex-col items-center justify-center p-3 rounded-lg border border-border hover:bg-muted transition-colors group"
                    href="#">
                    <span
                        class="material-symbols-outlined text-muted-foreground group-hover:text-primary transition-colors">support_agent</span>
                    <span class="text-[11px] font-bold mt-1 text-muted-foreground">Support</span>
                </a>
            </div>
        </div>
    </div>
</div>