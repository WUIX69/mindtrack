<?php
/**
 * Specialization Management
 */
$currentPage = "specializations";
$pageTitle = "Specialization Management | MindTrack Admin";
$headerData = [
    'title' => 'Specialization Management',
    'description' => 'Manage medical expertise areas for clinic staff',
    'actionLabel' => 'Add New Specialization',
    'actionIcon' => 'add',
    'actionUrl' => 'javascript:void(0);',
    'actionClass' => 'bg-primary hover:bg-primary/90 text-primary-foreground text-white px-5 py-2.5 rounded-lg font-medium transition-all shadow-sm shadow-primary/20 flex items-center gap-2 manage-specialization-btn',
    'mb' => 8
];

include_once __DIR__ . '/layout.php';
?>

<!-- DataTables Styles -->
<?= shared('components', 'elements/dataTables/styles') ?>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-card dark:bg-card p-4 rounded-xl border border-border">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-muted-foreground text-xs font-semibold uppercase">Total Specializations</p>
                <h3 class="text-2xl font-bold mt-1">12</h3>
            </div>
            <div
                class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 text-blue-600 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">category</span>
            </div>
        </div>
    </div>
    <div class="bg-card dark:bg-card p-4 rounded-xl border border-border">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-muted-foreground text-xs font-semibold uppercase">Active Status</p>
                <h3 class="text-2xl font-bold mt-1">11</h3>
            </div>
            <div
                class="w-10 h-10 bg-green-100 dark:bg-green-900/30 text-green-600 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">check_circle</span>
            </div>
        </div>
    </div>
    <div class="bg-card dark:bg-card p-4 rounded-xl border border-border">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-muted-foreground text-xs font-semibold uppercase">Recently Updated</p>
                <h3 class="text-2xl font-bold mt-1">3</h3>
            </div>
            <div
                class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 text-amber-600 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">history</span>
            </div>
        </div>
    </div>
    <div class="bg-card dark:bg-card p-4 rounded-xl border border-border">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-muted-foreground text-xs font-semibold uppercase">Top Capacity</p>
                <h3 class="text-2xl font-bold mt-1 text-primary">Clinical</h3>
            </div>
            <div class="w-10 h-10 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">trending_up</span>
            </div>
        </div>
    </div>
</div>

<!-- Filter Sub-header -->
<?= shared('components', 'layout/filterbar', [
    'isTransparent' => true,
    'mb' => '4',
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
            'name' => 'search',
            'placeholder' => 'Search Specializations...',
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
]); ?>

<!-- Main Content Card -->
<div class="bg-card dark:bg-card border border-border rounded-xl overflow-hidden shadow-sm">
    <div class="p-0">
        <table id="specializations-table" class="w-full text-left border-collapse display responsive nowrap"
            style="width:100%">
            <thead>
                <tr class="bg-muted/50 dark:bg-muted/50 border-b border-border">
                    <th class="px-6 py-4 text-xs font-bold uppercase text-muted-foreground tracking-wider">Name</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase text-muted-foreground tracking-wider max-w-xs">
                        Description</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase text-muted-foreground tracking-wider">Status</th>
                    <th
                        class="px-6 py-4 text-xs font-bold uppercase text-muted-foreground tracking-wider whitespace-nowrap">
                        Created At</th>
                    <th
                        class="px-6 py-4 text-xs font-bold uppercase text-muted-foreground tracking-wider whitespace-nowrap">
                        Updated At</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase text-muted-foreground tracking-wider text-right">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border">
                <!-- DataTables will populate this -->
            </tbody>
        </table>
    </div>
</div>

<!-- Add/Edit Modal (CSR) -->
<?= featured('specializations', 'components/manage-modal') ?>
<!-- Summary Modal (CSR) -->
<?= featured('specializations', 'components/summary-modal') ?>

<!-- DataTables Scripts -->
<?= shared('components', 'elements/dataTables/scripts') ?>

