<?php
/**
 * Admin - Appointments Management
 */
$pageTitle = "Appointments Management - MindTrack";
$headerData = [
    'title' => 'Appointments',
    'description' => 'Manage and schedule clinical sessions for all providers.',
    'searchPlaceholder' => 'Search appointments...',
    'actionLabel' => 'New Appointment',
    'actionIcon' => 'add',
    'actionUrl' => 'step-1-service.php',
    'mb' => 4
];
include_once __DIR__ . '/../layout.php';
?>

<!-- Filter Sub-header -->
<div class="bg-card rounded-xl border border-border p-4 flex flex-wrap items-center gap-4 mb-8">
    <div class="flex items-center gap-2">
        <span class="text-xs font-bold text-muted-foreground uppercase tracking-wider">Status:</span>
        <div class="flex bg-muted p-1 rounded-lg" id="status-filters">
            <button
                class="filter-btn active px-4 py-1.5 text-xs font-bold rounded-md bg-card shadow-sm text-primary transition-all"
                data-status="all">All</button>
            <button
                class="filter-btn px-4 py-1.5 text-xs font-bold rounded-md text-muted-foreground hover:text-foreground transition-all"
                data-status="pending">Pending</button>
            <button
                class="filter-btn px-4 py-1.5 text-xs font-bold rounded-md text-muted-foreground hover:text-foreground transition-all"
                data-status="uptcoming">Upcoming</button>
            <button
                class="filter-btn px-4 py-1.5 text-xs font-bold rounded-md text-muted-foreground hover:text-foreground transition-all"
                data-status="completed">Completed</button>
            <button
                class="filter-btn px-4 py-1.5 text-xs font-bold rounded-md text-muted-foreground hover:text-foreground transition-all"
                data-status="cancelled">Cancelled</button>
        </div>
    </div>
    <div class="h-8 w-px bg-border hidden md:block"></div>
    <div class="flex items-center gap-4 flex-1">
        <select id="filter-doctor"
            class="bg-muted border-none p-2 rounded-lg text-xs font-bold text-foreground focus:ring-primary/20 cursor-pointer w-48">
            <option value="">All Providers</option>
            <!-- Populated by JS -->
        </select>
        <div class="relative">
            <span
                class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-[18px] text-muted-foreground">calendar_today</span>
            <input id="filter-date"
                class="pl-10 pr-4 py-2 bg-muted border-none rounded-lg text-xs font-bold text-foreground w-64 focus:ring-primary/20"
                placeholder="Filter by Date" type="date" />
        </div>
    </div>
    <button id="reset-filters"
        class="flex items-center gap-1.5 text-xs font-bold text-primary hover:opacity-80 transition-opacity">
        <span class="material-symbols-outlined text-[18px]">filter_list_off</span>
        Reset Filters
    </button>
</div>

<!-- Main Grid Layout -->
<div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
    <!-- Appointments Table Section -->
    <div class="xl:col-span-3">
        <div class="bg-card rounded-xl border border-border overflow-hidden shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-muted/50 text-muted-foreground uppercase text-[11px] font-bold tracking-wider">
                        <th class="px-6 py-4">Patient</th>
                        <th class="px-6 py-4">Service</th>
                        <th class="px-6 py-4">Schedule</th>
                        <th class="px-6 py-4">Provider</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/50" id="appointments-list">
                    <!-- Loaded via JS -->
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-sm text-muted-foreground">
                            <div class="flex flex-col items-center gap-2">
                                <span class="loading loading-spinner loading-md text-primary"></span>
                                <span>Loading appointments...</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Pagination -->
            <div id="pagination" class="p-4 border-t border-border flex items-center justify-between hidden">
                <p class="text-xs text-muted-foreground font-medium" id="pagination-info">Showing 0-0 of 0 appointments
                </p>
                <div class="flex gap-2" id="pagination-controls">
                    <!-- Buttons rendered via JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Stats Content -->
    <div class="space-y-6">
        <!-- Daily Load Widget -->
        <div class="bg-card rounded-xl border border-border p-6 shadow-sm">
            <h3 class="text-sm font-bold mb-4 flex items-center gap-2 uppercase tracking-tight text-foreground">
                <span class="material-symbols-outlined text-primary text-[20px]">leaderboard</span>
                Daily Appointment Load
            </h3>
            <div class="space-y-4" id="daily-load-stats">
                <div class="text-xs text-muted-foreground text-center py-4">Loading stats...</div>
            </div>
            <div class="mt-6 pt-6 border-t border-border">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs text-muted-foreground font-medium">Total Appointments</span>
                    <span class="text-xs font-bold text-foreground" id="total-count">-</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-muted-foreground font-medium">Pending Requests</span>
                    <span class="text-[10px] font-bold px-2 py-0.5 bg-warning/10 text-warning rounded-full"
                        id="pending-count">-</span>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="bg-primary/5 rounded-xl border border-primary/10 p-5">
            <h4 class="text-sm font-bold text-primary mb-2 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">info</span>
                Admin Note
            </h4>
            <p class="text-xs text-muted-foreground leading-relaxed">
                Admins have full modification rights. Confirming an appointment sends a notification to the patient.
                Deleting is permanent.
            </p>
        </div>
    </div>
