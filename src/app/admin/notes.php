<?php
/**
 * Admin Notes Page
 */

require_once dirname(__DIR__, 2) . '/core/app.php';

// Page variables
$pageTitle = "Clinical Notes - MindTrack";
$activeMenu = "management";
$currentPage = 'notes';

// Build initial header data
$headerData = [
    'title' => 'Clinical Notes',
    'description' => 'System-wide clinical session documentation',
    'searchPlaceholder' => 'Search notes by name or provider...',
];

include_once __DIR__ . '/layout.php';
?>

<?= shared('components', 'elements/dataTables/styles') ?>

<!-- Main Content Area -->

<div class="grid grid-cols-1 xl:grid-cols-4 gap-6 items-start">

    <!-- Left Column: DataTable (Spans 3 columns) -->
    <div class="xl:col-span-3">
        <!-- Filter Bar (using reusable component) -->
        <?= shared('components', 'layout/filterbar', [
            'isTransparent' => true,
            'mb' => '4',
            'primary' => [
                'name' => 'status',
                'label' => 'Status:',
                'options' => [
                    ['value' => '', 'label' => 'All', 'count_id' => 'count-all'],
                    ['value' => 'completed', 'label' => 'Completed', 'count_id' => 'count-completed'],
                    ['value' => 'draft', 'label' => 'Draft', 'count_id' => 'count-draft']
                ]
            ],
            'secondary_filters' => [
                // [
                //     'type' => 'search',
                //     'name' => 'search',
                //     'placeholder' => 'Search by name or provider...',
                //     'icon' => 'search'
                // ],
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
        ]); ?>

        <div class="bg-card rounded-2xl border border-border overflow-hidden shadow-sm">
            <!-- Table -->
            <div class="overflow-x-auto w-full">
                <table id="admin-notes-table" class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-muted/50 border-b border-border">
                            <th
                                class="w-3/12 px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                Patient</th>
                            <th
                                class="w-3/12 px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                Doctor</th>
                            <th
                                class="w-2/12 px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                Date of Session</th>
                            <th
                                class="w-2/12 px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                Service Type</th>
                            <th
                                class="w-1/12 px-6 py-4 text-xs font-bold text-muted-foreground uppercase tracking-wider">
                                Status</th>
                            <th
                                class="w-1/12 px-6 py-4 text-xs font-bold flex justify-end text-muted-foreground uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border text-sm text-foreground bg-card">
                        <!-- DataTable rows will load here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Analytics / Activity (Spans 1 column) -->
    <div class="xl:col-span-1 space-y-6">

        <!-- Widget 1: Documentation Compliance -->
        <?php featured('notes', 'components/documentation-compliance'); ?>

        <!-- Widget 2: Recent Finalizations (Static Placeholders) -->
        <?php featured('notes', 'components/recent-finalizations'); ?>

        <!-- Widget 3: Quick Stats -->
        <?php featured('notes', 'components/widget-quick-stats'); ?>

    </div>
</div>

<!-- Includes -->
<?php featured('notes', 'components/manage-modal'); ?>

<?= shared('components', 'elements/dataTables/scripts') ?>
<script>
    $(document).ready(function () {
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
                            doc.name = doc.firstname + " " + doc.lastname;
                            select.append(`<option value="${doc.name}">Dr. ${doc.name}</option>`);
                        });
                    }
                }
            });
        }

        // Initialize DataTable
        const $table = $('#admin-notes-table').DataTable({
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
                emptyTable: "No clinical notes found.",
                zeroRecords: "No matching notes found"
            },
            ajax: {
                url: apiUrl('notes') + 'admin-notes-dataTable.php',
                type: 'GET',
                dataSrc: function (json) {
                    // Update filter counts from the response
                    if (json.counts) {
                        $('#count-all').text(json.counts.all || 0);
                        $('#count-completed').text(json.counts.signed || 0); // Note: Signed represents Completed
                        $('#count-draft').text(json.counts.draft || 0);
                    }
                    return json.data;
                }
            },
            columns: [
                {
                    data: 'patient_name',
                    orderable: true,
                    render: function (data, type, row) {
                        const name = data || 'Unknown Patient';
                        const initial = name.charAt(0);
                        return `
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs shrink-0">
                                ${initial}
                            </div>
                            <div>
                                <p class="font-bold text-foreground leading-none">${name}</p>
                            </div>
                        </div>`;
                    }
                },
                {
                    data: 'doctor_name',
                    orderable: true,
                    render: function (data, type, row) {
                        const name = data ? 'Dr. ' + data : 'Unknown Provider';
                        return `<span class="font-semibold">${name}</span>`;
                    }
                },
                {
                    data: 'sched_date',
                    orderable: true,
                    render: function (data, type, row) {
                        if (!data) return '<span class="text-muted-foreground italic">N/A</span>';
                        let display = new Date(data).toLocaleDateString("en-US", { month: "short", day: "numeric", year: "numeric" });
                        if (row.sched_time) {
                            display += '<br><span class="text-xs text-muted-foreground font-medium">' +
                                new Date('1970-01-01T' + row.sched_time).toLocaleTimeString("en-US", { hour: "numeric", minute: "2-digit" }) +
                                '</span>';
                        }
                        return display;
                    }
                },
                {
                    data: 'service_name',
                    orderable: true,
                    render: function (data) {
                        return data ? `<span class="inline-flex items-center px-2 py-1 rounded bg-muted/50 text-xs font-semibold text-foreground">${data}</span>` : '<span class="text-muted-foreground text-xs italic">N/A</span>';
                    }
                },
                {
                    data: 'status',
                    orderable: true,
                    render: function (data) {
                        const status = (data || 'draft').toLowerCase();
                        if (status === 'signed') {
                            return `
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.4)]"></div>
                                    <span class="font-bold text-xs text-foreground uppercase tracking-wider">Completed</span>
                                </div>`;
                        } else {
                            return `
                                <div class="flex items-center gap-2">
                                    <div class="w-2 h-2 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.4)]"></div>
                                    <span class="font-bold text-xs text-foreground uppercase tracking-wider">Draft</span>
                                </div>`;
                        }
                    }
                },
                {
                    data: 'uuid',
                    searchable: false,
                    orderable: false,
                    className: 'text-right',
                    render: function (data, type, row) {
                        // PDF Link logic
                        let pdfAction = '';
                        if (row.status === 'signed') {
                            pdfAction = `
                            <button title="View Report PDF" class="download-pdf-btn p-2 rounded-lg text-muted-foreground hover:text-primary hover:bg-primary/10 transition-colors" data-id="${data}">
                                <span class="material-symbols-outlined text-lg">picture_as_pdf</span>
                            </button>`;
                        }

                        return `
                        <div class="flex items-center justify-end gap-1">
                            ${pdfAction}
                            <button title="Edit Note" class="manage-note-btn p-2 rounded-lg text-muted-foreground hover:text-primary hover:bg-primary/10 transition-colors" data-id="${data}">
                                <span class="material-symbols-outlined text-lg">edit</span>
                            </button>
                        </div>`;
                    }
                }
            ],
            order: [[2, 'desc']] // Sort by date descending initially
        });

        // --- Global Search Filter Integration ---
        let searchTimeout = null;
        $('#global-search-input').on('keydown keyup input', function () {
            const val = $(this).val();
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(function () {
                $table.search(val).draw();
            }, 300);
        });

        // Event listener for filter changes emitted by filterbar.js
        $(document).on('filter:change', function (e, filters) {
            console.log("Filters changed:", filters);

            // Handle Status
            if (filters.status !== undefined) {
                let searchVal = filters.status;
                if (searchVal === 'completed') searchVal = 'signed';
                $table.column(4).search(searchVal);
            }

            // Handle Search
            if (filters.search !== undefined) {
                $table.search(filters.search);
            }

            // Handle Doctor
            if (filters.doctor !== undefined) {
                $table.column(1).search(filters.doctor);
            }

            // Handle Sort
            if (filters.sortby) {
                switch (filters.sortby) {
                    case 'newest': $table.order([2, 'desc']); break;
                    case 'oldest': $table.order([2, 'asc']); break;
                    case 'name_asc': $table.order([0, 'asc']); break;
                    case 'name_desc': $table.order([0, 'desc']); break;
                }
            }
            $table.draw();
        });

        // Click handler for Manage Note
        $(document).on('click', '.manage-note-btn', function (e) {
            e.preventDefault();
            const uuid = $(this).data('id');
            const $icon = $(this).find('span');

            // Show loading state on click
            $icon.text('sync').addClass('animate-spin');

            $.ajax({
                url: apiUrl('notes') + 'single-note.php',
                type: 'GET',
                data: { uuid: uuid },
                dataType: 'json',
                success: function (res) {
                    if (res.success && res.data) {
                        ManageNoteModal.open('edit', res.data);
                    } else {
                        alert(res.message || 'Error fetching note detail');
                    }
                },
                error: function () {
                    alert('Could not communicate with the server.');
                },
                complete: function () {
                    $icon.text('edit').removeClass('animate-spin');
                }
            });
        });

        // Click handler for PDF Download button
        $(document).on('click', '.download-pdf-btn', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const id = $(this).data('id');
            window.open(apiUrl("notes") + "export-pdf.php?uuid=" + id, '_blank');
        });

        // Fallback row click -> view/edit mode
        $('#admin-notes-table tbody').on('click', 'tr', function (e) {
            // Prevent if clicking on actions
            if ($(e.target).closest('button').length > 0) return;

            const data = $table.row(this).data();
            if (data && data.uuid) {
                // Find the manage button and click it to trigger the smooth logic
                $(this).find('.manage-note-btn').click();
            }
        });
    });
</script>