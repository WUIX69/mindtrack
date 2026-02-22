<!-- Security Section -->
<div class="grid grid-cols-1 lg:grid-cols-1 gap-8">
    <section
        class="bg-card rounded-2xl border border-border overflow-hidden shadow-sm transition-all hover:shadow-md h-fit">
        <div class="px-6 py-4 border-b border-border bg-muted/30">
            <h3 class="font-black text-sm uppercase tracking-widest flex items-center gap-2 text-foreground">
                <span
                    class="material-symbols-outlined text-primary text-xl font-variation-settings-['FILL'_1]">security</span>
                Security & Access
            </h3>
        </div>
        <form id="change-password-form" class="p-6 flex flex-col gap-6">
            <div class="flex flex-col gap-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">Current
                    Password</label>
                <input name="current_password" id="current_password"
                    class="w-full rounded-xl border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary px-4 py-2.5 text-sm font-bold text-foreground transition-all"
                    placeholder="••••••••" type="password" />
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">New
                    Password</label>
                <input name="new_password" id="new_password"
                    class="w-full rounded-xl border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary px-4 py-2.5 text-sm font-bold text-foreground transition-all"
                    placeholder="Min. 6 characters" type="password" />
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">Confirm
                    New Password</label>
                <input name="confirm_password" id="confirm_password"
                    class="w-full rounded-xl border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary px-4 py-2.5 text-sm font-bold text-foreground transition-all"
                    placeholder="Re-type new password" type="password" />
            </div>

            <button type="submit" id="update-password-btn"
                class="w-full mt-2 text-[10px] font-black py-3 bg-foreground text-background rounded-xl transition-all uppercase tracking-widest flex items-center justify-center gap-2 hover:bg-foreground/90">
                <span class="material-symbols-outlined text-[16px]">lock_reset</span>
                <span>Update Password</span>
            </button>
        </form>
    </section>
</div>

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