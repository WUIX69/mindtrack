<script>
    // Not used yet
    function initDataTables(options = {}) {
        const defaults = {
            table: null,
            data: {},
        };

        const config = { ...defaults, ...options };
        const $table = $(config.table);

        if (!$table || !$table.length) return false;
        // if ($table.DataTable()) $table.DataTable().destroy();

        $table.DataTable({
            dom: 't<"bottom-controls"<"info"i><"right-controls"l<"pagination"p>>>',
            pageLength: 10,
            deferRender: true,
            stateSave: true,
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            orderCellsTop: true,
            autoWidth: false,
            scrollCollapse: true,
            scrollX: true,
            scrollY: "500px",
            language: {
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                lengthMenu: "Entries per page _MENU_",
                processing: '<div class="ui active inline elastic loader"></div>',
                // infoEmpty: "No entries to show",
                // emptyTable: `
                //     <div class="ui placeholder segment">
                //         <div class="ui icon header">
                //             <i class="search icon"></i>
                //             No Users Found
                //         </div>
                //         <div class="ui primary button">Add New User</div>
                //     </div>
                // `,
            },
            columnDefs: config.columnDefs,
            columns: config.columns,
            ajax: {
                url: config.url,
                method: "GET",
                dataType: "json",
                data: config.data,
                dataSrc: function (response) {
                    response.recordsTotal = response.total;
                    response.recordsFiltered = response.total;
                    return config.map(response.users);
                },
                error: ajaxErrorHandler,
            },
            drawCallback: function (settings) {
                $(this).find(".ui.dropdown").dropdown();
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
    }

    $(function () {
        // Code here...
    });
</script>