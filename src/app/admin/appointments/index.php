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

<?php
// Define Filter Configuration
$filterConfig = [
    'primary' => [
        'name' => 'status',
        'label' => 'Status:',
        'options' => [
            ['value' => '', 'label' => 'All', 'count_id' => 'count-all'],
            ['value' => 'pending', 'label' => 'Pending', 'count_id' => 'count-pending'],
            ['value' => 'confirmed', 'label' => 'Upcoming', 'count_id' => 'count-confirmed'],
            ['value' => 'completed', 'label' => 'Completed', 'count_id' => 'count-completed'],
            ['value' => 'cancelled', 'label' => 'Cancelled', 'count_id' => 'count-cancelled']
        ]
    ],
    'secondary_filters' => [
        [
            'type' => 'select',
            'name' => 'service',
            'icon' => 'medical_services',
            'placeholder' => 'All Services',
            'options' => [] // Populated by JS
        ],
        [
            'type' => 'select',
            'name' => 'doctor',
            'icon' => 'person',
            'placeholder' => 'All Providers',
            'options' => [] // Populated by JS
        ],
        [
            'type' => 'date',
            'name' => 'date',
            'icon' => 'calendar_month'
        ]
    ],
    'actions' => [
        [
            'label' => 'Reset Filters',
            'icon' => 'filter_list_off',
            'id' => 'reset-filters',
            'class' => 'text-primary hover:opacity-80'
        ]
    ]
];

// Filter Sub-header 
shared('components', 'layout/filterbar', $filterConfig);
?>

<!-- Main Grid Layout -->
<div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
    <!-- Appointments Table Section -->
    <div class="xl:col-span-3">
        <div class="bg-card rounded-xl border border-border shadow-sm">
            <table id="appointments-table" class="w-full text-left border-collapse display responsive nowrap"
                style="width:100%">
                <thead>
                    <tr class="bg-muted/50 text-muted-foreground uppercase text-[11px] font-bold tracking-wider">
                        <th class="!p-5">Patient</th>
                        <th class="!p-5">Service</th>
                        <th class="!p-5">Schedule</th>
                        <th class="!p-5">Provider</th>
                        <th class="!p-5">Status</th>
                        <th class="!p-5 text-right">Actions</th>
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
        // Global array to store all appointments and use it in other components (e.g., summary-modal, reschedule-modal)
        window.allAppointments = [];

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
                // processing: '<div class="flex items-center gap-2 text-sm text-muted-foreground"><span class="loading loading-spinner loading-md text-primary"></span> Loading...</div>',
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
                                <button class="btn-edit w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" 
                                    data-uuid="${row.uuid}" 
                                    data-service="${row.service_uuid}" 
                                    data-patient="${row.patient_uuid}" 
                                    data-doctor="${row.doctor_uuid}" 
                                    data-notes="${row.notes}"
                                    data-date="${row.sched_date}"
                                    data-time="${row.sched_time}">
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
                    const statusBtn = $('.filter-primary-btn.bg-card[data-group="status"]');
                    d.filter_status = statusBtn.length ? statusBtn.data('value') : '';

                    d.filter_doctor = $('#doctor-filter').val();

                    d.filter_service = $('#service-filter').val();

                    d.filter_date = $('#date-filter').val();
                    return d;
                },
                dataSrc: function (response) {
                    // Update Status Counts
                    if (response.counts) {
                        // All count (sum of all statuses)
                        let total = 0;
                        for (const status in response.counts) {
                            total += parseInt(response.counts[status]);
                            const countId = `count-${status}`;
                            $(`#${countId}`).text(response.counts[status]);
                        }
                        $('#count-all').text(total);
                    }

                    // Update Sidebar Stats
                    if (response.data) {
                        $('#total-count').text(response.recordsTotal || '-');
                        // Pending count from the counts object if available
                        if (response.counts && response.counts.pending !== undefined) {
                            $('#pending-count').text(response.counts.pending);
                        }
                    }

                    window.allAppointments = response.data;
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
                        const select = $('#doctor-filter');
                        response.data.forEach(function (doc) {
                            select.append(`<option value="${doc.uuid}">Dr. ${doc.firstname} ${doc.lastname}</option>`);
                        });
                    }
                }
            });
        }

        // Also fetch services
        fetchServices();
        function fetchServices() {
            $.ajax({
                url: apiUrl("shared") + "services.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        const select = $('#service-filter');
                        response.data.forEach(function (svc) {
                            select.append(`<option value="${svc.uuid}">${svc.name}</option>`);
                        });
                    }
                }
            });
        }

        // --- Global Search Integration ---
        let searchTimeout = null;
        $('#global-search-input').on('keyup', function () {
            const val = $(this).val();
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function () {
                $appointmentsTable.search(val).draw();
            }, 300);
        });

        // --- Filters Interactivity ---

        // Listen for changes from the FilterBar component
        $(document).on('filter:change', function (e, filters) {
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

        // Edit
        $('body').on('click', '.btn-edit', function (e) {
            e.preventDefault();
            const uuid = $(this).data('uuid');
            const service = $(this).data('service');
            const patient = $(this).data('patient');
            const doctor = $(this).data('doctor');
            const notes = $(this).data('notes');
            const date = $(this).data('date');
            const time = $(this).data('time');

            window.location.href = `step-1-service.php?edit_uuid=${encodeURIComponent(uuid)}&service=${encodeURIComponent(service)}&patient_uuid=${encodeURIComponent(patient)}&doctor_uuid=${encodeURIComponent(doctor)}&notes=${encodeURIComponent(notes)}&date=${encodeURIComponent(date)}&time=${encodeURIComponent(time)}`;
        });
    });
</script>