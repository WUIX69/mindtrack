// services Table variables
const serviceSection = $("section.services-table");
const servicesTableBody = serviceSection.find("table tbody");

// service Modal variables
const serviceModal = $("#serviceModal");
const serviceModalForm = serviceModal.find("form");

// Filepond Flags (Required)
let isModalHide = false;
let isPondRender = false;

// Service Image FilePond
const serviceImagePond = FilePond.create(
    document.querySelector(".service-pond"),
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
                        "X-Reference-Model": "services",
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
                "X-Reference-Model": "services",
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

function getAllServices() {
    servicesTableBody.empty();

    $.ajax({
        url: apiUrl("services") + "services.php",
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

            const services = response.data;
            let servicesHTML = "";

            services.forEach((service, idx) => {
                servicesHTML += `
                    <tr class="service-item" data-service-uuid="${service.uuid}">
                        <td>
                            <img class="service-img" src="${service.image}" alt="Services">
                        </td>
                        <td>${service.name}</td>
                        <td>
                            ${service.description}
                        </td>
                        <td>&#8369; ${service.price}</td>
                        <td>${service.duration}</td>
                        <td>
                            <i class="${service.category.icon} icon"></i>
                            ${service.category.label}
                        </td>
                       <td>
                            <span class="text-capitalize service-status ${service.status.label}">
                                <i class="${service.status.icon} icon"></i>
                                ${service.status.label}
                            </span>
                        </td>
                        <td>
                            ${service.created_at}
                        </td>
                        <td>
                            ${service.updated_at}
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

            servicesTableBody.append(servicesHTML);
        },
        complete: function () {
            // Add event listener to dropdown
            servicesTableBody.find(".ui.dropdown").dropdown();
            servicesTableBody.find(".actions-dd").dropdown({
                onChange: function (value) {
                    // console.log(value);

                    // Get the category ID on its tr
                    const serviceUuid = $(this)
                        .closest(".service-item")
                        .data("service-uuid");

                    if (value === "view" || value === "edit") {
                        getSingleService(serviceUuid);
                    } else if (value === "delete") {
                        deleteService(serviceUuid);
                    } else {
                        return false;
                    }
                },
            });
        },
        error: ajaxErrorHandler,
    });
}

function getSingleService(serviceUuid = null) {
    if (!serviceUuid) return false;
    // loadExistingFiles(serviceUuid);

    $.ajax({
        url: apiUrl("services") + "services.php",
        method: "GET",
        data: {
            action: "single",
            uuid: serviceUuid,
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
            const service = response.data;
            $.each(service, function (key, value) {
                if (key === "files") {
                    // Prevent FilePond from deleting files when modal is hidden and !empty files
                    if (value.length > 0) isPondRender = true;

                    // Add files to FilePond
                    value.forEach(function (file) {
                        serviceImagePond
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
                    serviceModalForm.find('[name="' + key + '"]').val(value);
                }
            });

            // Show the modal
            serviceModal.modal("show");
        },
        error: ajaxErrorHandler,
    });
}

function deleteService(serviceUuid = null) {
    if (!serviceUuid) return false;

    // console.log(serviceUuid);
    // return false;

    $.ajax({
        url: apiUrl("services") + "services.php?uuid=" + serviceUuid,
        method: "DELETE",
        dataType: "json",
        timeout: 5000,
        success: function (response) {
            // console.log("API Response:", response);
            // return false;

            alert(response.message);
            if (!response.success) return false;
            getAllServices(); // Refresh the services data
        },
        error: ajaxErrorHandler,
    });
}

$(function () {
    getAllServices();

    // Get Single service and open modal
    $("body").on("click", ".service-item", function (e) {
        if (e.target.closest(".ui.dropdown")) return false;
        const serviceUuid = $(this).data("service-uuid");
        getSingleService(serviceUuid);
    });

    // Remove files from FilePond when modal is hidden
    serviceModal.modal("setting", "onHide", function () {
        isModalHide = true;
        if (!isPondRender) {
            // Delete files from storage and FilePond
            serviceImagePond.removeFiles({ revert: true });
        } else {
            // Delete files from FilePond UI
            serviceImagePond.removeFiles();
            // Reset the flag for next time
            isPondRender = false;
        }
    });

    // Validate service Modal Form
    serviceModalForm.form({
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
            price: {
                identifier: "price",
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
            duration: {
                identifier: "duration",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter an original price",
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
        },
        inline: true,
        on: "submit",
        onSuccess: function (event, fields) {
            event.preventDefault();
            const $submitBtn = $(this).find("button[type=submit]");
            const formData = new FormData(serviceModalForm[0]);

            let action = "store";
            if (formData.get("uuid")) action = "update";
            formData.append("action", action);

            // Collect all FilePond serverIds (folder names)
            let files = serviceImagePond.getFiles().map((f) => f.serverId);
            formData.set("files", files.join(","));
            formData.delete("file");

            // console.log(formData);
            // return false;

            $.ajax({
                url: apiUrl("services") + "services.php", // Change to your actual services endpoint if needed
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
                    getAllServices(); // Refresh the service data
                    isPondRender = true; // Set the flag BEFORE hiding the modal, For FilePond to know that the form is submitting on hide
                    serviceModal.modal("hide");
                },
                complete: function () {
                    $submitBtn.removeClass("loading");
                },
                error: ajaxErrorHandler,
            });
        },
    });
});
