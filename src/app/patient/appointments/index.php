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
<div id="summary-modal"
    class="fixed inset-0 z-[60] hidden items-center justify-center p-4 bg-background/80 backdrop-blur-sm">
    <div class="bg-card w-full max-w-lg rounded-[2.5rem] border border-border shadow-2xl p-8 transform transition-all">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-black text-foreground">Appointment Summary</h3>
            <button onclick="$('#summary-modal').addClass('hidden').removeClass('flex')"
                class="p-2 hover:bg-muted rounded-full transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="space-y-6">
            <div class="flex items-start gap-4 p-4 rounded-3xl bg-muted/50 border border-border">
                <div class="size-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl" id="summary-service-icon">psychology</span>
                </div>
                <div>
                    <p class="text-xs text-muted-foreground font-bold uppercase tracking-widest mb-1">Service &
                        Specialist</p>
                    <p class="text-lg font-black text-foreground" id="summary-service-name">---</p>
                    <p class="text-sm font-bold text-primary" id="summary-doctor-name">---</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 rounded-3xl bg-muted/30 border border-border">
                    <p class="text-[10px] text-muted-foreground font-bold uppercase tracking-widest mb-1">Date</p>
                    <p class="text-sm font-black text-foreground flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">calendar_today</span>
                        <span id="summary-date">---</span>
                    </p>
                </div>
                <div class="p-4 rounded-3xl bg-muted/30 border border-border">
                    <p class="text-[10px] text-muted-foreground font-bold uppercase tracking-widest mb-1">Time Slot</p>
                    <p class="text-sm font-black text-foreground flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">schedule</span>
                        <span id="summary-time">---</span>
                    </p>
                </div>
            </div>

            <div id="summary-notes-container" class="hidden">
                <p class="text-[10px] text-muted-foreground font-bold uppercase tracking-widest mb-2 px-1">Session Notes
                </p>
                <div class="p-4 rounded-2xl bg-muted/20 border border-border italic text-sm text-foreground/80"
                    id="summary-notes">
                    No notes recorded for this session.
                </div>
            </div>

            <div class="flex items-center justify-between px-1">
                <span class="text-xs font-bold text-muted-foreground">Current Status</span>
                <span id="summary-status"
                    class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider">---</span>
            </div>
        </div>

        <button onclick="$('#summary-modal').addClass('hidden').removeClass('flex')"
            class="w-full mt-8 py-4 bg-foreground text-background font-black rounded-2xl hover:opacity-90 transition-all">
            Close Summary
        </button>
    </div>
</div>

<!-- Withdraw Confirmation Modal -->
<div id="withdraw-modal"
    class="fixed inset-0 z-[60] hidden items-center justify-center p-4 bg-background/80 backdrop-blur-sm">
    <div class="bg-card w-full max-w-md rounded-[2.5rem] border border-border shadow-2xl p-8">
        <div class="size-20 bg-error/10 text-error rounded-3xl flex items-center justify-center mx-auto mb-6">
            <span class="material-symbols-outlined text-4xl">warning</span>
        </div>
        <h3 class="text-xl font-black text-center mb-2">Withdraw Request?</h3>
        <p class="text-muted-foreground text-center text-sm mb-8">This will cancel your pending appointment request.
            This action cannot be undone.</p>

        <div class="flex flex-col gap-3">
            <button id="confirm-withdraw-btn"
                class="w-full py-4 bg-error font-black rounded-2xl hover:opacity-95 shadow-xl shadow-error/20 transition-all">
                Yes, Withdraw Request
            </button>
            <button onclick="$('#withdraw-modal').addClass('hidden').removeClass('flex')"
                class="w-full py-4 bg-muted text-foreground font-black rounded-2xl hover:bg-muted/80 transition-all">
                Keep Requested Session
            </button>
        </div>
    </div>
</div>

