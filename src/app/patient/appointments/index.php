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

<!-- Filter Sub-header -->
<div class="bg-card rounded-2xl border border-border p-5 flex flex-wrap items-center gap-6 mb-10 shadow-sm">
    <div class="flex items-center gap-3">
        <span class="text-xs font-black text-muted-foreground uppercase tracking-widest">Status:</span>
        <div class="flex bg-muted p-1 rounded-xl" id="status-filters">
            <button data-status="all"
                class="filter-btn px-5 py-2 text-xs font-bold rounded-lg bg-card shadow-sm text-primary transition-all">All</button>
            <button data-status="confirmed"
                class="filter-btn px-5 py-2 text-xs font-bold rounded-lg text-muted-foreground hover:text-foreground transition-all">Upcoming
                (<span id="count-upcoming">0</span>)</button>
            <button data-status="pending"
                class="filter-btn px-5 py-2 text-xs font-bold rounded-lg text-muted-foreground hover:text-foreground transition-all">Pending
                Approval (<span id="count-pending">0</span>)</button>
            <button data-status="history"
                class="filter-btn px-5 py-2 text-xs font-bold rounded-lg text-muted-foreground hover:text-foreground transition-all">History
                (<span id="count-history">0</span>)</button>
        </div>
    </div>
    <div class="h-8 w-px bg-border hidden lg:block"></div>
    <div class="flex flex-wrap items-center gap-4 flex-1">
        <div class="relative flex-1 min-w-[200px]">
            <span
                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg text-muted-foreground">person</span>
            <select id="doctor-filter"
                class="w-full pl-10 pr-4 py-2.5 bg-muted border-none rounded-xl text-xs font-bold text-foreground focus:ring-2 focus:ring-primary/20 cursor-pointer appearance-none transition-all">
                <option value="all">All Providers</option>
            </select>
        </div>
        <div class="relative flex-1 min-w-[200px]">
            <span
                class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg text-muted-foreground">calendar_month</span>
            <input id="date-filter"
                class="w-full pl-10 pr-4 py-2.5 bg-muted border-none rounded-xl text-xs font-bold text-foreground focus:ring-2 focus:ring-primary/20 transition-all"
                type="date" />
        </div>
    </div>
    <button id="reset-filters"
        class="flex items-center gap-2 text-xs font-bold text-primary hover:opacity-80 transition-all p-2 rounded-lg hover:bg-primary/5">
        <span class="material-symbols-outlined text-lg">filter_alt_off</span>
        Reset
    </button>
</div>

<div id="appointments-container" class="space-y-6">
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

<!-- View Summary Modal -->
<?= featured('appointments', 'components/summary-modal') ?>
<!-- Withdraw Confirmation Modal -->
<?= featured('appointments', 'components/withdraw-modal') ?>
<!-- Reschedule Modal -->
<?= featured('appointments', 'components/reschedule-modal') ?>

