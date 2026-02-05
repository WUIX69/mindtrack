function getProfile() {
    $.ajax({
        url: apiUrl("settings") + "profileGet.php",
        method: "GET",
        data: {},
        dataType: "json",
        timeout: 5000,
        beforeSend: function () {
            // Code here...
        },
        success: function (response) {
            // console.log(response);
            // return false;

            $.each(response.data, function (name, value) {
                if (name == "urls") {
                    const urlInputs = $(".url-inputs");
                    if (value.length > 0) urlInputs.empty();

                    value.forEach((url) =>
                        urlInputs.append(
                            `<input type="url" placeholder="Enter your URL" name="urls[]" value="${url}">`
                        )
                    );
                } else if (name == "profile") {
                    if (value && Object.keys(value).length !== 0) {
                        window.profilePond.addFile(value.folder, {
                            type: "local",
                            options: {
                                file: {
                                    name: value.filename,
                                },
                                metadata: {
                                    name: value.filename,
                                    serverId: value.folder,
                                },
                            },
                        });
                    }
                } else {
                    // Populate normal input fields
                    $(`[name="${name}"]`).val(value);
                }
            });
        },
        complete: function () {
            // Code here...
        },
        error: ajaxErrorHandler,
    });
}
$(function () {
    getProfile();
});
