// Products Table variables
const productSection = $("section.products-table");
const productsTableBody = productSection.find("table tbody");

// Product Modal variables
const productModal = $("#productModal");
const productModalForm = productModal.find("form");

// Filepond Flags (Required)
let isModalHide = false;
let isPondRender = false;

// Product Image FilePond
const productImagePond = FilePond.create(
    document.querySelector(".product-pond"),
    {
        maxFiles: 2,
        maxFileSize: "2MB",
        allowMultiple: true,
        allowFileTypes: ["image/*"],
        labelIdle: `Drag & Drop your image or <span class="filepond--label-action">Browse</span>`,
        imagePreviewHeight: 170,
        imageCropAspectRatio: "1:1",
        imageResizeTargetWidth: 200,
        imageResizeTargetHeight: 200,
        onprocessfile: function (error, file) {
            // console.log("On Process Files:", file);
        },
        onaddfile: function (error, file) {
            // console.log("On Add File:", file);
        },
        onremovefile: function (error, file) {
            // console.log("On Remove File:", file);

            // Only handle "local" files (already on server) and only if not modal hide
            if (file.origin === 3 && !isModalHide) {
                console.log("is local delete");
                $.ajax({
                    url: apiUrl("shared") + "filepond.php",
                    headers: {
                        "X-Reference-Model": "products",
                    },
                    method: "DELETE",
                    data: file.serverId,
                    processData: false,
                    contentType: false,
                    error: ajaxErrorHandler,
                });
            }
        },
        onupdatefiles: function (files) {
            // const totalFileSize = files.reduce(
            //     (total, file) => total + file.fileSize,
            //     0
            // );
            // const showErrorState = totalFileSize > 26214400; // 25MB in bytes
            // console.log({ totalFileSize, showErrorState });
        },
        server: {
            url: apiUrl() + "filepond.php",
            headers: {
                "X-Reference-Model": "products",
            },
            timeout: 7000,
            withCredentials: false,
            process: {
                url: "",
            },
            revert: {
                url: "",
            },
            load: {
                url: "?folder=",
            },
        },
    }
);

