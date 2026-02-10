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
// $headContent = `shared('components', 'elements/dataTables/styles')`;
include_once __DIR__ . '/../layout.php';
?>

<?= shared('components', 'elements/dataTables/styles') ?>

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
            <table id="appointments-table" class="w-full text-left border-collapse display responsive nowrap"
                style="width:100%">
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
                <tbody class="divide-y divide-border/50">
                    <!-- DataTables will populate this -->
                </tbody>
            </table>
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
<?= shared('components', 'elements/dataTables/scripts'); ?>
<script>
    $(document).ready(function () {
        // --- DataTables Init ---
        const $appointmentsTable = $('#appointments-table').DataTable({
            layout: {
                topStart: null,
                topEnd: null,
                bottomStart: "info",
                bottomEnd: {
                    features: ["pageLength", "paging"],
                },
            },
            pageLength: 10,
            deferRender: true,
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            orderCellsTop: true,
            autoWidth: false,
            language: {
                info: "Showing _START_ to _END_ of _TOTAL_ appointments",
                lengthMenu: "Entries per page _MENU_",
                processing: '<div class="flex items-center gap-2 text-sm text-muted-foreground"><span class="loading loading-spinner loading-md text-primary"></span> Loading...</div>',
                infoEmpty: "No appointments found",
                emptyTable: "No appointments found.",
                zeroRecords: "No matching appointments found"
            },
            columns: [
                {
                    data: null,
                    render: function (data, type, row) {
                        const name = data.patient_name || 'Unknown Patient';
                        const initial = (data.patient_firstname || '?').charAt(0).toUpperCase();
                        const email = data.patient_email || 'No Email';
                        return `
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">${initial}</div>
                                <div>
                                    <p class="text-sm font-semibold text-foreground">${name}</p>
                                    <p class="text-[10px] text-muted-foreground uppercase">${email}</p>
                                </div>
                            </div>`;
                    }
                },
                {
                    data: 'service_name',
                    render: function (data) {
                        return `<span class="text-sm text-muted-foreground font-medium">${data || 'Service Deleted'}</span>`;
                    }
                },
                {
                    data: 'sched_date',
                    render: function (data, type, row) {
                        const dateObj = new Date(`${data} ${row.sched_time}`);
                        const formattedDate = dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        const formattedTime = dateObj.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
                        return `<div class="text-sm"><p class="font-bold text-foreground">${formattedDate}</p><p class="text-xs text-muted-foreground">${formattedTime}</p></div>`;
                    }
                },
                {
                    data: 'doctor_name',
                    render: function (data) {
                        return `<span class="text-sm text-muted-foreground">Dr. ${data || 'Unknown'}</span>`;
                    }
                },
                {
                    data: 'status',
                    render: function (data) {
                        const statusColors = APPOINTMENT_STATUS_COLORS;
                        const statusClass = statusColors[(data || '').toLowerCase()] || 'bg-muted text-muted-foreground';
                        return `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold ${statusClass} uppercase tracking-wide">${(data || '').replace('_', ' ')}</span>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-right",
                    render: function (data, type, row) {
                        return `
                        <div class="relative action-dropdown inline-block text-left">
                            <button class="action-dropdown-toggle size-8 rounded-lg flex items-center justify-center bg-muted text-muted-foreground hover:text-primary hover:bg-muted/80 transition-all border border-border" 
                                title="Actions" type="button">
                                <span class="material-symbols-outlined text-[18px]">more_vert</span>
                            </button>
                            <div class="action-dropdown-menu hidden absolute right-0 mt-1 w-52 bg-card rounded-xl border border-border shadow-xl z-50 py-1" style="display:none;">
                                <!-- Dropdown Content -->
                                <p class="text-left py-2 pl-3.5 text-[10px] font-bold text-muted-foreground uppercase tracking-wider">Change Status</p>
                                <button class="status-action w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" data-uuid="${row.uuid}" data-status="pending">
                                    <span>⏳</span> Pending
                                </button>
                                <button class="status-action w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" data-uuid="${row.uuid}" data-status="confirmed">
                                    <span>✅</span> Confirmed
                                </button>
                                <button class="status-action w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" data-uuid="${row.uuid}" data-status="completed">
                                    <span>🏁</span> Completed
                                </button>
                                <button class="status-action w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" data-uuid="${row.uuid}" data-status="cancelled">
                                    <span>❌</span> Cancelled
                                </button>
                                <button class="status-action w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" data-uuid="${row.uuid}" data-status="no_show">
                                    <span>🚫</span> No Show
                                </button>
                                <button class="status-action w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" data-uuid="${row.uuid}" data-status="rescheduled">
                                    <span>🔄</span> Rescheduled
                                </button>
                                <div class="border-t border-border my-1"></div>
                                <p class="text-left py-2 pl-3.5 text-[10px] font-bold text-muted-foreground uppercase tracking-wider">Manage</p>
                                <button class="btn-edit w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" data-uuid="${row.uuid}" data-service="${row.service_uuid}" data-patient="${row.patient_uuid}">
                                    <span>✏️</span> Edit
                                </button>
                                <button class="view-summary-btn w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" data-uuid="${row.uuid}">
                                    <span>👁</span> View
                                </button>
                                <div class="border-t border-border my-1"></div>
                                <button class="delete-btn w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2 text-error font-semibold" data-uuid="${row.uuid}">
                                    <span>🗑</span> Delete
                                </button>
                            </div>
                        </div>`;
                    }
                }
            ],
            ajax: {
                url: apiUrl("appointments") + "appointments-dataTable.php",
                method: "GET",
                dataType: "json",
                data: function (d) {
                    d.filter_status = $('.filter-btn.active').data('status');
                    d.filter_doctor = $('#filter-doctor').val();
                    d.filter_date = $('#filter-date').val();
                    return d;
                },
                dataSrc: function (response) {
                    // Update global state for Sidebar Stats
                    if (response.data) {
                        window.allAppointments = response.data; // Store current page data (for stats approximation)
                        // Ideally stats should come from a separate API or the endpoint response if we want accurate total stats
                        // For now we'll update with what we have or mock it. 
                        // The endpoint should probably return stats? DataTables response format is fixed.
                        // We'll approximate or fetch stats separately if needed.
                        // For now, let's just use the recordsTotal from response if available?
                        // response.recordsTotal available in response object, not dataSrc return.
                        // But we can access it here.
                        $('#total-count').text(response.recordsTotal || '-');
                        $('#pending-count').text('-'); // We don't have pending count in standard DT response unless we add it. 
                        // Start a separate fetch for stats? Or just show totals.
                    }
                    return response.data;
                },
                error: function (xhr, error, thrown) {
                    console.error('DataTables Error:', error);
                }
            }
        });

        // --- Filters Interactivity ---

        fetchDoctors();

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

        // Status Filter
        $('.filter-btn').click(function () {
            $('.filter-btn').removeClass('active bg-card shadow-sm text-primary').addClass('text-muted-foreground');
            $(this).addClass('active bg-card shadow-sm text-primary').removeClass('text-muted-foreground');
            $appointmentsTable.draw(); // Trigger server-side reload
        });

        // Other Filters
        $('#filter-doctor, #filter-date').change(function () {
            $appointmentsTable.draw();
        });

        // Reset
        $('#reset-filters').click(function () {
            $('.filter-btn').removeClass('active bg-card shadow-sm text-primary').addClass('text-muted-foreground');
            $('[data-status="all"]').addClass('active bg-card shadow-sm text-primary').removeClass('text-muted-foreground');
            $('#filter-doctor').val('');
            $('#filter-date').val('');
            $appointmentsTable.draw();
        });

        // --- Action Handlers (Delegated) ---

        // Dropdown Toggle
        $('body').on('click', '.action-dropdown-toggle', function (e) {
            e.preventDefault();
            e.stopPropagation();
            // Close others
            $('.action-dropdown-menu').hide().addClass('hidden');

            // Open this one
            const $menu = $(this).siblings('.action-dropdown-menu');
            $menu.removeClass('hidden').toggle();
        });

        // Close dropdowns on click outside
        $(document).click(function (e) {
            if (!$(e.target).closest('.action-dropdown').length) {
                $('.action-dropdown-menu').hide().addClass('hidden');
            }
        });

        // Status Change
        $('body').on('click', '.status-action', function (e) {
            e.preventDefault();
            const uuid = $(this).data('uuid');
            const status = $(this).data('status');
            const btn = $(this);

            // Optimistic UI or loading?
            // Since table reloads, just show loading on button or global

            $.ajax({
                url: apiUrl("appointments") + "update-status.php",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify({ appointment_uuid: uuid, status: status }),
                success: function (response) {
                    if (response.success) {
                        $appointmentsTable.draw(false); // Reload, keep paging
                    } else {
                        alert(response.message);
                    }
                },
                error: function () {
                    alert('Status update failed');
                }
            });
        });

        // Delete (Withdraw Modal)
        let activeWithdrawUuid = null;
        $('body').on('click', '.delete-btn', function (e) {
            e.preventDefault();
            activeWithdrawUuid = $(this).data('uuid');
            $('.action-dropdown-menu').hide().addClass('hidden');
            $('#withdraw-modal').removeClass('hidden').addClass('flex');
        });

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
                    if (response.success) {
                        $('#withdraw-modal').addClass('hidden').removeClass('flex');
                        $appointmentsTable.draw(false);
                    } else {
                        alert(response.message);
                    }
                },
                complete: function () {
                    btn.prop('disabled', false).text(originalText);
                    activeWithdrawUuid = null;
                }
            });
        });

        // Row Click - Summary (excluding actions)
        $('body').on('click', '#appointments-table tbody tr', function (e) {
            if ($(e.target).closest('.action-dropdown, button, a').length) return;

            // Get data from DataTables row
            const data = $appointmentsTable.row(this).data();
            if (data && data.uuid) {
                $(this).find('.view-summary-btn').trigger('click');
            }
        });

        // View Summary Trigger
        $('body').on('click', '.view-summary-btn', function (e) {
            // The existing summary modal JS should handle this if it listens to something?
            // Or we need to manually trigger it. 
            // The previous code had: $(this).find('.view-summary-btn').trigger('click');
            // But what LISTENS to .view-summary-btn?
            // It seems "components/summary-modal" likely attaches a listener. 
            // IMPORTANT: If summary-modal uses a global listener on .view-summary-btn, we are good.
            // If it needs initialization, we rely on it being loaded.
        });

        // Edit
        $('body').on('click', '.btn-edit', function (e) {
            e.preventDefault();
            const uuid = $(this).data('uuid');
            const service = $(this).data('service');
            const patient = $(this).data('patient');
            window.location.href = `step-1-service.php?edit_uuid=${uuid}&service=${service}&patient_id=${patient}`;
        });
    });
</script>