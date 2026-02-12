<?php
/**
 * Admin - Doctors Management
 */
$pageTitle = "Doctors Management - MindTrack";
$headerData = [
    'title' => 'Doctors',
    'description' => 'Manage clinical staff, specialties, and provider availability.',
    'searchPlaceholder' => 'Search providers by name, specialty, or ID...',
    'actionLabel' => 'Add New Doctor',
    'actionIcon' => 'person_add',
    'actionUrl' => 'javascript:void(0);',
    'actionClass' => 'bg-primary hover:bg-primary/90 text-primary-foreground manage-doctor-btn',
    'mb' => 4
];
$currentPage = 'doctors';

include_once __DIR__ . '/layout.php';
?>
<?= shared('components', 'elements/dataTables/styles') ?>

<?php
// Define Filter Configuration
$doctorFilterConfig = [
    'primary' => [
        'name' => 'status',
        'label' => 'Status:',
        'options' => [
            ['value' => '', 'label' => 'All'],
            ['value' => 'active', 'label' => 'Active'],
            ['value' => 'on_leave', 'label' => 'On Leave'],
            ['value' => 'inactive', 'label' => 'Inactive']
        ]
    ],
    'secondary_filters' => [
        [
            'type' => 'select',
            'name' => 'specialty',
            'icon' => 'medical_services',
            'placeholder' => 'All Specialties',
            'options' => [] // Populated by JS
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
?>
<!-- Filter Sub-header -->
<?= shared('components', 'layout/filterbar', $doctorFilterConfig) ?>

<!-- Main Grid Layout -->
<div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
    <!-- Doctors Table Section -->
    <div class="xl:col-span-3">
        <div class="bg-card rounded-xl border border-border overflow-hidden shadow-sm">
            <table id="doctors-table" class="w-full text-left border-collapse display responsive nowrap"
                style="width:100%">
                <thead>
                    <tr class="bg-muted/50 text-muted-foreground uppercase text-[11px] font-bold tracking-wider">
                        <th class="!p-5">Doctor</th>
                        <th class="!p-5">Contact</th>
                        <th class="!p-5 text-center">Assigned Patients</th>
                        <th class="!p-5">Availability</th>
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
        <!-- Specialty Distribution Widget -->
        <div class="bg-card rounded-xl border border-border p-6 shadow-sm">
            <h3 class="text-sm font-bold mb-4 flex items-center gap-2 uppercase tracking-tight text-foreground">
                <span class="material-symbols-outlined text-primary text-[20px]">pie_chart</span>
                Specialty Distribution
            </h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">Psychotherapy</span>
                        <span class="text-foreground">42%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full w-[42%]"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">CBT Therapy</span>
                        <span class="text-foreground">35%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500 rounded-full w-[35%]"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">Occupational Therapy</span>
                        <span class="text-foreground">23%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-success rounded-full w-[23%]"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Capacity Widget -->
        <div class="bg-card rounded-xl border border-border p-6 shadow-sm">
            <h3 class="text-sm font-bold mb-4 flex items-center gap-2 uppercase tracking-tight text-foreground">
                <span class="material-symbols-outlined text-success text-[20px]">group_add</span>
                Provider Capacity
            </h3>
            <div class="flex items-end gap-2 mb-4">
                <span class="text-3xl font-bold text-foreground">88%</span>
                <span class="text-xs font-bold text-success mb-1 flex items-center">
                    <span class="material-symbols-outlined text-[16px]">trending_up</span>
                    Optimal
                </span>
            </div>
            <div class="flex items-center gap-1 h-12">
                <div class="flex-1 bg-primary/20 rounded-t h-[70%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[85%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[75%]"></div>
                <div class="flex-1 bg-primary rounded-t h-[95%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[80%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[90%]"></div>
                <div class="flex-1 bg-primary/20 rounded-t h-[85%]"></div>
            </div>
            <p class="mt-4 text-[11px] text-muted-foreground font-medium leading-relaxed">
                Current clinic capacity is at <span class="text-foreground font-bold">high utilization</span>. Consider
                onboarding new specialists.
            </p>
        </div>

        <!-- Quality Control Card -->
        <div class="bg-primary/5 rounded-xl border border-primary/10 p-5">
            <h4 class="text-sm font-bold text-primary mb-2 flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[16px]">verified</span>
                Quality Control
            </h4>
            <p class="text-xs text-muted-foreground leading-relaxed">
                Monthly performance reviews are due for <span class="font-bold text-foreground">8 providers</span>.
                Please update session feedback reports by Friday.
            </p>
        </div>
    </div>
</div>
</div>

<?= shared('components', 'elements/dataTables/scripts'); ?>
<?php featured('doctors', 'components/manage-doctor-modal'); ?>

<script>
    $(document).ready(function () {
        // Trigger Add Doctor Modal
        // Trigger Add/Edit Doctor Modal
        $(document).on('click', '.manage-doctor-btn', function (e) {
            e.preventDefault();
            const doctorId = $(this).data('id');

            if (doctorId) {
                // Edit Mode - Fetch data first
                $.ajax({
                    url: apiUrl('doctors') + 'manage-doctor.php',
                    type: 'GET',
                    data: { uuid: doctorId, action: 'get_single' },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            openDoctorModal('edit', response.data);
                        } else {
                            alert(response.error || 'Could not fetch doctor details');
                        }
                    },
                    error: function () {
                        alert('Error fetching doctor data');
                    }
                });
            } else {
                // Add Mode
                openDoctorModal('add');
            }
        });

        // Trigger Delete Doctor Modal
        $(document).on('click', '.delete-doctor-btn', function (e) {
            e.preventDefault();
            const doctorUuid = $(this).data('id');

            if (confirm("Are you sure you want to delete this doctor? This action cannot be undone.")) {
                $.ajax({
                    url: apiUrl('doctors') + 'manage-doctor.php',
                    type: 'DELETE',
                    data: {
                        uuid: doctorUuid
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            // alert(response.message);
                            $('#doctors-table').DataTable().ajax.reload();
                        } else {
                            alert(response.message || 'Error deleting doctor');
                        }
                    },
                    error: function () {
                        alert('Server error executing delete');
                    }
                });
            }
        });

        const $table = $('#doctors-table').DataTable({
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
                emptyTable: "No doctors found.",
                zeroRecords: "No matching records found"
            },
            columns: [
                {
                    data: 'doctor_name',
                    render: function (data, type, row) {
                        const name = data || 'Unknown Doctor';
                        const initial = (name).charAt(0).toUpperCase();
                        const specialty = row.specialty || 'General Practitioner';
                        return `
                            <div class="flex items-center gap-3">
                                <div class="size-10 rounded-full bg-muted flex items-center justify-center text-foreground font-bold border-2 border-card shadow-sm">${initial}</div>
                                <div>
                                    <p class="text-sm font-semibold text-foreground">${name}</p>
                                    <p class="text-[10px] text-primary font-bold uppercase">${specialty}</p>
                                </div>
                            </div>`;
                    }
                },
                {
                    data: 'email',
                    render: function (data, type, row) {
                        return `
                            <div class="text-xs space-y-0.5">
                                <p class="text-foreground font-medium">${data || 'No Email'}</p>
                                <p class="text-muted-foreground">${row.phone || 'No Phone'}</p>
                            </div>
                        `;
                    }
                },
                {
                    data: 'patients',
                    className: "!text-center",
                    render: function (data) {
                        return `<span class="px-2.5 py-1 bg-muted rounded-full text-xs font-bold text-foreground overflow-hidden">${data || 0}</span>`;
                    }
                },
                {
                    data: 'availability',
                    render: function (data) {
                        if (!data) return '<span class="text-xs text-muted-foreground">Not set</span>';
                        try {
                            const schedule = typeof data === 'string' ? JSON.parse(data) : data;
                            // Basic formatting: check if Mon-Fri are active and same hours
                            let summary = "Custom Schedule";
                            let hours = "";

                            if (schedule.monday?.active && schedule.friday?.active) {
                                summary = "Mon-Fri";
                                hours = `${schedule.monday.start} - ${schedule.monday.end}`;
                            } else {
                                // Fallback
                                const activeDays = Object.keys(schedule).filter(day => schedule[day]?.active).map(d => d.substring(0, 3).replace(/b/g, '').replace(/^a/, 'A').toUpperCase());
                                summary = activeDays.length > 0 ? activeDays.join(', ') : 'Unavailable';
                            }

                            return `
                                <div class="text-xs font-medium text-muted-foreground">
                                    ${summary}
                                    <p class="text-[10px] text-muted-foreground/60">${hours}</p>
                                </div>
                            `;
                        } catch (e) {
                            return '<span class="text-xs text-error">Invalid Data</span>';
                        }
                    }
                },
                {
                    data: 'status',
                    render: function (data) {
                        const statusColors = {
                            'active': 'emerald',
                            'inactive': 'red',
                            'on_leave': 'amber'
                        };
                        const color = statusColors[data] || 'slate';
                        return `
                            <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-[10px] font-bold uppercase bg-${color}-100 text-${color}-700 dark:bg-${color}-900/30 dark:text-${color}-400">
                                <span class="size-1.5 rounded-full bg-${color}-500"></span>
                                ${(data || 'Unknown').replace('_', ' ')}
                            </span>
                        `;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-right",
                    render: function (data, type, row) {
                        return `
                            <div class="flex items-center justify-end gap-2">
                                <button type="button" data-id="${row.uuid}" class="px-3 py-1.5 bg-primary/10 text-primary text-xs font-bold rounded hover:bg-primary hover:text-white transition-all manage-doctor-btn">Manage</button>
                                <button type="button" data-id="${row.uuid}" class="px-3 py-1.5 bg-red-500/10 text-red-600 text-xs font-bold rounded hover:bg-red-500 hover:text-white transition-all delete-doctor-btn">Delete</button>
                            </div>
                        `;
                    }
                },
                // { data: 'specialty', visible: false },
                // { data: 'phone', visible: false },
                // { data: 'uuid', visible: false },
                { data: 'created_at', visible: false }
            ],
            ajax: {
                url: apiUrl("doctors") + "doctors-dataTable.php",
                method: "GET",
                dataType: "json",
                data: function (d) {
                    // Filters
                    const statusBtn = $('.filter-primary-btn.bg-card[data-group="status"]');
                    d.filter_status = statusBtn.length ? statusBtn.data('value') : '';

                    const specialty = $('select[name="specialty"]').val();
                    d.filter_specialty = specialty || '';

                    return d;
                },
                error: function (xhr, error, thrown) {
                    console.error('DataTables Error:', error);
                }
            }
        });

        // --- Fetch Specialties Dynamically ---
        fetchSpecialties();
        function fetchSpecialties() {
            $.ajax({
                url: apiUrl("shared") + "specializations.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        // The filterbar component might output a generic select. We need to find it.
                        // The name is "specialty".
                        const select = $('select[name="specialty"]');
                        response.data.forEach(function (spec) {
                            select.append(`<option value="${spec.name}">${spec.name}</option>`);
                        });
                    }
                }
            });
        }

        // Event Listeners for Filters
        $(document).on('filter:change', function (e, filters) {
            console.log("Filters changed:", filters);

            // Handle Search
            if (filters.search !== undefined) {
                $table.search(filters.search);
            }

            // Handle Sort
            if (filters.sort) {
                switch (filters.sort) {
                    case 'newest': $table.order([9, 'desc']); break;
                    case 'oldest': $table.order([9, 'asc']); break;
                    case 'name_asc': $table.order([0, 'asc']); break;
                    case 'name_desc': $table.order([0, 'desc']); break;
                }
            }
            $table.draw();
        });
    });
</script>