function getAllProducts() {
    productsTableBody.empty();

    $.ajax({
        url: apiUrl("products") + "products.php",
        method: "GET",
        data: {
            action: "all",
        },
        dataType: "json",
        timeout: 5000,
        success: function (response) {
            // console.log("API Response:", response);
            // return false;

            if (!response.success) {
                alert(response.message);
                return false;
            }

            const products = response.data;
            let productsHTML = "";

            products.forEach((product, idx) => {
                productsHTML += `
                    <tr class="product-item" data-product-uuid="${product.uuid}">
                        <td>
                            <img src="${product.image}" alt="Product" class="product-image">
                        </td>
                        <td class="product-name">${product.name}</td>
                        <td class="product-category">
                            <i class="${product.category.icon} icon"></i>
                            ${product.category.label}
                        </td>
                        <td class="product-price">&#8369; ${product.og_price}</td>
                        <td class="product-stock">${product.stock}</td>
                        <td>
                            <span class="text-capitalize product-status ${product.status.label}">
                                <i class="${product.status.icon} icon"></i>
                                ${product.status.label}
                            </span>
                        </td>
                        <td>
                            <span class="text-capitalize product-tags">
                                ${product.tags}
                            </span>
                        </td>
                        <td>
                            <span class="text-capitalize product-specs">
                                ${product.specs}
                            </span>
                        </td>
                        <td>
                            ${product.created_at}
                        </td>
                        <td>
                            ${product.updated_at}
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

            productsTableBody.append(productsHTML);
        },
        complete: function () {
            // Add event listener to dropdown
            productsTableBody.find(".ui.dropdown").dropdown();
            productsTableBody.find(".actions-dd").dropdown({
                onChange: function (value) {
                    // console.log(value);

                    // Get the category ID on its tr
                    const productUuid = $(this)
                        .closest(".product-item")
                        .data("product-uuid");

                    if (value === "view" || value === "edit") {
                        getSingleProduct(productUuid);
                    } else if (value === "delete") {
                        deleteProduct(productUuid);
                    } else {
                        return false;
                    }
                },
            });
        },
        error: ajaxErrorHandler,
    });
}

function getSingleProduct(productUuid = null) {
    if (!productUuid) return false;
    // loadExistingFiles(productUuid);

    $.ajax({
        url: apiUrl("products") + "products.php",
        method: "GET",
        data: {
            action: "single",
            uuid: productUuid,
        },
        dataType: "json",
        timeout: 5000,
        success: function (response) {
            // console.log("API Response:", response);
            // return false;

            if (!response.success) {
                alert(response.message);
                return false;
            }

            // Populate the form fields
            const product = response.data;
            $.each(product, function (key, value) {
                if (key === "files") {
                    // Prevent FilePond from deleting files when modal is hidden and !empty files
                    if (value.length > 0) isPondRender = true;

                    // Add files to FilePond
                    value.forEach(function (file) {
                        productImagePond
                            .addFile(file.folder, {
                                type: "local",
                                options: {
                                    file: {
                                        name: file.filename,
                                    },
                                    metadata: {
                                        serverId: file.folder,
                                    },
                                },
                            })
                            .then(function (fileItem) {
                                // console.log("Added fileItem:", fileItem);
                            });
                    });
                } else {
                    productModalForm.find('[name="' + key + '"]').val(value);
                }
            });

            // Show the modal
            productModal.modal("show");
        },
        error: ajaxErrorHandler,
    });
}

function deleteProduct(productUuid = null) {
    if (!productUuid) return false;

    // console.log(productUuid);
    // return false;

    $.ajax({
        url: apiUrl("products") + "products.php?uuid=" + productUuid,
        method: "DELETE",
        dataType: "json",
        timeout: 5000,
        success: function (response) {
            // console.log("API Response:", response);
            // return false;

            alert(response.message);
            if (!response.success) return false;
            getAllProducts(); // Refresh the products data
        },
        error: ajaxErrorHandler,
    });
}

$(function () {
    // Get all products on page load
    getAllProducts();

    // Get Single Product and open modal
    $("body").on("click", ".product-item", function (e) {
        if (e.target.closest(".ui.dropdown")) return false;
        const productUuid = $(this).data("product-uuid");
        getSingleProduct(productUuid);
    });

    // Remove files from FilePond when modal is hidden
    productModal.modal("setting", "onHide", function () {
        isModalHide = true;
        if (!isPondRender) {
            // Delete files from storage and FilePond
            productImagePond.removeFiles({ revert: true });
        } else {
            // Delete files from FilePond UI
            productImagePond.removeFiles();
            // Reset the flag for next time
            isPondRender = false;
        }
    });

    // Validate Product Modal Form
    productModalForm.form({
        fields: {
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
            og_price: {
                identifier: "og_price",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter an original price",
                    },
                    {
                        type: "decimal",
                        prompt: "Please enter a valid original price",
                    },
                ],
            },
            dc_price: {
                identifier: "dc_price",
                optional: true,
                rules: [
                    {
                        type: "decimal",
                        prompt: "Please enter a valid discounted price",
                    },
                ],
            },
            stock: {
                identifier: "stock",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter stock quantity",
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
            category_id: {
                identifier: "category_id",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please select a category",
                    },
                ],
            },
            tags: {
                identifier: "tags",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please select a tag",
                    },
                    {
                        type: "minCount[2]",
                        prompt: "Please select at least 2 tags",
                    },
                ],
            },
            specs: {
                identifier: "specs",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please select a spec",
                    },
                    {
                        type: "minCount[2]",
                        prompt: "Please select at least 2 specs",
                    },
                ],
            },
        },
        inline: true,
        on: "submit",
        onSuccess: function (event, fields) {
            event.preventDefault();
            const $submitBtn = $(this).find("button[type=submit]");
            const formData = new FormData(productModalForm[0]);

            let action = "store";
            if (formData.get("uuid")) action = "update";
            formData.append("action", action);

            // Collect all FilePond serverIds (folder names)
            let files = productImagePond.getFiles().map((f) => f.serverId);
            formData.set("files", files.join(","));
            formData.delete("file");

            // console.log(formData);
            // return false;

            $.ajax({
                url: apiUrl("products") + "products.php", // Change to your actual products endpoint if needed
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                timeout: 5000,
                beforeSend: function () {
                    $submitBtn.addClass("loading");
                },
                success: function (response) {
                    // console.log(response);
                    // return false;

                    alert(response.message);
                    getAllProducts(); // Refresh the products data
                    isPondRender = true; // Set the flag BEFORE hiding the modal, For FilePond to know that the form is submitting on hide
                    productModal.modal("hide");
                },
                complete: function () {
                    $submitBtn.removeClass("loading");
                },
                error: ajaxErrorHandler,
            });
        },
    });
});
