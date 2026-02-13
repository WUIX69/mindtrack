<?php
/**
 * Admin - Services Management
 */
$pageTitle = "Service Management - MindTrack";
$headerData = [
    'title' => 'Service Management',
    'description' => 'Categorize and manage your clinical services and therapy offerings.',
    'actionLabel' => 'Add New Service',
    'actionIcon' => 'add',
    'actionId' => 'add-service-btn',
    'mb' => '6'
];
$currentPage = 'services';

include_once __DIR__ . '/layout.php';

// --- Filter Configurations ---

$categoriesFilterConfig = [
    'mt' => 0,
    'mb' => 0,
    'isTransparent' => true,
    'secondary_filters' => [
        [
            'type' => 'search',
            'name' => 'search_categories',
            'placeholder' => 'Search categories...',
            'icon' => 'search'
        ]
    ],
    'actions' => [
        [
            'label' => 'Add Category',
            'icon' => 'add_circle',
            'id' => 'add-category-btn',
            'class' => 'text-primary hover:bg-primary/5 border border-primary/20'
        ]
    ]
];

$servicesFilterConfig = [
    'mt' => 0,
    'mb' => 0,
    'isTransparent' => true,
    'secondary_filters' => [
        [
            'type' => 'search',
            'name' => 'search_services',
            'placeholder' => 'Search services...',
            'icon' => 'search'
        ],
        [
            'type' => 'select',
            'name' => 'filter_category',
            'placeholder' => 'All Categories',
            'icon' => 'category',
            'options' => [] // Populated via JS
        ]
    ]
];
?>


<?= shared('components', 'elements/dataTables/styles') ?>

<div class="space-y-8">

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Categories Stat -->
        <div class="bg-card p-6 rounded-xl border border-border shadow-sm flex items-center gap-4">
            <div class="bg-primary/10 text-primary p-3 rounded-lg">
                <span class="material-symbols-outlined">category</span>
            </div>
            <div>
                <p class="text-sm font-medium text-muted-foreground">Categories</p>
                <p class="text-2xl font-bold text-foreground" id="stat-categories-count">-</p>
            </div>
        </div>
        <!-- Active Services Stat -->
        <div class="bg-card p-6 rounded-xl border border-border shadow-sm flex items-center gap-4">
            <div class="bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400 p-3 rounded-lg">
                <span class="material-symbols-outlined">list_alt</span>
            </div>
            <div>
                <p class="text-sm font-medium text-muted-foreground">Active Services</p>
                <p class="text-2xl font-bold text-foreground" id="stat-active-services">-</p>
            </div>
        </div>
        <!-- Inactive Services Stat -->
        <div class="bg-card p-6 rounded-xl border border-border shadow-sm flex items-center gap-4">
            <div class="bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400 p-3 rounded-lg">
                <span class="material-symbols-outlined">pause_circle</span>
            </div>
            <div>
                <p class="text-sm font-medium text-muted-foreground">Inactive Services</p>
                <p class="text-2xl font-bold text-foreground" id="stat-inactive-services">-</p>
            </div>
        </div>
    </div>

    <!-- Service Categories Section -->
    <section class="space-y-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-foreground flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">folder_open</span>
                Service Categories
            </h3>
            <!-- Filter Bar for Categories -->
            <?= shared('components', 'layout/filterbar', $categoriesFilterConfig) ?>
        </div>

        <div class="bg-card rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse display responsive nowrap" id="categories-table">
                    <thead>
                        <tr class="bg-muted/50 border-b border-border">
                            <th class="!p-4 uppercase tracking-wider text-xs text-muted-foreground">
                                Category</th>
                            <th class="!p-4 uppercase tracking-wider text-xs text-muted-foreground">
                                Description</th>
                            <th class="!p-4 uppercase tracking-wider text-xs text-muted-foreground">
                                Status</th>
                            <th class="!p-4 uppercase tracking-wider text-xs text-muted-foreground">
                                Created</th>
                            <th class="!p-4 uppercase tracking-wider text-xs text-muted-foreground">
                                Updated</th>
                            <th class="!p-4 uppercase tracking-wider text-xs text-muted-foreground">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50">
                        <!-- Populated by JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Individual Services Section -->
    <section class="space-y-4">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h3 class="text-lg font-bold text-foreground flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">medical_services</span>
                All Individual Services
            </h3>
            <!-- Filter Bar for Services -->
            <?= shared('components', 'layout/filterbar', $servicesFilterConfig) ?>
        </div>

        <div class="bg-card rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left" id="services-table">
                    <thead>
                        <tr class="bg-muted/50 border-b border-border">
                            <th class="!p-4 uppercase tracking-wider text-xs text-muted-foreground">
                                Service Name</th>
                            <th class="!p-4 uppercase tracking-wider text-xs text-muted-foreground">
                                Category</th>
                            <th class="!p-4 uppercase tracking-wider text-xs text-muted-foreground">
                                Specialization</th>
                            <th class="!p-4 uppercase tracking-wider text-xs text-muted-foreground">Price
                            </th>
                            <th class="!p-4 uppercase tracking-wider text-xs text-muted-foreground">
                                Duration</th>
                            <th class="!p-4 uppercase tracking-wider text-xs text-muted-foreground">
                                Status</th>
                            <th class="!p-4 uppercase tracking-wider text-xs text-muted-foreground">
                                Created</th>
                            <th class="!p-4 uppercase tracking-wider text-xs text-muted-foreground">
                                Updated</th>
                            <th class="!p-4 uppercase tracking-wider text-xs text-muted-foreground">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border/50">
                        <!-- Populated by DataTables -->
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Footnote Info -->
    <div class="p-6 bg-primary/5 rounded-xl border border-primary/10 flex items-start gap-4">
        <span class="material-symbols-outlined text-primary">info</span>
        <div>
            <h4 class="text-sm font-bold text-primary">Service Catalog Management</h4>
            <p class="text-xs text-primary/80 mt-1">Changes to service categories will immediately update the filtering
                options for all administrative and patient-facing views. Deleting a category will move its services to
                'Uncategorized'.</p>
        </div>
    </div>

