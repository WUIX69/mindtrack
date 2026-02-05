// Cache DOM elements
const $userModal = $("#userModal");
const $userModalForm = $userModal.find("#userForm");

$(function () {
    // Validate login form
    $userModalForm.form({
        fields: {
            firstname: {
                identifier: "firstname",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter a first name",
                    },
                ],
            },
            lastname: {
                identifier: "lastname",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter a last name",
                    },
                ],
            },
            email: {
                identifier: "email",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter an email",
                    },
                    {
                        type: "email",
                        prompt: "Please enter a valid email",
                    },
                ],
            },
            password: {
                identifier: "password",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter an email",
                    },
                ],
            },
            telephone: {
                identifier: "telephone",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter a telephone number",
                    },
                    {
                        type: "minLength[11]",
                        prompt: "Telephone number must be at least 11 digits",
                    },
                    {
                        type: "maxLength[11]",
                        prompt: "Telephone number must be at most 11 digits",
                    },
                    {
                        type: "number",
                        prompt: "Telephone number must be a number",
                    },
                ],
            },
            dob: {
                identifier: "dob",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter a date of birth",
                    },
                ],
            },
            role: {
                identifier: "role",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please select a role",
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

            $.ajax({
                url: apiUrl("users") + "users.php",
                method: "POST",
                data: {
                    action: fields.uuid ? "update" : "store",
                    ...fields,
                },
                dataType: "json",
                timeout: 5000,
                beforeSend: function () {
                    $submitBtn.addClass("loading");
                },
                success: function (response) {
                    // console.log("API Response:", response);
                    // return false;

                    alert(response.message);
                    $usersDataTable.ajax.reload();
                },
                complete: function () {
                    $submitBtn.removeClass("loading");
                },
                error: ajaxErrorHandler,
            });
        },
    });
});

// Export userModal and userModalForm to window for debugging
window.$userModal = $userModal;
window.$userModalForm = $userModalForm;
