<?php
/**
 * Add/Edit Doctor Modal
 *
 * A reuseable modal for creating and editing doctor profiles.
 * Handles styling adaptation from oklch to project theme.
 * @param string $title The title of the modal
 * @param string $subtitle The subtitle of the modal
 * @param string $isSubmit submit boolean
 */
?>
<!-- Modal Overlay -->
<div id="doctor-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 modal-overlay hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity opacity-0" id="modal-backdrop"></div>

    <!-- Modal Content -->
    <div class="bg-card dark:bg-card w-full max-w-2xl rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[95vh] relative z-10 transform scale-95 opacity-0 transition-all duration-300"
        id="modal-panel">

        <!-- Header -->
        <div class="px-8 py-6 border-b border-border flex justify-between items-center bg-card sticky top-0 z-10">
            <div>
                <h3 class="text-xl font-bold text-foreground" id="modal-title">Add New Doctor</h3>
                <p class="text-xs text-muted-foreground font-medium mt-1 uppercase tracking-wider" id="modal-subtitle">
                    Onboarding New Provider</p>
            </div>
            <button type="button" class="text-muted-foreground hover:text-foreground transition-colors modal-close">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Scrollable Body -->
        <div class="flex-1 overflow-y-auto p-8">
            <form id="doctor-form" class="space-y-8">
                <input type="hidden" name="uuid" id="doctor-uuid">

                <!-- Section 1: Profile Details -->
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="flex-1 space-y-4">
                        <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">person</span> 1. Profile Details
                        </h4>

                        <div class="grid grid-cols-1 gap-4">
                            <!-- Names -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">First
                                        Name</label>
                                    <input type="text" name="firstname"
                                        class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                                        placeholder="Jane">
                                </div>
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Last
                                        Name</label>
                                    <input type="text" name="lastname"
                                        class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                                        placeholder="Smith">
                                </div>
                            </div>

                            <!-- Password (Create Context Only) -->
                            <div id="password-container" class="grid grid-cols-1 hidden">
                                <label
                                    class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">
                                    Temporary Password
                                </label>
                                <div class="flex gap-2">
                                    <input type="text" name="password" id="temp-password"
                                        class="flex-1 bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all font-mono"
                                        placeholder="Generate or type password">
                                    <button type="button" id="generate-password-btn"
                                        class="px-4 py-2 bg-secondary text-secondary-foreground hover:bg-secondary/80 rounded-lg text-xs font-bold transition-colors flex items-center gap-2">
                                        <span class="material-symbols-outlined text-sm">autorenew</span>
                                        Generate
                                    </button>
                                </div>
                                <p class="text-[10px] text-muted-foreground mt-1">
                                    Required for new accounts. Doctors can change this later.
                                </p>
                            </div>

                            <!-- Email & Phone -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Email
                                        Address</label>
                                    <input type="email" name="email"
                                        class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                                        placeholder="jane.smith@mindtrack.com">
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

                            <!-- Specialty -->
                            <div>
                                <label
                                    class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Specialty</label>
                                <select name="specialty" id="doctor-specialty"
                                    class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all">
                                    <option value="">Select Specialty</option>
                                    <!-- Populated via JS -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Photo Upload -->
                    <div class="w-full md:w-32 flex flex-col items-center shrink-0">
                        <label
                            class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-3 text-center">Profile
                            Photo</label>
                        <div
                            class="group relative size-32 rounded-full border-2 border-dashed border-border flex flex-col items-center justify-center bg-muted/30 hover:border-primary transition-all cursor-pointer">
                            <span
                                class="material-symbols-outlined text-muted-foreground group-hover:text-primary mb-1">add_a_photo</span>
                            <span
                                class="text-[10px] font-semibold text-muted-foreground group-hover:text-primary">Upload</span>
                            <input type="file" name="avatar" class="hidden">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Professional Info -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">badge</span> 2. Professional Info
                    </h4>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">License
                                Number</label>
                            <input type="text" name="license_number"
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                                placeholder="MD-12345678">
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Brief
                                Biography</label>
                            <textarea name="bio" rows="3"
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all resize-none"
                                placeholder="Describe the doctor's experience and clinical focus..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Availability -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">schedule</span> 3. Initial Availability
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        <?php
                        $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                        foreach ($days as $day):
                            ?>
                            <label class="cursor-pointer">
                                <input type="checkbox" name="availability[]" value="<?= strtolower($day) ?>"
                                    class="hidden peer" <?= in_array($day, ['Mon', 'Tue', 'Wed', 'Thu', 'Fri']) ? 'checked' : '' ?>>
                                <div
                                    class="px-3 py-2 rounded-lg border border-border text-xs font-bold text-muted-foreground peer-checked:bg-primary/10 peer-checked:text-primary peer-checked:border-primary transition-all">
                                    <?= $day ?>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="px-8 py-6 border-t border-border flex justify-end gap-3 bg-card sticky bottom-0 z-10">
            <button type="button"
                class="px-6 py-2.5 text-sm font-bold text-muted-foreground hover:text-foreground transition-all modal-close">Cancel</button>
            <button type="submit" form="doctor-form"
                class="px-8 py-2.5 bg-primary text-primary-foreground rounded-lg text-sm font-bold hover:opacity-90 transition-all shadow-lg shadow-primary/25">Add
                Doctor</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        const $modal = $('#doctor-modal');
        const $backdrop = $('#modal-backdrop');
        const $panel = $('#modal-panel');
        const $form = $('#doctor-form');
        const $submitBtn = $form.find('button[type="submit"]');

        // UI Reusable Variables
        let $modalTitle = "<?= $title ?? 'Add New Doctor' ?>";
        let $modalSubtitle = "<?= $subtitle ?? 'Onboarding New Provider' ?>";
        let $isSubmit = "<?= $isSubmit ?? false ?>";

        // Fetch Specializations
        // function fetchSpecializations(selectedId = null) {
        //     const $select = $('#doctor-specialty');
        //     // Only fetch if empty (or force reload if needed, but checking length is good for caching in session)
        //     if ($select.children('option').length > 1 && !selectedId) return;

        //     $.get('/mindtrack/src/server/actions/specializations.php', function (response) {
        //         if (response.success) {
        //             let options = '<option value="">Select Specialty</option>';
        //             response.data.forEach(spec => {
        //                 options += `<option value="${spec.id}">${spec.name}</option>`;
        //             });
        //             $select.html(options);
        //             if (selectedId) $select.val(selectedId);
        //         }
        //     }, 'json');
        // }

        // --- Fetch Specialties Dynamically ---
        fetchSpecializations();
        function fetchSpecializations(selectedId = null) {
            $.ajax({
                url: apiUrl("shared") + "specializations.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        // The filterbar component might output a generic select. We need to find it.
                        // The name is "specialty".
                        const $select = $('#doctor-specialty');
                        response.data.forEach(function (spec) {
                            $select.append(`<option value="${spec.id}">${spec.name}</option>`);
                        });

                        if (selectedId) $select.val(selectedId);
                    }
                }
            });
        }

        // Animation Helpers
        function openModal() {
            $modal.removeClass('hidden');
            // Small timeout to allow removing hidden to take effect before animating opacity
            setTimeout(() => {
                $backdrop.removeClass('opacity-0');
                $panel.removeClass('scale-95 opacity-0');
            }, 10);
        }

        window.closeDoctorModal = function () {
            $backdrop.addClass('opacity-0');
            $panel.addClass('scale-95 opacity-0');

            // Wait for transition to finish
            setTimeout(() => {
                $modal.addClass('hidden');
                $form[0].reset(); // Reset form on close
                // Reset state
                $('#doctor-uuid').val('');
                $form.find('input[name="password"]').prop('required', true); // Require password for new
                $('#password-help').addClass('hidden');
            }, 300);
        }

        // Global function to open modal in specific mode
        window.openDoctorModal = function (mode, data = null) {
            if (mode === 'edit' && data) {
                // Edit Mode
                $('#modal-title').text('Edit Doctor');
                $('#modal-subtitle').text('Update Provider Details');
                $submitBtn.text('Save Changes');

                // Populate Form
                $('#doctor-uuid').val(data.uuid);
                $('input[name="firstname"]').val(data.firstname);
                $('input[name="lastname"]').val(data.lastname);
                $('input[name="email"]').val(data.email);
                $('input[name="phone"]').val(data.phone);
                $('input[name="phone"]').val(data.phone);
                // Fetch and select specialty
                fetchSpecializations(data.specialization_id);

                $('input[name="license_number"]').val(data.license_number);
                $('textarea[name="bio"]').val(data.bio);

                // Availability
                $('input[name="availability[]"]').prop('checked', false); // clear all
                if (data.availability) {
                    let availability = data.availability;
                    if (typeof availability === 'string') {
                        try {
                            availability = JSON.parse(availability);
                            // Handle object format (monday: {active: true...})
                            Object.keys(availability).forEach(day => {
                                if (availability[day].active) {
                                    $(`input[name="availability[]"][value="${day}"]`).prop('checked', true);
                                }
                            });
                        } catch (e) {
                            // Handle simple array format if exists
                        }
                    }
                }

                // Password not required for edit
                $form.find('input[name="password"]').prop('required', false);
                $('#password-container').addClass('hidden');
                $('#password-help').removeClass('hidden');

            } else {
                // Add Mode
                $('#modal-title').text($modalTitle);
                $('#modal-subtitle').text($modalSubtitle);
                $submitBtn.text('Add Doctor');
                $('#doctor-uuid').val('');
                $form[0].reset();

                // Password required for new
                $form.find('input[name="password"]').prop('required', true);
                $('#password-container').removeClass('hidden');
                $('#password-help').addClass('hidden');
            }
            openModal();
        };

        // Generate Password Handler
        $('#generate-password-btn').on('click', function () {
            const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
            let password = '';
            for (let i = 0; i < 12; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            $('#temp-password').val(password);
        });

        // Handle Form Submission
        $form.on('submit', function (e) {
            e.preventDefault();

            const uuid = $('#doctor-uuid').val();
            const url = apiUrl('doctors') + 'manage-doctor.php';

            const formData = new FormData(this);

            // Button Loading State
            const originalText = $submitBtn.text();
            $submitBtn.prop('disabled', true).html('<span class="material-symbols-outlined animate-spin text-sm">progress_activity</span> Saving...');

            // console.log(formData);
            // return false;

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    // console.log(response);
                    // return false;

                    if (response.success) {
                        // Show success toast (if available) or alert
                        // alert(response.message || 'Saved successfully');
                        closeDoctorModal();
                        // Reload DataTable
                        $('#doctors-table').DataTable().ajax.reload();
                    } else {
                        alert(response.error || 'An error occurred');
                    }
                },
                error: function (xhr) {
                    alert('Server error: ' + (xhr.responseJSON?.error || xhr.statusText));
                },
                complete: function () {
                    $submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });

        $(document).on('click', '.modal-close', function () {
            closeDoctorModal();
        });

        // Close on backdrop click
        $modal.on('click', function (e) {
            if ($(e.target).is($modal)) {
                closeDoctorModal();
            }
        });
    });
</script>