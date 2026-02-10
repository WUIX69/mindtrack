<script>
    // Example usage, this can be re-usable for or tables that uses DataTables
    const $usersDataTable = $usersTable.DataTable({
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
        // stateSave: true,
        responsive: true,
        processing: true,
        serverSide: true,
        searching: true,
        orderCellsTop: true,
        autoWidth: false,
        scrollCollapse: true,
        scrollX: true,
        scrollY: "565px",
        language: {
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            lengthMenu: "Entries per page _MENU_",
            processing: '<div class="ui active inline elastic loader"></div>',
            infoEmpty: "No entries to show",
            emptyTable: `
            <div class="ui placeholder segment">
                <div class="ui icon header">
                    <i class="search icon"></i>
                    No Users Found
                </div>
                <div class="ui primary button">Add New User</div>
            </div>
        `,
        },
        columns: [
            {
                data: null,
                render: function (data) {
                    return `
                    <div class="user-details">
                        <img class="ui avatar image" src="${data.profile}" alt="${data.name}" />
                        <div class="info d-flex flex-column">
                            <span class="text-capitalize">${data.name}</span>
                            <small>ID: ${data.user_uuid}</small>
                        </div>
                    </div>
                `;
                },
            },
            { data: "email" },
            { data: "role", orderable: false },
            { data: "location" },
            { data: "telephone" },
            { data: "dob" },
            { data: "created_at" },
            {
                data: null,
                orderable: false,
                render: function (data) {
                    return `
                    <div class="ui compact floating selection dropdown actions-dd">
                        <i class="dropdown icon"></i>
                        <div class="text">Actions</div>
                        <div class="menu">
                            <div class="item" data-value="view"><i class="eye icon"></i> View</div>
                            <div class="item" data-value="edit"><i class="edit blue icon"></i> Edit</div>
                            <div class="item" data-value="delete"><i class="trash alternate outline red icon"></i> Delete</div>
                        </div>
                    </div>
                `;
                },
            },
        ],
        ajax: {
            url: apiUrl("users") + "usersDataTable.php",
            method: "GET",
            dataType: "json",
            data: function (d) {
                return d;
            },
            dataSrc: function (response) {
                // console.log(response);
                // return false;
                return response.data;
            },
            error: ajaxErrorHandler,
        },
        drawCallback: function (settings) {
            $(this).find(".ui.dropdown").dropdown();
            $(this)
                .find(".actions-dd")
                .dropdown({
                    onChange: function (value) {
                        console.log(value);

                        // Get the category ID on its tr
                        const userUuid =
                            $(this).closest(".user-item").data("user-uuid") ?? null;

                        if (value === "view") {
                            singleUserWhereView(userUuid);
                        } else if (value === "edit") {
                            singleUserWhereEdit(userUuid);
                        } else if (value === "delete") {
                            deleteUser(userUuid);
                        } else {
                            return false;
                        }
                    },
                });
        },
        initComplete: function (settings, json) {
            // this.api().columns().every(function () {
            //     $(this.header()).css('position', 'static');
            // });
            // Bind search event
            // $('.user-search input').on('keyup', _.debounce(function () {
            //     const searchQuery = $(this).val().trim();
            //     $usersDataTable.search(searchQuery).draw();
            // }, 300));
        },
    });

    $(function () {
        // Code here...
    });
</script>