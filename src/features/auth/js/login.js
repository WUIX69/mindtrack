$(function () {
    // Validate login form
    $("#loginForm").form({
        fields: {
            email: {
                identifier: "email",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter an email",
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
                        prompt: "Please enter a password",
                    },
                ],
            },
            remember: {
                identifier: "remember",
                optional: true,
                // rules: [],
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
                url: apiUrl("auth") + "login.php",
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
                    window.location.replace(response.data.route); // Redirect to its route dir
                },
                complete: function () {
                    $submitBtn.removeClass("loading");
                },
                error: ajaxErrorHandler,
            });
        },
    });
});
