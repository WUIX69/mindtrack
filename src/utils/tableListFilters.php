<script>
    function tableListBaseFilters($dataTable = null) {
        let isResetBaseFilters = false;

        const $tableListBaseFilters = $(".table-list .base-filters");
        const $tableListBaseFiltersResetBtn =
            $tableListBaseFilters.find(".filter-reset-btn");

        const showTblBfResetBtn = () => {
            return $tableListBaseFiltersResetBtn.show();
        };
        const hideTblBfResetBtn = () => {
            return $tableListBaseFiltersResetBtn.hide();
        };

        $tableListBaseFiltersResetBtn.on("click", function () {
            isResetBaseFilters = true; // Set flag to true

            $tableListBaseFilters.find(".ui.dropdown").dropdown("restore defaults");
            $tableListBaseFilters.find(".ui.search input").val("");
            hideTblBfResetBtn();
            if ($dataTable) $dataTable.search(null).draw();

            isResetBaseFilters = false; // Reset flag to false after use
        });

        $tableListBaseFilters.find(".ui.dropdown").dropdown({
            onChange: function (value) {
                if (isResetBaseFilters) return; // Prevent multiple resets

                showTblBfResetBtn();
                if (value === "clear") {
                    $(this).dropdown("reset defaults");
                    return false;
                }
            },
        });

        $tableListBaseFilters.find(".ui.search input").on(
            "keyup",
            _.debounce(function () {
                let value = $(this).val().trim();
                if ($dataTable) $dataTable.search(value).draw();

                let isAnyDropdownActive =
                    $tableListBaseFilters.find(".ui.dropdown .item.active.selected")
                        .length > 0;
                if (!value && !isAnyDropdownActive) {
                    hideTblBfResetBtn();
                } else {
                    showTblBfResetBtn();
                }
            }, 500),
        );
    }

    $(function () {
        // Code here...
    });
</script>