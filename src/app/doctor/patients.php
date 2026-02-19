<?php
/**
 * Doctor Patients Page - Patient Directory
 */
$pageTitle = "My Patients - MindTrack Doctor";

$headerData = [
    'title' => 'My Patients',
    'description' => 'Manage and monitor patient treatment progress',
    'searchPlaceholder' => 'Search patients by name, ID, or treatment type...',
    // Action button removed as doctors don't create patients
];

// Determine current page for sidebar
$currentPage = 'patients';

include_once __DIR__ . '/layout.php';
?>

<?= shared('components', 'elements/dataTables/styles') ?>

<div class="flex flex-col h-full space-y-4">
    <!-- Filter Bar -->
    <?php
    $patientFilterConfig = [
        'primary' => [
            'name' => 'status',
            'label' => 'Status:',
            'options' => [
                ['value' => '', 'label' => 'All'],
                ['value' => 'active', 'label' => 'Active'],
                ['value' => 'inactive', 'label' => 'Inactive']
            ]
        ],
        'secondary_filters' => [
            [
                'type' => 'search',
                'name' => 'search', // This matches input name
                'placeholder' => 'Search Patients...',
                'icon' => 'search'
            ],
            [
                'type' => 'select',
                'name' => 'sort',
                'icon' => 'sort',
                'placeholder' => 'Sort Order',
                'options' => [
                    'recent' => 'Recent First',
                    'oldest' => 'Oldest First',
                    'name_asc' => 'Name (A-Z)',
                    'name_desc' => 'Name (Z-A)'
                ]
            ]
        ]
    ];
    ?>
    <?= shared('components', 'layout/filterbar', $patientFilterConfig) ?>

    <!-- Data Table Container -->
    <div class="bg-card rounded-2xl border border-border shadow-sm overflow-hidden min-h-0">
        <div class="flex-1 overflow-auto">
            <table id="patients-table" class="w-full text-left border-collapse min-w-[800px] stripe hover">
                <thead>
                    <tr
                        class="bg-muted/30 sticky top-0 z-10 border-b border-border text-[10px] font-black text-muted-foreground uppercase tracking-widest">
                        <th class="px-6 py-4">Patient</th>
                        <th class="px-6 py-4">Contact</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Last Session</th>
                        <th class="px-6 py-4">Next Session</th>
                        <th class="px-6 py-4">Primary Service</th>
                        <th class="px-6 py-4 text-center">Sessions</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    <!-- Loaded via DataTables -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= shared('components', 'elements/dataTables/scripts') ?>
<script>
    $(document).ready(function () {
        const table = $('#patients-table').DataTable({
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
            // Updated language based on doctor context
            language: {
                info: "Showing _START_ to _END_ of _TOTAL_ patients",
                lengthMenu: "Rows per page _MENU_",
                infoEmpty: "No patients found",
                emptyTable: "No patients found. Appointments with new patients will appear here.",
                zeroRecords: "No matching patients found"
            },
            ajax: {
                url: apiUrl('patients') + 'doctor-patients-dataTable.php',
                data: function (d) {
                    // Placeholder for custom params if needed
                }
            },
            columns: [
                {
                    data: 'name', // Updated: using concatenated name
                    render: function (data, type, row) {
                        // Updated: removed avatar, just name + ID badge
                        return `
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary text-xs font-bold">P</div>
                                <div>
                                    <p class="text-sm font-black text-foreground">${data}</p>
                                    <p class="text-[10px] font-bold text-muted-foreground uppercase flex items-center gap-1 mt-0.5">
                                        ID: ${row.uuid.substring(0, 8)}
                                    </p>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'email',
                    render: function (data, type, row) {
                        return `
                            <div class="flex flex-col text-xs">
                                <span class="font-medium text-foreground">${data}</span>
                                <span class="text-muted-foreground mt-0.5">${row.phone || 'No phone'}</span>
                            </div>
                        `;
                    }
                },
                {
                    data: 'status',
                    render: function (data) {
                        const statusColors = {
                            'active': 'emerald',
                            'inactive': 'red',
                            'on_leave': 'amber',
                            'archived': 'slate'
                        };
                        const color = statusColors[data] || 'slate';
                        const displayStatus = {
                            'active': 'Active',
                            'inactive': 'Inactive',
                            'on_leave': 'On Leave'
                        }[data] || data || 'Unknown';

                        return `
                            <span class="inline-flex items-center gap-1.5 text-[10px] font-black uppercase tracking-widest text-${color}-600 dark:text-${color}-400">
                                <span class="size-1.5 rounded-full bg-${color}-500 animate-pulse"></span>
                                ${displayStatus}
                            </span>
                        `;
                    }
                },
                {
                    data: 'last_session',
                    render: function (data) {
                        if (!data) return '<span class="text-xs text-muted-foreground italic">No sessions yet</span>';
                        return `<span class="text-xs font-semibold text-muted-foreground">${data}</span>`;
                    }
                },
                {
                    data: 'next_session',
                    render: function (data) {
                        if (!data) return '<span class="text-xs text-muted-foreground opacity-70">None scheduled</span>';
                        return `
                            <div class="flex flex-col">
                                <p class="text-xs font-black text-foreground">${data}</p>
                            </div>
                        `;
                    }
                },
                {
                    data: 'primary_service',
                    render: function (data) {
                        if (!data) return '<span class="text-xs text-muted-foreground">-</span>';
                        return `
                            <span class="px-2 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-primary/10 text-primary">
                                ${data}
                            </span>
                        `;
                    }
                },
                {
                    data: 'total_sessions',
                    className: '!text-center',
                    render: function (data) {
                        return `<span class="text-sm font-bold text-foreground">${data || 0}</span>`;
                    }
                },
                {
                    data: 'uuid',
                    orderable: false,
                    className: '!text-right',
                    render: function (data) {
                        return `
                            <div class="flex items-center justify-end gap-3">
                                <button class="p-2 text-muted-foreground hover:bg-primary/10 hover:text-primary rounded-lg transition-all" title="Add Clinical Note">
                                    <span class="material-symbols-outlined text-lg">edit_note</span>
                                </button>
                                <button class="px-4 py-1.5 text-[10px] font-black text-primary border-2 border-primary/20 hover:border-primary hover:bg-primary hover:text-primary-foreground rounded-lg transition-all uppercase tracking-widest">
                                    View Records
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            drawCallback: function () {
                // Style pagination buttons if needed
            }
        });

        // --- Global Search Filter Integration ---
        let searchTimeout = null;
        $('#global-search-input').on('keydown keyup input', function () {
            const val = $(this).val();
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function () {
                table.search(val).draw();
            }, 300);
        });

        // Event Listeners for Filters
        $(document).on('filter:change', function (e, filters) {
            // Handle Status (Column 3 - index 2)
            if (filters.status !== undefined) {
                table.column(2).search(filters.status);
            }

            // Handle Sort
            if (filters.sort) {
                // Sort logic mapped to columns. 
                // Name is col 0, Created At is col 9 (hidden)
                // Note: CreatedAt is mapped in backend columns for sorting purposes
                switch (filters.sort) {
                    case 'recent': table.order([9, 'desc']); break; // Created At DESC
                    case 'oldest': table.order([9, 'asc']); break;  // Created At ASC
                    case 'name_asc': table.order([0, 'asc']); break; // Name ASC
                    case 'name_desc': table.order([0, 'desc']); break; // Name DESC
                }
            }
            table.draw();
        });
    });
</script>