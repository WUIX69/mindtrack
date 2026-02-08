<form class="space-y-10" action="#" method="POST">
    <!-- Section 1: Personal Details -->
    <div class="space-y-8">
        <div class="flex items-center gap-3 border-b border-border pb-3">
            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-xl">person</span>
            </div>
            <h3 class="text-xl font-black tracking-tight text-foreground">Personal Details</h3>
        </div>

        <div class="grid grid-cols-1 gap-6 px-1">
            <div class="flex flex-col gap-2.5">
                <label class="text-xs font-black uppercase tracking-widest text-muted-foreground ml-1">Full
                    Name</label>
                <div class="relative group">
                    <span
                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground group-focus-within:text-primary transition-colors duration-300">badge</span>
                    <input
                        class="w-full pl-12 pr-5 py-4 bg-muted/30 border-border border rounded-xl font-bold text-foreground focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-300 outline-none"
                        placeholder="Enter your full name" type="text" name="name" required />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-2.5">
                    <label class="text-xs font-black uppercase tracking-widest text-muted-foreground ml-1">Email
                        Address</label>
                    <div class="relative group">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground group-focus-within:text-primary transition-colors duration-300">mail</span>
                        <input
                            class="w-full pl-12 pr-5 py-4 bg-muted/30 border-border border rounded-xl font-bold text-foreground focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-300 outline-none"
                            placeholder="name@example.com" type="email" name="email" required />
                    </div>
                </div>
                <div class="flex flex-col gap-2.5">
                    <label class="text-xs font-black uppercase tracking-widest text-muted-foreground ml-1">Phone
                        Number</label>
                    <div class="relative group">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground group-focus-within:text-primary transition-colors duration-300">call</span>
                        <input
                            class="w-full pl-12 pr-5 py-4 bg-muted/30 border-border border rounded-xl font-bold text-foreground focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-300 outline-none"
                            placeholder="+1 (555) 000-0000" type="tel" name="phone" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 2: Security -->
    <div class="space-y-8 pt-4">
        <div class="flex items-center gap-3 border-b border-border pb-3">
            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-xl">security</span>
            </div>
            <h3 class="text-xl font-black tracking-tight text-foreground">Security</h3>
        </div>

        <div class="grid grid-cols-1 gap-8 px-1">
            <div class="flex flex-col gap-2.5">
                <label class="text-xs font-black uppercase tracking-widest text-muted-foreground ml-1">Create
                    Password</label>
                <div class="relative group">
                    <span
                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground group-focus-within:text-primary transition-colors duration-300">lock</span>
                    <input
                        class="w-full pl-12 pr-12 py-4 bg-muted/30 border-border border rounded-xl font-bold text-foreground focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-300 outline-none"
                        placeholder="••••••••" type="password" name="password" required />
                    <button
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-muted-foreground hover:text-primary transition-colors duration-200"
                        type="button">
                        <span class="material-symbols-outlined text-2xl">visibility</span>
                    </button>
                </div>

                <!-- Password Strength -->
                <div class="mt-4 bg-muted/20 p-4 rounded-xl border border-border/50">
                    <div class="flex gap-2 h-2 w-full mb-4">
                        <div class="flex-1 bg-success rounded-full shadow-sm"></div>
                        <div class="flex-1 bg-success rounded-full shadow-sm"></div>
                        <div class="flex-1 bg-success rounded-full shadow-sm"></div>
                        <div class="flex-1 bg-muted dark:bg-muted/10 rounded-full"></div>
                    </div>
                    <ul class="text-xs font-black uppercase tracking-wider grid grid-cols-2 gap-y-3 gap-x-6">
                        <li class="flex items-center gap-2 text-success">
                            <span class="material-symbols-outlined text-sm font-black text-[18px]">check_circle</span>
                            8+ characters
                        </li>
                        <li class="flex items-center gap-2 text-success">
                            <span class="material-symbols-outlined text-sm font-black text-[18px]">check_circle</span>
                            Uppercase letter
                        </li>
                        <li class="flex items-center gap-2 text-muted-foreground">
                            <span class="material-symbols-outlined text-sm text-[18px]">circle</span> One
                            number
                        </li>
                        <li class="flex items-center gap-2 text-muted-foreground">
                            <span class="material-symbols-outlined text-sm text-[18px]">circle</span>
                            Special symbol
                        </li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col gap-2.5">
                <label class="text-xs font-black uppercase tracking-widest text-muted-foreground ml-1">Confirm
                    Password</label>
                <div class="relative group">
                    <span
                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground group-focus-within:text-primary transition-colors duration-300">lock_reset</span>
                    <input
                        class="w-full pl-12 pr-12 py-4 bg-muted/30 border-success/50 border-2 rounded-xl font-bold text-foreground focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-300 outline-none"
                        placeholder="••••••••" type="password" name="confirm_password" required />
                    <span
                        class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-success text-2xl">check_circle</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Terms -->
    <div class="px-1">
        <label
            class="flex items-start gap-4 p-4 rounded-xl bg-muted/20 border border-border/50 cursor-pointer group hover:bg-muted/30 transition-all duration-300">
            <input class="checkbox checkbox-primary checkbox-sm mt-1 border-2 rounded" type="checkbox" required />
            <span
                class="text-sm font-bold text-muted-foreground group-hover:text-foreground transition-colors leading-relaxed">
                I agree to the <a class="text-primary font-black hover:underline underline-offset-4 decoration-2"
                    href="#">Terms of Service</a> and <a
                    class="text-primary font-black hover:underline underline-offset-4 decoration-2" href="#">Privacy
                    Policy</a>.
            </span>
        </label>
    </div>

    <!-- CTA -->
    <div class="flex flex-col gap-6 pt-4 px-1">
        <button
            class="w-full bg-primary hover:scale-[1.02] active:scale-[0.98] text-white font-black py-5 text-xl rounded-2xl shadow-2xl shadow-primary/20 transition-all flex items-center justify-center gap-3 uppercase tracking-widest"
            type="submit">
            <span>Start Your Journey</span>
            <span class="material-symbols-outlined text-2xl">arrow_forward</span>
        </button>
        <p class="text-center text-base font-black text-muted-foreground">
            Already have an account?
            <a class="text-primary hover:underline underline-offset-4 decoration-2 px-1" href="index.php">Sign In</a>
        </p>
    </div>
</form>
<script>
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
</script>