</div>

<!-- Modals -->
<?= featured('services', 'components/category-modal') ?>
<?= featured('services', 'components/service-modal') ?>

</div>

<?= shared('components', 'elements/dataTables/scripts') ?>
<script>
    $(document).ready(function () {
        const categoriesActionUrl = apiUrl('shared') + "categories.php";
        const specializationsActionUrl = apiUrl('shared') + "specializations.php";
        const servicesDtUrl = apiUrl('services') + "services-dataTable.php";
        const servicesActionUrl = apiUrl('services') + "manage-services.php";

        const formatDate = (dateString) => {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        };

        // --- Categories Logic ---

        // 1. Initialize Categories DataTable
        const categoriesTable = $('#categories-table').DataTable({
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
                emptyTable: "No categories found.",
                zeroRecords: "No matching categories found"
            },
            ajax: {
                url: apiUrl('shared') + "categories-dataTable.php",
                data: function (d) {
                    // console.log(d);
                    // return false;

                    d.reference_model = 'services'; // Critical for filtering
                }
            },
            columns: [
                {
                    data: 'icon',
                    render: function (data, type, row) {
                        const color = 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400';
                        return `
                        <div class="flex items-center gap-3">
                            <div class="p-1.5 rounded ${color}">
                                <span class="material-symbols-outlined text-lg">${data || 'folder'}</span>
                            </div>
                            <span class="text-sm font-bold text-foreground">${row.name}</span>
                        </div>`;
                    }
                },
                {
                    data: 'description',
                    render: (data) => `<p class="text-xs text-muted-foreground max-w-md truncate">${data || ''}</p>`
                },
                {
                    data: 'status',
                    render: (data) => `<span class="px-2 py-1 rounded text-xs font-semibold ${data === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'} uppercase">${data}</span>`
                },
                {
                    data: 'created_at',
                    render: (data) => `<span class="text-xs text-muted-foreground">${formatDate(data)}</span>`
                },
                {
                    data: 'updated_at',
                    render: (data) => `<span class="text-xs text-muted-foreground">${formatDate(data)}</span>`
                },
                {
                    data: null,
                    orderable: false,
                    className: "text-left",
                    render: function (data, type, row) {
                        return `
                        <div class="flex items-center justify-start gap-2 text-muted-foreground">
                            <button class="hover:text-primary transition-colors edit-category-btn" data-id="${data.id}"><span
                                    class="material-symbols-outlined text-lg">edit</span></button>
                            <button class="hover:text-error transition-colors delete-category-btn" data-id="${data.id}"><span
                                    class="material-symbols-outlined text-lg">delete</span></button>
                        </div>`;
                    }
                }
            ],
            drawCallback: function (settings) {
                const api = this.api();
                $('#stat-categories-count').text(api.page.info().recordsTotal);
            }
        });

        // Category Search (External Input)
        $('input[name="search_categories"]').on('input', function () {
            categoriesTable.search(this.value).draw();
        });

        // 2. Dropdown Population
        getCategoryDropdown();
        getSpecializationDropdown();

        function getCategoryDropdown() {
            $.ajax({
                url: categoriesActionUrl,
                method: 'GET',
                dataType: 'json',
                data: { reference_model: 'services' },
                headers: { 'X-Reference-Model': 'services' },
                success: function (response) {
                    if (!response.success) return false;
                    const $filterSelect = $('select[name="filter_category"]');
                    const $modalSelect = $('#service-category');

                    // Clear and Add Default Options
                    $filterSelect.html('<option value="">All Categories</option>');
                    $modalSelect.html('<option disabled selected value="">Select a category</option>');

                    response.data.forEach(function (cat) {
                        $filterSelect.append(`<option value="${cat.name}">${cat.name}</option>`);
                        $modalSelect.append(`<option value="${cat.id}">${cat.name}</option>`);
                    });
                }
            });
        }

        function getSpecializationDropdown() {
            $.ajax({
                url: specializationsActionUrl,
                method: 'GET',
                dataType: 'json',
                data: { action: 'specializations' },
                success: function (response) {
                    if (!response.success) return false;
                    const $modalSelect = $('#service-specialization');

                    // Clear and Add Default Options
                    $modalSelect.html('<option disabled selected value="">Select a specialization (Optional)</option>');

                    response.data.forEach(function (spec) {
                        $modalSelect.append(`<option value="${spec.id}">${spec.name}</option>`);
                    });
                }
            });
        }

        // Add Category Click
        $('#add-category-btn').on('click', function () {
            if (window.openCategoryModal) window.openCategoryModal('add');
        });

        // Edit Category Click
        $('#categories-table').on('click', '.edit-category-btn', function () {
            const id = $(this).data('id');

            // Fetch single category for edit - Reuse the 'all' cache or fetch single? 
            // Better to fetch single to be safe, but we don't have a specific single endpoint optimized. 
            // We can reuse the row data from DataTables!

            // Get row data
            const tr = $(this).closest('tr');
            const row = categoriesTable.row(tr).data();

            if (row && window.openCategoryModal) {
                const modalData = {
                    name: row.name,
                    icon: row.icon,
                    desc: row.description,
                };
                window.openCategoryModal('edit', modalData);
                $('#category-id').val(row.id);
                $('#category-status').val(row.status);
            }
        });

        // Delete Category Click
        $('#categories-table').on('click', '.delete-category-btn', function () {
            if (!confirm('Are you sure you want to delete this category?')) return;
            const id = $(this).data('id');
            $.ajax({
                url: categoriesActionUrl + '?id=' + id + '&reference_model=services',
                method: 'DELETE',
                success: function (res) {
                    categoriesTable.ajax.reload();
                    getCategoryDropdown(); // Update dropdowns
                    servicesTable.ajax.reload(); // Reload services too
                }
            });
        });

        // Category Saved Event
        $(document).on('category-saved', function () {
            categoriesTable.ajax.reload();
            getCategoryDropdown();
            servicesTable.ajax.reload(); // In case categories affect services display
        });


        // --- Services Logic (DataTables) ---

        const servicesTable = $('#services-table').DataTable({
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
                emptyTable: "No services found.",
                zeroRecords: "No matching services found"
            },
            ajax: {
                url: servicesDtUrl,
                data: function (d) {
                    // Custom params removed
                }
            },
            columns: [
                {
                    data: 'name',
                    render: (data) => `<span class="text-sm font-bold text-foreground">${data}</span>`
                },
                {
                    data: 'category_name', // Comes from joined table
                    render: (data) => `<span class="text-xs font-medium text-primary bg-primary/10 px-2 py-1 rounded">${data || 'Uncategorized'}</span>`
                },
                {
                    data: 'specialization_name', // Comes from joined table
                    render: (data) => `<span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded dark:bg-blue-900/20 dark:text-blue-400">${data || '-'}</span>`
                },
                {
                    data: 'price',
                    render: (data) => `<span class="text-sm font-medium text-foreground">₱${parseFloat(data).toFixed(2)}</span>`
                },
                {
                    data: 'duration',
                    render: (data) => `<span class="text-xs text-muted-foreground">${data} mins</span>`
                },
                {
                    data: 'status',
                    render: (data) => `<span class="px-2 py-1 rounded text-xs font-semibold ${data === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'} uppercase">${data}</span>`
                },
                {
                    data: 'created_at',
                    render: (data) => `<span class="text-xs text-muted-foreground">${formatDate(data)}</span>`
                },
                {
                    data: 'updated_at',
                    render: (data) => `<span class="text-xs text-muted-foreground">${formatDate(data)}</span>`
                },
                {
                    data: null,
                    orderable: false,
                    className: "text-left",
                    render: function (data, type, row) {
                        return `
                        <div class="flex items-center justify-start gap-2 text-muted-foreground">
                            <button class="hover:text-primary transition-colors edit-service-btn" data-uuid="${row.uuid}">
                                <span class="material-symbols-outlined text-lg">edit</span>
                            </button>
                            <button class="hover:text-error transition-colors delete-service-btn" data-uuid="${row.uuid}">
                                <span class="material-symbols-outlined text-lg">delete</span>
                            </button>
                        </div>`;
                    }
                }
            ],
            drawCallback: function (settings) {
                const api = this.api();
                const counts = settings.json.counts;
                if (counts) {
                    $('#stat-active-services').text(counts.active);
                    $('#stat-inactive-services').text(counts.inactive);
                }
            }
        });

        // Service Filters
        $('select[name="filter_category"]').on('change', function () {
            servicesTable.column(1).search(this.value).draw();
        });
        $('input[name="search_services"]').on('input', function () {
            servicesTable.search(this.value).draw();
        });

        // Add Service Click
        $('#add-service-btn').on('click', function () {
            if (window.openServiceModal) window.openServiceModal('add');
        });

        // Edit Service Click
        $('#services-table').on('click', '.edit-service-btn', function () {
            const uuid = $(this).data('uuid');
            // Fetch single service details
            $.get(apiUrl('shared') + "services.php", { action: 'single', uuid: uuid }, function (response) {
                if (!response.success) return false;
                const modalData = response.data;
                window.openServiceModal('edit', modalData);
            });
        });

        // Delete Service Click
        $('#services-table').on('click', '.delete-service-btn', function () {
            if (!confirm('Are you sure you want to delete this service?')) return;
            const uuid = $(this).data('uuid');
            $.ajax({
                url: servicesActionUrl + '?uuid=' + uuid, // Pass UUID as query param for simple DELETE
                method: 'DELETE',
                success: function (res) {
                    servicesTable.ajax.reload();
                    // Update stats logic here if needed
                }
            });
        });

        // Service Saved Event
        $(document).on('service-saved', function () {
            servicesTable.ajax.reload();
        });
    });
</script>