<!-- Reschedule Modal -->
<div id="reschedule-modal"
    class="fixed inset-0 z-[60] hidden items-center justify-center p-4 bg-background/80 backdrop-blur-sm">
    <div class="bg-card w-full max-w-lg rounded-[2.5rem] border border-border shadow-2xl p-8 transform transition-all">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-black text-foreground tracking-tight">Reschedule Session</h3>
            <button onclick="$('#reschedule-modal').addClass('hidden').removeClass('flex')"
                class="p-2 hover:bg-muted rounded-full transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="space-y-6">
            <!-- Summary Info -->
            <div class="flex items-center gap-4 p-4 rounded-3xl bg-muted/50 border border-border">
                <div class="size-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">schedule</span>
                </div>
                <div>
                    <p class="text-[10px] text-muted-foreground font-bold uppercase tracking-widest mb-0.5">Current
                        Specialist</p>
                    <p class="text-base font-black text-foreground" id="reschedule-summary-doctor">---</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="space-y-2">
                    <label class="text-xs font-black text-muted-foreground uppercase tracking-wider ml-1">New
                        Date</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground">calendar_today</span>
                        <input type="date" id="reschedule-date"
                            class="w-full pl-12 pr-6 py-4 bg-muted/30 border border-border rounded-2xl text-sm font-bold focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all"
                            min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d') ?>">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black text-muted-foreground uppercase tracking-wider ml-1">Available
                        Times</label>
                    <div class="grid grid-cols-3 gap-3" id="reschedule-time-slots">
                        <?php
                        $modalSlots = ['9:00 AM', '10:30 AM', '11:00 AM', '2:00 PM', '3:30 PM', '4:45 PM'];
                        foreach ($modalSlots as $index => $time):
                            ?>
                            <label class="cursor-pointer">
                                <input type="radio" name="reschedule_time" value="<?= $time ?>"
                                    class="peer absolute opacity-0" <?= $index === 0 ? 'checked' : '' ?> />
                                <div
                                    class="py-3 px-2 text-xs font-black rounded-xl border-2 border-transparent bg-muted/30 text-muted-foreground transition-all text-center peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary hover:border-primary/30">
                                    <?= $time ?>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <button id="confirm-reschedule-btn"
            class="w-full mt-10 py-4 bg-primary text-white font-black rounded-2xl hover:opacity-95 shadow-xl shadow-primary/20 transform transition-all active:scale-[0.98] flex items-center justify-center gap-2">
            Confirm New Schedule
            <span class="material-symbols-outlined text-xl">event_available</span>
        </button>
    </div>
</div>