<script>
    // Global Data Store
    window.allSpecializations = [];

    // Helper to get single specialization
    window.getSingleSpecialization = function (id) {
        return window.allSpecializations.find(item => item.id == id);
    };

    $(document).ready(function () {
        // --- DataTables Integration ---
        const $table = $('#specializations-table').DataTable({
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
            serverSide: false, // Client-side filtering for now since the action returns all data
            ajax: {
                url: apiUrl("shared") + "specializations.php", // Re-using shared action
                dataSrc: function (json) {
                    window.allSpecializations = json.data || [];
                    return json.data;
                },
                error: function (xhr, error, thrown) {
                    console.error('DataTables Error:', error);
                }
            },
            columns: [
                {
                    data: 'name',
                    render: function (data) {
                        return `<span class="font-semibold text-foreground">${data}</span>`;
                    }
                },
                {
                    data: 'description',
                    render: function (data) {
                        return `<span class="text-muted-foreground truncate max-w-xs block" title="${data}">${data || '-'}</span>`;
                    }
                },
                {
                    data: 'status',
                    className: "min-w-30",
                    render: function (data) {
                        // Mock status if logic not present in DB
                        const status = data || 'active';
                        const color = status === 'active' ? 'green' : 'slate';
                        return `
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-${color}-100 dark:bg-${color}-900/30 text-${color}-700 dark:text-${color}-400">
                                ${status}
                            </span>
                        `;
                    }
                },
                {
                    data: 'created_at',
                    className: "font-mono text-xs text-muted-foreground whitespace-nowrap",
                    render: function (data) {
                        if (!data) return '-';
                        return new Date(data).toLocaleDateString('en-US', {
                            weekday: 'short',
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        });
                    }
                },
                {
                    data: 'updated_at',
                    className: "font-mono text-xs text-muted-foreground whitespace-nowrap",
                    render: function (data) {
                        if (!data) return '-';
                        return new Date(data).toLocaleDateString('en-US', {
                            weekday: 'short',
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        });
                    }
                },
                {
                    data: null,
                    orderable: false,
                    className: "text-left",
                    render: function (data, type, row) {
                        return `
                            <div class="flex items-center justify-start gap-4">
                                <button type="button" data-id="${row.id}" class="px-3 py-1.5 bg-sky-500/10 text-sky-600 text-xs font-bold rounded hover:bg-sky-500 hover:text-white transition-all view-btn">View</button>
                                <button type="button" data-id="${row.id}" class="px-3 py-1.5 bg-primary/10 text-primary text-xs font-bold rounded hover:bg-primary hover:text-white transition-all edit-btn">Manage</button>
                                <button type="button" data-id="${row.id}" class="px-3 py-1.5 bg-red-500/10 text-red-600 text-xs font-bold rounded hover:bg-red-500 hover:text-white transition-all delete-btn">Delete</button>
                            </div>
                        `;
                    }
                },
                { data: 'created_at', visible: false }
            ],
            language: {
                info: "Showing _START_ to _END_ of _TOTAL_ results",
                emptyTable: "No specializations found."
            }
        });

        // --- Global Search ---
        // let searchTimeout = null;
        // $('#search-filter').on('keydown keyup input', function () {
        //     const val = $(this).val();
        //     clearTimeout(searchTimeout);
        //     searchTimeout = setTimeout(function () {
        //         $table.search(val).draw();
        //     }, 300);
        // });

        // Event Listeners for Filters
        $(document).on('filter:change', function (e, filters) {
            console.log("Filters changed:", filters);

            // Handle Status
            if (filters.status !== undefined) {
                $table.column(2).search(filters.status);
            }

            // Handle Search
            if (filters.search !== undefined) {
                $table.search(filters.search);
            }

            // Handle Sort
            if (filters.sort) {
                switch (filters.sort) {
                    case 'newest': $table.order([6, 'desc']); break;
                    case 'oldest': $table.order([6, 'asc']); break;
                    case 'name_asc': $table.order([0, 'asc']); break;
                    case 'name_desc': $table.order([0, 'desc']); break;
                }
            }
            $table.draw();
        });

        // --- Delete Logic ---
        $('#specializations-table').on('click', '.delete-btn', function () {
            const id = $(this).data('id');
            if (confirm("Are you sure you want to delete this specialization? This action cannot be undone.")) {
                $.ajax({
                    url: apiUrl("specializations") + "manage-specialization.php",
                    method: 'POST',
                    data: { action: 'delete', id: id },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            $table.ajax.reload();
                        } else {
                            alert(response.message || 'Failed to delete item.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error:', error);
                        alert('An error occurred while deleting.');
                    }
                });
            }
        });
    });
</script>