<?php
/**
 * Doctor Clinical Notes Page
 */
$currentPage = 'notes';
$pageTitle = "Clinical Notes - MindTrack Doctor";
$headContent = <<<'HTML'
<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
HTML;

include_once __DIR__ . '/layout.php';
?>

<div class="flex h-[calc(100vh-80px)] lg:h-[calc(100vh-96px)] overflow-hidden -m-8">
    <!-- Inner Sidebar: Session List -->
    <?= featured('notes', 'components/sidebar-notes') ?>

    <!-- Main Note Editor -->
    <section class="flex-1 flex flex-col bg-background-light dark:bg-background-dark overflow-hidden relative">
        <div id="editor-overlay"
            class="absolute inset-0 bg-background/80 backdrop-blur-sm z-50 flex items-center justify-center">
            <div class="text-center">
                <span class="material-symbols-outlined text-4xl text-primary animate-pulse mb-2">edit_document</span>
                <h2 class="text-xl font-bold text-foreground">Select a Session</h2>
                <p class="text-sm text-muted-foreground mt-1">Choose a session from the sidebar to view or write notes.
                </p>
            </div>
        </div>

        <div id="editor-loading"
            class="absolute inset-0 bg-background/50 backdrop-blur-sm z-40 hidden flex items-center justify-center">
            <span class="material-symbols-outlined text-4xl text-primary animate-spin">refresh</span>
        </div>

        <!-- Patient Header Sticky Bar -->
        <div
            class="px-8 py-6 border-b border-border flex flex-wrap gap-y-4 items-center justify-between sticky top-0 bg-background/95 backdrop-blur-md z-30">
            <div class="flex items-center gap-6">
                <div>
                    <h1 id="header-patient-name" class="text-2xl font-black text-foreground tracking-tight">Loading...
                    </h1>
                    <div
                        class="flex items-center gap-5 mt-1.5 text-[11px] font-bold text-muted-foreground uppercase opacity-80">
                        <span class="flex items-center gap-2" id="header-appointment-date">
                            <span class="material-symbols-outlined text-base text-primary/70">event</span>
                            --
                        </span>
                        <span class="flex items-center gap-2" id="header-note-status">
                            <span class="material-symbols-outlined text-base text-primary/70">info</span>
                            --
                        </span>
                    </div>
                </div>
                <div class="h-10 w-px bg-border hidden md:block"></div>
                <div class="hidden md:block">
                    <p class="text-[10px] font-black text-muted-foreground uppercase tracking-widest">Service</p>
                    <p id="header-service-name" class="text-sm font-bold text-primary mt-0.5 tracking-wide uppercase">--
                    </p>
                </div>
            </div>
        </div>

        <!-- Editor Content (Scrollable) -->
        <form id="note-form" class="flex-1 overflow-y-auto p-8 lg:p-12 flex flex-col">
            <input type="hidden" id="note-uuid" name="uuid" value="">
            <input type="hidden" id="note-appointment-uuid" name="appointment_uuid" value="">
            <input type="hidden" id="note-patient-uuid" name="patient_uuid" value="">

            <div class="space-y-12 flex-1">
                <!-- Subjective -->
                <div class="space-y-5 group">
                    <div
                        class="flex items-center gap-4 text-primary border-b border-primary/10 pb-3 transition-all group-focus-within:border-primary/30">
                        <div class="size-8 bg-primary/10 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl">forum</span>
                        </div>
                        <h4 class="font-black text-sm uppercase tracking-widest">Subjective</h4>
                    </div>
                    <div class="space-y-3">
                        <label
                            class="block text-[10px] font-black text-muted-foreground uppercase tracking-widest opacity-60">Patient's
                            Report & Symptoms</label>
                        <textarea id="note-subjective" name="subjective"
                            class="w-full min-h-[160px] p-6 bg-card border border-border rounded-2xl focus:ring-2 focus:ring-primary/5 focus:border-primary text-foreground/90 placeholder:text-muted-foreground/40 leading-relaxed shadow-sm transition-all"
                            placeholder="Enter patient reports, family history, and chief concerns..."></textarea>
                    </div>
                </div>

                <!-- Objective -->
                <div class="space-y-6 group">
                    <div class="space-y-4 group">
                        <label
                            class="block text-[11px] font-black text-muted-foreground/70 uppercase tracking-widest">Observations
                            & Vitals</label>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Blood Pressure Card -->
                            <div
                                class="bg-[#f8fafc] dark:bg-card border border-border/80 rounded-xl p-4 focus-within:ring-2 focus-within:ring-primary/10 focus-within:border-primary transition-all shadow-sm">
                                <label
                                    class="block text-[10px] font-bold text-muted-foreground/60 uppercase tracking-widest mb-1">Blood
                                    Pressure</label>
                                <div class="flex items-baseline gap-1.5">
                                    <input type="text" id="note-blood-pressure" name="blood_pressure"
                                        class="w-[90px] bg-transparent border-none p-0 focus:ring-0 text-2xl font-bold text-foreground/90 placeholder:text-muted-foreground/30"
                                        placeholder="120/80">
                                    <span class="text-sm font-medium text-muted-foreground/60">mmHg</span>
                                </div>
                            </div>

                            <!-- Heart Rate Card -->
                            <div
                                class="bg-[#f8fafc] dark:bg-card border border-border/80 rounded-xl p-4 focus-within:ring-2 focus-within:ring-primary/10 focus-within:border-primary transition-all shadow-sm">
                                <label
                                    class="block text-[10px] font-bold text-muted-foreground/60 uppercase tracking-widest mb-1">Heart
                                    Rate</label>
                                <div class="flex items-baseline gap-1.5">
                                    <input type="text" id="note-heart-rate" name="heart_rate"
                                        class="w-[60px] bg-transparent border-none p-0 focus:ring-0 text-2xl font-bold text-foreground/90 placeholder:text-muted-foreground/30"
                                        placeholder="72">
                                    <span class="text-sm font-medium text-muted-foreground/60">bpm</span>
                                </div>
                            </div>

                            <!-- Weight Card -->
                            <div
                                class="bg-[#f8fafc] dark:bg-card border border-border/80 rounded-xl p-4 focus-within:ring-2 focus-within:ring-primary/10 focus-within:border-primary transition-all shadow-sm">
                                <label
                                    class="block text-[10px] font-bold text-muted-foreground/60 uppercase tracking-widest mb-1">Weight</label>
                                <div class="flex items-baseline gap-1.5">
                                    <input type="text" id="note-weight" name="weight"
                                        class="w-[70px] bg-transparent border-none p-0 focus:ring-0 text-2xl font-bold text-foreground/90 placeholder:text-muted-foreground/30"
                                        placeholder="68.5">
                                    <span class="text-sm font-medium text-muted-foreground/60">kg</span>
                                </div>
                            </div>
                        </div>

                        <textarea id="note-objective" name="objective"
                            class="w-full min-h-[120px] p-5 bg-[#f8fafc] dark:bg-card border border-border/80 rounded-xl focus:ring-2 focus:ring-primary/10 focus:border-primary resize-y text-foreground/80 placeholder:text-muted-foreground/40 text-sm shadow-sm transition-all leading-relaxed"
                            placeholder="Neurological exam: Cranial nerves II-XII intact. Fundoscopic exam normal bilaterally..."></textarea>
                    </div>
                </div>

                <!-- Assessment -->
                <div class="space-y-5 group">
                    <div
                        class="flex items-center gap-4 text-primary border-b border-primary/10 pb-3 transition-all group-focus-within:border-primary/30">
                        <div class="size-8 bg-primary/10 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl">analytics</span>
                        </div>
                        <h4 class="font-black text-sm uppercase tracking-widest">Assessment</h4>
                    </div>
                    <div class="space-y-3">
                        <label
                            class="block text-[10px] font-black text-muted-foreground uppercase tracking-widest opacity-60">Diagnosis
                            & Clinical Impression</label>
                        <textarea id="note-assessment" name="assessment"
                            class="w-full min-h-[120px] p-6 bg-card border border-border rounded-2xl focus:ring-2 focus:ring-primary/5 focus:border-primary text-foreground/90 placeholder:text-muted-foreground/40 leading-relaxed shadow-sm transition-all"
                            placeholder="Summarize diagnosis and clinical impression..."></textarea>
                    </div>
                </div>

                <!-- Plan -->
                <div class="space-y-5 group pb-24"> <!-- Bottom padding for sticky footer -->
                    <div
                        class="flex items-center gap-4 text-primary border-b border-primary/10 pb-3 transition-all group-focus-within:border-primary/30">
                        <div class="size-8 bg-primary/10 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl">assignment</span>
                        </div>
                        <h4 class="font-black text-sm uppercase tracking-widest">Plan</h4>
                    </div>
                    <div class="space-y-3">
                        <label
                            class="block text-[10px] font-black text-muted-foreground uppercase tracking-widest opacity-60">Next
                            Steps & Prescriptions</label>
                        <textarea id="note-plan" name="plan"
                            class="w-full min-h-[140px] p-6 bg-card border border-border rounded-2xl focus:ring-2 focus:ring-primary/5 focus:border-primary text-foreground/90 placeholder:text-muted-foreground/40 leading-relaxed shadow-sm transition-all"
                            placeholder="Outline medication, follow-up, and therapy plan..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Sticky Footer Action Bar -->
            <footer
                class="shrink-0 bg-background/90 backdrop-blur-xl border-t border-border p-6 shadow-[0_-4px_20px_0_rgba(0,0,0,0.05)] mt-auto sticky bottom-0 z-30">
                <div class="flex items-center justify-between">
                    <div
                        class="flex items-center gap-3 text-muted-foreground text-[10px] font-black uppercase tracking-widest opacity-60 group">
                        <span id="save-status-icon"
                            class="material-symbols-outlined text-sm font-variation-settings-['FILL'_1]">info</span>
                        <span id="save-status-text">Ready to save</span>
                    </div>
                    <div class="flex gap-4">
                        <button type="button" id="btn-save-draft"
                            class="px-7 py-3 rounded-xl border-2 border-border text-foreground/70 font-black text-xs hover:bg-muted hover:text-foreground transition-all uppercase tracking-widest">
                            Save Draft
                        </button>
                        <button type="button" id="btn-sign-note"
                            class="px-10 py-3 rounded-xl bg-primary text-primary-foreground font-black text-xs shadow-lg shadow-primary/30 hover:shadow-primary/50 hover:-translate-y-0.5 transition-all flex items-center gap-3 uppercase tracking-widest disabled:opacity-50 disabled:cursor-not-allowed">
                            <span
                                class="material-symbols-outlined text-lg font-variation-settings-['wght'_600]">draw</span>
                            Finalize & Sign Note
                        </button>
                    </div>
                </div>
            </footer>
        </form>
    </section>
