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
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total Patients -->
    <div class="bg-card p-6 rounded-2xl border border-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div
                class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-primary-foreground transition-all">
                <span class="material-symbols-outlined text-2xl">group</span>
            </div>
            <span
                class="flex items-center gap-1 text-xs font-bold text-green-500 bg-green-500/10 px-2 py-1 rounded-full text-nowrap">
                <span class="material-symbols-outlined text-sm">trending_up</span>
                12.5%
            </span>
        </div>
        <h3 class="text-muted-foreground text-sm font-medium">Total Online Support</h3>
        <p class="text-3xl font-black mt-1 text-foreground">1,284</p>
    </div>

    <!-- Active Doctors -->
    <div class="bg-card p-6 rounded-2xl border border-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div
                class="size-12 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 group-hover:bg-orange-500 group-hover:text-primary-foreground transition-all">
                <span class="material-symbols-outlined text-2xl">schedule</span>
            </div>
            <span
                class="flex items-center gap-1 text-xs font-bold text-orange-500 bg-orange-500/10 px-2 py-1 rounded-full text-nowrap">
                12 New
            </span>
        </div>
        <h3 class="text-muted-foreground text-sm font-medium">Pending Requests</h3>
        <p class="text-3xl font-black mt-1 text-foreground">12</p>
    </div>

    <!-- Appointments Today -->
    <div class="bg-card p-6 rounded-2xl border border-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div
                class="size-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-primary-foreground transition-all">
                <span class="material-symbols-outlined text-2xl">medical_services</span>
            </div>
            <span
                class="flex items-center gap-1 text-xs font-bold text-blue-500 bg-blue-500/10 px-2 py-1 rounded-full text-nowrap">
                Stable
            </span>
        </div>
        <h3 class="text-muted-foreground text-sm font-medium">Active Providers</h3>
        <p class="text-3xl font-black mt-1 text-foreground">24</p>
    </div>

    <!-- Revenue -->
    <div class="bg-card p-6 rounded-2xl border border-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div
                class="size-12 rounded-xl bg-green-500/10 flex items-center justify-center text-green-500 group-hover:bg-green-500 group-hover:text-primary-foreground transition-all">
                <span class="material-symbols-outlined text-2xl">forum</span>
            </div>
            <span
                class="flex items-center gap-1 text-xs font-bold text-green-500 bg-green-500/10 px-2 py-1 rounded-full text-nowrap">
                <span class="material-symbols-outlined text-sm">trending_up</span>
                8%
            </span>
        </div>
        <h3 class="text-muted-foreground text-sm font-medium">Monthly Stats</h3>
        <p class="text-3xl font-black mt-1 text-foreground">450</p>
    </div>
</div>

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
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold">Today's Schedule</h3>
            <button class="p-1.5 rounded-lg border border-border hover:bg-muted transition-all">
                <span class="material-symbols-outlined text-[18px]">calendar_today</span>
            </button>
        </div>
        <div class="bg-card rounded-xl border border-border p-5 shadow-sm">
            <div
                class="relative space-y-6 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-muted">
                <div class="relative pl-8 group">
                    <div
                        class="absolute left-0 top-1 size-[22px] rounded-full bg-card border-2 border-primary ring-4 ring-primary/5 z-10">
                    </div>
                    <div class="flex flex-col">
                        <span
                            class="text-[10px] font-bold text-primary uppercase tracking-widest leading-none mb-1">08:30
                            AM - Confirmed</span>
                        <h4 class="text-sm font-bold text-foreground">Initial Assessment</h4>
                        <p class="text-xs text-muted-foreground mt-0.5">Patient: Arthur Morgan</p>
                        <div class="mt-2 flex items-center gap-1.5 text-[10px] text-muted-foreground">
                            <span class="material-symbols-outlined text-[14px]">person</span> Dr. Aris Thorne
                        </div>
                    </div>
                </div>
                <div class="relative pl-8 group">
                    <div class="absolute left-0 top-1 size-[22px] rounded-full bg-card border-2 border-border z-10">
                    </div>
                    <div class="flex flex-col">
                        <span
                            class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest leading-none mb-1">10:00
                            AM - Confirmed</span>
                        <h4 class="text-sm font-bold text-foreground">CBT Therapy</h4>
                        <p class="text-xs text-muted-foreground mt-0.5">Patient: Sadie Adler</p>
                        <div class="mt-2 flex items-center gap-1.5 text-[10px] text-muted-foreground">
                            <span class="material-symbols-outlined text-[14px]">person</span> Dr. Helena Smith
                        </div>
                    </div>
                </div>
                <div class="relative pl-8 group">
                    <div class="absolute left-0 top-1 size-[22px] rounded-full bg-card border-2 border-orange-500 z-10">
                    </div>
                    <div class="flex flex-col">
                        <span
                            class="text-[10px] font-bold text-orange-500 uppercase tracking-widest leading-none mb-1">02:00
                            PM - Next Session</span>
                        <h4 class="text-sm font-bold text-foreground">Crisis Intervention</h4>
                        <p class="text-xs text-muted-foreground mt-0.5">Patient: Javier Escuella</p>
                        <div class="mt-2 flex items-center gap-1.5 text-[10px] text-muted-foreground">
                            <span class="material-symbols-outlined text-[14px]">person</span> Dr. Aris Thorne
                        </div>
                    </div>
                </div>
            </div>
            <button
                class="w-full mt-6 py-2.5 bg-muted text-muted-foreground text-xs font-bold rounded-lg hover:bg-muted/80 transition-all uppercase tracking-wider">
                VIEW FULL CALENDAR
            </button>
        </div>
    </div>
</div>

<!-- Doctor Workload Summary -->
<section class="bg-card rounded-xl border border-border p-6 shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-foreground">Provider Capacity Overview</h3>
        <div class="flex gap-2">
            <span class="flex items-center gap-1.5 text-xs font-medium text-muted-foreground">
                <span class="size-2 rounded-full bg-primary"></span> High
            </span>
            <span class="flex items-center gap-1.5 text-xs font-medium text-muted-foreground">
                <span class="size-2 rounded-full bg-primary/30"></span> Low
            </span>
        </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="space-y-3">
            <div class="flex justify-between text-xs font-bold uppercase tracking-wide">
                <span class="text-muted-foreground">Dr. Aris Thorne</span>
                <span class="text-primary">85%</span>
            </div>
            <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                <div class="h-full bg-primary rounded-full w-[85%]"></div>
            </div>
        </div>
        <div class="space-y-3">
            <div class="flex justify-between text-xs font-bold uppercase tracking-wide">
                <span class="text-muted-foreground">Dr. Helena Smith</span>
                <span class="text-primary">62%</span>
            </div>
            <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                <div class="h-full bg-primary rounded-full w-[62%]"></div>
            </div>
        </div>
        <div class="space-y-3">
            <div class="flex justify-between text-xs font-bold uppercase tracking-wide">
                <span class="text-muted-foreground">Dr. James Taylor</span>
                <span class="text-primary">45%</span>
            </div>
            <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                <div class="h-full bg-primary rounded-full w-[45%]"></div>
            </div>
        </div>
        <div class="space-y-3">
            <div class="flex justify-between text-xs font-bold uppercase tracking-wide">
                <span class="text-muted-foreground">Dr. Sarah Connor</span>
                <span class="text-red-600">92%</span>
            </div>
            <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                <div class="h-full bg-red-600 rounded-full w-[92%]"></div>
            </div>
        </div>
    </div>
</section>
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