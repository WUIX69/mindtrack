$(function () {
    $("#profileForm").form({
        fields: {
            profile: {
                identifier: "profile",
                optional: true,
                rules: [],
            },
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
            telephone: {
                identifier: "telephone",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter your telephone",
                    },
                    {
                        type: "number",
                        prompt: "Please enter a valid telephone number",
                    },
                ],
            },
            dob: {
                identifier: "dob",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter your date of birth",
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
            location: {
                identifier: "location",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter your location",
                    },
                ],
            },
            bio: {
                identifier: "bio",
                optional: true,
                rules: [],
            },
            urls: {
                identifier: "urls[]",
                optional: true,
                rules: [],
            },
        },
        inline: true,
        on: "blur", // EG: submit, blur
        onSuccess: function (event, fields) {
            event.preventDefault();
            const $submitBtn = $(this).find("button[type=submit]");
            // const formData = new FormData(this); // Only use when uploading a file is included

            // Use Serialize instead of fields for the form (includes all urls[])
            let formSerialized = $(this).serializeArray();
            formSerialized.push({ name: "action", value: "profile-update" }); // Add action

            // console.log(formSerialized);
            // console.log(fields);
            // return false;

            $.ajax({
                url: apiUrl("settings") + "profilePost.php",
                method: "POST",
                data: formSerialized,
                // processData: false, // Only use when FormData
                // contentType: false, // Only use when FormData
                dataType: "json",
                timeout: 5000,
                beforeSend: function () {
                    $submitBtn.addClass("loading");
                },
                success: function (response) {
                    console.log("API Response:", response);
                    alert(response.message);
                    getProfile(); // Refresh the profile data
                },
                complete: function () {
                    $submitBtn.removeClass("loading");
                },
                error: ajaxErrorHandler,
            });
        },
    });
});
