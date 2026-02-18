<!-- View Summary Modal -->
<div id="summary-modal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 modal-overlay hidden">
    <!-- Backdrop -->
    <div class="absolute min-h-screen inset-0 bg-background/80 backdrop-blur-sm transition-opacity opacity-0"
        id="summary-modal-backdrop">
    </div>

    <!-- Modal Panel -->
    <div class="bg-card w-full max-w-lg rounded-[2.5rem] border border-border shadow-2xl p-8 transform transition-all duration-300 scale-95 opacity-0 relative z-10"
        id="summary-modal-panel">

        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-black text-foreground">Appointment Summary</h3>
            <button type="button" class="summary-modal-close p-2 hover:bg-muted rounded-full transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="space-y-6">
            <div class="flex items-start gap-4 p-4 rounded-3xl bg-muted/50 border border-border">
                <div class="size-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl" id="summary-service-icon">psychology</span>
                </div>
                <div>
                    <p class="text-xs text-muted-foreground font-bold uppercase tracking-widest mb-1">Service &
                        Specialist</p>
                    <p class="text-lg font-black text-foreground" id="summary-service-name">---</p>
                    <p class="text-sm font-bold text-primary" id="summary-doctor-name">---</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="p-4 rounded-3xl bg-muted/30 border border-border">
                    <p class="text-[10px] text-muted-foreground font-bold uppercase tracking-widest mb-1">Date</p>
                    <p class="text-sm font-black text-foreground flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">calendar_today</span>
                        <span id="summary-date">---</span>
                    </p>
                </div>
                <div class="p-4 rounded-3xl bg-muted/30 border border-border">
                    <p class="text-[10px] text-muted-foreground font-bold uppercase tracking-widest mb-1">Time Slot</p>
                    <p class="text-sm font-black text-foreground flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-lg">schedule</span>
                        <span id="summary-time">---</span>
                    </p>
                </div>
            </div>

            <div id="summary-notes-container" class="hidden">
                <p class="text-[10px] text-muted-foreground font-bold uppercase tracking-widest mb-2 px-1">Session Notes
                </p>
                <div class="p-4 rounded-2xl bg-muted/20 border border-border italic text-sm text-foreground/80"
                    id="summary-notes">
                    No notes recorded for this session.
                </div>
            </div>

            <div class="flex items-center justify-between px-1">
                <span class="text-xs font-bold text-muted-foreground">Current Status</span>
                <span id="summary-status"
                    class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider">---</span>
            </div>
        </div>

        <button type="button"
            class="summary-modal-close w-full mt-8 py-4 bg-foreground text-background font-black rounded-2xl hover:opacity-90 transition-all">
            Close Summary
        </button>
    </div>
</div>

<script>
    $(function () {
        // Initialize global array if not already present
        window.allAppointments = window.allAppointments || [];

        const $modal = $('#summary-modal');
        const $backdrop = $('#summary-modal-backdrop');
        const $panel = $('#summary-modal-panel');

        function openModal() {
            $modal.removeClass('hidden');
            // Small timeout to allow display:flex to apply before transition
            setTimeout(() => {
                $backdrop.removeClass('opacity-0');
                $panel.removeClass('scale-95 opacity-0');
            }, 10);
        }

        window.closeSummaryModal = function () {
            $backdrop.addClass('opacity-0');
            $panel.addClass('scale-95 opacity-0');

            // Wait for transition to finish before hiding
            setTimeout(() => {
                $modal.addClass('hidden');
            }, 300);
        }

        window.openSummaryModal = function (uuid) {
            // Ensure strict comparison
            const a = window.allAppointments.find(x => String(x.uuid) === String(uuid));
            if (!a) {
                console.error('Appointment not found for UUID:', uuid);
                return;
            }

            const dateStr = new Date(a.sched_date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });

            $('#summary-service-name').text(a.service_name);
            $('#summary-doctor-name').text(`Dr. ${a.doctor_firstname} ${a.doctor_lastname}`);
            $('#summary-date').text(dateStr);
            $('#summary-time').text(a.sched_time);

            const statusColors = APPOINTMENT_STATUS_COLORS;

            const statusClass = statusColors[a.status.toLowerCase()] || 'bg-muted text-muted-foreground';
            const statusLabel = a.status.charAt(0).toUpperCase() + a.status.slice(1).replace('_', ' ');

            $('#summary-status').text(statusLabel).attr('class', '').addClass(`px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider ${statusClass}`);

            if (a.notes) {
                $('#summary-notes-container').removeClass('hidden');
                $('#summary-notes').text(a.notes);
            } else {
                $('#summary-notes-container').addClass('hidden');
            }

            openModal();
        };

        // Close handlers
        $(document).on('click', '.summary-modal-close', function () {
            closeSummaryModal();
        });

        $modal.on('click', function (e) {
            if ($(e.target).is($modal)) closeSummaryModal();
        });
    });
</script>