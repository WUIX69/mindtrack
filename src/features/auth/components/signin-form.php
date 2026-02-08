<form class="flex flex-col gap-6" onsubmit="return false;">
    <div class="flex flex-col gap-2">
        <label class="text-xs font-black uppercase tracking-widest text-muted-foreground ml-1">Email
            Address</label>
        <div class="relative group">
            <input
                class="w-full h-14 rounded-xl border border-border bg-muted/30 px-5 text-foreground font-semibold focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all duration-300"
                placeholder="name@example.com" type="email" />
        </div>
    </div>

    <div class="flex flex-col gap-2">
        <div class="flex justify-between items-center ml-1">
            <label class="text-xs font-black uppercase tracking-widest text-muted-foreground">Password</label>
        </div>
        <div class="relative flex items-center">
            <input
                class="w-full h-14 rounded-xl border border-border bg-muted/30 px-5 text-foreground font-semibold focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all duration-300"
                placeholder="••••••••" type="password" />
            <button class="absolute right-4 text-muted-foreground hover:text-primary transition-colors duration-200"
                type="button">
                <span class="material-symbols-outlined text-2xl">visibility</span>
            </button>
        </div>
    </div>

    <div class="flex items-center justify-between px-1">
        <label class="flex items-center gap-2 cursor-pointer group">
            <input class="checkbox checkbox-primary checkbox-sm border-2 rounded" type="checkbox" />
            <span class="text-sm font-bold text-muted-foreground group-hover:text-foreground transition-colors">Remember
                Me</span>
        </label>
        <a class="text-sm font-black text-primary hover:underline underline-offset-4 decoration-2" href="#">Forgot
            Password?</a>
    </div>

    <button
        class="w-full h-14 bg-primary hover:scale-[1.02] active:scale-[0.98] text-white font-black text-lg rounded-xl transition-all shadow-xl shadow-primary/20 mt-2 uppercase tracking-wider">
        Sign In
    </button>
</form>
<script>
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
</script>