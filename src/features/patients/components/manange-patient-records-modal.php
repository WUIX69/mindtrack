<?php
/**
 * Manage Patient Records Modal (Doctor View)
 *
 * @param string $uuid (optional - injected via JS)
 */
?>
<div id="manage-records-modal" class="fixed inset-0 z-[100] h-screen flex items-center justify-center p-4 modal-overlay hidden">
    <div class="absolute min-h-screen inset-0 bg-black/50 backdrop-blur-sm transition-opacity opacity-0" id="records-modal-backdrop"></div>

    <div class="bg-card dark:bg-card w-full max-w-3xl rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh] relative z-10 transform scale-95 opacity-0 transition-all duration-300" id="records-modal-panel">

        <!-- Header -->
        <div class="px-8 py-6 border-b border-border flex justify-between items-center bg-card sticky top-0 z-10">
            <div>
                <h3 class="text-xl font-bold text-foreground" id="rec-patient-name">Patient Records</h3>
                <p class="text-xs text-muted-foreground font-bold mt-1 uppercase tracking-widest" id="rec-patient-id">
                    ID: --------
                </p>
            </div>
            <button type="button" class="text-muted-foreground hover:text-foreground transition-colors close-records-modal">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Tab Navigation -->
        <div class="px-8 bg-card border-b border-border sticky top-[88px] z-10">
            <div class="flex gap-8">
                <button type="button" class="py-4 text-xs font-black uppercase tracking-widest border-b-2 border-primary text-primary transition-all tab-btn" data-tab="overview">
                    Overview
                </button>
                <button type="button" class="py-4 text-xs font-black uppercase tracking-widest border-b-2 border-transparent text-muted-foreground hover:text-foreground transition-all tab-btn" data-tab="medical">
                    Medical History
                </button>
                <button type="button" class="py-4 text-xs font-black uppercase tracking-widest border-b-2 border-transparent text-muted-foreground hover:text-foreground transition-all tab-btn" data-tab="sessions">
                    Session History
                </button>
            </div>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto p-8" id="records-modal-body">
            
            <!-- Overview Tab -->
            <div id="tab-overview" class="tab-content space-y-8">
                <div class="grid grid-cols-2 gap-8">
                    <section class="space-y-4">
                        <h4 class="text-[10px] font-black text-primary uppercase tracking-[0.2em] flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">person</span> Basic Information
                        </h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Email Address</label>
                                <p class="text-sm font-medium text-foreground" id="rec-email">---</p>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Phone Number</label>
                                <p class="text-sm font-medium text-foreground" id="rec-phone">---</p>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Date of Birth</label>
                                    <p class="text-sm font-medium text-foreground" id="rec-dob">---</p>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Gender</label>
                                    <p class="text-sm font-medium text-foreground capitalize" id="rec-gender">---</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="space-y-4">
                        <h4 class="text-[10px] font-black text-primary uppercase tracking-[0.2em] flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">contact_emergency</span> Emergency Contact
                        </h4>
                        <div class="space-y-3 p-4 rounded-xl bg-muted/30 border border-border/50">
                            <div>
                                <label class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Contact Name</label>
                                <p class="text-sm font-black text-foreground" id="rec-ec-name">---</p>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Contact Phone</label>
                                <p class="text-sm font-bold text-foreground" id="rec-ec-phone">---</p>
                            </div>
                        </div>
                    </section>
                </div>

                <section class="space-y-4 pt-4 border-t border-border/50">
                    <h4 class="text-[10px] font-black text-primary uppercase tracking-[0.2em] flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">home</span> Resident Address
                    </h4>
                    <p class="text-sm font-medium text-foreground leading-relaxed" id="rec-address">---</p>
                </section>

                <section class="grid grid-cols-3 gap-4 pt-4 border-t border-border/50">
                    <div class="p-4 rounded-xl bg-primary/5 border border-primary/10">
                        <p class="text-[9px] font-black text-primary uppercase tracking-widest mb-1">Clinical Relationship</p>
                        <p class="text-lg font-black text-foreground" id="rec-total-sessions">0</p>
                        <p class="text-[10px] font-bold text-muted-foreground uppercase">Completed Sessions</p>
                    </div>
                    <div class="p-4 rounded-xl bg-muted/30 border border-border/50 col-span-2">
                        <p class="text-[9px] font-black text-muted-foreground uppercase tracking-widest mb-1">Last Clinical Interaction</p>
                        <p class="text-sm font-black text-foreground mt-1" id="rec-last-session">---</p>
                    </div>
                </section>
            </div>

            <!-- Medical History Tab (Editable) -->
            <div id="tab-medical" class="tab-content space-y-8 hidden">
                <form id="medical-history-form" class="space-y-6">
                    <input type="hidden" name="patient_uuid" id="rec-post-uuid">
                    
                    <div class="space-y-4">
                        <h4 class="text-[10px] font-black text-primary uppercase tracking-[0.2em] flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">clinical_notes</span> Clinical Profile
                        </h4>
                        
                        <div>
                            <label class="block text-[11px] font-black text-muted-foreground uppercase tracking-wider mb-2">Primary Conditions</label>
                            <textarea name="conditions" id="rec-conditions" rows="4" 
                                class="w-full bg-muted/50 border border-border rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all resize-none"
                                placeholder="Detail known medical or psychological conditions..."></textarea>
                        </div>

                        <div>
                            <label class="block text-[11px] font-black text-muted-foreground uppercase tracking-wider mb-2">Relevant Allergies & Sensitivities</label>
                            <input type="text" name="allergies" id="rec-allergies" 
                                class="w-full bg-muted/50 border border-border rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                                placeholder="Food, drug, or environmental allergies...">
                        </div>
                    </div>

                    <div class="space-y-4 pt-6 border-t border-border/50">
                        <h4 class="text-[10px] font-black text-primary uppercase tracking-[0.2em] flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">notification_important</span> Clinical Priority Alerts
                        </h4>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="flex items-center gap-3 p-4 rounded-xl border border-border bg-muted/30 cursor-pointer hover:bg-muted/50 transition-all group">
                                <input type="checkbox" name="alerts[]" value="critical" class="rounded-lg border-border text-error focus:ring-error size-5">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-error uppercase tracking-widest">Critical</span>
                                    <span class="text-[9px] text-muted-foreground font-bold leading-tight mt-0.5">High Risk / Urgent Care</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 p-4 rounded-xl border border-border bg-muted/30 cursor-pointer hover:bg-muted/50 transition-all group">
                                <input type="checkbox" name="alerts[]" value="warning" class="rounded-lg border-border text-warning focus:ring-warning size-5">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-warning uppercase tracking-widest">Watch</span>
                                    <span class="text-[9px] text-muted-foreground font-bold leading-tight mt-0.5">Moderate Observation</span>
                                </div>
                            </label>
                            <label class="flex items-center gap-3 p-4 rounded-xl border border-border bg-muted/30 cursor-pointer hover:bg-muted/50 transition-all group">
                                <input type="checkbox" name="alerts[]" value="success" class="rounded-lg border-border text-success focus:ring-success size-5">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-success uppercase tracking-widest">Stable</span>
                                    <span class="text-[9px] text-muted-foreground font-bold leading-tight mt-0.5">Routine Monitoring</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Session History Tab -->
            <div id="tab-sessions" class="tab-content hidden h-full">
                <div class="space-y-4 h-full flex flex-col">
                    <h4 class="text-[10px] font-black text-primary uppercase tracking-[0.2em] flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">history</span> Session Logs
                    </h4>
                    
                    <div class="flex-1 overflow-visible">
                        <table class="w-full text-left" id="rec-sessions-table">
                            <thead>
                                <tr class="text-[9px] font-black text-muted-foreground uppercase tracking-widest border-b border-border">
                                    <th class="pb-3">Date</th>
                                    <th class="pb-3">Service</th>
                                    <th class="pb-3">Status</th>
                                    <th class="pb-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border/50" id="rec-sessions-list">
                                <!-- Loaded via AJAX -->
                            </tbody>
                        </table>
                        <div id="sessions-empty" class="hidden py-12 flex flex-col items-center justify-center text-center">
                            <span class="material-symbols-outlined text-4xl text-muted-foreground/30 mb-2">event_busy</span>
                            <p class="text-sm font-bold text-muted-foreground">No sessions recorded with this patient.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer -->
        <div class="px-8 py-6 border-t border-border flex justify-end gap-3 bg-card sticky bottom-0 z-10">
            <button type="button" class="px-6 py-2.5 text-sm font-black text-muted-foreground hover:text-foreground transition-all close-records-modal">
                Close
            </button>
            <button type="submit" form="medical-history-form" id="save-medical-btn" class="hidden px-8 py-2.5 bg-primary text-primary-foreground rounded-xl text-sm font-black hover:opacity-90 transition-all shadow-lg shadow-primary/25">
                Save Records
            </button>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    const $modal = $('#manage-records-modal');
    const $backdrop = $('#records-modal-backdrop');
    const $panel = $('#records-modal-panel');
    const $form = $('#medical-history-form');
    const $saveBtn = $('#save-medical-btn');

    // --- Modal Controls ---
    window.openPatientRecordsModal = function(uuid) {
        // Reset state
        $('.tab-btn').removeClass('border-primary text-primary active').addClass('border-transparent text-muted-foreground');
        $('[data-tab="overview"]').addClass('border-primary text-primary active').removeClass('border-transparent text-muted-foreground');
        $('.tab-content').addClass('hidden');
        $('#tab-overview').removeClass('hidden');
        $saveBtn.addClass('hidden');

        // Show Modal
        $modal.removeClass('hidden');
        setTimeout(() => {
            $backdrop.removeClass('opacity-0');
            $panel.removeClass('scale-95 opacity-0');
        }, 10);

        loadPatientData(uuid);
    };

    function closeRecordsModal() {
        $backdrop.addClass('opacity-0');
        $panel.addClass('scale-95 opacity-0');
        setTimeout(() => {
            $modal.addClass('hidden');
        }, 300);
    }

    $('.close-records-modal, #records-modal-backdrop').on('click', function(e) {
        if (e.target === this || $(this).hasClass('close-records-modal')) {
            closeRecordsModal();
        }
    });

    // --- Tab Switching ---
    $('.tab-btn').on('click', function() {
        const tab = $(this).data('tab');
        
        $('.tab-btn').removeClass('border-primary text-primary active').addClass('border-transparent text-muted-foreground');
        $(this).addClass('border-primary text-primary active').removeClass('border-transparent text-muted-foreground');
        
        $('.tab-content').addClass('hidden');
        $(`#tab-${tab}`).removeClass('hidden');

        // Only show save button on medical tab
        if (tab === 'medical') {
            $saveBtn.removeClass('hidden');
        } else {
            $saveBtn.addClass('hidden');
        }

        if (tab === 'sessions') {
            loadSessionHistory($('#rec-post-uuid').val());
        }
    });

    // --- Data Loading ---
    function loadPatientData(uuid) {
        const url = apiUrl('patients') + 'manage-records.php?action=getPatientRecords&patient_uuid=' + uuid;
        
        // Show loading state here if desired
        $.getJSON(url, function(response) {
            if (response.success) {
                const p = response.data;
                $('#rec-post-uuid').val(p.uuid);
                $('#rec-patient-name').text(`${p.firstname} ${p.lastname}`);
                $('#rec-patient-id').text(`ID: ${p.uuid.substring(0, 8)}`);
                
                // Overview
                $('#rec-email').text(p.email);
                $('#rec-phone').text(p.phone || 'N/A');
                $('#rec-dob').text(p.date_of_birth || 'Not Set');
                $('#rec-gender').text(p.gender || 'Not Set');
                $('#rec-address').text(p.address || 'No address provided.');
                $('#rec-ec-name').text(p.emergency_contact_name || 'N/A');
                $('#rec-ec-phone').text(p.emergency_contact_phone || 'N/A');
                $('#rec-total-sessions').text(p.total_doctor_sessions || '0');
                $('#rec-last-session').text(p.last_session || 'None yet');

                // Medical History
                const mh = p.medical_history || {};
                $('#rec-conditions').val(mh.conditions || '');
                $('#rec-allergies').val(mh.allergies || '');
                
                // Reset Alerts
                $form.find('input[name="alerts[]"]').prop('checked', false);
                if (mh.alerts && Array.isArray(mh.alerts)) {
                    mh.alerts.forEach(alert => {
                        $form.find(`input[name="alerts[]"][value="${alert}"]`).prop('checked', true);
                    });
                }
            } else {
                alert(response.message || 'Failed to load record.');
                closeRecordsModal();
            }
        });
    }

    function loadSessionHistory(uuid) {
        const url = apiUrl('patients') + 'manage-records.php?action=getSessionHistory&patient_uuid=' + uuid;
        const $list = $('#rec-sessions-list');
        const $empty = $('#sessions-empty');
        const $table = $('#rec-sessions-table');

        $list.html(`<tr><td colspan="4" class="py-8 text-center text-muted-foreground italic">Fetching history...</td></tr>`);

        $.getJSON(url, function(response) {
            if (response.success && response.data.length > 0) {
                let html = '';
                response.data.forEach(s => {
                    const statusColors = { 'completed': 'emerald', 'confirmed': 'primary', 'no_show': 'red', 'cancelled': 'slate' };
                    const color = statusColors[s.status] || 'slate';
                    
                    html += `
                        <tr class="group hover:bg-muted/30 transition-all">
                            <td class="py-4">
                                <p class="text-sm font-black text-foreground">${s.sched_date}</p>
                                <p class="text-[10px] text-muted-foreground uppercase font-bold">${s.sched_time}</p>
                            </td>
                            <td class="py-4 text-xs font-bold text-muted-foreground">${s.service_name}</td>
                            <td class="py-4">
                                <span class="text-[9px] font-black uppercase tracking-widest text-${color}-600 dark:text-${color}-400">
                                    ${s.status}
                                </span>
                            </td>
                            <td class="py-4 text-right">
                                <button type="button" class="text-[10px] font-black uppercase text-primary hover:underline" onclick="window.location.href='/mindtrack/app/doctor/notes.php?appointment=${s.uuid}'">
                                    Notes
                                </button>
                            </td>
                        </tr>
                    `;
                });
                $list.html(html);
                $table.removeClass('hidden');
                $empty.addClass('hidden');
            } else {
                $table.addClass('hidden');
                $empty.removeClass('hidden');
            }
        });
    }

    // --- Form Submission ---
    $form.on('submit', function(e) {
        e.preventDefault();
        const url = apiUrl('patients') + 'manage-records.php?action=updateMedicalHistory';
        const formData = $(this).serialize();
        const originalText = $saveBtn.text();

        $saveBtn.prop('disabled', true).html('<span class="material-symbols-outlined animate-spin text-sm">progress_activity</span> Saving...');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Show success state briefly
                    $saveBtn.text('Saved!').removeClass('bg-primary').addClass('bg-emerald-500');
                    setTimeout(() => {
                        $saveBtn.text(originalText).addClass('bg-primary').removeClass('bg-emerald-500').prop('disabled', false);
                    }, 2000);
                } else {
                    alert(response.message || 'Error updating record.');
                    $saveBtn.prop('disabled', false).text(originalText);
                }
            },
            error: function() {
                alert('Connection error.');
                $saveBtn.prop('disabled', false).text(originalText);
            }
        });
    });
});
</script>

<style>
.tab-content.hidden { display: none; }
.modal-overlay { background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); }
</style>