<script src="<?= shared('data', 'icons.js', true) ?>"></script>
<script>
    $(document).ready(function () {
        window.allAppointments = [];
        let filters = {
            status: 'all',
            doctor: 'all',
            date: ''
        };

        function fetchDoctors() {
            $.ajax({
                url: apiUrl("shared") + "list-doctors.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (!response.success) return;

                    const $select = $('#doctor-filter');
                    response.data.forEach(d => {
                        $select.append(`<option value="${d.uuid}">Dr. ${d.firstname} ${d.lastname}</option>`);
                    });
                }
            });
        }

        window.fetchAppointments = function () {
            $.ajax({
                url: apiUrl("appointments") + "list-appointments.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (!response.success) {
                        $('#appointments-container').html('<div class="py-20 text-center text-red-500 font-bold">' + response.message + '</div>');
                        return;
                    }
                    window.allAppointments = response.data;
                    updateCounts();
                    applyFilters();
                },
                error: function () {
                    $('#appointments-container').html('<div class="py-20 text-center text-red-500 font-bold">Failed to load appointments.</div>');
                }
            });
        }

        function updateCounts() {
            const upcoming = window.allAppointments.filter(a => a.status === 'confirmed').length;
            const pending = window.allAppointments.filter(a => a.status === 'pending').length;
            const history = window.allAppointments.filter(a => ['completed', 'cancelled', 'no_show'].includes(a.status)).length;
            $('#count-upcoming').text(upcoming);
            $('#count-pending').text(pending);
            $('#count-history').text(history);
        }

        function applyFilters() {
            let filtered = window.allAppointments;

            // Filter by Status
            if (filters.status === 'confirmed') {
                filtered = filtered.filter(a => a.status === 'confirmed');
            } else if (filters.status === 'pending') {
                filtered = filtered.filter(a => a.status === 'pending');
            } else if (filters.status === 'history') {
                filtered = filtered.filter(a => ['completed', 'cancelled', 'no_show'].includes(a.status));
            }

            // Filter by Doctor
            if (filters.doctor !== 'all') {
                filtered = filtered.filter(a => a.doctor_uuid === filters.doctor);
            }

            // Filter by Date
            if (filters.date) {
                filtered = filtered.filter(a => a.sched_date === filters.date);
            }

            renderAppointments(filtered);
        }

        function renderAppointments(data) {
            const $container = $('#appointments-container');

            if (data.length === 0) {
                $container.html(`
                <div class="bg-card p-12 rounded-[2rem] border border-dashed border-border flex flex-col items-center justify-center text-center">
                    <div class="size-20 rounded-3xl bg-primary/5 text-primary/30 flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-5xl">calendar_today</span>
                    </div>
                    <h3 class="text-xl font-black text-foreground mb-2">No Appointments Found</h3>
                    <p class="text-muted-foreground max-w-sm mb-8">Try adjusting your filters or book a new session if you haven't yet.</p>
                    <a href="step-1-service.php" class="px-8 py-4 bg-primary text-white font-black rounded-2xl shadow-xl shadow-primary/20 hover:opacity-95 transition-all">Book New Appointment</a>
                </div>
            `);
                return;
            }

            let html = '';
            data.forEach(a => {
                const isConfirmed = a.status === 'confirmed';
                const isPending = a.status === 'pending';
                const isCancelled = a.status === 'cancelled';
                const isCompleted = a.status === 'completed';

                let statusClass = 'bg-muted text-muted-foreground';
                let statusLabel = a.status.charAt(0).toUpperCase() + a.status.slice(1).replace('_', ' ');

                if (isConfirmed) {
                    statusClass = 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400';
                    statusLabel = 'Approved';
                } else if (isPending) {
                    statusClass = 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400';
                    statusLabel = 'Pending Approval';
                } else if (isCancelled) {
                    statusClass = 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400';
                    statusLabel = 'Cancelled';
                } else if (isCompleted) {
                    statusClass = 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400';
                }

                const dateStr = new Date(a.sched_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
                const timeStr = a.sched_time;

                html += `
                <div class="bg-card p-6 rounded-[2rem] border border-border shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                        <div class="lg:w-1/4">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined">${getServiceIcon(a.service_name)}</span>
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
                            ${isConfirmed ? `
                                <button data-uuid="${a.uuid}" data-service="${a.service_uuid}" data-doctor="${a.doctor_uuid}" data-notes="${a.notes}" class="reschedule-btn px-5 py-2.5 rounded-xl border border-border text-sm font-bold hover:bg-muted transition-colors w-full lg:w-auto">Reschedule</button>
                            ` : isPending ? `
                                <button data-uuid="${a.uuid}" data-service="${a.service_uuid}" data-doctor="${a.doctor_uuid}" data-notes="${a.notes}" class="edit-request-btn px-5 py-2.5 rounded-xl border border-border text-sm font-bold hover:bg-muted transition-colors">Edit Request</button>
                                <button data-uuid="${a.uuid}" class="withdraw-btn px-5 py-2.5 rounded-xl border border-red-100 dark:border-red-900/30 text-red-600 dark:text-red-400 text-sm font-bold hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors">Withdraw</button>
                            ` : `
                                <button data-uuid="${a.uuid}" class="view-summary-btn px-5 py-2.5 rounded-xl border border-border text-sm font-bold hover:bg-muted transition-colors">View Summary</button>
                            `}
                        </div>
                    </div>
                </div>
            `;
            });
            $container.html(html);
        }

        $('body').on('click', '.edit-request-btn', function () {
            const uuid = $(this).data('uuid');
            const service = $(this).data('service');
            const doctor = $(this).data('doctor');
            const notes = $(this).data('notes');
            // Redirect to step-1 with edit_uuid and carry over previous selections
            window.location.href = `step-1-service.php?edit_uuid=${encodeURIComponent(uuid)}&service=${encodeURIComponent(service)}&doctor_uuid=${encodeURIComponent(doctor)}&notes=${encodeURIComponent(notes)}`;
        });

        // Event Listeners for Filters
        $('body').on('click', '.filter-btn', function () {
            filters.status = $(this).data('status');

            $('.filter-btn').removeClass('bg-card shadow-sm text-primary').addClass('text-muted-foreground hover:text-foreground');
            $(this).addClass('bg-card shadow-sm text-primary').removeClass('text-muted-foreground hover:text-foreground');

            applyFilters();
        });

        $('#doctor-filter').on('change', function () {
            filters.doctor = $(this).val();
            applyFilters();
        });

        $('#date-filter').on('change', function () {
            filters.date = $(this).val();
            applyFilters();
        });

        $('#reset-filters').on('click', function () {
            filters = { status: 'all', doctor: 'all', date: '' };

            // Reset UI
            $('.filter-btn[data-status="all"]').click();
            $('#doctor-filter').val('all');
            $('#date-filter').val('');

            applyFilters();
        });

        fetchDoctors();
        // Initial fetch
        window.fetchAppointments();
    });
</script>