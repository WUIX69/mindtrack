<?php
/**
 * Doctor Settings Page
 */
$pageTitle = "Account Settings - MindTrack Doctor";

$headerData = [
    'title' => 'Account Settings',
    'description' => 'Manage your clinical profile, scheduling rules, and account security preferences.'
];

include_once __DIR__ . '/layout.php';
?>

<div class="flex flex-col gap-8 pb-12">
    <form id="profile-form" class="flex flex-col gap-8">
        <!-- 1. Professional Profile Section -->
        <section
            class="bg-card rounded-2xl border border-border overflow-hidden shadow-sm transition-all hover:shadow-md">
            <div class="px-6 py-4 border-b border-border bg-muted/30 flex justify-between items-center">
                <h3 class="font-black text-sm uppercase tracking-widest flex items-center gap-2 text-foreground">
                    <span
                        class="material-symbols-outlined text-primary text-xl font-variation-settings-['FILL'_1]">account_circle</span>
                    Professional Profile
                </h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="flex flex-col gap-2">
                    <label
                        class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">First
                        Name</label>
                    <input name="firstname" id="firstname"
                        class="w-full rounded-xl border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary px-4 py-2.5 text-sm font-bold text-foreground transition-all"
                        type="text" />
                </div>
                <div class="flex flex-col gap-2">
                    <label
                        class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">Last
                        Name</label>
                    <input name="lastname" id="lastname"
                        class="w-full rounded-xl border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary px-4 py-2.5 text-sm font-bold text-foreground transition-all"
                        type="text" />
                </div>
                <div class="flex flex-col gap-2">
                    <label
                        class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">Email</label>
                    <input name="email" id="email"
                        class="w-full rounded-xl border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary px-4 py-2.5 text-sm font-bold text-foreground transition-all"
                        type="email" />
                </div>
                <div class="flex flex-col gap-2">
                    <label
                        class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">Phone</label>
                    <input name="phone" id="phone"
                        class="w-full rounded-xl border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary px-4 py-2.5 text-sm font-bold text-foreground transition-all"
                        type="text" />
                </div>
                <div class="flex flex-col gap-2">
                    <label
                        class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">Specialization</label>
                    <select name="specialization_id" id="specialization_id"
                        class="w-full rounded-xl border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary px-4 py-2.5 text-sm font-bold text-foreground transition-all">
                        <option value="">Select Specialization</option>
                        <!-- Populated via AJAX -->
                    </select>
                </div>
                <div class="flex flex-col gap-2">
                    <label
                        class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">License
                        Number</label>
                    <input name="license_number" id="license_number"
                        class="w-full rounded-xl border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary px-4 py-2.5 text-sm font-bold text-foreground transition-all"
                        type="text" />
                </div>
                <div class="flex flex-col gap-2">
                    <label
                        class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">Consultation
                        Fee</label>
                    <div class="relative">
                        <span class="absolute left-4 top-[10px] text-muted-foreground font-bold">₱</span>
                        <input name="consultation_fee" id="consultation_fee"
                            class="w-full pl-8 rounded-xl border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary px-4 py-2.5 text-sm font-bold text-foreground transition-all"
                            type="number" step="0.01" />
                    </div>
                </div>
                <div class="flex flex-col gap-2 md:col-span-2">
                    <label
                        class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">Biography</label>
                    <textarea name="bio" id="bio"
                        class="w-full rounded-xl border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary px-4 py-3 text-sm font-medium text-foreground/80 leading-relaxed transition-all"
                        placeholder="Enter your professional summary for patients to see..." rows="4"></textarea>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-border bg-muted/10 flex justify-end">
                <button type="submit" id="save-profile-btn"
                    class="flex items-center gap-2 bg-primary text-primary-foreground px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-primary/90 transition-all shadow-md">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Save Profile Settings</span>
                </button>
            </div>
        </section>
    </form>

    <!-- 2. Availability Management -->
    <form id="availability-form" class="flex flex-col gap-8">
        <section
            class="bg-card rounded-2xl border border-border overflow-hidden shadow-sm transition-all hover:shadow-md">
            <div class="px-6 py-4 border-b border-border bg-muted/30 flex justify-between items-center">
                <h3 class="font-black text-sm uppercase tracking-widest flex items-center gap-2 text-foreground">
                    <span
                        class="material-symbols-outlined text-primary text-xl font-variation-settings-['FILL'_1]">schedule</span>
                    Availability Management
                </h3>
            </div>
            <div class="p-6">
                <div id="availability-container" class="flex flex-col gap-1">
                    <!-- Dynamic rendering of 7 days via JS -->
                </div>
            </div>
            <div class="px-6 py-4 border-t border-border bg-muted/10 flex justify-end">
                <button type="submit" id="save-availability-btn"
                    class="flex items-center gap-2 bg-primary text-primary-foreground px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest hover:bg-primary/90 transition-all shadow-md">
                    <span class="material-symbols-outlined text-[18px]">save</span>
                    <span>Save Availability</span>
                </button>
            </div>
        </section>
    </form>

    <!-- 3. Security Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
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
                    <label
                        class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">Current
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
                    <label
                        class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">Confirm
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
</div>

