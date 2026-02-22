<!-- Profile Photo -->
<style>
    .filepond--root :not(text) {
        font-size: 14px;
    }
</style>
<div class="flex flex-col items-center gap-4">
    <div class="relative group">
        <div class="w-32 h-32 rounded-full bg-cover bg-center border-4 border-background dark:border-border shadow-md">
            <input type="file" class="filepond profile-pond ignore" name="profile">
        </div>
    </div>
    <p class="text-xs text-muted-foreground font-medium text-center">Update your profile photo
    </p>
</div>
<script>
    $(document).ready(function () {
        const profilePond = FilePond.create(document.querySelector(".profile-pond"), {
            maxFiles: 1,
            maxFileSize: "2MB",
            instantUpload: false,
            allowMultiple: false,
            allowFileTypes: ["image/*"],

            labelIdle: `Drag & Drop your picture or <span class="filepond--label-action">Browse</span>`,

            imagePreviewHeight: 170,
            imageCropAspectRatio: "1:1",
            imageResizeTargetWidth: 200,
            imageResizeTargetHeight: 200,

            stylePanelLayout: "compact circle",
            styleLoadIndicatorPosition: "center bottom",
            styleProgressIndicatorPosition: "right bottom",
            styleButtonRemoveItemPosition: "left bottom",
            styleButtonProcessItemPosition: "right bottom",
            onremovefile: function (error, file) {
                // console.log(error, file);
                // Only handle "local" files (already on server) and only if not modal hide
                if (file.origin === 3) {
                    console.log("is local delete");
                    $.ajax({
                        url: apiUrl("shared") + "filepond.php",
                        headers: {
                            "X-Reference-Model": "profiles",
                        },
                        method: "DELETE",
                        data: file.serverId,
                        processData: false,
                        contentType: false,
                        error: ajaxErrorHandler,
                    });
                }
            },
        });

        // Set server configuration
        profilePond.setOptions({
            server: {
                headers: {
                    "X-Reference-Model": "profiles",
                },
                timeout: 7000,
                withCredentials: false,
                credit: false,
                process: {
                    url: apiUrl("settings") + "profile-post.php",
                    method: "POST",
                    ondata: function (formData) {
                        formData.append("action", "profile-upload");
                        return formData;
                    },
                    onload: (jsonResponse) => {
                        const response = JSON.parse(jsonResponse);
                        alert(response.message);

                        // Update all visible img src that uses profile photo with fade animation
                        $("img.user-profile-photo").fadeOut(300, function () {
                            $(this)
                                .attr("src", response.data.profile_url)
                                .fadeIn(300);
                        });

                        return response.data.folder; // filepond needs the unique foldername
                    },
                },
                revert: {
                    url: apiUrl("shared") + "filepond.php",
                },
                load: {
                    url: apiUrl("shared") + "filepond.php?folder=",
                },
            },
        });

        // Export profilePond to window for debugging
        window.profilePond = profilePond;
    });
</script>