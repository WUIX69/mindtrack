[SPECIFIC] **NOT SHAREABLE** Feature sliced design, Specific Features Business logic goes here

features/{feature-name}/
├── **server**
│ ├── actions (api layer)
│ └── db (database sql interactions)
├── **components** (ui): Include `<script></script>` tag at the bottom and has and js/jquery code
├── **schemas** (validation)
└── **utils** (utility)

## COMPONENTS EXAMPLE

user-modal.php (This eleminates `js` folder on features, jquery <script> already included on `src/components/elements/styles.php` to work on top)

```
<!-- Add/Edit User Modal -->
<div class="ui tiny modal" id="userModal">
    <div class="header" data-default-header="Add New User">Add New User</div>
    <div class="content">
        <form class="ui form" id="userForm">
            <input type="hidden" name="uuid" />
            <div class="two fields">
                <div class="field">
                    <label>First Name</label>
                    <input type="text" name="firstname" placeholder="First Name" />
                </div>
                <div class="field">
                    <label>Last Name</label>
                    <input type="text" name="lastname" placeholder="Last Name" />
                </div>
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Email" />
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="password" />
                </div>
            </div>
            <div class="field">
                <label>Telephone</label>
                <input type="text" name="telephone" placeholder="Telephone" />
            </div>
            <div class="two fields">
                <div class="field">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" placeholder="Date of Birth" />
                </div>
                <div class="field">
                    <label>Role</label>
                    <div class="ui fluid floating selection search dropdown">
                        <input type="hidden" name="role" />
                        <div class="default text">Select role</div>
                        <i class="dropdown icon"></i>
                        <div class="menu">
                            <div class="item" data-value="admin">Admin</div>
                            <div class="item" data-value="user">User</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="actions">
                <button class="ui cancel clear button" type="reset">Cancel</button>
                <button class="ui positive submit button" type="submit" id="userFormSubmitBtn">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>
<script>
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
</script>
```
