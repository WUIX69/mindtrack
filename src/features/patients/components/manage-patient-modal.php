<?php
/**
 * Add/Edit Patient Modal
 *
 * @param string $title
 * @param string $subtitle
 */
?>
<div id="patient-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 modal-overlay hidden">
    <div class="absolute min-h-screen inset-0 bg-black/50 backdrop-blur-sm transition-opacity opacity-0"
        id="patient-modal-backdrop">
    </div>

    <div class="bg-card dark:bg-card w-full max-w-2xl rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[95vh] relative z-10 transform scale-95 opacity-0 transition-all duration-300"
        id="patient-modal-panel">

        <!-- Header -->
        <div class="px-8 py-6 border-b border-border flex justify-between items-center bg-card sticky top-0 z-10">
            <div>
                <h3 class="text-xl font-bold text-foreground" id="p-modal-title">Add New Patient</h3>
                <p class="text-xs text-muted-foreground font-medium mt-1 uppercase tracking-wider"
                    id="p-modal-subtitle">
                    Registering New Patient Record</p>
            </div>
            <button type="button" class="text-muted-foreground hover:text-foreground transition-colors p-modal-close">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto p-8">
            <form id="patient-form" class="space-y-8">
                <input type="hidden" name="uuid" id="patient-uuid">

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
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Email
                                Address</label>
                            <input type="email" name="email" required
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                                placeholder="sarah.j@email.com">
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
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Date
                                of Birth</label>
                            <input type="date" name="date_of_birth"
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all">
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Status</label>
                            <select name="status" id="patient-status"
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="on_leave">On Leave</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Gender</label>
                            <select name="gender"
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Address</label>
                        <textarea name="address" rows="2"
                            class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all resize-none"
                            placeholder="Full residence address..."></textarea>
                    </div>
                </div>

                <!-- Section 2: Emergency Contact -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">contact_emergency</span> 2. Emergency Contact
                    </h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Contact
                                Name</label>
                            <input type="text" name="emergency_contact_name"
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                                placeholder="Full Name">
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Contact
                                Phone</label>
                            <input type="tel" name="emergency_contact_phone"
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                                placeholder="(555) 000-0000">
                        </div>
                    </div>
                </div>

                <!-- Section 3: Medical History & Alerts -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">medical_information</span> 3. Medical History &
                        Alerts
                    </h4>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Conditions</label>
                            <textarea name="conditions" rows="2"
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all resize-none"
                                placeholder="Known medical conditions..."></textarea>
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Allergies</label>
                            <input type="text" name="allergies"
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                                placeholder="Food or drug allergies...">
                        </div>
                        <div>
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-3">Priority
                                Alerts</label>
                            <div class="grid grid-cols-3 gap-2">
                                <label
                                    class="flex items-center gap-2 p-3 rounded-lg border border-border bg-muted/30 cursor-pointer hover:bg-muted/50 transition-all">
                                    <input type="checkbox" name="alerts[]" value="critical"
                                        class="rounded border-border text-error focus:ring-error">
                                    <span class="text-xs font-bold text-error uppercase">Critical</span>
                                </label>
                                <label
                                    class="flex items-center gap-2 p-3 rounded-lg border border-border bg-muted/30 cursor-pointer hover:bg-muted/50 transition-all">
                                    <input type="checkbox" name="alerts[]" value="warning"
                                        class="rounded border-border text-warning focus:ring-warning">
                                    <span class="text-xs font-bold text-warning uppercase">Watch</span>
                                </label>
                                <label
                                    class="flex items-center gap-2 p-3 rounded-lg border border-border bg-muted/30 cursor-pointer hover:bg-muted/50 transition-all">
                                    <input type="checkbox" name="alerts[]" value="success"
                                        class="rounded border-border text-success focus:ring-success">
                                    <span class="text-xs font-bold text-success uppercase">Stable</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="p-password-container" class="space-y-4 hidden">
                    <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">lock</span> 4. Account Security
                    </h4>
                    <div>
                        <label
                            class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Password</label>
                        <input type="password" name="password" id="p-password"
                            class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                            placeholder="Leave blank to auto-generate">
                        <p class="text-[10px] text-muted-foreground mt-1">Default temporary password will be sent via
                            email if left blank.</p>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="px-8 py-6 border-t border-border flex justify-end gap-3 bg-card sticky bottom-0 z-10">
            <button type="button"
                class="px-6 py-2.5 text-sm font-bold text-muted-foreground hover:text-foreground transition-all p-modal-close">Cancel</button>
            <button type="submit" form="patient-form" id="p-submit-btn"
                class="px-8 py-2.5 bg-primary text-primary-foreground rounded-lg text-sm font-bold hover:opacity-90 transition-all shadow-lg shadow-primary/25">Add
                Patient</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const $modal = $('#patient-modal');
        const $backdrop = $('#patient-modal-backdrop');
        const $panel = $('#patient-modal-panel');
        const $form = $('#patient-form');
        const $submitBtn = $('#p-submit-btn');

        function openModal() {
            $modal.removeClass('hidden');
            setTimeout(() => {
                $backdrop.removeClass('opacity-0');
                $panel.removeClass('scale-95 opacity-0');
            }, 10);
        }

        window.closePatientModal = function () {
            $backdrop.addClass('opacity-0');
            $panel.addClass('scale-95 opacity-0');
            setTimeout(() => {
                $modal.addClass('hidden');
                $form[0].reset();
                $('#patient-uuid').val('');
            }, 300);
        }

        window.openPatientModal = function (mode, data = null) {
            if (mode === 'edit' && data) {
                $('#p-modal-title').text('Edit Patient');
                $('#p-modal-subtitle').text('Update Patient Record');
                $submitBtn.text('Save Changes');
                $('#p-password-container').addClass('hidden');

                $('#patient-uuid').val(data.uuid);
                $form.find('[name="firstname"]').val(data.firstname);
                $form.find('[name="lastname"]').val(data.lastname);
                $form.find('[name="email"]').val(data.email);
                $form.find('[name="phone"]').val(data.phone);
                $form.find('[name="status"]').val(data.status || 'active');
                $form.find('[name="date_of_birth"]').val(data.date_of_birth);
                $form.find('[name="gender"]').val(data.gender);
                $form.find('[name="address"]').val(data.address);
                $form.find('[name="emergency_contact_name"]').val(data.emergency_contact_name);
                $form.find('[name="emergency_contact_phone"]').val(data.emergency_contact_phone);

                // Medical History
                const history = data.medical_history || {};
                $form.find('[name="conditions"]').val(history.conditions || '');
                $form.find('[name="allergies"]').val(history.allergies || '');

                // Reset checkboxes
                $form.find('[name="alerts[]"]').prop('checked', false);
                if (history.alerts && Array.isArray(history.alerts)) {
                    history.alerts.forEach(alert => {
                        $form.find(`[name="alerts[]"][value="${alert}"]`).prop('checked', true);
                    });
                }

            } else {
                $('#p-modal-title').text('Add New Patient');
                $('#p-modal-subtitle').text('Registering New Patient Record');
                $submitBtn.text('Add Patient');
                $('#p-password-container').removeClass('hidden');
                $('#patient-uuid').val('');
                $form[0].reset();
            }
            openModal();
        }

        $form.on('submit', function (e) {
            e.preventDefault();
            const url = apiUrl('patients') + 'manage-patient.php';
            const formData = new FormData(this);
            const originalText = $submitBtn.text();

            $submitBtn.prop('disabled', true).html('<span class="material-symbols-outlined animate-spin text-sm">progress_activity</span> Processing...');

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
                    if (response.success) {
                        closePatientModal();
                        $('#patients-table').DataTable().ajax.reload();
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

        $(document).on('click', '.p-modal-close', function () {
            closePatientModal();
        });

        $modal.on('click', function (e) {
            if ($(e.target).is($modal)) closePatientModal();
        });
    });
</script>