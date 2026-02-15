<?php
/**
 * Admin - Patients Management
 */
$pageTitle = "Patients Management - MindTrack";
$headerData = [
    'title' => 'Patients',
    'description' => 'Maintain comprehensive health records and track clinical progress.',
    'searchPlaceholder' => 'Find patient by name or ID...',
    'actionLabel' => 'Add New Patient',
    'actionIcon' => 'person_add',
    'actionId' => 'add-patient-btn',
    'mb' => 4
];
$currentPage = 'patients';

include_once __DIR__ . '/layout.php';
?>

<?= shared('components', 'elements/dataTables/styles') ?>

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
<!-- Filter Sub-header -->
<?= shared('components', 'layout/filterbar', $patientFilterConfig) ?>

<!-- Main Grid Layout -->
<div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
    <!-- Patients Table Section -->
    <div class="xl:col-span-3">
        <div class="bg-card rounded-xl border border-border overflow-hidden shadow-sm">
            <table id="patients-table" class="w-full text-left border-collapse stripe hover">
                <thead>
                    <tr class="bg-muted/50 text-muted-foreground uppercase text-[11px] font-bold tracking-wider">
                        <th class="px-6 py-4">Patient</th>
                        <th class="px-6 py-4">Contact</th>
                        <th class="px-6 py-4">Last Appointment</th>
                        <th class="px-6 py-4">Sessions</th>
                        <th class="px-6 py-4">Alerts</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/50">
                    <!-- Loaded via DataTables -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sidebar Stats Content -->
    <div class="space-y-6">
        <!-- Demographics Widget -->
        <div class="bg-card rounded-xl border border-border p-6 shadow-sm">
            <h3 class="text-sm font-bold mb-4 flex items-center gap-2 uppercase tracking-tight text-foreground">
                <span class="material-symbols-outlined text-primary text-[20px]">analytics</span>
                Patient Demographics
            </h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">Adults (18-65)</span>
                        <span class="text-foreground">65%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full w-[65%]"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">Adolescents (12-17)</span>
                        <span class="text-foreground">22%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-blue-400 rounded-full w-[22%]"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">Seniors (65+)</span>
                        <span class="text-foreground">13%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-warning rounded-full w-[13%]"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Growth Widget -->
        <div class="bg-card rounded-xl border border-border p-6 shadow-sm">
            <h3 class="text-sm font-bold mb-4 flex items-center gap-2 uppercase tracking-tight text-foreground">
                <span class="material-symbols-outlined text-success text-[20px]">person_add_alt</span>
                New Patients This Month
            </h3>
            <div class="flex items-end gap-2 mb-4">
                <span class="text-3xl font-bold text-foreground">42</span>
                <span class="text-xs font-bold text-success mb-1 flex items-center">
                    <span class="material-symbols-outlined text-[16px]">trending_up</span>
                    +12%
                </span>
            </div>
            <div class="flex items-center gap-1 h-12">
                <div class="flex-1 bg-primary/20 rounded-t h-[40%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[60%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[30%]"></div>
                <div class="flex-1 bg-primary rounded-t h-[90%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[50%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[75%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[85%]"></div>
            </div>
        </div>

        <!-- Compliance Card -->
        <div class="bg-primary/5 rounded-xl border border-primary/10 p-5">
            <h4 class="text-sm font-bold text-primary mb-2 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">info</span>
                Data Compliance
            </h4>
            <p class="text-xs text-muted-foreground leading-relaxed">
                Ensure all patient records are updated within <span class="font-bold text-foreground">24 hours</span> of
                their last consultation to maintain HIPAA compliance.
            </p>
        </div>
    </div>
</div>

