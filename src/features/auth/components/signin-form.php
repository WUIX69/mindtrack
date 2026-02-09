<form class="flex flex-col gap-6" id="loginForm" onsubmit="return false;">
    <div class="flex flex-col gap-2">
        <label class="text-xs font-black uppercase tracking-widest text-muted-foreground ml-1">Email
            Address</label>
        <div class="relative group">
            <input
                class="w-full h-14 rounded-xl border border-border bg-muted/30 px-5 text-foreground font-semibold focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all duration-300"
                id="email" name="email" placeholder="name@example.com" type="email" />
        </div>
    </div>

    <div class="flex flex-col gap-2">
        <div class="flex justify-between items-center ml-1">
            <label class="text-xs font-black uppercase tracking-widest text-muted-foreground">Password</label>
        </div>
        <div class="relative flex items-center">
            <input
                class="w-full h-14 rounded-xl border border-border bg-muted/30 px-5 text-foreground font-semibold focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all duration-300"
                id="password" name="password" placeholder="••••••••" type="password" />
            <button class="absolute right-4 text-muted-foreground hover:text-primary transition-colors duration-200"
                type="button">
                <span class="material-symbols-outlined text-2xl">visibility</span>
            </button>
        </div>
    </div>

    <div class="flex items-center justify-between px-1">
        <label class="flex items-center gap-2 cursor-pointer group">
            <input class="checkbox checkbox-primary checkbox-sm border-2 rounded" name="remember" type="checkbox" />
            <span class="text-sm font-bold text-muted-foreground group-hover:text-foreground transition-colors">Remember
                Me</span>
        </label>
        <a class="text-sm font-black text-primary hover:underline underline-offset-4 decoration-2" href="#">Forgot
            Password?</a>
    </div>

    <button
        class="w-full h-14 bg-primary hover:scale-[1.02] active:scale-[0.98] text-white font-black text-lg rounded-xl transition-all shadow-xl shadow-primary/20 mt-2 uppercase tracking-wider"
        type="submit">
        <span>Sign In</span>
    </button>
</form>

<script>
    $(function () {
        $("#loginForm").validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                email: "Please enter a valid email address",
                password: "Please enter your password"
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
                error.insertAfter(element.closest('.relative'));
            },
            submitHandler: function (form) {
                const $form = $(form);
                const $submitBtn = $form.find("button[type=submit]");
                const formData = $form.serialize();

                $.ajax({
                    url: apiUrl("auth") + "login.php",
                    method: "POST",
                    data: formData,
                    dataType: "json",
                    timeout: 10000,
                    beforeSend: function () {
                        $submitBtn.prop("disabled", true).addClass("opacity-70 cursor-not-allowed");
                        $submitBtn.find("span:first").text("Signing in...");
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.replace(response.data.route);
                        } else {
                            alert(response.message);
                        }
                    },
                    complete: function () {
                        $submitBtn.prop("disabled", false).removeClass("opacity-70 cursor-not-allowed");
                        $submitBtn.find("span:first").text("Sign In");
                    },
                    error: ajaxErrorHandler,
                });
                return false;
            }
        });
    });
</script>