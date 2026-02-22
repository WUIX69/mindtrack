<?php
/**
 * Patient Account Settings Page
 */

$pageTitle = "Account Settings";
$bodyClass = "bg-muted/50 dark:bg-background text-foreground font-display transition-colors duration-200";
// Set current page for sidebar highlighting
$headerData = [
    'title' => 'Account Settings',
    'description' => 'Manage your personal information, security, and account details.'
];
$currentPage = 'settings';

include __DIR__ . '/layout.php';
?>
<?= shared('components', 'elements/filepond/styles') ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-10">
    <div class="lg:col-span-2 space-y-8">
        <!-- Profile Information Section -->
        <section class="bg-card dark:bg-card rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-border">
                <h3 class="font-bold text-lg">Profile Information</h3>
            </div>
            <div class="p-6">
                <form id="profile-form">
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Profile -->
                        <?= featured('settings', 'components/profile'); ?>
                        <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold text-foreground mb-1">First Name</label>
                                <input
                                    class="w-full px-4 py-2 bg-muted/30 dark:bg-muted/10 border border-border rounded-lg text-sm focus:ring-primary focus:border-primary transition-all font-medium skeleton-loader"
                                    type="text" id="firstname" name="firstname" />
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold text-foreground mb-1">Last Name</label>
                                <input
                                    class="w-full px-4 py-2 bg-muted/30 dark:bg-muted/10 border border-border rounded-lg text-sm focus:ring-primary focus:border-primary transition-all font-medium skeleton-loader"
                                    type="text" id="lastname" name="lastname" />
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold text-foreground mb-1">Email Address</label>
                                <input
                                    class="w-full px-4 py-2 bg-muted/30 dark:bg-muted/10 border border-border rounded-lg text-sm focus:ring-primary focus:border-primary transition-all font-medium skeleton-loader"
                                    type="email" id="email" name="email" />
                            </div>
                            <div class="col-span-2 md:col-span-1">
                                <label class="block text-sm font-bold text-foreground mb-1">Phone Number</label>
                                <input
                                    class="w-full px-4 py-2 bg-muted/30 dark:bg-muted/10 border border-border rounded-lg text-sm focus:ring-primary focus:border-primary transition-all font-medium skeleton-loader"
                                    type="tel" id="phone" name="phone" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <!-- Patient Information Section -->
        <section class="bg-card dark:bg-card rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-border">
                <h3 class="font-bold text-lg">Patient Information</h3>
            </div>
            <div class="p-6">
                <form id="patient-info-form">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-bold text-foreground mb-1">Date of Birth</label>
                            <input
                                class="w-full px-4 py-2 bg-muted/30 dark:bg-muted/10 border border-border rounded-lg text-sm focus:ring-primary focus:border-primary transition-all font-medium skeleton-loader"
                                type="date" id="date_of_birth" name="date_of_birth" />
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-bold text-foreground mb-1">Gender</label>
                            <select
                                class="w-full px-4 py-2 bg-muted/30 dark:bg-muted/10 border border-border rounded-lg text-sm focus:ring-primary focus:border-primary transition-all font-medium skeleton-loader"
                                id="gender" name="gender">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-bold text-foreground mb-1">Address</label>
                            <textarea
                                class="w-full px-4 py-2 bg-muted/30 dark:bg-muted/10 border border-border rounded-lg text-sm focus:ring-primary focus:border-primary transition-all font-medium skeleton-loader"
                                rows="2" id="address" name="address"
                                placeholder="123 Main St, City, Country"></textarea>
                        </div>

                        <div class="col-span-2 border-t border-border pt-4 mt-2">
                            <h4 class="font-bold text-sm mb-4 text-muted-foreground">Emergency Contact</h4>
                        </div>

                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-bold text-foreground mb-1">Contact Name</label>
                            <input
                                class="w-full px-4 py-2 bg-muted/30 dark:bg-muted/10 border border-border rounded-lg text-sm focus:ring-primary focus:border-primary transition-all font-medium skeleton-loader"
                                type="text" id="emergency_contact_name" name="emergency_contact_name" />
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-bold text-foreground mb-1">Contact Phone</label>
                            <input
                                class="w-full px-4 py-2 bg-muted/30 dark:bg-muted/10 border border-border rounded-lg text-sm focus:ring-primary focus:border-primary transition-all font-medium skeleton-loader"
                                type="tel" id="emergency_contact_phone" name="emergency_contact_phone" />
                        </div>
                    </div>
                </form>
                <div class="mt-8 flex justify-end">
                    <button id="save-settings-btn"
                        class="bg-primary hover:bg-primary/90 text-primary-foreground px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md shadow-primary/20 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm hidden"
                            id="save-spinner">progress_activity</span>
                        Save Changes
                    </button>
                </div>
            </div>
        </section>

        <!-- Security Section -->
        <?= featured('settings', 'components/change-password'); ?>

        <!-- Dangerous Zone Section -->
        <section
            class="bg-red-50/50 dark:bg-red-900/10 rounded-xl border border-red-100 dark:border-red-900/30 shadow-sm overflow-hidden">
            <div class="p-6 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="font-bold text-red-700 dark:text-red-400 text-lg">Deactivate Account</h3>
                    <p class="text-xs text-red-600 dark:text-red-300/70 font-medium">Permanently delete your account and
                        all
                        associated health records. This action is irreversible.</p>
                </div>
                <button
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md shadow-red-600/20 whitespace-nowrap">
                    Delete Account
                </button>
            </div>
        </section>
    </div>

    <!-- Right Column: Summary & Decorative -->
    <!-- Decorative Image Card -->
    <?= featured('settings', 'components/decorative'); ?>
