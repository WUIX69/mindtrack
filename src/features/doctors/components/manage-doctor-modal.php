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
                                <select name="specialty" id="doctor-specialty" data-is-managed-modal="true"
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

                <!-- Section 3: Detailed Availability -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">schedule</span> 3. Weekly Availability
                    </h4>

                    <div class="bg-muted/30 rounded-xl border border-border overflow-hidden">
                        <div class="divide-y divide-border/50">
                            <?php
                            $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                            $defaultStart = '09:00';
                            $defaultEnd = '17:00';

                            foreach ($days as $day):
                                $dayLabel = ucfirst($day);
                                $isWeekend = in_array($day, ['saturday', 'sunday']);
                                $isChecked = !$isWeekend ? 'checked' : '';
                                $containerClass = !$isWeekend ? '' : 'opacity-50 pointer-events-none grayscale';
                                ?>
                                <div class="flex items-center justify-between p-4 group">
                                    <div class="w-20 shrink-0">
                                        <span
                                            class="text-xs font-bold text-muted-foreground uppercase tracking-wider"><?= $dayLabel ?></span>
                                    </div>
                                    <div class="flex-1 flex justify-center items-center gap-3 time-container transition-all <?= $containerClass ?>"
                                        id="container-<?= $day ?>">
                                        <div class="relative">
                                            <span
                                                class="absolute left-2.5 top-1/2 -translate-y-1/2 text-[10px] font-bold text-muted-foreground uppercase">From</span>
                                            <input type="time" name="availability[<?= $day ?>][start]"
                                                value="<?= $defaultStart ?>"
                                                class="bg-card border-border rounded-lg pl-10 pr-2 py-1.5 text-xs focus:ring-primary focus:border-primary w-full border shadow-sm">
                                        </div>
                                        <span class="text-muted-foreground text-xs font-bold lg:block hidden">—</span>
                                        <div class="relative">
                                            <span
                                                class="absolute left-2.5 top-1/2 -translate-y-1/2 text-[10px] font-bold text-muted-foreground uppercase">To</span>
                                            <input type="time" name="availability[<?= $day ?>][end]"
                                                value="<?= $defaultEnd ?>"
                                                class="bg-card border-border rounded-lg pl-10 pr-2 py-1.5 text-xs focus:ring-primary focus:border-primary w-full border shadow-sm">
                                        </div>
                                    </div>
                                    <div class="w-12 flex justify-end">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="availability[<?= $day ?>][active]" value="1"
                                                class="hidden peer day-toggle" data-target="container-<?= $day ?>"
                                                <?= $isChecked ?>>
                                            <div
                                                class="w-10 h-5 bg-muted peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary shadow-inner">
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
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

        // Toggle Day Logic
        $(document).on('change', '.day-toggle', function () {
            const targetId = $(this).data('target');
            const $container = $('#' + targetId);
            const isChecked = $(this).is(':checked');

            if (isChecked) {
                $container.removeClass('opacity-50 pointer-events-none grayscale');
            } else {
                $container.addClass('opacity-50 pointer-events-none grayscale');
            }
        });

        // UI Reusable Variables
        let $modalTitle = "<?= $title ?? 'Add New Doctor' ?>";
        let $modalSubtitle = "<?= $subtitle ?? 'Onboarding New Provider' ?>";
        let $isSubmit = "<?= $isSubmit ?? false ?>";

        // Animation Helpers
        function openModal() {
            $modal.removeClass('hidden');
            setTimeout(() => {
                $backdrop.removeClass('opacity-0');
                $panel.removeClass('scale-95 opacity-0');
            }, 10);
        }

        window.closeDoctorModal = function () {
            $backdrop.addClass('opacity-0');
            $panel.addClass('scale-95 opacity-0');
            setTimeout(() => {
                $modal.addClass('hidden');
                $form[0].reset();
                // Reset availability UI state
                $('.day-toggle').each(function () {
                    $(this).trigger('change');
                });
                $('#doctor-uuid').val('');
                $form.find('input[name="password"]').prop('required', true);
                $('#password-help').addClass('hidden');
            }, 300);
        }

        window.openDoctorModal = function (mode, data = null) {
            if (mode === 'edit' && data) {
                // Edit Mode
                $('#modal-title').text('Edit Doctor');
                $('#modal-subtitle').text('Update Provider Details');
                $submitBtn.text('Save Changes');

                // Populate Standard Fields
                $('#doctor-uuid').val(data.uuid);
                $('input[name="firstname"]').val(data.firstname);
                $('input[name="lastname"]').val(data.lastname);
                $('input[name="email"]').val(data.email);
                $('input[name="phone"]').val(data.phone);
                window.fetchSpecialties(data.specialization_id);
                $('input[name="license_number"]').val(data.license_number);
                $('textarea[name="bio"]').val(data.bio);

                // Populate Availability
                // Reset all to default first
                const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

                // Uncheck all initially to clear state
                // but actually standard form reset handles inputs, we need to handle visual state

                let schedule = data.availability;
                // Parse if string
                if (typeof schedule === 'string') {
                    try { schedule = JSON.parse(schedule); } catch (e) { schedule = {}; }
                }

                if (schedule && typeof schedule === 'object') {
                    days.forEach(day => {
                        const dayData = schedule[day];
                        const $row = $(`#container-${day}`).closest('.group');
                        const $toggle = $row.find('.day-toggle');

                        if (dayData && dayData.active) {
                            $toggle.prop('checked', true);
                            $row.find(`input[name="availability[${day}][start]"]`).val(dayData.start || '09:00');
                            $row.find(`input[name="availability[${day}][end]"]`).val(dayData.end || '17:00');
                        } else {
                            $toggle.prop('checked', false);
                        }
                        // Update visual state
                        $toggle.trigger('change');
                    });
                }

                // Password Handling
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

                // Reset Availability UI
                // Default Mon-Fri active, Sat-Sun inactive
                const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                days.forEach(day => {
                    const isWeekend = (day === 'saturday' || day === 'sunday');
                    const $toggle = $(`#container-${day}`).closest('.group').find('.day-toggle');
                    $toggle.prop('checked', !isWeekend);
                    $toggle.trigger('change');
                });

                // Password Handling
                $form.find('input[name="password"]').prop('required', true);
                $('#password-container').removeClass('hidden');
                $('#password-help').addClass('hidden');
            }
            openModal();
        };

        $('#generate-password-btn').on('click', function () {
            const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
            let password = '';
            for (let i = 0; i < 12; i++) {
                password += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            $('#temp-password').val(password);
        });

        $form.on('submit', function (e) {
            e.preventDefault();
            const uuid = $('#doctor-uuid').val();
            const url = apiUrl('doctors') + 'manage-doctor.php';
            const formData = new FormData(this);
            const originalText = $submitBtn.text();
            $submitBtn.prop('disabled', true).html('<span class="material-symbols-outlined animate-spin text-sm">progress_activity</span> Saving...');

            $.ajax({
                url: apiUrl('doctors') + 'manage-doctor.php', // Use full path logic if apiUrl is complex
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        closeDoctorModal();
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