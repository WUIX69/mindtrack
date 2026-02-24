<?php
/**
 * Note Summary Modal (Patient View)
 * 
 * Displays the details of a clinical note for the patient.
 * Uses CSR for data population.
 */
?>
<!-- Note Summary Modal Overlay -->
<div id="note-summary-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 modal-overlay hidden"
    style="background-color: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px);">
    <!-- Modal Content -->
    <div
        class="bg-card dark:bg-card w-full max-w-2xl rounded-[0.75rem] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">

        <!-- Header -->
        <div class="px-8 py-6 border-b border-border flex justify-between items-start bg-card sticky top-0 z-10">
            <div class="flex items-start gap-4">
                <div
                    class="size-12 rounded-full bg-primary/10 flex items-center justify-center text-primary shrink-0 mt-1">
                    <span class="material-symbols-outlined text-2xl">description</span>
                </div>
                <div>
                    <div class="flex items-center gap-3">
                        <h3 class="text-xl font-bold text-foreground">Clinical Note</h3>
                        <span id="summary-note-status"
                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide">
                        </span>
                    </div>
                    <p id="summary-note-date" class="text-sm font-semibold text-muted-foreground mt-1"></p>
                    <p id="summary-note-provider" class="text-xs text-primary font-bold tracking-wider mt-0.5"></p>
                </div>
            </div>
            <button id="close-note-summary-btn"
                class="size-10 flex items-center justify-center rounded-full hover:bg-muted text-muted-foreground hover:text-foreground transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Scrollable Body -->
        <div class="flex-1 overflow-y-auto p-8 space-y-8">

            <!-- Appointment Details -->
            <section class="grid grid-cols-2 gap-6 bg-muted/30 p-6 rounded-xl border border-border">
                <div>
                    <label
                        class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Service</label>
                    <p id="summary-note-service" class="text-sm font-semibold text-foreground">-</p>
                </div>
                <div>
                    <label
                        class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Provider</label>
                    <div class="flex items-center gap-2 mt-1">
                        <div id="summary-note-provider-img"
                            class="w-6 h-6 rounded-full bg-cover bg-center border border-border"></div>
                        <p id="summary-note-provider-name" class="text-sm font-semibold text-foreground">-</p>
                    </div>
                </div>
            </section>

            <!-- Note Content (SOAP) -->
            <section class="space-y-6">

                <!-- Subjective & Objective -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">chat_bubble</span> Subjective
                        </h4>
                        <div
                            class="bg-card p-5 rounded-xl border border-border shadow-sm h-full max-h-[315px] overflow-y-auto">
                            <p id="summary-note-subjective"
                                class="text-sm text-foreground leading-relaxed whitespace-pre-wrap">No content.</p>
                        </div>
                    </div>
                    <div class="space-y-3 flex flex-col h-full">
                        <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">monitor_heart</span> Objective
                        </h4>
                        <!-- Vitals Grid (Fixed at top) -->
                        <div class="grid grid-cols-3 gap-3">
                            <div
                                class="bg-muted/30 p-3 rounded-lg flex flex-col items-center justify-center text-center border border-border">
                                <span class="material-symbols-outlined text-rose-500 mb-1 text-[20px]">favorite</span>
                                <span
                                    class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-0.5">Blood
                                    Pressure</span>
                                <span id="summary-note-bp" class="text-sm font-bold text-foreground">-</span>
                            </div>
                            <div
                                class="bg-muted/30 p-3 rounded-lg flex flex-col items-center justify-center text-center border border-border">
                                <span class="material-symbols-outlined text-amber-500 mb-1 text-[20px]">ecg_heart</span>
                                <span
                                    class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-0.5">Heart
                                    Rate</span>
                                <span id="summary-note-hr" class="text-sm font-bold text-foreground">-</span>
                            </div>
                            <div
                                class="bg-muted/30 p-3 rounded-lg flex flex-col items-center justify-center text-center border border-border">
                                <span class="material-symbols-outlined text-blue-500 mb-1 text-[20px]">weight</span>
                                <span
                                    class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-0.5">Weight</span>
                                <span id="summary-note-weight" class="text-sm font-bold text-foreground">-</span>
                            </div>
                        </div>
                        <!-- Objective Text (Scrollable) -->
                        <div
                            class="bg-card p-5 rounded-xl border border-border shadow-sm flex-1 max-h-[200px] overflow-y-auto">
                            <p id="summary-note-objective"
                                class="text-sm text-foreground leading-relaxed whitespace-pre-wrap">No content.</p>
                        </div>
                    </div>
                </div>

                <!-- Assessment & Plan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">psychology</span> Assessment
                        </h4>
                        <div
                            class="bg-card p-5 rounded-xl border border-border shadow-sm h-full max-h-[250px] overflow-y-auto">
                            <p id="summary-note-assessment"
                                class="text-sm text-foreground leading-relaxed whitespace-pre-wrap">No content.</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">clinical_notes</span> Plan
                        </h4>
                        <div
                            class="bg-card p-5 rounded-xl border border-border shadow-sm h-full max-h-[250px] overflow-y-auto">
                            <p id="summary-note-plan"
                                class="text-sm text-foreground leading-relaxed whitespace-pre-wrap">No content.</p>
                        </div>
                    </div>
                </div>

            </section>
        </div>

        <!-- Footer -->
        <div class="px-8 py-6 border-t border-border flex justify-end gap-3 bg-card sticky bottom-0 z-10">
            <button id="close-note-summary-footer-btn"
                class="px-6 py-2.5 text-sm font-bold text-muted-foreground hover:text-foreground transition-all border border-border rounded-lg hover:border-foreground/20">Close</button>
            <button id="download-note-btn"
                class="px-8 py-2.5 bg-primary text-primary-foreground rounded-lg text-sm font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/25 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">download</span>
                Download PDF
            </button>
        </div>
    </div>