</div>

<!-- Modals -->
<?= featured('appointments', 'components/summary-modal') ?>
<?= featured('appointments', 'components/withdraw-modal', [
    'role' => 'admin',
    'title' => 'Delete Appointment?',
    'message' => 'Are you sure you want to permanently delete this appointment? This action cannot be undone.',
    'confirm_text' => 'Yes, Delete',
]); ?>

<script>
    $(document).ready(function () {
        // Global State
        window.allAppointments = [];
        window.filteredAppointments = [];
        let currentPage = 1;
        const itemsPerPage = 10;
        let appointmentToDelete = null;
        let appointmentToConfirm = null;

        // Init
        fetchDoctors();
        fetchAppointments();

        // --- Fetch Data ---

        function fetchDoctors() {
            $.ajax({
                url: apiUrl("shared") + "doctors.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        const select = $('#filter-doctor');
                        response.data.forEach(function (doc) {
                            select.append(`<option value="${doc.uuid}">Dr. ${doc.firstname} ${doc.lastname}</option>`);
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
                    // console.log(response);
                    // return false;

                    if (response.success) {
                        window.allAppointments = response.data;
                        applyFilters();
                    } else {
                        $('#appointments-list').html(`<tr><td colspan="6" class="px-6 py-4 text-center text-error">${response.message}</td></tr>`);
                    }
                },
                error: function () {
                    $('#appointments-list').html(`<tr><td colspan="6" class="px-6 py-4 text-center text-error">Failed to load appointments.</td></tr>`);
                }
            });
        }

        // --- Filtering ---

        $('.filter-btn').click(function () {
            $('.filter-btn').removeClass('active bg-card shadow-sm text-primary').addClass('text-muted-foreground');
            $(this).addClass('active bg-card shadow-sm text-primary').removeClass('text-muted-foreground');
            currentPage = 1;
            applyFilters();
        });

        $('#filter-doctor, #filter-date').change(function () {
            currentPage = 1;
            applyFilters();
        });

        $('#reset-filters').click(function () {
            $('.filter-btn').removeClass('active bg-card shadow-sm text-primary').addClass('text-muted-foreground');
            $('[data-status="all"]').addClass('active bg-card shadow-sm text-primary').removeClass('text-muted-foreground');
            $('#filter-doctor').val('');
            $('#filter-date').val('');
            currentPage = 1;
            applyFilters();
        });

        function applyFilters() {
            const status = $('.filter-btn.active').data('status');
            const doctorId = $('#filter-doctor').val();
            const date = $('#filter-date').val();

            window.filteredAppointments = window.allAppointments.filter(appt => {
                let match = true;

                // Status Filter
                if (status !== 'all') {
                    if (status === 'upcoming') {
                        // Logic for upcoming could be date-based, but relying on status 'confirmed' + future date is better
                        // For simplicity matching status string or mapping
                        match = appt.status.toLowerCase() === 'confirmed' || appt.status.toLowerCase() === 'scheduled';
                    } else {
                        match = appt.status.toLowerCase() === status.toLowerCase();
                    }
                }

                // Doctor Filter
                if (doctorId && appt.doctor_uuid !== doctorId) match = false;

                // Date Filter
                if (date && appt.sched_date !== date) match = false;

                return match;
            });

            updateSidebarStats();
            renderTable();
            renderPagination();
        }

        // --- Rendering ---

        function renderTable() {
            const tbody = $('#appointments-list');
            tbody.empty();

            if (window.filteredAppointments.length === 0) {
                tbody.html(`<tr><td colspan="6" class="px-6 py-8 text-center text-sm text-muted-foreground">No appointments found.</td></tr>`);
                return;
            }

            const start = (currentPage - 1) * itemsPerPage;
            const end = start + itemsPerPage;
            const pageData = window.filteredAppointments.slice(start, end);


            pageData.forEach(appt => {
                const statusColors = APPOINTMENT_STATUS_COLORS;
                const statusClass = statusColors[appt.status.toLowerCase()] || 'bg-muted text-muted-foreground';

                const pFirst = appt.patient_firstname || '';
                const pLast = appt.patient_lastname || '';
                const patientName = (pFirst || pLast) ? `${pFirst} ${pLast}`.trim() : 'Unknown Patient';
                const patientInitial = pFirst ? pFirst.charAt(0) : '?';

                const dFirst = appt.doctor_firstname || '';
                const dLast = appt.doctor_lastname || '';
                const doctorName = (dFirst || dLast) ? `Dr. ${dFirst} ${dLast}`.trim() : 'Unknown Doctor';

                // Format Date/Time
                const dateObj = new Date(`${appt.sched_date} ${appt.sched_time}`);
                const formattedDate = dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                const formattedTime = dateObj.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });

                const row = `
                    <tr class="hover:bg-muted/30 transition-colors group cursor-pointer appointment-row" data-uuid="${appt.uuid}">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                    ${patientInitial}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-foreground">${patientName}</p>
                                    <p class="text-[10px] text-muted-foreground uppercase">${appt.patient_email || 'No Email'}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-muted-foreground font-medium">${appt.service_name || 'Service Deleted'}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <p class="font-bold text-foreground">${formattedDate}</p>
                                <p class="text-xs text-muted-foreground">${formattedTime}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-muted-foreground">${doctorName}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold ${statusClass} uppercase tracking-wide">
                                ${appt.status.replace('_', ' ')}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="relative action-dropdown">
                                <button class="action-dropdown-toggle size-8 rounded-lg flex items-center justify-center bg-muted text-muted-foreground hover:text-primary hover:bg-muted/80 transition-all border border-border" 
                                    title="Actions" data-uuid="${appt.uuid}" data-service="${appt.service_uuid}" data-patient="${appt.patient_uuid}">
                                    <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                </button>
                                <div class="action-dropdown-menu hidden absolute right-0 mt-1 w-52 bg-card rounded-xl border border-border shadow-xl z-50 py-1">
                                    <!-- Change Status -->
                                    <p class="text-left py-2 pl-3.5 text-[10px] font-bold text-muted-foreground uppercase tracking-wider">Change Status</p>
                                    <button class="status-action w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" data-uuid="${appt.uuid}" data-status="pending">
                                        <span>⏳</span> Pending
                                    </button>
                                    <button class="status-action w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" data-uuid="${appt.uuid}" data-status="confirmed">
                                        <span>✅</span> Confirmed
                                    </button>
                                    <button class="status-action w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" data-uuid="${appt.uuid}" data-status="completed">
                                        <span>🏁</span> Completed
                                    </button>
                                    <button class="status-action w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" data-uuid="${appt.uuid}" data-status="cancelled">
                                        <span>❌</span> Cancelled
                                    </button>
                                    <button class="status-action w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" data-uuid="${appt.uuid}" data-status="no_show">
                                        <span>🚫</span> No Show
                                    </button>
                                    <button class="status-action w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" data-uuid="${appt.uuid}" data-status="rescheduled">
                                        <span>🔄</span> Rescheduled
                                    </button>
                                    <div class="border-t border-border my-1"></div>
                                    <!-- Manage -->
                                    <p class="text-left py-2 pl-3.5 text-[10px] font-bold text-muted-foreground uppercase tracking-wider">Manage</p>
                                    <button class="btn-edit w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" data-uuid="${appt.uuid}" data-service="${appt.service_uuid}" data-patient="${appt.patient_uuid}">
                                        <span>✏️</span> Edit
                                    </button>
                                    <button class="view-summary-btn w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" data-uuid="${appt.uuid}">
                                        <span>👁</span> View
                                    </button>
                                    <div class="border-t border-border my-1"></div>
                                    <!-- Danger -->
                                    <button class="delete-btn w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2 text-error font-semibold" data-uuid="${appt.uuid}">
                                        <span>🗑</span> Delete
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        function renderPagination() {
            const total = window.filteredAppointments.length;
            const totalPages = Math.ceil(total / itemsPerPage);
            const start = total === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
            const end = Math.min(start + itemsPerPage - 1, total);

            $('#pagination-info').text(`Showing ${start}-${end} of ${total} appointments`);

            const controls = $('#pagination-controls');
            controls.empty();

            if (totalPages <= 1) {
                $('#pagination').addClass('hidden');
                return;
            }
            $('#pagination').removeClass('hidden');

            // Prev
            controls.append(`
                <button class="px-3 py-1 text-xs font-bold rounded ${currentPage === 1 ? 'bg-muted text-muted-foreground cursor-not-allowed' : 'bg-muted text-foreground hover:bg-muted/80'} border border-border"
                    ${currentPage === 1 ? 'disabled' : ''} onclick="changePage(${currentPage - 1})">Prev</button>
            `);

            // Pages (simple version)
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                    controls.append(`
                        <button class="px-3 py-1 text-xs font-bold rounded ${i === currentPage ? 'bg-primary text-white border-primary' : 'bg-muted text-foreground hover:bg-muted/80 border-border'}"
                            onclick="changePage(${i})">${i}</button>
                    `);
                } else if (i === currentPage - 2 || i === currentPage + 2) {
                    controls.append(`<span class="px-1">...</span>`);
                }
            }

            // Next
            controls.append(`
                <button class="px-3 py-1 text-xs font-bold rounded ${currentPage === totalPages ? 'bg-muted text-muted-foreground cursor-not-allowed' : 'bg-muted text-foreground hover:bg-muted/80'} border border-border"
                    ${currentPage === totalPages ? 'disabled' : ''} onclick="changePage(${currentPage + 1})">Next</button>
            `);
        }

        window.changePage = function (page) {
            currentPage = page;
            renderTable();
            renderPagination();
        }

        function updateSidebarStats() {
            // Calculate stats from window.allAppointments (or filtered? usually all)
            // Let's use all to show overall stats, or filtered for "current view" stats.
            // Requirement mentions "Daily Load", which implies current context or today.
            // Let's stick to ALL appointments for general stats to make it useful.

            const total = window.allAppointments.length;
            const pending = window.allAppointments.filter(a => a.status === 'pending').length;

            $('#total-count').text(total);
            $('#pending-count').text(pending);

            // Mocking daily load bars for now as it requires complex logic matching today's date and time slots
            // In a real app we'd parse sched_date/time
        }

        // --- Actions ---

        // Dropdown Toggle
        $('body').on('click', '.action-dropdown-toggle', function (e) {
            e.stopPropagation();
            const $menu = $(this).siblings('.action-dropdown-menu');
            const wasHidden = $menu.hasClass('hidden');

            // Close all other dropdowns
            $('.action-dropdown-menu').addClass('hidden');

            // Toggle this dropdown
            if (wasHidden) {
                $menu.removeClass('hidden');
            }
        });

        // Close dropdown when clicking outside
        $('body').on('click', function (e) {
            if (!$(e.target).closest('.action-dropdown').length) {
                $('.action-dropdown-menu').addClass('hidden');
            }
        });

        // Close dropdown on Escape key
        $('body').on('keydown', function (e) {
            if (e.key === 'Escape') {
                $('.action-dropdown-menu').addClass('hidden');
            }
        });

        // Status Change Handler
        $('body').on('click', '.status-action', function (e) {
            e.stopPropagation();
            const uuid = $(this).data('uuid');
            const status = $(this).data('status');
            const btn = $(this);
            const originalText = btn.html();

            btn.prop('disabled', true).html('<span class="loading loading-spinner loading-xs"></span> Updating...');

            $.ajax({
                url: apiUrl("appointments") + "update-status.php",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify({ appointment_uuid: uuid, status: status }),
                success: function (response) {
                    if (!response.success) {
                        alert(response.message);
                        return;
                    }
                    $('.action-dropdown-menu').addClass('hidden');
                    fetchAppointments(); // Refresh list
                },
                error: function () {
                    alert('Failed to update status. Please try again.');
                },
                complete: function () {
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });

        // Delete Handler - directly open withdraw modal
        let activeWithdrawUuid = null;

        $('body').on('click', '.delete-btn', function (e) {
            e.stopPropagation();
            const uuid = $(this).data('uuid');
            $('.action-dropdown-menu').addClass('hidden');

            // Set the UUID and open the modal directly
            activeWithdrawUuid = uuid;
            $('#withdraw-modal').removeClass('hidden').addClass('flex');
        });

        // Handle the actual delete confirmation
        $('#confirm-withdraw-btn').off('click').on('click', function () {
            if (!activeWithdrawUuid) return;
            const btn = $(this);
            const originalText = btn.text();
            btn.prop('disabled', true).html('<span class="loading loading-spinner"></span> Processing...');

            $.ajax({
                url: apiUrl("appointments") + "delete-appointment.php",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify({ appointment_uuid: activeWithdrawUuid }),
                success: function (response) {
                    if (!response.success) {
                        alert(response.message);
                        return;
                    }
                    $('#withdraw-modal').addClass('hidden').removeClass('flex');
                    fetchAppointments(); // Refresh list
                },
                error: function () {
                    alert('Failed to delete appointment. Please try again.');
                },
                complete: function () {
                    btn.prop('disabled', false).text(originalText);
                    activeWithdrawUuid = null;
                }
            });
        });

        // Row Click Handler - open summary modal (exclude clicks on dropdown)
        $('body').on('click', '.appointment-row', function (e) {
            // Don't trigger if clicking inside the dropdown
            if ($(e.target).closest('.action-dropdown').length) {
                return;
            }

            const uuid = $(this).data('uuid');
            // Trigger the view summary button logic
            $(this).find('.view-summary-btn').trigger('click');
        });

        $('body').on('click', '.btn-edit', function (e) {
            e.stopPropagation();
            const uuid = $(this).data('uuid');
            const service = $(this).data('service');
            const patient = $(this).data('patient');
            window.location.href = `step-1-service.php?edit_uuid=${uuid}&service=${service}&patient_id=${patient}`;
        });
    });
</script>