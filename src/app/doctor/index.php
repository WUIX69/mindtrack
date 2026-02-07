<?php
/**
 * Doctor Dashboard Index
 */
$pageTitle = "MindTrack Doctor Dashboard";
$headerData = [
    'title' => 'Good Morning, Dr. Aris',
    'description' => "Welcome back to Wayside Psyche Resources Center.",
    'searchPlaceholder' => 'Search patient records, sessions, or clinical files...',
    'actionLabel' => 'Export Report',
    'extraContent' => '
        <button class="px-4 py-2 bg-white dark:bg-card border border-border rounded-lg text-sm font-semibold flex items-center gap-2 hover:bg-muted transition-all">
            <span class="material-symbols-outlined text-lg">add</span>
            New Appointment
        </button>'
];
include_once __DIR__ . '/layout.php';
?>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div
                class="size-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                <span class="material-symbols-outlined">event_available</span>
            </div>
            <span class="text-xs font-bold text-green-600 bg-green-100 dark:bg-green-900/30 px-2 py-1 rounded-full">+2
                from yest.</span>
        </div>
        <p class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Today\'s Sessions</p>
        <h3 class="text-3xl font-extrabold mt-1 text-foreground">8</h3>
    </div>
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div
                class="size-10 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600">
                <span class="material-symbols-outlined">pending_actions</span>
            </div>
            <span class="text-xs font-bold text-amber-600 bg-amber-100 dark:bg-amber-900/30 px-2 py-1 rounded-full">High
                Priority</span>
        </div>
        <p class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Pending Notes</p>
        <h3 class="text-3xl font-extrabold mt-1 text-foreground">3</h3>
    </div>
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div
                class="size-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600">
                <span class="material-symbols-outlined">medical_services</span>
            </div>
            <span class="text-xs font-bold text-muted-foreground">Total this week</span>
        </div>
        <p class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Consultations</p>
        <h3 class="text-3xl font-extrabold mt-1 text-foreground">12</h3>
    </div>
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div
                class="size-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                <span class="material-symbols-outlined">timer</span>
            </div>
        </div>
        <p class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Weekly Hours</p>
        <h3 class="text-3xl font-extrabold mt-1 text-foreground">34.5</h3>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Today\'s Schedule -->
    <div class="lg:col-span-2 space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-foreground">Today\'s Schedule</h2>
            <button class="text-primary text-sm font-semibold hover:underline">View Full Calendar</button>
        </div>
        <div class="space-y-4">
            <!-- Appointment Card 1 -->
            <div
                class="group bg-card p-5 rounded-xl border border-border shadow-sm hover:border-primary transition-all flex flex-col sm:flex-row items-start sm:items-center gap-4">
                <div class="w-16 flex flex-col items-center justify-center border-r border-border pr-4">
                    <span class="text-xs font-bold text-muted-foreground uppercase">09:00</span>
                    <span class="text-sm font-extrabold text-foreground">AM</span>
                </div>
                <div class="flex-1 flex items-center gap-4 min-w-0">
                    <img class="size-12 rounded-lg object-cover" data-alt="Patient Sarah Jenkins"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuBgZ5O4ZeiQPnCeFCkYe9R3m93uFqwNopkzpiJynk9qOmfuKCC1itOjJLeeSdPVfsfQZqnCPSjbLuoCsuT9fdYKQMQt1yjzE2cEnPyAJNDCzRFZw9ygISxuTDUaOMdmmUGN6GvU6NugfqKxWA-A7FwAwgwb87PxrkwWlI8C_dVV_rp_sHn-H4h-HacOW4dmPDAM-H_gQIBo8a4g6Uy8XJubcEDh3QWk9j2xLIhLdAjQrPm92ckFuFpA_XLOWr27Xe4GPz1uMRWIiLI" />
                    <div class="min-w-0">
                        <h4 class="font-bold text-base truncate text-foreground">Sarah Jenkins</h4>
                        <p class="text-xs text-muted-foreground flex items-center gap-1">
                            <span class="size-2 rounded-full bg-blue-500"></span>
                            Routine Check-up • 45m
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto mt-2 sm:mt-0">
                    <span
                        class="px-2.5 py-1 bg-green-50 dark:bg-green-900/20 text-green-600 text-[10px] font-bold uppercase tracking-wider rounded-md">Checked
                        In</span>
                    <button
                        class="flex-1 sm:flex-none px-4 py-2 bg-primary text-primary-foreground text-xs font-bold rounded-lg hover:bg-primary/90 shadow-md shadow-primary/10 transition-all">
                        Start Session
                    </button>
                </div>
            </div>
            <!-- Appointment Card 2 -->
            <div
                class="group bg-card p-5 rounded-xl border border-border shadow-sm hover:border-primary transition-all flex flex-col sm:flex-row items-start sm:items-center gap-4 opacity-80 hover:opacity-100">
                <div class="w-16 flex flex-col items-center justify-center border-r border-border pr-4">
                    <span class="text-xs font-bold text-muted-foreground uppercase">10:30</span>
                    <span class="text-sm font-extrabold text-foreground">AM</span>
                </div>
                <div class="flex-1 flex items-center gap-4 min-w-0">
                    <img class="size-12 rounded-lg object-cover" data-alt="Patient Michael Ross"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCAfb22TAnfpkFg7hBndFFxjAHCzhjPkLiQ3bJ_VlbRTKvSbI01uiuiUYEiUgPpTaTMlNVlnrlxsoH1VxsPdT3t_hcX2lnC_2cwCHruuduLbBl9bTT3fLP9Carv1_XiyUXqmTfToc_trexOJ5YTbNlEAvadxkCrhhTfGG9OVAdnAooDBEIXzJiRsL-8tzWiYEPOzSBSZx4UC7pdZMjqfimzZYMalDe0wPrGqqU8c6eiuh_S8yXQQwFbESVr4gtI78RiCrgAgBC6U1g" />
                    <div class="min-w-0">
                        <h4 class="font-bold text-base truncate text-foreground">Michael Ross</h4>
                        <p class="text-xs text-muted-foreground flex items-center gap-1">
                            <span class="size-2 rounded-full bg-primary"></span>
                            Initial Assessment • 60m
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto mt-2 sm:mt-0">
                    <span
                        class="px-2.5 py-1 bg-muted text-muted-foreground text-[10px] font-bold uppercase tracking-wider rounded-md">Pending</span>
                    <button
                        class="flex-1 sm:flex-none px-4 py-2 bg-muted text-muted-foreground text-xs font-bold rounded-lg cursor-not-allowed">
                        Start Session
                    </button>
                </div>
            </div>
            <!-- Appointment Card 3 -->
            <div
                class="group bg-card p-5 rounded-xl border border-border shadow-sm hover:border-primary transition-all flex flex-col sm:flex-row items-start sm:items-center gap-4 opacity-80 hover:opacity-100">
                <div class="w-16 flex flex-col items-center justify-center border-r border-border pr-4">
                    <span class="text-xs font-bold text-muted-foreground uppercase">01:15</span>
                    <span class="text-sm font-extrabold text-foreground">PM</span>
                </div>
                <div class="flex-1 flex items-center gap-4 min-w-0">
                    <img class="size-12 rounded-lg object-cover" data-alt="Patient Elena Rodriguez"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCtqdxsSXDXF2JeFlffCcJ5saorwUXc3QoQ6Em9JDqVGxKiRApNzxl5qtpVUhnqSyT_mvW9yQwF_dSLDPM07QJnmqnq8YxhW2mYw4FKA0diUKlkXLT6uN6FUAa6LiFWzpKcxPqJg-RUllkkuCMczlLb6HzRkl2npmxev9kpn48veMf6easR7qBFNxQ-VHpDpfSR_blxwljl8IgFKW4vXPZeXiGL5ACMm2yVZ9u17Xojw65yYeV0S_mHpbdH0m5IW5QVzVzl6_K52PA" />
                    <div class="min-w-0">
                        <h4 class="font-bold text-base truncate text-foreground">Elena Rodriguez</h4>
                        <p class="text-xs text-muted-foreground flex items-center gap-1">
                            <span class="size-2 rounded-full bg-amber-500"></span>
                            Follow-up Session • 30m
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3 w-full sm:w-auto mt-2 sm:mt-0">
                    <span
                        class="px-2.5 py-1 bg-amber-50 dark:bg-amber-900/20 text-amber-600 text-[10px] font-bold uppercase tracking-wider rounded-md">Expected</span>
                    <button
                        class="flex-1 sm:flex-none px-4 py-2 bg-muted text-muted-foreground text-xs font-bold rounded-lg cursor-not-allowed">
                        Start Session
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Side Panels: Activity & Quick Links -->
    <div class="space-y-8">
        <!-- Quick Links -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-foreground">Clinical Tools</h2>
            <div class="grid grid-cols-2 gap-3">
                <button
                    class="p-4 bg-card border border-border rounded-xl hover:border-primary transition-all text-left flex flex-col gap-2 shadow-sm group">
                    <span
                        class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">pill</span>
                    <span class="text-xs font-bold text-foreground opacity-80 group-hover:opacity-100">New Rx</span>
                </button>
                <button
                    class="p-4 bg-card border border-border rounded-xl hover:border-primary transition-all text-left flex flex-col gap-2 shadow-sm group">
                    <span
                        class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">outgoing_mail</span>
                    <span class="text-xs font-bold text-foreground opacity-80 group-hover:opacity-100">Referral</span>
                </button>
                <button
                    class="p-4 bg-card border border-border rounded-xl hover:border-primary transition-all text-left flex flex-col gap-2 shadow-sm group">
                    <span
                        class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">history_edu</span>
                    <span class="text-xs font-bold text-foreground opacity-80 group-hover:opacity-100">History
                        Search</span>
                </button>
                <button
                    class="p-4 bg-card border border-border rounded-xl hover:border-primary transition-all text-left flex flex-col gap-2 shadow-sm group">
                    <span
                        class="material-symbols-outlined text-primary group-hover:scale-110 transition-transform">lab_profile</span>
                    <span class="text-xs font-bold text-foreground opacity-80 group-hover:opacity-100">Lab Portal</span>
                </button>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="space-y-4">
            <h2 class="text-xl font-bold text-foreground">Recent Patient Activity</h2>
            <div class="bg-card rounded-xl border border-border overflow-hidden shadow-sm">
                <div class="divide-y divide-border">
                    <div class="p-4 hover:bg-muted/50 transition-colors">
                        <div class="flex items-start gap-3">
                            <div
                                class="mt-1 size-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                                <span class="material-symbols-outlined text-base">upload_file</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm text-foreground opacity-90"><span class="font-bold">Lab results</span>
                                    uploaded for Sarah Jenkins</p>
                                <span class="text-[10px] text-muted-foreground font-medium uppercase tracking-widest">12
                                    minutes ago</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 hover:bg-muted/50 transition-colors">
                        <div class="flex items-start gap-3">
                            <div
                                class="mt-1 size-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                                <span class="material-symbols-outlined text-base">done_all</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm text-foreground opacity-90"><span
                                        class="font-bold">Prescription</span> confirmed for David Miller</p>
                                <span class="text-[10px] text-muted-foreground font-medium uppercase tracking-widest">2
                                    hours ago</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 hover:bg-muted/50 transition-colors">
                        <div class="flex items-start gap-3">
                            <div
                                class="mt-1 size-8 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600">
                                <span class="material-symbols-outlined text-base">priority_high</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm text-foreground opacity-90"><span class="font-bold">Missed
                                        session</span> alert for Kevin Bates</p>
                                <span class="text-[10px] text-muted-foreground font-medium uppercase tracking-widest">4
                                    hours ago</span>
                            </div>
                        </div>
                    </div>
                </div>
                <button
                    class="w-full py-3 bg-muted/30 text-[10px] font-bold text-muted-foreground uppercase tracking-widest hover:text-primary hover:bg-muted transition-all border-t border-border">
                    View All Activity
                </button>
            </div>
        </div>
    </div>
</div>