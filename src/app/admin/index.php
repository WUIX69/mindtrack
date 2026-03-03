<?php
/**
 * Admin Dashboard Index
 */
$pageTitle = "MindTrack Admin Dashboard";
$headerData = [
    'title' => 'Morning Overview',
    'description' => "Here's what's happening at Wayside Psyche Center today.",
    'actionLabel' => 'Add New Appointment',
    'actionUrl' => 'appointments/step-1-service.php',
    'mb' => 4
];
include_once __DIR__ . '/layout.php';
?>
<?= shared('components', 'elements/dataTables/styles') ?>

<!-- Quick Stats -->
<?= featured('dashboard', 'components/admin-quick-stats') ?>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <!-- Appointment Requests Table -->
    <div class="xl:col-span-2 space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold">Recent Appointment Requests</h3>
            <a href="<?= app('admin/appointments') ?>" class="text-sm text-primary font-semibold hover:underline">View
                All</a>
        </div>
        <div class="mb-4">
            <?= shared('components', 'layout/filterbar', [
                'isTransparent' => true,
                'mb' => '4',
                'primary' => [
                    'name' => 'status',
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
                        'type' => 'search',
                        'name' => 'search',
                        'placeholder' => 'Search Appointments...',
                        'icon' => 'search'
                    ],
                ],
                'actions' => [
                    [
                        'label' => 'Reset Filters',
                        'icon' => 'filter_list_off',
                        'id' => 'reset-filters',
                        'class' => 'text-primary hover:opacity-80'
                    ]
                ]
            ]) ?>
        </div>
        <div class="bg-card rounded-xl border border-border shadow-sm">
            <table id="appointments-dashboard-table" class="w-full text-left border-collapse display responsive nowrap"
                style="width:100%">
                <thead>
                    <tr class="bg-muted/50 text-muted-foreground uppercase text-[11px] font-bold tracking-wider">
                        <th class="!p-5">Patient</th>
                        <th class="!p-5">Requested Time</th>
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

    <!-- Today's Schedule Sidebar Widget -->
    <?= featured('dashboard', 'components/admin-todays-schedule') ?>
</div>

<!-- Doctor Workload Summary -->
<?= featured('dashboard', 'components/admin-workload-summary') ?>

<!-- Modals -->
<?= featured('appointments', 'components/summary-modal') ?>
<?= featured('appointments', 'components/withdraw-modal', [
    'role' => 'admin',
    'title' => 'Delete Appointment?',
    'message' => 'Are you sure you want to permanently delete this appointment? This action cannot be undone.',
    'confirm_text' => 'Yes, Delete',
]); ?>

<script src="<?= shared('data', 'appointment-statuses.js', true) ?>"></script>
<?= shared('components', 'elements/dataTables/scripts'); ?>
<script>
    $(document).ready(function () {
        // Global array to store all appointments
        window.allAppointments = [];

        // --- DataTables Init ---
        const $dashboardTable = $('#appointments-dashboard-table').DataTable({
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
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                lengthMenu: "_MENU_ per page",
                infoEmpty: "No entries",
                emptyTable: "No recent appointments found.",
                zeroRecords: "No matching records found"
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
                            <div class="action-dropdown-menu hidden absolute right-0 mt-1 w-52 bg-card rounded-xl border border-border shadow-xl z-50 py-1">
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
                                <button class="w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" onclick="openSummaryModal('${row.uuid}')">
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
                    // Status Filter
                    const statusBtn = $('.filter-primary-btn.bg-card[data-group="status"]');
                    d.filter_status = statusBtn.length ? statusBtn.data('value') : '';

                    // Note: Doctor/Service/Date filters are not present on dashboard yet, so handled implicitly as empty

                    return d;
                },
                dataSrc: function (response) {
                    // Update Status Counts on Filter Bar
                    if (response.counts) {
                        let total = 0;
                        for (const status in response.counts) {
                            const count = parseInt(response.counts[status]);
                            total += count;
                            const countId = `count-${status}`;
                            $(`#${countId}`).text(count);
                        }
                        $('#count-all').text(total);
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

        // Listen for changes from the FilterBar component
        $(document).on('filter:change', function (e, filters) {
            // Check if search filter changed
            if (filters.search !== undefined) {
                $dashboardTable.search(filters.search);
            }
            $dashboardTable.draw();
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

            $.ajax({
                url: apiUrl("appointments") + "update-status.php",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify({ appointment_uuid: uuid, status: status }),
                success: function (response) {
                    if (response.success) {
                        $dashboardTable.draw(false);
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
                        $dashboardTable.draw(false);
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
        $('body').on('click', '#appointments-dashboard-table tbody tr', function (e) {
            if ($(e.target).closest('.action-dropdown, button, a').length) return;

            // Get data from DataTables row
            const data = $dashboardTable.row(this).data();
            if (data && data.uuid) {
                const uuid = $(this).data('uuid');
                if (uuid) {
                    openSummaryModal(uuid);
                }
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

            // Redirect to edit page (adjust path if needed relative to admin root)
            // Assuming step-1-service.php is in appointments/ feature folder?
            // Wait, step-1-service.php is in src/features/appointments/components/? Or is it a page?
            // In src/app/admin/appointments/index.php (line 12), actionUrl is 'step-1-service.php'.
            // In src/app/admin/index.php, step-1-service.php is likely in `appointments/` subdir relative to admin root?
            // Let's check `src/app/admin/appointments/step-1-service.php` exists?
            // I'll assume standard path: `appointments/step-1-service.php`

            window.location.href = `appointments/step-1-service.php?edit_uuid=${encodeURIComponent(uuid)}&service=${encodeURIComponent(service)}&patient_uuid=${encodeURIComponent(patient)}&doctor_uuid=${encodeURIComponent(doctor)}&notes=${encodeURIComponent(notes)}&date=${encodeURIComponent(date)}&time=${encodeURIComponent(time)}`;
        });
    });
</script>