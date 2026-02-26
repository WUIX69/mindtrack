<?= shared('components', 'elements/dataTables/styles') ?>

<!-- 4. Security & Access -->
<section class="">
    <div class="py-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-2xl">admin_panel_settings</span>
                <h3 class="font-bold text-lg text-foreground">Administrators</h3>
            </div>
            <?= shared('components', 'layout/filterbar', [
                'isTransparent' => true,
                'mb' => '0',
                'secondary_filters' => [
                    [
                        'type' => 'search',
                        'name' => 'search',
                        'placeholder' => 'Search admin users...',
                        'icon' => 'search'
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
    </div>
    <div class="bg-card rounded-xl border border-border shadow-sm overflow-hidden mb-12">
        <div class="overflow-x-auto">
            <table id="admin-users-table" class="w-full text-left display responsive nowrap" style="width:100%">
                <thead>
                    <tr class="text-xs uppercase tracking-wider text-muted-foreground bg-muted/50">
                        <th class="px-6 py-3 font-semibold !p-5">User</th>
                        <th class="px-6 py-3 font-semibold !p-5 hidden md:table-cell">Contact</th>
                        <th class="px-6 py-3 font-semibold !p-5">Status</th>
                        <th class="px-6 py-3 font-semibold !p-5 hidden sm:table-cell">Role</th>
                        <th class="px-6 py-3 font-semibold !p-5 hidden lg:table-cell">Dates</th>
                        <th class="px-6 py-3 font-semibold !p-5 text-right w-24">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/50">
                </tbody>
            </table>
        </div>

        <div class="p-4 bg-muted/10 text-center border-t border-border">
            <button onclick="openAdminUserModal('add')"
                class="text-xs font-bold text-primary flex items-center justify-center gap-2 w-full hover:underline transition-all">
                <span class="material-symbols-outlined text-sm">add</span> Add New User
            </button>
        </div>
    </div>
</section>

<!-- Manage Admin Users Modal -->
<?= featured('settings', 'components/manage-admin-users-modal'); ?>

<?= shared('components', 'elements/dataTables/scripts') ?>
<script>
    $(document).ready(function () {
        window.allAdminUsers = window.allAdminUsers || [];

        const table = $('#admin-users-table').DataTable({
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
            order: [[5, 'desc']], // Default sort by created_at (Joined)
            orderCellsTop: true,
            autoWidth: false,
            language: {
                info: "Showing _START_ to _END_ of _TOTAL_ users",
                lengthMenu: "Entries per page _MENU_",
                infoEmpty: "No users found",
                emptyTable: "No users found.",
                zeroRecords: "No matching users found"
            },
            columns: [
                {
                    data: 'firstname',
                    className: "px-6 py-4",
                    render: function (data, type, row) {
                        const fullName = `${row.firstname} ${row.lastname}`;
                        const initials = (row.firstname?.[0] || '') + (row.lastname?.[0] || '');

                        const verificationBadge = parseInt(row.is_email_verified) === 1
                            ? `<span class="material-symbols-outlined text-[13px] text-green-500" title="Email Verified">verified</span>`
                            : `<span class="material-symbols-outlined text-[13px] text-orange-400" title="Email Unverified">pending</span>`;

                        return `
                        <div class="flex items-center gap-3">
                            <div class="size-8 rounded bg-primary/10 text-primary flex items-center justify-center font-bold text-xs shrink-0">
                                ${initials.toUpperCase()}
                            </div>
                            <div>
                                <p class="font-semibold text-foreground">${fullName}</p>
                                <p class="text-[11px] text-muted-foreground flex items-center gap-1">${row.email} ${verificationBadge}</p>
                            </div>
                        </div>`;
                    }
                },
                {
                    data: 'phone',
                    className: "px-6 py-4 hidden md:table-cell",
                    render: function (data) {
                        return `<span class="text-sm text-foreground">${data || '<span class="text-muted-foreground italic text-xs">Not provided</span>'}</span>`;
                    }
                },
                {
                    data: 'status',
                    className: "px-6 py-4",
                    render: function (data) {
                        let statusClass = 'bg-muted text-muted-foreground';
                        let statusLabel = (data || 'Unknown').charAt(0).toUpperCase() + (data || 'unknown').slice(1);

                        if (data === 'active') {
                            statusClass = 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400';
                        } else if (data === 'inactive') {
                            statusClass = 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400';
                        }

                        return `<span class="px-2 py-0.5 rounded text-[11px] font-bold inline-block ${statusClass}">${statusLabel}</span>`;
                    }
                },
                {
                    data: 'role',
                    className: "px-6 py-4 hidden sm:table-cell",
                    render: function (data) {
                        const roleLabel = (data || 'Unknown').toUpperCase();
                        return `<span class="px-2 py-0.5 rounded text-[11px] font-bold bg-primary/10 text-primary border border-primary/20 inline-block">${roleLabel}</span>`;
                    }
                },
                {
                    data: 'created_at',
                    className: "px-6 py-4 hidden lg:table-cell",
                    render: function (data, type, row) {
                        const createdStr = data ? new Date(data).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : '-';
                        const updatedStr = row.updated_at ? new Date(row.updated_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) : '-';
                        return `
                            <div class="flex flex-col gap-0.5">
                                <span class="text-xs text-foreground"><span class="text-muted-foreground">Joined:</span> ${createdStr}</span>
                                <span class="text-[10px] text-muted-foreground">Updated: ${updatedStr}</span>
                            </div>
                        `;
                    }
                },
                {
                    data: 'uuid',
                    className: "px-6 py-4 text-right w-24",
                    orderable: false,
                    render: function (data, type, row) {
                        return `
                            <div class="flex items-center justify-end gap-2">
                                <button onclick="openAdminUserModal('edit', '${data}')" class="p-1.5 text-muted-foreground hover:text-primary transition-colors rounded-md hover:bg-primary/10">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </button>
                                <button onclick="deleteAdminUser('${data}')" class="p-1.5 text-muted-foreground hover:text-error transition-colors rounded-md hover:bg-error/10">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            ajax: {
                url: apiUrl("settings") + "admin-users-dataTable.php",
                method: "GET",
                dataType: "json",
                data: function (d) {
                    return d;
                },
                dataSrc: function (response) {
                    // Update global store for modal usage
                    const users = response.data || [];
                    const currentMap = new Map(window.allAdminUsers.map(u => [u.uuid, u]));
                    users.forEach(u => currentMap.set(u.uuid, u));
                    window.allAdminUsers = Array.from(currentMap.values());

                    return users;
                },
                error: typeof ajaxErrorHandler !== 'undefined' ? ajaxErrorHandler : function (e) { console.error('DataTables load error', e); }
            }
        });

        // --- Filters Interactivity ---
        $(document).on('filter:change', function (e, filters) {
            if (filters.search !== undefined) {
                table.search(filters.search);
            }

            if (filters.status !== undefined) {
                table.column(2).search(filters.status);
            }

            if (filters.sortby !== undefined) {
                switch (filters.sortby) {
                    case 'newest':
                        table.order([4, 'desc']);
                        break;
                    case 'oldest':
                        table.order([4, 'asc']);
                        break;
                    case 'name_asc':
                        table.order([0, 'asc']);
                        break;
                    case 'name_desc':
                        table.order([0, 'desc']);
                        break;
                    default:
                        table.order([4, 'desc']); // Default
                        break;
                }
            }

            table.draw();
        });

        window.fetchAdminUsers = function () {
            table.ajax.reload(null, false);
        };

        window.deleteAdminUser = function (uuid) {
            if (confirm("Are you sure you want to delete this admin user? This action cannot be undone.")) {
                $.ajax({
                    url: apiUrl("settings") + 'manage-admin-users.php?uuid=' + uuid,
                    type: 'DELETE',
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            window.fetchAdminUsers();
                            // Optional: show a toast notification here
                        } else {
                            alert(response.message || 'An error occurred while deleting.');
                        }
                    },
                    error: function (xhr) {
                        alert('Server error: ' + (xhr.responseJSON?.message || xhr.statusText));
                    }
                });
            }
        };
    });
</script>