<form id="registerForm" class="space-y-10" action="#" method="POST">
    <!-- Section 1: Personal Details -->
    <div class="space-y-8">
        <div class="flex items-center gap-3 border-b border-border pb-3">
            <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-xl">person</span>
            </div>
            <h3 class="text-xl font-black tracking-tight text-foreground">Personal Details</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-1">
            <div class="flex flex-col gap-2.5">
                <label class="text-xs font-black uppercase tracking-widest text-muted-foreground ml-1">First
                    Name</label>
                <div class="relative group">
                    <span
                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground group-focus-within:text-primary transition-colors duration-300">badge</span>
                    <input
                        class="w-full pl-12 pr-5 py-4 bg-muted/30 border-border border rounded-xl font-bold text-foreground focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-300 outline-none"
                        placeholder="First Name" type="text" name="firstname" required />
                </div>
            </div>
            <div class="flex flex-col gap-2.5">
                <label class="text-xs font-black uppercase tracking-widest text-muted-foreground ml-1">Last Name</label>
                <div class="relative group">
                    <span
                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground group-focus-within:text-primary transition-colors duration-300">badge</span>
                    <input
                        class="w-full pl-12 pr-5 py-4 bg-muted/30 border-border border rounded-xl font-bold text-foreground focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-300 outline-none"
                        placeholder="Last Name" type="text" name="lastname" required />
                </div>
            </div>

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
                    <input id="password"
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
                        class="w-full pl-12 pr-12 py-4 bg-muted/30 border-border border rounded-xl font-bold text-foreground focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all duration-300 outline-none"
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
            <input class="checkbox checkbox-primary checkbox-sm mt-1 border-2 rounded" type="checkbox" name="terms"
                required />
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
        $("#registerForm").validate({
            rules: {
                firstname: {
                    required: true,
                    minlength: 2
                },
                lastname: {
                    required: true,
                    minlength: 2
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8
                },
                confirm_password: {
                    required: true,
                    equalTo: "#password"
                },
                terms: {
                    required: true
                }
            },
            messages: {
                firstname: "Please enter your first name",
                lastname: "Please enter your last name",
                email: "Please enter a valid email address",
                password: "Password must be at least 8 characters",
                confirm_password: "Passwords do not match",
                terms: "Please accept the terms and conditions"
            },
            errorElement: "div",
            errorClass: "text-red-500 text-xs font-bold mt-1 ml-1",
            highlight: function (element) {
                $(element).closest('.relative').find('input').addClass('border-red-500').removeClass('border-border');
            },
            unhighlight: function (element) {
                $(element).closest('.relative').find('input').removeClass('border-red-500').addClass('border-border');
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") === "terms") {
                    error.insertAfter(element.closest('label'));
                } else {
                    error.insertAfter(element.closest('.relative'));
                }
            },
            submitHandler: function (form) {
                const $form = $(form);
                const $submitBtn = $form.find("button[type=submit]");
                const formData = $form.serialize();

                $.ajax({
                    url: apiUrl("shared") + "register.php",
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    timeout: 10000,
                    beforeSend: function () {
                        $submitBtn.prop("disabled", true).addClass("opacity-70 cursor-not-allowed");
                        $submitBtn.find("span:first").text("Processing...");
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.replace("index.php");
                        } else {
                            alert(response.message);
                        }
                    },
                    complete: function () {
                        $submitBtn.prop("disabled", false).removeClass("opacity-70 cursor-not-allowed");
                        $submitBtn.find("span:first").text("Start Your Journey");
                    },
                    error: ajaxErrorHandler,
                });
                return false;
            }
        });
    });
</script>