</div>

<!-- Modals -->
<?= featured('notes', 'components/sign-modal') ?>

<script>
    $(document).ready(function () {

        const params = new URLSearchParams(window.location.search);
        window.API_URL = apiUrl('notes') + 'notes.php';
        window.currentAppointmentUuid = params.get('appointment_uuid') || '';
        let currentPatientUuid = null;
        window.isNoteSigned = false;

        // --- Editor Logic ---
        window.loadNoteEditor = function (appointmentUuid) {
            window.currentAppointmentUuid = appointmentUuid;
            $('#editor-overlay').addClass('hidden');
            $('#editor-loading').removeClass('hidden');

            // Render sidebar again to highlight the active item
            window.renderSidebarNotes(window.currentNotes || []);

            $.ajax({
                url: window.API_URL + '?appointment_uuid=' + encodeURIComponent(appointmentUuid),
                method: 'GET',
                dataType: 'json',
                success: function (resp) {
                    // console.log(resp);
                    // return false;
                    try {
                        const res = typeof resp === 'string' ? JSON.parse(resp) : resp;
                        $('#editor-loading').addClass('hidden');

                        if (res.success && res.data.appointment) {
                            populateEditor(res.data.appointment, res.data.note);
                        } else {
                            alert('Could not load session details.');
                        }
                    } catch (e) {
                        $('#editor-loading').addClass('hidden');
                        console.error('Parse error', e);
                    }
                },
                error: function () {
                    $('#editor-loading').addClass('hidden');
                    alert('Connection error loading note.');
                }
            });
        }

        function populateEditor(appointment, note) {
            // console.log(appointment, note);
            // return false;

            // Headers
            $('#header-patient-name').text(`${appointment.patient_firstname} ${appointment.patient_lastname}`);

            const dateStr = new Date(appointment.sched_date + ' ' + appointment.sched_time).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit' });
            $('#header-appointment-date').html(`<span class="material-symbols-outlined text-base text-primary/70">event</span> ${dateStr}`);
            $('#header-service-name').text(appointment.service_name);

            // Form Fields
            $('#note-appointment-uuid').val(appointment.uuid);
            $('#note-patient-uuid').val(appointment.patient_uuid);

            if (note) {
                // Parse the JSON objective field to get vitals
                let objectiveData = {};
                try {
                    objectiveData = note.objective ? JSON.parse(note.objective) : {};
                } catch (e) {
                    // Fallback if not valid JSON
                    objectiveData = { objective: note.objective };
                }

                // console.log(objectiveData);
                // return false;

                $('#note-uuid').val(note.uuid);
                $('#note-subjective').val(note.subjective || '');
                $('#note-objective').val(objectiveData['objective'] || '');
                $('#note-blood-pressure').val(objectiveData['blood_pressure'] || '');
                $('#note-heart-rate').val(objectiveData['heart_rate'] || '');
                $('#note-weight').val(objectiveData['weight'] || '');
                $('#note-assessment').val(note.assessment || '');
                $('#note-plan').val(note.plan || '');

                window.isNoteSigned = note.status === 'signed';
                const statusLabel = window.isNoteSigned ? 'Signed Note' : 'Draft Note';
                $('#header-note-status').html(`<span class="material-symbols-outlined text-base text-primary/70">draw</span> ${statusLabel}`);

                setSaveStatus(`Last updated ${new Date(note.updated_at).toLocaleTimeString()}`, 'check_circle', 'text-emerald-500');
            } else {
                // New Note
                $('#note-uuid').val('');
                $('#note-subjective').val('');
                $('#note-objective').val('');
                $('#note-blood-pressure').val('');
                $('#note-heart-rate').val('');
                $('#note-weight').val('');
                $('#note-assessment').val('');
                $('#note-plan').val('');
                window.isNoteSigned = false;

                $('#header-note-status').html(`<span class="material-symbols-outlined text-base text-primary/70">draw</span> New Draft`);
                setSaveStatus('Draft ready to be saved', 'info', 'text-primary');
            }

            // Lock controls if signed
            const $inputs = $('#note-form textarea, #note-form input[type="text"]');
            const $btnSave = $('#btn-save-draft');
            const $btnSign = $('#btn-sign-note');

            if (window.isNoteSigned) {
                $inputs.prop('readonly', true).addClass('bg-muted/30 cursor-not-allowed opacity-80');
                $btnSave.hide();
                $btnSign.hide();
                setSaveStatus('Note is signed and finalized', 'lock', 'text-amber-500');
            } else {
                $inputs.prop('readonly', false).removeClass('bg-muted/30 cursor-not-allowed opacity-80');
                $btnSave.show();
                $btnSign.show();
            }
        }

        function setSaveStatus(text, icon, colorClass) {
            $('#save-status-text').text(text);
            $('#save-status-icon')
                .text(icon)
                .removeClass('text-emerald-500 text-amber-500 text-primary text-red-500')
                .addClass(colorClass);
        }

        window.getNoteFormData = function (status) {
            return {
                appointment_uuid: $('#note-appointment-uuid').val(),
                patient_uuid: $('#note-patient-uuid').val(),
                uuid: $('#note-uuid').val() || null,
                subjective: $('#note-subjective').val(),
                objective: $('#note-objective').val(),
                blood_pressure: $('#note-blood-pressure').val(),
                heart_rate: $('#note-heart-rate').val(),
                weight: $('#note-weight').val(),
                assessment: $('#note-assessment').val(),
                plan: $('#note-plan').val(),
                status: status
            };
        };

        // --- Save Action ---
        $('#btn-save-draft').click(function () {
            if (!window.currentAppointmentUuid || window.isNoteSigned) return;

            const data = window.getNoteFormData('draft');

            setSaveStatus('Saving draft...', 'sync', 'text-primary animate-spin');

            // console.log(data);
            // return false;

            $.ajax({
                url: API_URL,
                method: 'POST',
                data: JSON.stringify(data),
                dataType: 'json',
                contentType: 'application/json',
                success: function (resp) {
                    // console.log(resp);
                    // return false;
                    try {
                        const res = typeof resp === 'string' ? JSON.parse(resp) : resp;
                        alert(res.message);
                        if (res.success) {
                            setSaveStatus('Draft saved successfully', 'check_circle', 'text-emerald-500');
                            if (res.uuid) {
                                $('#note-uuid').val(res.uuid);
                            }
                            // Refresh sidebar to ensure note exists there
                            window.fetchSidebarNotes();
                        } else {
                            setSaveStatus('Error: ' + res.message, 'error', 'text-red-500');
                            alert(res.message);
                        }
                    } catch (e) {
                        setSaveStatus('Parse error', 'error', 'text-red-500');
                        console.error('Error saving', e);
                    }
                },
                error: function () {
                    setSaveStatus('Connection error', 'error', 'text-red-500');
                }
            });
        });

        // Initial Load
        window.fetchSidebarNotes();
        if (window.currentAppointmentUuid) {
            window.loadNoteEditor(window.currentAppointmentUuid);
        }

    });
</script>