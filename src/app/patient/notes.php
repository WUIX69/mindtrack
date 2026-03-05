<?php
/**
 * Patient Medical Notes Page
 */

$pageTitle = "My Medical Notes";
$bodyClass = "bg-muted/50 dark:bg-background text-foreground font-display transition-colors duration-200";
// Set current page for sidebar highlighting
$headerData = [
    'title' => 'My Notes',
    'description' => 'Access and manage your clinical documents and test results.',
    'searchPlaceholder' => 'Search by name or provider...',
    'actionLabel' => 'Upload New',
    'actionIcon' => 'upload'
];
$currentPage = 'notes';

include __DIR__ . '/layout.php';

// PHP data loading replaced by CSR
?>

<?= shared('components', 'elements/dataTables/styles') ?>
<div class="mb-4">
    <?= shared('components', 'layout/filterbar', [
        'isTransparent' => true,
        'mb' => '4',
        'primary' => [
            'name' => 'status',
            'options' => [
                ['value' => '', 'label' => 'All', 'count_id' => 'count-all'],
                ['value' => 'completed', 'label' => 'Completed', 'count_id' => 'count-completed'],
                ['value' => 'draft', 'label' => 'Draft', 'count_id' => 'count-draft']
            ]
        ],
        'secondary_filters' => [
            [
                'type' => 'search',
                'name' => 'search',
                'placeholder' => 'Search by name or provider...',
                'icon' => 'search'
            ],
            [
                'type' => 'select',
                'name' => 'doctor',
                'icon' => 'person',
                'placeholder' => 'All Providers',
                'options' => [] // Populated by JS
            ],
            [
                'type' => 'select',
                'name' => 'sortby',
                'placeholder' => 'Sort by',
                'options' => [
                    'newest' => 'Newest First',
                    'oldest' => 'Oldest First',
                    'name_asc' => 'Name (A-Z)',
                    'name_desc' => 'Name (Z-A)'
                ],
                'default' => 'newest'
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
    ]) ?>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2">
        <div class="bg-card dark:bg-card rounded-xl border border-border overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table id="notes-table" class="w-full text-left display responsive nowrap" style="width:100%">
                    <thead>
                        <tr class="text-xs uppercase tracking-wider text-muted-foreground bg-muted/50">
                            <th class="px-6 py-4 font-semibold !p-5">Document Info</th>
                            <th class="px-6 py-4 font-semibold !p-5">Date / Service</th>
                            <th class="px-6 py-4 font-semibold !p-5">Provider</th>
                            <th class="px-6 py-4 font-semibold text-right !p-5">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="space-y-6">
        <!-- Quick Insights -->
        <?= featured('notes', 'components/quick-insights'); ?>

        <div class="bg-card dark:bg-card p-6 rounded-xl border border-border shadow-sm">
            <div class="flex items-center gap-2 mb-3">
                <span class="material-symbols-outlined text-green-600">verified_user</span>
                <h3 class="font-bold">Privacy Protected</h3>
            </div>
            <p class="text-xs text-muted-foreground leading-relaxed font-medium">
                Your medical notes are encrypted and HIPAA compliant. Only authorized providers can access your full
                medical history.
            </p>
            <button
                class="mt-4 w-full py-2 text-xs font-bold text-primary border border-primary/20 bg-primary/5 rounded-lg hover:bg-primary/10 transition-colors">
                Manage Permissions
            </button>
        </div>
        <div
            class="relative overflow-hidden bg-primary p-6 rounded-xl text-primary-foreground shadow-lg shadow-primary/20">
            <div class="absolute -right-4 -bottom-4 opacity-20">
                <span class="material-symbols-outlined text-8xl">help</span>
            </div>
            <h3 class="text-xs font-bold uppercase tracking-widest opacity-80 mb-2">Need Assistance?</h3>
            <p class="text-sm font-medium leading-relaxed mb-4">Can't find a specific document? Contact our support team
                or your provider directly.</p>
            <button
                class="bg-primary-foreground/20 hover:bg-primary-foreground/30 text-primary-foreground text-xs font-bold px-4 py-2 rounded-lg transition-colors">
                Contact Center
            </button>
        </div>
    </div>
</div>

<?= featured('notes', 'components/summary-modal'); ?>

<?= shared('components', 'elements/dataTables/scripts') ?>
<script>
    $(document).ready(function () {
        const table = $('#notes-table').DataTable({
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
            order: [[3, 'desc']], // Default sort by updated_at (hidden)
            orderCellsTop: true,
            autoWidth: false,
            language: {
                info: "Showing _START_ to _END_ of _TOTAL_ notes",
                lengthMenu: "Entries per page _MENU_",
                infoEmpty: "No notes found",
                emptyTable: "No notes found.",
                zeroRecords: "No matching notes found"
            },
            columns: [
                {
                    data: 'subjective',
                    className: "px-6 py-4",
                    orderable: false,
                    render: function (data, type, row) {
                        const noteType = row.status === 'signed' ? 'Clinical Note (Final)' : 'Clinical Note (Draft)';
                        return `
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center text-primary shrink-0">
                                    <span class="material-symbols-outlined text-[20px]">assignment</span>
                                </div>
                                <div>
                                    <p class="text-sm font-bold">${noteType}</p>
                                    <p class="text-[11px] text-muted-foreground font-medium truncate max-w-[200px]">${data || 'No summary available'}</p>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'sched_date',
                    className: "px-6 py-4",
                    render: function (data, type, row) {
                        const dateObj = new Date(`${data} ${row.sched_time}`);
                        const formattedDate = dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        return `
                            <p class="text-sm font-bold">${formattedDate}</p>
                            <p class="text-xs text-muted-foreground">${row.service_name || 'No Service'}</p>
                        `;
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
                    className: "px-6 py-4 text-right",
                    render: function (data, type, row) {
                        let statusClass = 'bg-muted text-muted-foreground';
                        let statusLabel = 'Draft';

                        if (data === 'signed') {
                            statusClass = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400';
                            statusLabel = 'Completed';
                        } else if (data === 'draft') {
                            statusClass = 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400';
                            statusLabel = 'Draft';
                        }

                        // Added a download button (static layout for visual)
                        return `
                            <div class="flex justify-end gap-2 items-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide mr-2 ${statusClass}">${statusLabel}</span>
                                <button class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/5 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined hidden">download</span>
                                </button>
                            </div>
                        `;
                    }
                },
                { data: 'updated_at', visible: false }, // Hidden column to allow proper sorting
                { data: 'doctor_uuid', name: 'doctor_uuid', visible: false } // Hidden column to filter by doctor
            ],
            ajax: {
                url: apiUrl("notes") + "patient-notes-dataTable.php",
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
                    return response.data || [];
                },
                error: typeof ajaxErrorHandler !== 'undefined' ? ajaxErrorHandler : function (e) { console.error('DataTables load error', e); }
            },
            createdRow: function (row, data, dataIndex) {
                $(row).addClass('hover:bg-muted/30 transition-colors cursor-pointer');
            }
        });

        // Row Click to View Summary
        $('#notes-table tbody').on('click', 'tr', function (e) {
            // Ignore if click is on an interactive element (though we only have display elements mostly)
            if ($(e.target).closest('button, a, input, select').length) return;

            const rowData = table.row(this).data();
            if (rowData && rowData.uuid) {
                // Fetch fresh single note details from backend
                $.ajax({
                    url: apiUrl("notes") + "single-note.php",
                    type: "GET",
                    data: { uuid: rowData.uuid },
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                        // return false;
                        if (response.success && response.data) {
                            NoteSummaryModal.open(response.data);
                        } else {
                            alert(response.message || 'Could not fetch note details.');
                        }
                    },
                    error: function () {
                        alert('Error fetching note data from server.');
                    }
                });
            }
        });

        // --- Filters Interactivity ---

        // Listen for filter changes from filterbar
        $(document).on('filter:change', function (e, filters) {

            if (filters.status !== undefined) {
                // translate 'completed' back to 'signed' for backend filtering
                let searchValue = filters.status;
                if (searchValue === 'completed') searchValue = 'signed';

                table.column(3).search(searchValue); // Map to DB status
            }
            if (filters.search !== undefined) {
                table.search(filters.search);
            }
            if (filters.doctor !== undefined) {
                table.column('doctor_uuid:name').search(filters.doctor);
            }
            if (filters.sortby !== undefined) {
                if (filters.sortby === 'newest') table.order([4, 'desc']);
                else if (filters.sortby === 'oldest') table.order([4, 'asc']);
                else if (filters.sortby === 'name_asc') table.order([2, 'asc']); // index 2 is doctor_name
                else if (filters.sortby === 'name_desc') table.order([2, 'desc']);
            }

            table.draw();
        });



        // --- Fetch Doctors CSR ---
        fetchDoctors();

        function fetchDoctors() {
            $.ajax({
                url: apiUrl("shared") + "doctors.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    // return false;
                    if (!response.success) return;
                    // Filter component generates select tags with name="[name]", using bracket selector
                    const select = $('select[name="doctor"]');
                    response.data.forEach(function (doc) {
                        select.append(`<option value="${doc.uuid}">Dr. ${doc.firstname} ${doc.lastname}</option>`);
                    });
                }
            });
        }
    });
</script>