<script>
    $(document).ready(function () {
        let allAppointments = [];
        let filters = {
            status: 'all',
            doctor: 'all',
            date: ''
        };
        let activeWithdrawUuid = null;
        let activeRescheduleUuid = null;
        let activeRescheduleService = null;
        let activeRescheduleDoctor = null;

        function fetchDoctors() {
            $.ajax({
                url: apiUrl("appointments") + "list-doctors.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        const $select = $('#doctor-filter');
                        response.data.forEach(d => {
                            $select.append(`<option value="${d.uuid}">Dr. ${d.firstname} ${d.lastname}</option>`);
                        });
                    }
                }
            });
        }

        function fetchAppointments() {
            $.ajax({
                url: apiUrl("appointments") + "list-appointments.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        allAppointments = response.data;
                        updateCounts();
                        applyFilters();
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
            const upcoming = allAppointments.filter(a => a.status === 'confirmed').length;
            const pending = allAppointments.filter(a => a.status === 'pending').length;
            const history = allAppointments.filter(a => ['completed', 'cancelled', 'no_show'].includes(a.status)).length;
            $('#count-upcoming').text(upcoming);
            $('#count-pending').text(pending);
            $('#count-history').text(history);
        }

        function applyFilters() {
            let filtered = allAppointments;

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

                let statusClass = 'bg-muted text-muted-foreground';
                let statusLabel = a.status.charAt(0).toUpperCase() + a.status.slice(1).replace('_', ' ');

                if (isConfirmed) {
                    statusClass = 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400';
                    statusLabel = 'Approved';
                } else if (isPending) {
                    statusClass = 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400';
                    statusLabel = 'Pending Approval';
                } else if (a.status === 'cancelled') {
                    statusClass = 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400';
                    statusLabel = 'Cancelled';
                }

                const dateStr = new Date(a.sched_date).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
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

        // Action Handlers
        $(document).on('click', '.view-summary-btn', function () {
            const uuid = $(this).data('uuid');
            const a = allAppointments.find(x => x.uuid === uuid);
            if (!a) return;

            const dateStr = new Date(a.sched_date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });

            $('#summary-service-name').text(a.service_name);
            $('#summary-doctor-name').text(`Dr. ${a.doctor_firstname} ${a.doctor_lastname}`);
            $('#summary-date').text(dateStr);
            $('#summary-time').text(a.sched_time);

            const isConfirmed = a.status === 'confirmed';
            const isPending = a.status === 'pending';
            let statusClass = 'bg-muted text-muted-foreground';
            let statusLabel = a.status.charAt(0).toUpperCase() + a.status.slice(1).replace('_', ' ');

            if (isConfirmed) {
                statusClass = 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400';
                statusLabel = 'Approved';
            } else if (isPending) {
                statusClass = 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400';
                statusLabel = 'Pending Approval';
            } else if (a.status === 'cancelled') {
                statusClass = 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400';
                statusLabel = 'Cancelled';
            }

            $('#summary-status').text(statusLabel).attr('class', '').addClass(`px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider ${statusClass}`);

            if (a.notes) {
                $('#summary-notes-container').removeClass('hidden');
                $('#summary-notes').text(a.notes);
            } else {
                $('#summary-notes-container').addClass('hidden');
            }

            $('#summary-modal').removeClass('hidden').addClass('flex');
        });

        let activeRescheduleNotes = null;

        $(document).on('click', '.reschedule-btn', function () {
            const uuid = $(this).data('uuid');
            const service = $(this).data('service');
            const doctor = $(this).data('doctor');
            const notes = $(this).data('notes');
            const a = allAppointments.find(x => x.uuid === uuid);

            if (!a) return;

            activeRescheduleUuid = uuid;
            activeRescheduleService = service;
            activeRescheduleDoctor = doctor;
            activeRescheduleNotes = notes;

            $('#reschedule-summary-doctor').text(`Dr. ${a.doctor_firstname} ${a.doctor_lastname}`);
            $('#reschedule-modal').removeClass('hidden').addClass('flex');
        });

        $('#confirm-reschedule-btn').on('click', function () {
            if (!activeRescheduleUuid) return;

            const btn = $(this);
            const date = $('#reschedule-date').val();
            const timeSlot = $('input[name="reschedule_time"]:checked').val();

            if (!date || !timeSlot) {
                alert('Please select a valid date and time.');
                return;
            }

            btn.prop('disabled', true).html('<span class="loading loading-spinner"></span> Rescheduling...');

            const bookingData = {
                appointment_uuid: activeRescheduleUuid,
                service_uuid: activeRescheduleService,
                doctor_uuid: activeRescheduleDoctor,
                sched_date: date,
                sched_time: timeSlot,
                notes: activeRescheduleNotes
            };

            $.ajax({
                url: apiUrl("appointments") + "book.php",
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(bookingData),
                success: function (response) {
                    if (response.success) {
                        $('#reschedule-modal').addClass('hidden').removeClass('flex');
                        fetchAppointments(); // Refresh list
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function () {
                    alert('An unexpected error occurred. Please try again.');
                },
                complete: function () {
                    btn.prop('disabled', false).html('Confirm New Schedule <span class="material-symbols-outlined text-xl">event_available</span>');
                    activeRescheduleUuid = null;
                }
            });
        });

        $(document).on('click', '.edit-request-btn', function () {
            const uuid = $(this).data('uuid');
            const service = $(this).data('service');
            const doctor = $(this).data('doctor');
            const notes = $(this).data('notes');
            // Redirect to step-1 with edit_uuid and carry over previous selections
            window.location.href = `step-1-service.php?edit_uuid=${encodeURIComponent(uuid)}&service=${encodeURIComponent(service)}&doctor_uuid=${encodeURIComponent(doctor)}&notes=${encodeURIComponent(notes)}`;
        });

        $(document).on('click', '.withdraw-btn', function () {
            activeWithdrawUuid = $(this).data('uuid');
            $('#withdraw-modal h3').text('Withdraw Request?');
            $('#withdraw-modal p').text('Are you sure you want to retract your pending appointment request?');
            $('#withdraw-modal').removeClass('hidden').addClass('flex');
        });

        $('#confirm-withdraw-btn').on('click', function () {
            if (!activeWithdrawUuid) return;
            const btn = $(this);
            btn.prop('disabled', true).html('<span class="loading loading-spinner"></span> Processing...');

            $.ajax({
                url: apiUrl("appointments") + "cancel-appointment.php",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify({ appointment_uuid: activeWithdrawUuid }),
                success: function (response) {
                    if (response.success) {
                        $('#withdraw-modal').addClass('hidden').removeClass('flex');
                        fetchAppointments(); // Refresh list
                    } else {
                        alert(response.message);
                    }
                },
                complete: function () {
                    btn.prop('disabled', false).text('Yes, Withdraw Request');
                    activeWithdrawUuid = null;
                }
            });
        });

        // Event Listeners for Filters
        $(document).on('click', '.filter-btn', function () {
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
        fetchAppointments();
    });
</script>