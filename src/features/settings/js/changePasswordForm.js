$(function () {
    // console.log("changePassForm");
    $("#changePasswordForm").form({
        fields: {
            current_password: {
                identifier: "current_password",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter your current password",
                    },
                ],
            },
            new_password: {
                identifier: "new_password",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter your new password",
                    },
                    {
                        type: "minLength[6]",
                        prompt: "Your new password must be at least 6 characters",
                    },
                ],
            },
            confirm_new_password: {
                identifier: "confirm_new_password",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please confirm your new password",
                    },
                    {
                        type: "match[new_password]",
                        prompt: "Passwords do not match",
                    },
                ],
            },
        },
        inline: true,
        on: "submit",
        onSuccess: function (event, fields) {
            event.preventDefault();
            const $submitBtn = $(this).find("button[type=submit]");

            // console.log(fields);
            // return false;

            $.ajax({
                url: apiUrl("settings") + "changePassword.php",
                method: "POST",
                data: fields,
                dataType: "json",
                timeout: 5000,
                beforeSend: function () {
                    $submitBtn.addClass("loading");
                },
                success: function (response) {
                    console.log("API Response:", response);
                    alert(response.message);
                    // Optionally reset the form or handle UI updates here
                },
                complete: function () {
                    $submitBtn.removeClass("loading");
                },
                error: ajaxErrorHandler,
            });
        },
    });
});
