<?php
/**
 * Manage Note Modal (Admin View)
 * 
 * An editable form modal for admins to create, read, update, and delete clinical notes.
 * Uses CSR for data population.
 */
?>
<!-- Manage Note Modal Overlay -->
<div id="manage-note-modal"
    class="fixed inset-0 z-[100] h-screen flex items-center justify-center p-4 modal-overlay hidden"
    style="background-color: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px);">
    <!-- Modal Content -->
    <div
        class="bg-card dark:bg-card w-full max-w-3xl rounded-[0.75rem] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">

        <!-- Header -->
        <div
            class="px-8 py-6 border-b border-border flex justify-between items-start bg-card sticky top-0 z-10 w-full shrink-0">
            <div class="flex items-start gap-4">
                <div
                    class="size-12 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0 mt-1">
                    <span id="manage-note-icon" class="material-symbols-outlined text-2xl">edit_document</span>
                </div>
                <div>
                    <div class="flex items-center gap-3">
                        <h3 id="manage-note-title" class="text-xl font-bold text-foreground">Edit Clinical Note</h3>
                        <span id="manage-note-status-badge"
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">
                        </span>
                    </div>
                    <p id="manage-note-subtitle" class="text-sm font-semibold text-muted-foreground mt-1">Update session
                        documentation</p>
                    <p id="manage-note-patient" class="text-xs text-primary font-bold tracking-wider mt-0.5"></p>
                </div>
            </div>
            <button id="close-manage-note-top-btn"
                class="size-10 flex items-center justify-center rounded-full hover:bg-muted text-muted-foreground hover:text-foreground transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Scrollable Body (Form) -->
        <div class="flex-1 overflow-y-auto p-8 bg-background/50">
            <form id="manage-note-form" class="space-y-8">
                <!-- Hidden fields -->
                <input type="hidden" id="note-uuid" name="uuid" value="">

                <!-- NOTE: For admin, creating a note requires explicit patient and appointment selection. 
                     Since building a huge multi-step selector is out of scope for this task (which is mainly managing existing notes), 
                     we will implement "Add" mode assuming the UI passes patient_uuid and appointment_uuid.
                     If they are empty, we show an alert. -->
                <input type="hidden" id="note-patient-uuid" name="patient_uuid" value="">
                <input type="hidden" id="note-appointment-uuid" name="appointment_uuid" value="">
                <input type="hidden" id="note-doctor-uuid" name="doctor_uuid" value="">

                <!-- Context Read-Only Section (populated on edit) -->
                <section id="note-context-section"
                    class="grid grid-cols-2 gap-6 bg-card p-6 rounded-xl border border-border">
                    <div>
                        <label
                            class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Service
                            & Date</label>
                        <p id="manage-note-service-date" class="text-sm font-semibold text-foreground">-</p>
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Provider</label>
                        <div class="flex items-center gap-2 mt-1">
                            <div id="manage-note-provider-img"
                                class="w-6 h-6 rounded-full bg-cover bg-center border border-border"></div>
                            <p id="manage-note-provider-name" class="text-sm font-semibold text-foreground">-</p>
                        </div>
                    </div>
                </section>

                <!-- Note Content (SOAP) -->
                <section class="space-y-6">
                    <!-- Subjective -->
                    <div class="space-y-3">
                        <label for="subjective"
                            class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">chat_bubble</span> Subjective
                        </label>
                        <textarea id="subjective" name="subjective" rows="4"
                            class="w-full bg-card border border-border rounded-xl px-4 py-3 text-sm text-foreground focus:ring-2 focus:ring-primary/20 transition-all resize-y placeholder:text-muted-foreground/50"
                            placeholder="Patient's chief complaint and symptoms in their own words..."></textarea>
                    </div>

                    <!-- Objective & Vitals -->
                    <div class="space-y-4">
                        <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">monitor_heart</span> Objective & Vitals
                        </h4>

                        <!-- Vitals Grid -->
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="blood_pressure"
                                    class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Blood
                                    Pressure (mmHg)</label>
                                <input type="text" id="blood_pressure" name="blood_pressure" placeholder="120/80"
                                    class="w-full bg-card border border-border rounded-lg px-3 py-2 text-sm text-foreground focus:ring-2 focus:ring-primary/20 transition-all">
                            </div>
                            <div>
                                <label for="heart_rate"
                                    class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Heart
                                    Rate (bpm)</label>
                                <input type="text" id="heart_rate" name="heart_rate" placeholder="72"
                                    class="w-full bg-card border border-border rounded-lg px-3 py-2 text-sm text-foreground focus:ring-2 focus:ring-primary/20 transition-all">
                            </div>
                            <div>
                                <label for="weight"
                                    class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Weight
                                    (kg)</label>
                                <input type="text" id="weight" name="weight" placeholder="65"
                                    class="w-full bg-card border border-border rounded-lg px-3 py-2 text-sm text-foreground focus:ring-2 focus:ring-primary/20 transition-all">
                            </div>
                        </div>

                        <!-- Objective Text -->
                        <textarea id="objective" name="objective" rows="4"
                            class="w-full bg-card border border-border rounded-xl px-4 py-3 text-sm text-foreground focus:ring-2 focus:ring-primary/20 transition-all resize-y placeholder:text-muted-foreground/50"
                            placeholder="Clinical observations, physical exam findings, test results..."></textarea>
                    </div>

                    <!-- Assessment -->
                    <div class="space-y-3">
                        <label for="assessment"
                            class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">psychology</span> Assessment
                        </label>
                        <textarea id="assessment" name="assessment" rows="3"
                            class="w-full bg-card border border-border rounded-xl px-4 py-3 text-sm text-foreground focus:ring-2 focus:ring-primary/20 transition-all resize-y placeholder:text-muted-foreground/50"
                            placeholder="Diagnosis and clinical reasoning..."></textarea>
                    </div>

                    <!-- Plan -->
                    <div class="space-y-3">
                        <label for="plan"
                            class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">clinical_notes</span> Plan
                        </label>
                        <textarea id="plan" name="plan" rows="3"
                            class="w-full bg-card border border-border rounded-xl px-4 py-3 text-sm text-foreground focus:ring-2 focus:ring-primary/20 transition-all resize-y placeholder:text-muted-foreground/50"
                            placeholder="Treatment plan, medications, follow-up recommendations..."></textarea>
                    </div>

                    <!-- Status Selection -->
                    <div class="space-y-3 pt-4 border-t border-border">
                        <label for="note_status"
                            class="text-xs font-bold text-muted-foreground uppercase tracking-widest">Document
                            Status</label>
                        <select id="note_status" name="status"
                            class="w-full max-w-xs bg-card border border-border rounded-xl px-4 py-2.5 text-sm font-semibold text-foreground focus:ring-2 focus:ring-primary/20 transition-all">
                            <option value="draft">Draft (Work in Progress)</option>
                            <option value="signed">Finalized & Signed</option>
                        </select>
                        <p class="text-[10px] text-muted-foreground">Signed notes cannot be modified later.</p>
                    </div>
                </section>
            </form>
        </div>

        <!-- Footer -->
        <div
            class="px-8 py-5 border-t border-border flex justify-between gap-3 bg-card sticky bottom-0 z-10 w-full shrink-0">
            <div>
                <button id="delete-note-btn" type="button"
                    class="hidden px-4 py-2.5 text-sm font-bold text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/30 transition-all rounded-lg">
                    Delete Note
                </button>
            </div>
            <div class="flex gap-3">
                <button type="button" id="close-manage-note-btn"
                    class="px-6 py-2.5 text-sm font-bold text-muted-foreground hover:text-foreground transition-all border border-border rounded-lg hover:border-foreground/20">Cancel</button>
                <button type="button" id="download-note-btn"
                    class="hidden px-6 py-2.5 bg-muted text-foreground rounded-lg text-sm font-bold hover:bg-muted/80 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">picture_as_pdf</span>
                </button>
                <button type="submit" form="manage-note-form" id="save-note-btn"
                    class="px-8 py-2.5 bg-primary text-primary-foreground rounded-lg text-sm font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/25 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">save</span>
                    Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const ManageNoteModal = {
        $modal: $('#manage-note-modal'),
        $form: $('#manage-note-form'),
        mode: 'add', // 'add' or 'edit'

        open: function (mode, data = {}) {
            this.mode = mode;
            this.resetForm();

            if (mode === 'edit') {
                $('#manage-note-title').text('Edit Clinical Note');
                $('#manage-note-subtitle').text('Manage existing session documentation');
                $('#manage-note-icon').text('edit_document');
                $('#delete-note-btn').removeClass('hidden');

                // Only show download if it's an existing note
                if (data.uuid) {
                    $('#download-note-btn').removeClass('hidden').data('id', data.uuid);
                }

                this.populate(data);

                // Admins can always edit notes, so no locking logic here
                $('#note_status').prop('disabled', false);
                $('#save-note-btn').removeClass('hidden');
                this.$form.find('input, select, textarea').prop('disabled', false);
                $('#note-uuid').prop('disabled', false);
                $('#note-patient-uuid').prop('disabled', false);
                $('#note-appointment-uuid').prop('disabled', false);
                $('#note-doctor-uuid').prop('disabled', false);
            } else {
                $('#manage-note-title').text('Create Clinical Note');
                $('#manage-note-subtitle').text('Transcribe a new session note');
                $('#manage-note-icon').text('post_add');
                $('#delete-note-btn').addClass('hidden');
                $('#download-note-btn').addClass('hidden');
                $('#note_status').prop('disabled', false);
                $('#save-note-btn').removeClass('hidden');
                this.$form.find('input, select, textarea').prop('disabled', false);
                $('#note-context-section').addClass('hidden'); // Hide context if we don't have it yet
            }

            this.$modal.removeClass('hidden');
            $('body').addClass('overflow-hidden');
        },

        close: function () {
            this.$modal.addClass('hidden');
            $('body').removeClass('overflow-hidden');
            this.resetForm();
        },

        resetForm: function () {
            this.$form[0].reset();
            this.$form.find('input[type="hidden"]').val('');
            $('#manage-note-status-badge').removeClass().addClass('hidden');
            $('#note-context-section').removeClass('hidden');
        },

        populate: function (data) {
            // Hidden Context
            $('#note-uuid').val(data.uuid || '');
            $('#note-patient-uuid').val(data.patient_uuid || '');
            $('#note-appointment-uuid').val(data.appointment_uuid || '');
            $('#note-doctor-uuid').val(data.doctor_uuid || '');

            // Formatting Date
            let formattedDate = 'Unknown Date';
            if (data.sched_date) {
                const dateObj = new Date(`${data.sched_date} ${data.sched_time || '00:00:00'}`);
                formattedDate = dateObj.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                if (data.sched_time) {
                    formattedDate += ' · ' + dateObj.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
                }
            }

            // Provider Info
            const doctorFullName = 'Dr. ' + (data.doctor_firstname || 'Unknown');
            $('#manage-note-service-date').text((data.service_name || 'General') + ' - ' + formattedDate);
            $('#manage-note-provider-name').text(doctorFullName);
            $('#manage-note-provider-img').css('background-image', `url('https://ui-avatars.com/api/?name=${encodeURIComponent(doctorFullName)}&background=random')`);

            // Patient Context (Admin only)
            const patientName = data.patient_firstname ? (data.patient_firstname + ' ' + (data.patient_lastname || '')) : 'Unknown Patient';
            $('#manage-note-patient').text('Patient: ' + patientName);

            // SOAP Content
            $('#subjective').val(data.subjective || '');

            // Parse Objective JSON
            let objectiveText = '';
            let bp = '';
            let hr = '';
            let weight = '';

            if (data.objective) {
                try {
                    const objData = JSON.parse(data.objective);
                    objectiveText = objData.objective || '';
                    bp = objData.blood_pressure || '';
                    hr = objData.heart_rate || '';
                    weight = objData.weight || '';
                } catch (e) {
                    objectiveText = data.objective; // fallback
                }
            }

            $('#blood_pressure').val(bp);
            $('#heart_rate').val(hr);
            $('#weight').val(weight);
            $('#objective').val(objectiveText);

            $('#assessment').val(data.assessment || '');
            $('#plan').val(data.plan || '');

            // Status Selection
            const status = (data.status || 'draft').toLowerCase();
            $('#note_status').val(status);

            // Status Badge
            const $statusBadge = $('#manage-note-status-badge');
            $statusBadge.removeClass('hidden').removeClass('bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400 bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400 bg-muted text-muted-foreground');

            if (status === 'signed') {
                $statusBadge.addClass('inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400').text('Completed');
            } else if (status === 'draft') {
                $statusBadge.addClass('inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400').text('Draft');
            } else {
                $statusBadge.addClass('inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-muted text-muted-foreground').text(status);
            }
        },

        save: function () {
            // Need to temporarily enable the select to serialize it if disabled
            const $statusSelect = $('#note_status');
            const wasDisabled = $statusSelect.prop('disabled');
            if (wasDisabled) $statusSelect.prop('disabled', false);

            const formData = this.$form.serializeArray();
            const dataObj = {};
            $(formData).each(function (i, field) {
                dataObj[field.name] = field.value;
            });
            dataObj.action = 'save';

            if (wasDisabled) $statusSelect.prop('disabled', true);

            // Validate requirements (admin must have these context IDs)
            if (!dataObj.patient_uuid || !dataObj.appointment_uuid || !dataObj.doctor_uuid) {
                alert("Cannot create note without linked patient, appointment, and provider records.");
                return;
            }

            const $btn = $('#save-note-btn');
            const originalText = $btn.html();
            $btn.html('<span class="material-symbols-outlined animate-spin">sync</span> Saving...').prop('disabled', true);

            $.ajax({
                url: apiUrl('notes') + 'admin-notes.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(dataObj),
                success: (response) => {
                    const res = typeof response === 'string' ? JSON.parse(response) : response;
                    if (res.success) {
                        alert(res.message);
                        this.close();
                        if ($.fn.DataTable.isDataTable('#admin-notes-table')) {
                            $('#admin-notes-table').DataTable().ajax.reload(null, false);
                        }
                    } else {
                        alert(res.message || 'Failed to save note.');
                        console.error(res.errors || res);
                    }
                },
                error: () => {
                    alert('Server communication error.');
                },
                complete: () => {
                    $btn.html(originalText).prop('disabled', false);
                }
            });
        },

        delete: function () {
            const uuid = $('#note-uuid').val();
            if (!uuid) return;

            if (confirm("Are you sure you want to permanently delete this clinical note? This action cannot be undone and will void the session record.")) {
                const $btn = $('#delete-note-btn');
                const originalText = $btn.html();
                $btn.html('Deleting...').prop('disabled', true);

                $.ajax({
                    url: apiUrl('notes') + 'admin-notes.php?uuid=' + uuid,
                    type: 'DELETE',
                    success: (response) => {
                        const res = typeof response === 'string' ? JSON.parse(response) : response;
                        if (res.success) {
                            this.close();
                            if ($.fn.DataTable.isDataTable('#admin-notes-table')) {
                                $('#admin-notes-table').DataTable().ajax.reload(null, false);
                            }
                        } else {
                            alert(res.message || 'Failed to delete note.');
                        }
                    },
                    error: () => {
                        alert('Server communication error.');
                    },
                    complete: () => {
                        $btn.html(originalText).prop('disabled', false);
                    }
                });
            }
        }
    };

    $(document).ready(function () {
        // Form submission
        $('#manage-note-form').on('submit', function (e) {
            e.preventDefault();
            ManageNoteModal.save();
        });

        // Delete button
        $('#delete-note-btn').on('click', function (e) {
            e.preventDefault();
            ManageNoteModal.delete();
        });

        // Close handlers
        $('#close-manage-note-btn, #close-manage-note-top-btn').on('click', function () {
            ManageNoteModal.close();
        });

        // Close on escape
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape' && !$('#manage-note-modal').hasClass('hidden')) {
                ManageNoteModal.close();
            }
        });

        // Close on click outside
        $('#manage-note-modal').on('click', function (e) {
            if (e.target === this) {
                ManageNoteModal.close();
            }
        });

        // Trigger PDF download
        $('#download-note-btn').on('click', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            if (id) {
                window.open(apiUrl("notes") + "export-pdf.php?uuid=" + id, '_blank');
            }
        });
    });
</script>