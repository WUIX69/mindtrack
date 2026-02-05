// service Categories Table
const serviceCategorySection = $("section.categories-table");
const categoriesTableBody = serviceCategorySection.find("table tbody");

// service Category Modal
const serviceCategoryModal = $("#serviceCategoryModal");
const serviceCategoryModalForm = serviceCategoryModal.find("form");

function serviceCategoriesAjax(options) {
    // Set default URL prefix and headers
    let url = apiUrl("shared") + "categories.php";
    if (options.urlParams) {
        url += "?" + $.param(options.urlParams);
    }

    const defaultOptions = {
        url: url,
        headers: {
            "X-Reference-Model": "services",
        },
        dataType: "json",
        timeout: 5000,
        error: ajaxErrorHandler,
    };
    // Merge defaults with user options (user options take precedence)
    const finalOptions = $.extend(true, {}, defaultOptions, options);
    return $.ajax(finalOptions);
}

function getAllServiceCategories() {
    categoriesTableBody.empty();

    serviceCategoriesAjax({
        method: "GET",
        data: { action: "all" },
        success: function (response) {
            // console.log("API Response:", response);
            // return false;

            if (!response.success) {
                alert(response.message);
                return false;
            }

            const categories = response.data;
            let categoriesHTML = "";

            categories.forEach((item) => {
                categoriesHTML += `
                    <tr class="service-category-item" data-category-id="${
                        item.id
                    }">
                        <td><i class="${item.icon} icon"></i></td>
                        <td>${item.name}</td>
                        <td>${item.description}</td>
                        <td>
                            <span class="text-capitalize category-status ${
                                item.status === "active" ? "active" : "inactive"
                            }">
                                <i class="${
                                    item.status === "active"
                                        ? "check circle green"
                                        : "times circle red"
                                } icon"></i>
                                ${item.status}
                            </span>
                        </td>
                        <td>
                            <div class="ui compact floating selection dropdown actions-dd">
                                <i class="dropdown icon"></i>
                                <div class="text">Actions</div>
                                <div class="menu">
                                    <div class="item" data-value="view"><i class="eye icon"></i>View</div>
                                    <div class="item" data-value="edit"><i class="edit blue icon"></i>Edit</div>
                                    <div class="item" data-value="delete"><i class="trash alternate outline red icon"></i>Delete</div>
                                </div>
                            </div>
                        </td>
                    </tr>
                `;
            });

            categoriesTableBody.append(categoriesHTML);
        },
        complete: function () {
            // Add event listener to dropdown
            categoriesTableBody.find(".ui.dropdown").dropdown();
            categoriesTableBody.find(".actions-dd").dropdown({
                onChange: function (value) {
                    // console.log(value);

                    // Get the category ID on its tr
                    const categoryId = $(this)
                        .closest(".service-category-item")
                        .data("category-id");

                    if (value === "view" || value === "edit") {
                        getSingleServiceCategory(categoryId);
                    } else if (value === "delete") {
                        deleteServiceCategory(categoryId);
                    } else {
                        return false;
                    }
                },
            });
        },
    });
}

function getSingleServiceCategory(categoryId = null) {
    if (!categoryId) return false;

    serviceCategoriesAjax({
        method: "GET",
        data: {
            action: "single",
            id: categoryId,
        },
        success: function (response) {
            // console.log("API Response:", response);
            // return false;

            if (!response.success) {
                alert(response.message);
                return false;
            }

            // Populate the form fields
            const category = response.data;
            $.each(category, function (key, value) {
                // console.log(key, value);
                serviceCategoryModalForm
                    .find('[name="' + key + '"]')
                    .val(value);
            });

            // Show the modal
            serviceCategoryModal.modal("show");
        },
    });
}

function deleteServiceCategory(categoryId = null) {
    if (!categoryId) return false;

    // console.log(categoryId);
    // return false;

    serviceCategoriesAjax({
        urlParams: { id: categoryId },
        method: "DELETE",
        success: function (response) {
            // console.log("API Response:", response);
            // return false;

            alert(response.message);
            if (!response.success) return false;
            getAllServiceCategories(); // Refresh the service categories data
        },
    });
}

$(function () {
    getAllServiceCategories();

    // Get Single service Category and open modal
    $("body").on("click", ".service-category-item", function (e) {
        if (e.target.closest(".ui.dropdown")) return false;
        const categoryId = $(this).data("category-id");
        getSingleServiceCategory(categoryId);
    });

    // Validate service Category Modal Form
    serviceCategoryModalForm.form({
        fields: {
            icon: {
                identifier: "icon",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please select an icon",
                    },
                ],
            },
            name: {
                identifier: "name",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter a name",
                    },
                ],
            },
            description: {
                identifier: "description",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter a description",
                    },
                ],
            },
            status: {
                identifier: "status",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please select a status",
                    },
                ],
            },
        },
        inline: true,
        on: "blur", // EG: submit, blur
        onSuccess: function (event, fields) {
            event.preventDefault();
            const $submitBtn = $(this).find("button[type=submit]");

            // console.log(fields);
            // return false;

            // api
            serviceCategoriesAjax({
                method: "POST",
                data: {
                    action: fields.id ? "update" : "store", // If id is present use update, otherwise use store
                    ...fields,
                },
                beforeSend: function () {
                    $submitBtn.addClass("loading");
                },
                success: function (response) {
                    // console.log("API Response:", response);
                    // return false;

                    alert(response.message);
                    getAllServiceCategories(); // Refresh the product categories data
                    serviceCategoryModal.modal("hide");
                },
                complete: function () {
                    $submitBtn.removeClass("loading");
                },
            });
        },
    });
});
