<?php
$pageTitle = "MindTrack Patient Appointments List";
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
        <button id="tab-active"
            class="tab-btn pb-4 px-1 border-b-2 border-primary text-primary font-semibold text-sm transition-all focus:outline-none">
            Active Sessions (<span id="count-active">0</span>)
        </button>
        <button id="tab-history"
            class="tab-btn pb-4 px-1 text-muted-foreground hover:text-foreground dark:text-muted-foreground dark:hover:text-gray-200 text-sm transition-all font-medium focus:outline-none border-b-2 border-transparent">
            History (<span id="count-history">0</span>)
        </button>
    </nav>
</div>

<div id="appointments-container" class="space-y-6 min-h-[300px]">
    <!-- Skeleton Loading -->
    <?php for ($i = 0; $i < 2; $i++): ?>
        <div class="h-32 bg-card rounded-[2rem] border border-border animate-pulse"></div>
    <?php endfor; ?>
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

<script>
    $(document).ready(function () {
        let allAppointments = [];
        let currentTab = 'active';

        function fetchAppointments() {
            $.ajax({
                url: apiUrl("appointments") + "list-appointments.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        allAppointments = response.data;
                        updateCounts();
                        renderTab(currentTab);
                    } else {
                        $('#appointments-container').html('<div class="py-20 text-center text-red-500 font-bold">' + response.message + '</div>');
                    }
                },
                error: function () {
                    $('#appointments-container').html('<div class="py-20 text-center text-red-500 font-bold">Failed to load appointments.</div>');
                }
            });
        }

        function updateCounts() {
            const active = allAppointments.filter(a => ['confirmed', 'pending'].includes(a.status)).length;
            const history = allAppointments.filter(a => ['completed', 'cancelled', 'no_show'].includes(a.status)).length;
            $('#count-active').text(active);
            $('#count-history').text(history);
        }

        function renderTab(tab) {
            const statuses = tab === 'active' ? ['confirmed', 'pending'] : ['completed', 'cancelled', 'no_show'];
            const filtered = allAppointments.filter(a => statuses.includes(a.status));
            const $container = $('#appointments-container');

            if (filtered.length === 0) {
                $container.html(`
                <div class="bg-card p-12 rounded-[2rem] border border-dashed border-border flex flex-col items-center justify-center text-center">
                    <div class="size-20 rounded-3xl bg-primary/5 text-primary/30 flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-5xl">calendar_today</span>
                    </div>
                    <h3 class="text-xl font-black text-foreground mb-2">No ${tab === 'active' ? 'Upcoming' : 'Past'} Appointments</h3>
                    <p class="text-muted-foreground max-w-sm mb-8">${tab === 'active' ? "You don't have any scheduled sessions yet." : "You don't have any completed sessions in your history."}</p>
                    ${tab === 'active' ? '<a href="step-1-service.php" class="px-8 py-4 bg-primary text-white font-black rounded-2xl shadow-xl shadow-primary/20 hover:opacity-95 transition-all">Book New Appointment</a>' : ''}
                </div>
            `);
                return;
            }

            let html = '';
            filtered.forEach(a => {
                const statusClass = a.status === 'confirmed' ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400';
                const statusLabel = a.status.charAt(0).toUpperCase() + a.status.slice(1);
                const dateStr = new Date(a.sched_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                // Simple time format - you might want a more robust one
                const timeStr = a.sched_time;

                html += `
                <div class="bg-card p-6 rounded-[2rem] border border-border shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                        <div class="lg:w-1/4">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined">psychology</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg">${a.service_name}</h3>
                                    <p class="text-xs text-muted-foreground font-medium">${a.service_duration} mins</p>
                                </div>
                            </div>
                            <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider ${statusClass}">${statusLabel}</span>
                        </div>
                        <div class="lg:w-1/4 flex items-center gap-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-lg">calendar_today</span>
                                    ${dateStr}
                                </span>
                                <span class="text-sm font-bold mt-1 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-lg">schedule</span>
                                    ${timeStr}
                                </span>
                            </div>
                        </div>
                        <div class="lg:w-1/4 flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-muted border-2 border-border overflow-hidden">
                                <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(a.doctor_firstname + ' ' + a.doctor_lastname)}&background=random" class="size-full object-cover" />
                            </div>
                            <div>
                                <p class="text-xs text-muted-foreground font-medium">Assigned Doctor</p>
                                <p class="text-sm font-bold">Dr. ${a.doctor_firstname} ${a.doctor_lastname}</p>
                            </div>
                        </div>
                        <div class="lg:w-1/4 flex flex-col sm:flex-row gap-3 lg:justify-end">
                            ${tab === 'active' ? `
                                <button class="px-5 py-2.5 rounded-xl border border-border text-sm font-bold hover:bg-muted transition-colors">Reschedule</button>
                                <button class="px-5 py-2.5 rounded-xl border border-red-100 dark:border-red-900/30 text-red-600 dark:text-red-400 text-sm font-bold hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors">Cancel</button>
                            ` : `
                                <button class="px-5 py-2.5 rounded-xl border border-border text-sm font-bold hover:bg-muted transition-colors">View Summary</button>
                            `}
                        </div>
                    </div>
                </div>
            `;
            });
            $container.html(html);
        }

        $('.tab-btn').on('click', function () {
            const id = $(this).attr('id');
            currentTab = id === 'tab-active' ? 'active' : 'history';

            $('.tab-btn').removeClass('border-primary text-primary font-semibold').addClass('text-muted-foreground font-medium border-transparent');
            $(this).addClass('border-primary text-primary font-semibold text-sm').removeClass('text-muted-foreground font-medium border-transparent');

            renderTab(currentTab);
        });

        fetchAppointments();
    });
</script>