</div>

<?= shared('components', 'elements/filepond/scripts') ?>
<script>

    // Initialize jQuery Validation
    window.validatorConfig = {
        errorElement: 'span',
        errorClass: 'text-red-500 text-xs mt-1 block font-medium',
        highlight: function (element) {
            $(element).addClass('!border-red-500').removeClass('border-border');
            $(element).parent().find('.material-symbols-outlined').addClass('text-red-500');
        },
        unhighlight: function (element) {
            $(element).removeClass('!border-red-500').addClass('border-border');
            $(element).parent().find('.material-symbols-outlined').removeClass('text-red-500');
        }
    };

    $(document).ready(function () {

        const fetchSettings = () => {
            $('.skeleton-loader').addClass('animate-pulse opacity-50');

            $.get(apiUrl('settings') + 'patient-settings.php', function (response) {
                try {
                    const res = typeof response === 'string' ? JSON.parse(response) : response;

                    if (res.success && res.data) {
                        const data = res.data;

                        // Add profile image to pond
                        if (data.profile) {
                            if (data.profile && Object.keys(data.profile).length !== 0) {
                                window.profilePond.addFile(data.profile.folder, {
                                    type: "local",
                                    options: {
                                        file: {
                                            name: data.profile.filename,
                                        },
                                        metadata: {
                                            name: data.profile.filename,
                                            serverId: data.profile.folder,
                                        },
                                    },
                                });
                            }
                        }

                        // Populate Profile Form
                        $('#firstname').val(data.firstname);
                        $('#lastname').val(data.lastname);
                        $('#email').val(data.email);
                        $('#phone').val(data.phone);

                        // Populate Patient Info Form
                        $('#date_of_birth').val(data.date_of_birth);
                        $('#gender').val(data.gender);
                        $('#address').val(data.address);
                        $('#emergency_contact_name').val(data.emergency_contact_name);
                        $('#emergency_contact_phone').val(data.emergency_contact_phone);

                        // Populate Summary Card
                        const fullname = `${data.firstname} ${data.lastname}`;
                        $('#summary-name').text(fullname);
                        $('#summary-email').text(data.email);
                        $('#summary-status').text(data.status || 'Active');

                        if (data.created_at) {
                            const date = new Date(data.created_at);
                            $('#summary-joined').text(date.toLocaleDateString('en-US', {
                                year: 'numeric',
                                month: 'short',
                                day: 'numeric'
                            }));
                        }

                        // Avatar
                        const avatarUrl = data.avatar || `https://ui-avatars.com/api/?name=${encodeURIComponent(fullname)}&background=random`;
                        $('#profile-avatar').css('background-image', `url('${avatarUrl}')`);
                        $('#summary-avatar').css('background-image', `url('${avatarUrl}')`);

                    } else {
                        console.error('Failed to load settings:', res.message);
                        // Optional: Show error toast
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                } finally {
                    $('.skeleton-loader').removeClass('animate-pulse opacity-50');
                }
            }).fail(function () {
                console.error('API request failed');
                $('.skeleton-loader').removeClass('animate-pulse opacity-50');
            });
        };

        // Initial Load
        fetchSettings();

        // Save Handler
        $('#profile-form').validate({
            ...window.validatorConfig,
            rules: {
                firstname: "required",
                lastname: "required",
                email: { required: true, email: true },
                phone: { required: false }
            },
            messages: {
                firstname: "First name is required",
                lastname: "Last name is required",
                email: "Valid email is required"
            }
        });

        $('#patient-info-form').validate({
            ...window.validatorConfig,
            rules: {
                date_of_birth: { required: false, date: true },
                gender: { required: false }
            }
        });

        // Save Handler
        $('#save-settings-btn').on('click', function (e) {
            e.preventDefault();
            const $btn = $(this);
            const $btnText = $btn.find('span').not('.material-symbols-outlined');
            const $btnIcon = $btn.find('.material-symbols-outlined');

            // Trigger validation on both forms
            const isProfileValid = $('#profile-form').valid();
            const isPatientValid = $('#patient-info-form').valid();

            if (!isProfileValid || !isPatientValid) {
                if (window.toast && window.toast.error) {
                    window.toast.error('Please fix the errors before saving.');
                } else {
                    alert('Please fix the errors before saving.');
                }

                // Scroll to first error
                $('html, body').animate({
                    scrollTop: $('.text-red-500').first().offset().top - 100
                }, 500);

                return;
            }

            // Gather data
            const profileData = $('#profile-form').serializeArray();
            const patientData = $('#patient-info-form').serializeArray();
            const formData = [...profileData, ...patientData];

            let data = {};
            formData.forEach(item => {
                data[item.name] = item.value;
            });

            // Loading State
            $btn.prop('disabled', true);
            const originalIconText = $btnIcon.text();
            $btnIcon.text('progress_activity').addClass('animate-spin');

            $.post(apiUrl('settings') + 'patient-settings.php', data, function (response) {
                try {
                    const res = typeof response === 'string' ? JSON.parse(response) : response;

                    if (res.success) {
                        if (window.toast && window.toast.success) {
                            window.toast.success(res.message);
                        } else {
                            alert(res.message);
                        }

                        // Refresh data to ensure UI is in sync
                        fetchSettings();
                    } else {
                        // Backend validation errors
                        if (window.toast && window.toast.error) {
                            window.toast.error(res.message);
                        } else {
                            alert(res.message);
                        }
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    if (window.toast && window.toast.error) {
                        window.toast.error('An unexpected error occurred.');
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