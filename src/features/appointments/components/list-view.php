<?php
// Define Filter Configuration
$filterConfig = [
    'isTransparent' => true,
    'primary' => [
        'name' => 'status',
        // 'label' => 'Status:',
        'options' => [
            ['value' => '', 'label' => 'All', 'count_id' => 'count-all'],
            ['value' => 'pending', 'label' => 'Pending', 'count_id' => 'count-pending'],
            ['value' => 'confirmed', 'label' => 'Confirmed', 'count_id' => 'count-confirmed'],
            ['value' => 'completed', 'label' => 'Completed', 'count_id' => 'count-completed'],
            ['value' => 'cancelled', 'label' => 'Cancelled', 'count_id' => 'count-cancelled']
        ]
    ],
    'secondary_filters' => [
        [
            'type' => 'search',
            'name' => 'search', // This matches input name
            'placeholder' => 'Search Appointments...',
            'icon' => 'search'
        ],
        [
            'type' => 'select',
            'name' => 'sort',
            'icon' => 'sort',
            'placeholder' => 'Sort By',
            'options' => [
                'newest' => 'Newest First',
                'oldest' => 'Oldest First',
                'name_asc' => 'Name (A-Z)',
                'name_desc' => 'Name (Z-A)'
            ]
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

// Include Filterbar
shared('components', 'layout/filterbar', $filterConfig);
?>

<!-- Schedule List Table -->
<div class="bg-card w-full rounded-2xl border border-border mt-6">
    <div class="p-0">
        <table id="schedule-list-table" class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">Patient</th>
                    <th class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">Service</th>
                    <th class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">Date & Time
                    </th>
                    <th class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">Duration</th>
                    <th class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider text-right">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                <!-- DataTables will populate this -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modals -->

<?= featured('appointments', 'components/reschedule-modal') ?>

<script>
    $(document).ready(function () {
        // --- Constants & Config ---
        const TABLE_ID = '#schedule-list-table';
        const API_ENDPOINT = apiUrl('appointments') + '/list-view-dataTable.php';

        // Initialize global array (safely)
        window.allAppointments = window.allAppointments || [];

        // --- Helper: Format Date ---
        function formatDateTime(dateString, timeString) {
            const date = new Date(dateString + ' ' + timeString);
            return {
                date: date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }),
                time: date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })
            };
        }

        // --- DataTable Initialization ---
        const table = $(TABLE_ID).DataTable({
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
                lengthMenu: "Entries per page _MENU_",
                infoEmpty: "No entries",
                emptyTable: `
                    <div class="flex flex-col items-center justify-center py-8 text-center text-muted-foreground">
                        <span class="material-symbols-outlined text-4xl mb-2 opacity-50">event_busy</span>
                        <p class="text-sm">No scheduled sessions found.</p>
                    </div>
                `,
                zeroRecords: "No matching records found"
            },
            ajax: {
                url: API_ENDPOINT,
                data: function (d) {
                    // Inject Active Filters
                    const filters = getActiveFilters();
                    Object.assign(d, filters);
                },
                dataSrc: function (response) {
                    // Populate global appointments for modals (merge)
                    if (response.data) {
                        window.allAppointments = window.allAppointments || [];
                        const newData = response.data;
                        newData.forEach(item => {
                            const idx = window.allAppointments.findIndex(x => String(x.uuid) === String(item.uuid));
                            if (idx > -1) {
                                window.allAppointments[idx] = item;
                            } else {
                                window.allAppointments.push(item);
                            }
                        });
                    }
                    return response.data;
                }
            },
            columns: [
                {
                    data: 'patient_name',
                    render: function (data, type, row) {
                        const initials = data ? data.charAt(0).toUpperCase() : '?';
                        // Assuming patient_avatar might be available or we defaults
                        const avatarHtml = row.patient_avatar
                            ? `<img src="${row.patient_avatar}" class="w-8 h-8 rounded-full object-cover">`
                            : `<div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-bold">${initials}</div>`;

                        return `
                            <div class="flex items-center gap-3">
                                ${avatarHtml}
                                <div>
                                    <div class="text-sm font-semibold text-foreground">${data}</div>
                                    <div class="text-xs text-muted-foreground">#${row.patient_id || 'ID'}</div>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'service_name',
                    render: function (data) {
                        return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-background border border-border text-foreground">${data}</span>`;
                    }
                },
                {
                    data: 'date',
                    render: function (data, type, row) {
                        const dt = formatDateTime(data, row.time_start);
                        return `
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold text-foreground">${dt.date}</span>
                                <span class="text-xs text-muted-foreground">${dt.time}</span>
                            </div>
                        `;
                    }
                },
                {
                    data: 'duration',
                    render: function (data) {
                        return `<span class="text-sm text-foreground">${data} mins</span>`;
                    }
                },
                {
                    data: 'status',
                    render: function (data) {
                        const colorClass = APPOINTMENT_STATUS_COLORS[data] || 'bg-gray-100 text-gray-800';
                        const label = data.charAt(0).toUpperCase() + data.slice(1);
                        return `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${colorClass}">${label}</span>`;
                    }
                },
                {
                    data: null,
                    className: 'text-right',
                    orderable: false,
                    render: function (data, type, row) {
                        const uuid = row.uuid || row.id; // Fallback if id is used

                        // Start Session Button
                        let startBtn = '';
                        if (row.status === 'confirmed' || row.status === 'rescheduled') {
                            startBtn = `
                                <button class="btn-start-session flex items-center gap-1 px-3 py-1.5 bg-primary text-primary-foreground text-xs font-bold rounded-lg hover:bg-primary/90 transition-colors shadow-sm" 
                                    onclick="window.location.href='<?= app('doctor/notes.php') ?>?appointment_uuid=${uuid}'" title="Start Session">
                                    <span class="material-symbols-outlined text-[16px]">videocam</span>
                                    <span>Start</span>
                                </button>
                            `;
                        }

                        // Burger Menu Actions
                        // Exclude delete, exclude step-by-step edit
                        // Include View, Reschedule, Status Changes

                        let rescheduleAction = '';
                        if (['pending', 'confirmed', 'rescheduled'].includes(row.status)) {
                            rescheduleAction = `
                                <button class="reschedule-btn w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" 
                                    data-uuid="${uuid}">
                                    <span>🔄</span> Reschedule
                                </button>
                            `;
                        }

                        // Status Change Actions
                        let statusActions = '';
                        const statuses = [
                            { value: 'pending', label: 'Pending', icon: 'hourglass_empty', color: 'text-amber-600' },
                            { value: 'completed', label: 'Completed', icon: 'done_all', color: 'text-blue-600' },
                            { value: 'confirmed', label: 'Confirm', icon: 'check_circle', color: 'text-green-600' },
                            { value: 'cancelled', label: 'Cancel', icon: 'cancel', color: 'text-red-600' },
                            { value: 'no_show', label: 'No Show', icon: 'visibility_off', color: 'text-gray-600' }
                        ];

                        statuses.forEach(status => {
                            // Always show all status options
                            statusActions += `
                                <button class="w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2 ${status.color}" 
                                    onclick="window.updateStatus('${uuid}', '${status.value}')">
                                    <span class="material-symbols-outlined text-[16px]">${status.icon}</span> ${status.label}
                                </button>
                            `;
                        });

                        return `
                        <div class="flex items-center justify-end gap-2">
                            ${startBtn}
                            <div class="relative action-dropdown inline-block text-left">
                                <button class="action-dropdown-toggle size-8 rounded-lg flex items-center justify-center bg-muted text-muted-foreground hover:text-primary hover:bg-muted/80 transition-all border border-border" 
                                    title="Actions" type="button">
                                    <span class="material-symbols-outlined text-[18px]">more_vert</span>
                                </button>
                                <div class="action-dropdown-menu hidden absolute right-0 mt-1 w-48 bg-card rounded-xl border border-border shadow-xl z-50 py-1" style="display:none;">
                                    <p class="text-left py-2 pl-3.5 text-[10px] font-bold text-muted-foreground uppercase tracking-wider">Status</p>
                                    ${statusActions}
                                    
                                    <div class="h-px bg-border my-1"></div>
                                    
                                    <p class="text-left py-2 pl-3.5 text-[10px] font-bold text-muted-foreground uppercase tracking-wider">Manage</p>
                                    <button class="w-full text-left px-3 py-2 text-sm hover:bg-muted/50 transition-colors flex items-center gap-2" onclick="openSummaryModal('${uuid}')">
                                        <span>👁</span> View
                                    </button>
                                    ${rescheduleAction}
                                </div>
                            </div>
                        </div>`;
                    }
                }
            ],
            drawCallback: function (settings) {
                const response = settings.json; // Access the JSON response
                if (response && response.counts) {
                    // Update All Count
                    $('#count-all').text(response.counts.all || 0);

                    // Update Status Counts
                    const statuses = ['pending', 'confirmed', 'completed', 'cancelled'];
                    statuses.forEach(status => {
                        $(`#count-${status}`).text(response.counts[status] || 0);
                    });
                }
            },
            createdRow: function (row, data, dataIndex) {
                // Add cursor-pointer and data-uuid for row click
                $(row).addClass('cursor-pointer hover:bg-muted/50 transition-colors');
                $(row).attr('data-uuid', data.uuid || data.id);
            }
        });

        // --- Row Click Handler (Open Summary) ---
        $(TABLE_ID + ' tbody').on('click', 'tr', function (e) {
            // Prevent if clicking on the Actions column (last column) or any interactive element
            if ($(e.target).closest('td:last-child').length || $(e.target).closest('button, a, input, select').length) {
                return;
            }

            const uuid = $(this).data('uuid');
            if (uuid) {
                openSummaryModal(uuid);
            }
        });

        // --- Filter Integration ---
        $(document).on('filter:change', function (e, filters) {
            console.log("Filters changed:", filters);

            // Handle Status (Column 5 index 4)
            if (filters.status !== undefined) {
                // Correctly target the Status column (index 4)
                table.column(4).search(filters.status);
            }

            // Handle Search
            if (filters.search !== undefined) {
                table.search(filters.search);
            }

            // Handle Sort
            if (filters.sort) {
                switch (filters.sort) {
                    case 'newest':
                        table.order([6, 'desc']); // Date column
                        break;
                    case 'oldest':
                        table.order([6, 'asc']);
                        break;
                    case 'name_asc':
                        table.order([0, 'asc']); // Patient Name column
                        break; // Added break
                    case 'name_desc':
                        table.order([0, 'desc']);
                        break;
                }
            }
            table.draw();
        });

        $(document).on('click', '#reset-filters', function () {
            // Trigger Reset on Filterbar (which emits filter:change)
            $('.filter-tab[data-value=""]').click();
            $('input[name="search"]').val('');
            $('input[name="date"]').val('');
            table.draw();
        });

        // --- Dropdown Handlers ---
        $('body').on('click', '.action-dropdown-toggle', function (e) {
            e.preventDefault();
            e.stopPropagation();
            // Close others
            $('.action-dropdown-menu').hide().addClass('hidden');

            // Open this one
            const $menu = $(this).siblings('.action-dropdown-menu');
            // Toggle
            if ($menu.is(':visible')) {
                $menu.hide().addClass('hidden');
            } else {
                $menu.show().removeClass('hidden');
            }
        });

        // Close dropdowns on click outside
        $(document).click(function (e) {
            if (!$(e.target).closest('.action-dropdown').length) {
                $('.action-dropdown-menu').hide().addClass('hidden');
            }
        });

        // --- Status Update Handler ---
        window.updateStatus = function (uuid, status) {
            if (!confirm(`Are you sure you want to mark this appointment as ${status}?`)) return;

            $.ajax({
                url: apiUrl('appointments') + '/schedules.php?action=update_status',
                method: 'POST',
                data: JSON.stringify({ uuid: uuid, status: status }),
                contentType: 'application/json',
                success: function (response) {
                    const res = typeof response === 'string' ? JSON.parse(response) : response;
                    if (res.success) {
                        // alert('Status updated successfully');
                        table.ajax.reload(null, false); // Reload table without resetting paging
                    } else {
                        alert('Failed to update status: ' + res.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Update status error:', error);
                    alert('An error occurred while updating status.');
                }
            });
        };
    });

    function getActiveFilters() {
        return {
            status: $('.filter-tab.active').data('value') || '',
            // search is handled by table.search() and native DataTables params
            date: $('input[name="date"]').val()
        };
    }
</script>