<?= shared('components', 'elements/dataTables/styles') ?>
<!-- Appointment History Table -->
<div class="lg:col-span-2">
    <div class="py-5 pr-2 flex items-center justify-between">
        <h3 class="font-bold text-lg">Recent Appointment History</h3>
        <a class="text-primary text-sm font-bold hover:underline" href="<?= app('patient/appointments/') ?>">View
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
    <div class="bg-card rounded-xl border border-border overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table id="appointment-history-table" class="w-full text-left display responsive nowrap" style="width:100%">
                <thead>
                    <tr class="text-xs uppercase tracking-wider text-muted-foreground bg-muted/50">
                        <th class="px-6 py-3 font-semibold !p-5">Date</th>
                        <th class="px-6 py-3 font-semibold !p-5">Service</th>
                        <th class="px-6 py-3 font-semibold !p-5">Provider</th>
                        <th class="px-6 py-3 font-semibold !p-5">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/50">
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= shared('components', 'elements/dataTables/scripts') ?>
<script>
    $(document).ready(function () {
        // Initialize global array if not already present
        window.allAppointments = window.allAppointments || [];

        const table = $('#appointment-history-table').DataTable({
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
            order: [[0, 'desc']], // Default sort by Date
            orderCellsTop: true,
            autoWidth: false,
            language: {
                info: "Showing _START_ to _END_ of _TOTAL_ appointments",
                lengthMenu: "Entries per page _MENU_",
                infoEmpty: "No appointments found",
                emptyTable: "No appointments found.",
                zeroRecords: "No matching appointments found"
            },
            columns: [
                {
                    data: 'sched_date',
                    className: "px-6 py-4",
                    render: function (data, type, row) {
                        const dateObj = new Date(`${data} ${row.sched_time}`);
                        const formattedDate = dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        const formattedTime = row.sched_time;
                        return `
                            <p class="text-sm font-bold">${formattedDate}</p>
                            <p class="text-xs text-muted-foreground">${formattedTime}</p>
                        `;
                    }
                },
                {
                    data: 'service_name',
                    className: "px-6 py-4",
                    render: function (data) {
                        return `<span class="text-sm">${data || 'Service Deleted'}</span>`;
                    }
                },
                {
                    data: 'doctor_name',
                    className: "px-6 py-4",
                    orderable: false,
                    render: function (data, type, row) {
                        const doctorFullName = 'Dr. ' + (row.doctor_firstname || 'Unknown');
                        return `
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-muted border border-border overflow-hidden shrink-0">
                                <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(doctorFullName)}&background=random" class="size-full object-cover" />
                            </div>
                            <span class="text-sm font-medium whitespace-nowrap">${doctorFullName}</span>
                        </div>`;
                    }
                },
                {
                    data: 'status',
                    className: "px-6 py-4",
                    render: function (data) {
                        const statusColors = typeof APPOINTMENT_STATUS_COLORS !== 'undefined' ? APPOINTMENT_STATUS_COLORS : {};
                        let statusClass = statusColors[(data || '').toLowerCase()] || 'bg-muted text-muted-foreground';
                        let statusLabel = (data || '').charAt(0).toUpperCase() + (data || '').slice(1).replace('_', ' ');

                        if (data === 'confirmed') {
                            statusClass = 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400';
                            statusLabel = 'Approved';
                        } else if (data === 'pending') {
                            statusClass = 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400';
                            statusLabel = 'Pending';
                        } else if (data === 'completed') {
                            statusClass = 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400';
                        }

                        return `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide ${statusClass}">${statusLabel}</span>`;
                    }
                }
            ],
            ajax: {
                url: apiUrl("appointments") + "appointments-history-dataTable.php",
                method: "GET",
                dataType: "json",
                data: function (d) {
                    return d;
                },
                dataSrc: function (response) {
                    // Update Status Counts from response.counts
                    if (response.counts) {
                        let total = 0;
                        for (const status in response.counts) {
                            if (status !== 'all') {
                                total += parseInt(response.counts[status]);
                                $(`#count-${status}`).text(response.counts[status]);
                            }
                        }
                        $('#count-all').text(response.counts.all !== undefined ? response.counts.all : total);
                    }

                    // Update global appointments store for modal usage
                    const appointments = response.data || [];
                    const currentMap = new Map(window.allAppointments.map(a => [a.uuid, a]));
                    appointments.forEach(a => currentMap.set(a.uuid, a));
                    window.allAppointments = Array.from(currentMap.values());

                    return appointments;
                },
                error: typeof ajaxErrorHandler !== 'undefined' ? ajaxErrorHandler : function (e) { console.error('DataTables load error', e); }
            },
            createdRow: function (row, data, dataIndex) {
                $(row).addClass('hover:bg-muted/30 transition-colors cursor-pointer');
                $(row).attr('onclick', `openSummaryModal('${data.uuid}')`);
            }
        });

        // --- Filters Interactivity ---

        // Listen for filter changes from filterbar
        $(document).on('filter:change', function (e, filters) {
            if (filters.status !== undefined) {
                const searchValue = filters.status ? filters.status : '';
                table.column(3).search(searchValue);
            }
            if (filters.search !== undefined) {
                table.search(filters.search);
            }
            table.draw();
        });

        $('#reset-filters').on('click', function (e) {
            e.preventDefault();
            table.search('').columns().search('').draw();
        });

        window.fetchAppointments = function () {
            table.draw(false);
        };
    });
</script>