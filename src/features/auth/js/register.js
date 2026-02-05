$(function () {
    $("#registerForm").form({
        fields: {
            firstname: {
                identifier: "firstname",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter your first name",
                    },
                ],
            },
            lastname: {
                identifier: "lastname",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter your last name",
                    },
                ],
            },
            email: {
                identifier: "email",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter your email",
                    },
                    {
                        type: "email",
                        prompt: "Please enter a valid email address",
                    },
                ],
            },
            password: {
                identifier: "password",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter your password",
                    },
                ],
            },
            confirm_password: {
                identifier: "confirm_password",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please confirm your password",
                    },
                    {
                        type: "match[password]",
                        prompt: "Passwords do not match",
                    },
                ],
            },
            terms: {
                identifier: "terms",
                rules: [
                    {
                        type: "checked",
                        prompt: "Please accept the terms and conditions",
                    },
                ],
            },
        },
        inline: true,
        on: "blur", // EG: submit, blur
        onSuccess: function (event, fields) {
            event.preventDefault();
            const $submitBtn = $(this).find("button[type=submit]");
            // const formData = new FormData(this); // Only use when a file is included

            // console.log(formData);
            // console.log(fields);
            // return false;

            $.ajax({
                url: apiUrl("auth") + "register.php",
                method: "POST",
                data: fields,
                // processData: false, // Only use when FormData is used
                // contentType: false, // Only use when FormData is used
                dataType: "json",
                timeout: 5000,
                beforeSend: function () {
                    $submitBtn.addClass("loading");
                },
                success: function (response) {
                    console.log("API Response:", response);
                    alert(response.message);

                    if (!response.success) return false;
                    window.location.replace("index.php"); // Redirect to login
                },
                complete: function () {
                    $submitBtn.removeClass("loading");
                },
                error: ajaxErrorHandler,
            });
        },
    });
});
