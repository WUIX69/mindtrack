const $userFlyout = $("#userFlyout");

const $usersTable = $("#usersTable");
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

function singleUserWhereEdit(userUuid = null) {
    if (!userUuid) return false;
    $.ajax({
        url: apiUrl("users") + "users.php",
        method: "GET",
        data: { action: "singleWhereEdit", uuid: userUuid },
        success: function (response) {
            // console.log(response);
            // return false;

            if (!response.success) {
                alert(response.message);
                return false;
            }

            $userModal.find(".header").text("Edit User");
            $userModal.find("input[name='password']").prop("disabled", true);
            $userModalForm.form("set values", response.data);
            $userModal.modal("show");
        },
        error: ajaxErrorHandler,
    });
}

function singleUserWhereView(userUuid = null) {
    if (!userUuid) return false;
    $.ajax({
        url: apiUrl("users") + "users.php",
        method: "GET",
        data: { action: "singleWhereView", uuid: userUuid },
        success: function (response) {
            // console.log(response);
            // return false;

            if (!response.success) {
                alert(response.message);
                return false;
            }

            const flyoutContent = $userFlyout.find(".content");
            const userData = response.data;

            $.each(userData, function (key, value) {
                if (key === "profile") {
                    flyoutContent.find(`#profile`).attr("src", value);
                } else {
                    flyoutContent.find(`#${key}`).text(value);
                }
            });

            $userFlyout.flyout("show");
        },
        error: ajaxErrorHandler,
    });
}

function deleteUser(userUuid = null) {
    if (!userUuid) return false;
    $.ajax({
        url: apiUrl("users") + "users.php?user_uuid=" + userUuid,
        method: "DELETE",
        success: function (response) {
            // console.log(response);
            // return false;

            $usersDataTable.ajax.reload();
        },
        error: ajaxErrorHandler,
    });
}

$(function () {
    // Handle table list base filters
    tableListBaseFilters($usersDataTable);

    $("body").on("click", ".user-item", function (e) {
        if (e.target.closest(".ui.dropdown")) return false;
        const userUuid = $(this).data("user-uuid");
        singleUserWhereView(userUuid);
    });
});