</div>

<script>
    const NoteSummaryModal = {
        $modal: $('#note-summary-modal'),

        open: function (data) {
            this.populate(data);
            this.$modal.removeClass('hidden');
            $('body').addClass('overflow-hidden');
        },

        close: function () {
            this.$modal.addClass('hidden');
            $('body').removeClass('overflow-hidden');
        },

        populate: function (data) {
            // Formatting Date
            let formattedDate = 'Unknown Date';
            if (data.sched_date) {
                const dateObj = new Date(`${data.sched_date} ${data.sched_time || '00:00:00'}`);
                formattedDate = dateObj.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
                if (data.sched_time) {
                    formattedDate += ' at ' + dateObj.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' });
                }
            }
            $('#summary-note-date').text(formattedDate);

            // Provider Info
            const doctorFullName = 'Dr. ' + (data.doctor_firstname || 'Unknown Provider');
            $('#summary-note-provider').text(data.service_name || 'General Consultation');
            $('#summary-note-service').text(data.service_name || '-');
            $('#summary-note-provider-name').text(doctorFullName);
            $('#summary-note-provider-img').css('background-image', `url('https://ui-avatars.com/api/?name=${encodeURIComponent(doctorFullName)}&background=random')`);

            // SOAP Content
            $('#summary-note-subjective').text(data.subjective || '-');

            // Parse Objective JSON
            let objectiveText = '-';
            let bp = '-';
            let hr = '-';
            let weight = '-';

            if (data.objective) {
                try {
                    const objData = JSON.parse(data.objective);
                    objectiveText = objData.objective || '-';
                    bp = objData.blood_pressure || '-';
                    hr = objData.heart_rate ? objData.heart_rate + ' bpm' : '-';
                    weight = objData.weight ? objData.weight + ' kg' : '-';
                } catch (e) {
                    // Fallback if not valid JSON
                    objectiveText = data.objective;
                }
            }

            $('#summary-note-bp').text(bp);
            $('#summary-note-hr').text(hr);
            $('#summary-note-weight').text(weight);
            $('#summary-note-objective').text(objectiveText);

            $('#summary-note-assessment').text(data.assessment || '-');
            $('#summary-note-plan').text(data.plan || '-');
            // Status Badge
            const $statusBadge = $('#summary-note-status');
            $statusBadge.removeClass(); // clear existing classes
            if (data.status === 'signed') {
                $statusBadge.addClass('inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-400').text('Completed');
            } else if (data.status === 'draft') {
                $statusBadge.addClass('inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400').text('Draft');
            } else {
                $statusBadge.addClass('inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-muted text-muted-foreground').text(data.status || 'Unknown');
            }

            // Optional: Store ID in download button for future implementation
            $('#download-note-btn').data('id', data.uuid);
        }
    };

    $(document).ready(function () {
        // Close handlers
        $('#close-note-summary-btn, #close-note-summary-footer-btn').on('click', function () {
            NoteSummaryModal.close();
        });

        // Close on escape
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape' && !$('#note-summary-modal').hasClass('hidden')) {
                NoteSummaryModal.close();
            }
        });

        // Close on click outside
        $('#note-summary-modal').on('click', function (e) {
            if (e.target === this) {
                NoteSummaryModal.close();
            }
        });

        // Trigger PDF download
        $('#download-note-btn').on('click', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            if (id) {
                // Open the PDF generation endpoint in a new tab to initiate download
                window.open(apiUrl("notes") + "export-pdf.php?uuid=" + id, '_blank');
            }
        });
    });
</script>