<script>
    $(document).ready(function () {
        const daysOfWeek = [
            { id: 'monday', label: 'Monday' },
            { id: 'tuesday', label: 'Tuesday' },
            { id: 'wednesday', label: 'Wednesday' },
            { id: 'thursday', label: 'Thursday' },
            { id: 'friday', label: 'Friday' },
            { id: 'saturday', label: 'Saturday' },
            { id: 'sunday', label: 'Sunday' }
        ];

        const fetchSpecializations = () => {
            return $.ajax({
                url: apiUrl('shared') + 'specializations.php',
                type: 'GET',
                dataType: 'json',
                success: function (res) {
                    if (res.success && res.data) {
                        const $select = $('#specialization_id');
                        $select.empty().append('<option value="">Select Specialization</option>');
                        res.data.forEach(spec => {
                            $select.append(`<option value="${spec.id}">${spec.name}</option>`);
                        });
                    }
                }
            });
        };

        const renderAvailabilityUI = (availabilityInput) => {
            let availability = {};
            try {
                if (typeof availabilityInput === 'string') {
                    availability = JSON.parse(availabilityInput);
                } else if (typeof availabilityInput === 'object' && availabilityInput !== null) {
                    availability = availabilityInput;
                }
            } catch (e) {
                console.warn('Could not parse JSON availability:', e);
            }

            const $container = $('#availability-container');
            $container.empty();

            daysOfWeek.forEach(day => {
                const dayData = availability[day.id] || { start: '09:00', end: '17:00', active: "0" };
                const isActive = (dayData.active === true || dayData.active === "1" || String(dayData.active).toLowerCase() === 'true');

                const $row = $(`
                    <div class="grid grid-cols-12 items-center gap-6 py-4 border-b border-border/50 last:border-0 ${!isActive ? 'opacity-40 grayscale-[0.5]' : ''}">
                        <div class="col-span-3 text-xs font-black text-foreground uppercase tracking-widest">
                            ${day.label}
                        </div>
                        <div class="col-span-6 flex items-center gap-5">
                            <input class="availability-start rounded-lg border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary text-sm font-bold px-3 py-1.5 transition-all ${!isActive ? 'cursor-not-allowed' : ''}" type="time" data-day="${day.id}" value="${dayData.start || '09:00'}" ${!isActive ? 'disabled' : ''} />
                            <span class="text-[10px] font-black text-muted-foreground uppercase opacity-40 tracking-tighter">to</span>
                            <input class="availability-end rounded-lg border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary text-sm font-bold px-3 py-1.5 transition-all ${!isActive ? 'cursor-not-allowed' : ''}" type="time" data-day="${day.id}" value="${dayData.end || '17:00'}" ${!isActive ? 'disabled' : ''} />
                        </div>
                        <div class="col-span-3 flex justify-end items-center gap-4">
                            <span class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-50 state-label">
                                ${isActive ? 'Active' : 'Off'}
                            </span>
                            <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                <input type="checkbox" class="sr-only peer availability-toggle" data-day="${day.id}" ${isActive ? 'checked' : ''}>
                                <div class="w-9 h-5 bg-border peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/50 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                            </label>
                        </div>
                    </div>
                `);

                $container.append($row);
            });

            // Bind toggle event
            $('.availability-toggle').on('change', function () {
                const $row = $(this).closest('.grid');
                const isChecked = $(this).is(':checked');

                if (isChecked) {
                    $row.removeClass('opacity-40 grayscale-[0.5]');
                    $row.find('input[type="time"]').prop('disabled', false).removeClass('cursor-not-allowed');
                    $row.find('.state-label').text('Active');
                } else {
                    $row.addClass('opacity-40 grayscale-[0.5]');
                    $row.find('input[type="time"]').prop('disabled', true).addClass('cursor-not-allowed');
                    $row.find('.state-label').text('Off');
                }
            });
        };

        const fetchSettings = () => {
            $.ajax({
                url: apiUrl('settings') + 'doctor-settings.php',
                type: 'GET',
                dataType: 'json',
                beforeSend: function () {
                    $('.skeleton-loader').addClass('animate-pulse opacity-50');
                },
                complete: function () {
                    $('.skeleton-loader').removeClass('animate-pulse opacity-50');
                },
                success: function (response) {
                    if (!response.success || !response.data) return false;
                    const data = response.data;

                    // Populate Profile Form
                    $('#firstname').val(data.firstname);
                    $('#lastname').val(data.lastname);
                    $('#email').val(data.email);
                    $('#phone').val(data.phone);
                    $('#specialization_id').val(data.specialization_id);
                    $('#license_number').val(data.license_number);
                    $('#consultation_fee').val(data.consultation_fee);
                    $('#bio').val(data.bio);

                    // Render Availability UI
                    renderAvailabilityUI(data.availability);
                },
                error: ajaxErrorHandler
            });
        };

        // Initialize: Fetch specs then fetch settings
        fetchSpecializations().always(fetchSettings);

        // Save Profile & Availability
        const validatorConfig = {
            errorElement: 'span',
            errorClass: 'text-red-500 text-xs mt-1 block font-medium',
            highlight: function (element) {
                $(element).addClass('!border-red-500').removeClass('border-border');
            },
            unhighlight: function (element) {
                $(element).removeClass('!border-red-500').addClass('border-border');
            }
        };

        $('#profile-form').validate({
            ...validatorConfig,
            rules: {
                firstname: "required",
                lastname: "required",
                email: { required: true, email: true },
                specialization_id: "required"
            },
            submitHandler: function (form, e) {
                e.preventDefault();

                const $btn = $('#save-profile-btn');
                const $btnIcon = $btn.find('.material-symbols-outlined');
                const originalIconText = $btnIcon.text();

                $btn.prop('disabled', true);
                $btnIcon.text('progress_activity').addClass('animate-spin');

                const formDataArray = $(form).serializeArray();
                let data = {};
                formDataArray.forEach(item => {
                    data[item.name] = item.value;
                });
                data.action = 'updateWhereDoctor';

                $.ajax({
                    url: apiUrl('settings') + 'doctor-settings.php',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        alert(response.message);
                        if (response.success) {
                            if (window.toast && window.toast.success) toast.success(response.message);
                            fetchSettings();
                        } else {
                            if (window.toast && window.toast.error) toast.error(response.message || "Failed to update settings");
                        }
                    },
                    error: function (xhr, status, error) {
                        if (window.toast && window.toast.error) toast.error("An unexpected error occurred");
                        console.error("Save profile error:", error, xhr.responseText);
                    },
                    complete: function () {
                        $btn.prop('disabled', false);
                        $btnIcon.text(originalIconText).removeClass('animate-spin');
                    }
                });
            }
        });

        // Availability Form Submission
        $('#availability-form').on('submit', function (e) {
            e.preventDefault();

            const $btn = $('#save-availability-btn');
            const $btnIcon = $btn.find('.material-symbols-outlined');
            const originalIconText = $btnIcon.text();

            $btn.prop('disabled', true);
            $btnIcon.text('progress_activity').addClass('animate-spin');

            // Gather Availability state into JSON
            const availabilityData = {};
            $('.availability-toggle').each(function () {
                const day = $(this).data('day');
                const $row = $(this).closest('.grid');
                availabilityData[day] = {
                    start: $row.find('.availability-start').val() || '09:00',
                    end: $row.find('.availability-end').val() || '17:00',
                    active: $(this).is(':checked') ? "1" : "0"
                };
            });

            const data = {
                action: 'updateWhereDoctorAvailability',
                availability: JSON.stringify(availabilityData)
            };

            $.ajax({
                url: apiUrl('settings') + 'doctor-settings.php',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (response) {
                    alert(response.message);
                    if (response.success) {
                        if (window.toast && window.toast.success) toast.success(response.message);
                        fetchSettings();
                    } else {
                        if (window.toast && window.toast.error) toast.error(response.message || "Failed to update availability");
                    }
                },
                error: function (xhr, status, error) {
                    if (window.toast && window.toast.error) toast.error("An unexpected error occurred");
                    console.error("Save availability error:", error, xhr.responseText);
                },
                complete: function () {
                    $btn.prop('disabled', false);
                    $btnIcon.text(originalIconText).removeClass('animate-spin');
                }
            });
        });

        // Change Password Validation
        $('#change-password-form').validate({
            ...validatorConfig,
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
        $('#change-password-form').on('submit', function (e) {
            e.preventDefault();

            if (!$(this).valid()) return;

            const $btn = $('#update-password-btn');
            const $btnIcon = $btn.find('.material-symbols-outlined');
            const originalIconText = $btnIcon.text();

            $btn.prop('disabled', true);
            $btnIcon.text('progress_activity').addClass('animate-spin');

            const formData = $(this).serialize();

            $.ajax({
                url: apiUrl('settings') + 'change-password.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (res) {
                    if (res.success) {
                        if (window.toast && window.toast.success) toast.success(res.message);
                        $('#change-password-form')[0].reset();
                    } else {
                        if (window.toast && window.toast.error) toast.error(res.message);
                    }
                },
                error: function (xhr, status, error) {
                    if (window.toast && window.toast.error) toast.error('An unexpected error occurred.');
                    console.error("Password update error:", error, xhr.responseText);
                },
                complete: function () {
                    $btn.prop('disabled', false);
                    $btnIcon.text(originalIconText).removeClass('animate-spin');
                }
            });
        });
    });
</script>