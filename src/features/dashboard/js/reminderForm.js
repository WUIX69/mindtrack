const $reminderModal = $("#reminderModal");
const $reminderForm = $reminderModal.find(".ui.form");

$(function () {
    initModal({
        modal_id: $reminderModal,
        transition: "swing down",
        duration: 800,
    });

    // Validate login form
    $reminderForm.form({
        fields: {
            employee: {
                identifier: "employee",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter a name",
                    },
                ],
            },
            employee_search: {
                identifier: "employee_search",
                optional: true,
                rules: [],
            },
            date: {
                identifier: "date",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter a date",
                    },
                ],
            },
            time_in: {
                identifier: "time_in",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please select a time in",
                    },
                ],
            },
            time_out: {
                identifier: "time_out",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please select a time in",
                    },
                ],
            },
            memo: {
                identifier: "memo",
                rules: [
                    {
                        type: "empty",
                        prompt: "Please enter a memo",
                    },
                    {
                        type: "minLength[2]",
                        prompt: "Memo must be at least 2 characters",
                    },
                ],
            },
        },
        inline: true,
        on: "blur", // EG: submit, blur
        onSuccess: function (event, fields) {
            event.preventDefault();
            const $submitBtn = $(this).find("button[type=submit]");

            console.log(fields);
            return false;
        },
    });
});
