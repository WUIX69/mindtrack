<!-- Manage Admin User Modal -->
<div id="admin-user-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 modal-overlay hidden">
    <div class="absolute min-h-screen inset-0 bg-black/50 backdrop-blur-sm transition-opacity opacity-0"
        id="admin-user-modal-backdrop">
    </div>

    <div class="bg-card dark:bg-card w-full max-w-lg rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[95vh] relative z-10 transform scale-95 opacity-0 transition-all duration-300"
        id="admin-user-modal-panel">

        <!-- Header -->
        <div class="px-8 py-6 border-b border-border flex justify-between items-center bg-card sticky top-0 z-10">
            <div>
                <h3 class="text-xl font-bold text-foreground" id="au-modal-title">Add New Admin User</h3>
                <p class="text-xs text-muted-foreground font-medium mt-1 uppercase tracking-wider"
                    id="au-modal-subtitle">
                    Registering New System Administrator</p>
            </div>
            <button type="button" class="text-muted-foreground hover:text-foreground transition-colors au-modal-close">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto p-8">
            <form id="admin-user-form" class="space-y-8">
                <input type="hidden" name="uuid" id="admin-user-uuid">

                <!-- Section 1: Basic Information -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">person</span> 1. Basic Information
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">First
                                Name</label>
                            <input type="text" name="firstname" required
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                                placeholder="Sarah">
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Last
                                Name</label>
                            <input type="text" name="lastname" required
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                                placeholder="Jenkins">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Email
                                Address</label>
                            <input type="email" name="email" required
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                                placeholder="sarah.j@wayside.org">
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Phone
                                Number</label>
                            <input type="tel" name="phone"
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                                placeholder="(555) 000-0000">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Account Settings -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">settings</span> 2. Account Settings
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Status</label>
                            <select name="status" id="admin-user-status"
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <p class="text-[10px] text-muted-foreground mt-1">Inactive users cannot log in to the admin
                                portal.</p>
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Email
                                Verification</label>
                            <select name="is_email_verified" id="admin-user-verified"
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all">
                                <option value="0">Unverified</option>
                                <option value="1">Verified</option>
                            </select>
                            <p class="text-[10px] text-muted-foreground mt-1">Manually bypass or set the user's email
                                verification status.</p>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Account Security -->
                <div id="au-password-container" class="space-y-4">
                    <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">lock</span> 3. Account Security
                    </h4>
                    <div>
                        <label
                            class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Temporary
                            Password</label>
                        <div class="flex gap-2">
                            <input type="text" name="password" id="au-password"
                                class="flex-1 bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all font-mono"
                                placeholder="Generate or type password">
                            <button type="button" id="au-generate-password-btn"
                                class="px-4 py-2 bg-secondary text-secondary-foreground hover:bg-secondary/80 rounded-lg text-xs font-bold transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">autorenew</span>
                                Generate
                            </button>
                        </div>
                        <p class="text-[10px] text-muted-foreground mt-1 au-password-hint">Required for new accounts.
                            Admins can change this later in their profile settings.</p>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="px-8 py-6 border-t border-border flex justify-end gap-3 bg-card sticky bottom-0 z-10">
            <button type="button"
                class="px-6 py-2.5 text-sm font-bold text-muted-foreground hover:text-foreground transition-all au-modal-close">Cancel</button>
            <button type="submit" form="admin-user-form" id="au-submit-btn"
                class="px-8 py-2.5 bg-primary text-primary-foreground rounded-lg text-sm font-bold hover:opacity-90 transition-all shadow-lg shadow-primary/25">Add
                Admin</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const $modal = $('#admin-user-modal');
        const $backdrop = $('#admin-user-modal-backdrop');
        const $panel = $('#admin-user-modal-panel');
        const $form = $('#admin-user-form');
        const $submitBtn = $('#au-submit-btn');

        function openModal() {
            $modal.removeClass('hidden');
            setTimeout(() => {
                $backdrop.removeClass('opacity-0');
                $panel.removeClass('scale-95 opacity-0');
            }, 10);
        }

        window.closeAdminUserModal = function () {
            $backdrop.addClass('opacity-0');
            $panel.addClass('scale-95 opacity-0');
            setTimeout(() => {
                $modal.addClass('hidden');
                $form[0].reset();
                $('#admin-user-uuid').val('');
                $form.find('input[name="password"]').prop('required', true);
            }, 300);
        }

        window.openAdminUserModal = function (mode, uuid = null) {
            if (mode === 'edit' && uuid) {
                // Find user in global array
                const data = window.allAdminUsers.find(u => u.uuid === uuid);
                if (!data) {
                    console.error("Admin user data not found for UUID:", uuid);
                    return;
                }

                $('#au-modal-title').text('Edit Admin User');
                $('#au-modal-subtitle').text('Update System Administrator');
                $submitBtn.text('Save Changes');

                // For edit mode, password is optional. Don't hide the container, let admin change password if needed, but make it optional.
                $form.find('input[name="password"]').prop('required', false).attr('placeholder', 'Leave blank to keep current');
                $('.au-password-hint').text('Optional. Set a new password to override the current one.');

                $('#admin-user-uuid').val(data.uuid);
                $form.find('[name="firstname"]').val(data.firstname);
                $form.find('[name="lastname"]').val(data.lastname);
                $form.find('[name="email"]').val(data.email);
                $form.find('[name="phone"]').val(data.phone);
                $form.find('[name="status"]').val(data.status || 'active');
                $form.find('[name="is_email_verified"]').val(data.is_email_verified || 0);

            } else {
                $('#au-modal-title').text('Add New Admin User');
                $('#au-modal-subtitle').text('Registering New System Administrator');
                $submitBtn.text('Add Admin');

                $form.find('input[name="password"]').prop('required', true).attr('placeholder', 'Generate or type password');
                $('.au-password-hint').text('Required for new accounts. Admins can change this later in their profile settings.');

                $('#admin-user-uuid').val('');
                $form[0].reset();
            }
            openModal();
        }

        $('#au-generate-password-btn').on('click', function () {
            const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
            let password = '';
            for (let i = 0; i < 12; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            $('#au-password').val(password);
        });

        $form.on('submit', function (e) {
            e.preventDefault();
            const url = apiUrl('settings') + 'manage-admin-users.php';
            const formData = new FormData(this);
            const originalText = $submitBtn.text();

            $submitBtn.prop('disabled', true).html('<span class="material-symbols-outlined animate-spin text-sm">progress_activity</span> Processing...');

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    alert(response.message);
                    if (response.success) {
                        closeAdminUserModal();
                        if (typeof window.fetchAdminUsers === 'function') {
                            window.fetchAdminUsers();
                        }
                    } else {
                        alert(response.message || 'An error occurred');
                    }
                },
                error: function (xhr) {
                    alert('Server error: ' + (xhr.responseJSON?.message || xhr.statusText));
                },
                complete: function () {
                    $submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });

        $(document).on('click', '.au-modal-close', function () {
            closeAdminUserModal();
        });

        $modal.on('click', function (e) {
            if ($(e.target).is($modal)) closeAdminUserModal();
        });
    });
</script>