<!-- Security Section -->
<section class="bg-card dark:bg-card rounded-xl border border-border shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-border flex items-center gap-2">
        <h3 class="font-bold text-lg">Security</h3>
    </div>
    <div class="p-6 space-y-6">

        <form id="change-password-form">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="space-y-2">
                    <label class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Current
                        Password</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-3 top-2.5 text-muted-foreground/70">lock</span>
                        <input type="password" name="current_password"
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                            placeholder="••••••••">
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">New
                        Password</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-3 top-2.5 text-muted-foreground/70">key</span>
                        <input type="password" name="new_password" id="new_password"
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                            placeholder="••••••••">
                    </div>
                </div>
                <div class="space-y-2 md:col-span-2">
                    <label class="text-xs font-semibold uppercase tracking-wider text-muted-foreground">Confirm
                        New Password</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-3 top-2.5 text-muted-foreground/70">check_circle</span>
                        <input type="password" name="confirm_password"
                            class="w-full pl-10 pr-4 py-2 rounded-lg border border-border focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                            placeholder="••••••••">
                    </div>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" id="update-password-btn"
                    class="bg-primary hover:bg-primary/90 text-primary-foreground px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md shadow-primary/20 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Update Password</span>
                </button>
            </div>
        </form>
    </div>
</section>

<script>
    $(document).ready(function () {

        // Change Password Validation
        $('#change-password-form').validate({
            ...window.validatorConfig,
            rules: {
                current_password: "required",
                new_password: { required: true, minlength: 6 },
                confirm_password: { required: true, equalTo: "#new_password" }
            },
            messages: {
                current_password: "Enter your current password",
                new_password: { required: "Enter a new password", minlength: "Password must be at least 6 characters" },
                confirm_password: { required: "Confirm your new password", equalTo: "Passwords do not match" }
            }
        });

        // Change Password Handler
        $('#update-password-btn').on('click', function (e) {
            e.preventDefault();

            if (!$('#change-password-form').valid()) return;

            const $btn = $(this);
            const $btnIcon = $btn.find('.material-symbols-outlined');
            const originalIconText = $btnIcon.text();

            $btn.prop('disabled', true);
            $btnIcon.text('progress_activity').addClass('animate-spin');

            const formData = $('#change-password-form').serialize();

            $.post(apiUrl('settings') + 'change-password.php', formData, function (response) {
                try {
                    const res = typeof response === 'string' ? JSON.parse(response) : response;
                    if (res.success) {
                        if (window.toast && window.toast.success) {
                            window.toast.success(res.message);
                        } else {
                            alert(res.message);
                        }
                        $('#change-password-form')[0].reset();
                    } else {
                        if (window.toast && window.toast.error) {
                            window.toast.error(res.message);
                        } else {
                            alert(res.message);
                        }
                    }
                } catch (e) {
                    if (window.toast && window.toast.error) {
                        window.toast.error('An unexpected error occurred.');
                    } else {
                        alert('An unexpected error occurred.');
                    }
                }
            })
                .fail(function () {
                    if (window.toast && window.toast.error) {
                        window.toast.error('Connection error. Please try again.');
                    }
                })
                .always(function () {
                    $btn.prop('disabled', false);
                    $btnIcon.text(originalIconText).removeClass('animate-spin');
                });
        });
    });
</script>