<!-- Modals -->
<?= shared('features', 'patients/components/manage-patient-modal') ?>

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
            language: {
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                lengthMenu: "Entries per page _MENU_",
                infoEmpty: "No entries",
                emptyTable: "No patients found.",
                zeroRecords: "No matching records found"
            },
            ajax: {
                url: apiUrl('patients') + 'patients-dataTable.php',
                data: function (d) {
                    const filters = window.currentFilters || {};
                    d.status = filters.status || '';
                    d.sort = filters.sort || 'recent';
                }
            },
            columns: [
                {
                    data: 'firstname',
                    render: function (data, type, row) {
                        const avatar = row.avatar || 'https://ui-avatars.com/api/?name=' + row.firstname + '+' + row.lastname + '&background=random';
                        return `
                            <div class="flex items-center gap-3">
                                <div class="size-9 rounded-full bg-muted bg-cover bg-center shrink-0" style="background-image: url('${avatar}')"></div>
                                <div class="truncate">
                                    <p class="text-sm font-semibold text-foreground truncate">${row.firstname} ${row.lastname}</p>
                                    <p class="text-[10px] text-muted-foreground uppercase">#PAT-${row.uuid.substring(0, 8)}</p>
                                </div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'email',
                    render: function (data, type, row) {
                        return `
                            <div class="text-xs space-y-0.5">
                                <p class="text-foreground font-medium">${row.email}</p>
                                <p class="text-muted-foreground">${row.phone || 'No phone'}</p>
                            </div>
                        `;
                    }
                },
                {
                    data: 'last_appt_date',
                    render: function (data, type, row) {
                        if (!data) return '<span class="text-xs text-muted-foreground italic">No appointments</span>';
                        return `
                             <div class="text-xs">
                                <p class="font-bold text-foreground">${data}</p>
                                <p class="text-muted-foreground truncate w-32">${row.last_service_name || ''}</p>
                            </div>
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
                    data: 'medical_history',
                    orderable: false,
                    render: function (data) {
                        let history = data;
                        if (typeof data === 'string' && data !== '') {
                            try { history = JSON.parse(data); } catch (e) { history = {}; }
                        }

                        const alerts = (history && history.alerts) ? history.alerts : [];
                        if (alerts.length === 0) return '<span class="size-2 rounded-full bg-muted inline-block"></span>';

                        return `
                            <div class="flex gap-1 justify-center lg:justify-start">
                                ${alerts.map(a => `<span class="size-2 rounded-full bg-${a}" title="${a.toUpperCase()} Alert"></span>`).join('')}
                            </div>
                        `;
                    }
                },
                {
                    data: 'uuid',
                    className: 'text-right',
                    orderable: false,
                    render: function (data, type, row) {
                        return `
                            <div class="flex items-center justify-end gap-2">
                                <button class="manage-btn px-3 py-1.5 bg-primary/10 text-primary text-xs font-bold rounded hover:bg-primary hover:text-white transition-all">Manage</button>
                                <button class="size-8 rounded-lg flex items-center justify-center text-muted-foreground hover:bg-muted transition-all">
                                    <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            drawCallback: function () {
                // Style pagination
                // $('.paginate_button').addClass('px-3 py-1 text-xs font-bold rounded bg-muted text-foreground border border-border mx-0.5 hover:bg-muted/80 transition-all');
                // $('.paginate_button.current').addClass('bg-primary text-white border-primary').removeClass('bg-muted text-foreground');
                // $('.paginate_button.disabled').addClass('opacity-50 cursor-not-allowed');
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

        // Filter Integration
        $(document).on('filter:change', function (e, filters) {
            window.currentFilters = filters;
            table.ajax.reload();
        });

        // Filter Integration
        // $(document).on('filter:change', function (e, filters) {
        //     console.log("Filters changed:", filters);

        //     // Handle Sort
        //     if (filters.sort) {
        //         switch (filters.sort) {
        //             case 'recent': table.order([9, 'desc']); break;
        //             case 'oldest': table.order([9, 'asc']); break;
        //             case 'name_asc': table.order([0, 'asc']); break;
        //             case 'name_desc': table.order([0, 'desc']); break;
        //         }
        //     }
        //     table.draw();
        // });

        // Add Patient
        $('#add-patient-btn').on('click', function () {
            window.openPatientModal('add');
        });

        // Edit/Manage Patient
        $('#patients-table').on('click', '.manage-btn', function () {
            const rowData = table.row($(this).closest('tr')).data();
            // Fetch fresh details for the modal to be safe, or use rowData if complete
            // Let's use rowData but ensure we have all fields in the DataTable response
            // Actually, medical_history might need parsing if it came as string
            let processedData = { ...rowData };
            if (typeof processedData.medical_history === 'string' && processedData.medical_history !== '') {
                try { processedData.medical_history = JSON.parse(processedData.medical_history); } catch (e) { }
            }
            window.openPatientModal('edit', processedData);
        });
    });
</script>