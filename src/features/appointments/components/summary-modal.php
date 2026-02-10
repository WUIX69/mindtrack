<!-- View Summary Modal -->
<div id="summary-modal"
    class="fixed inset-0 z-[60] hidden items-center justify-center p-4 bg-background/80 backdrop-blur-sm">
    <div class="bg-card w-full max-w-lg rounded-[2.5rem] border border-border shadow-2xl p-8 transform transition-all">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-black text-foreground">Appointment Summary</h3>
            <button onclick="$('#summary-modal').addClass('hidden').removeClass('flex')"
                class="p-2 hover:bg-muted rounded-full transition-colors">
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

        <button onclick="$('#summary-modal').addClass('hidden').removeClass('flex')"
            class="w-full mt-8 py-4 bg-foreground text-background font-black rounded-2xl hover:opacity-90 transition-all">
            Close Summary
        </button>
    </div>
</div>
<script>
    $(function () {
        // Action Handlers
        $('body').on('click', '.view-summary-btn', function () {
            const uuid = $(this).data('uuid');
            const a = window.allAppointments.find(x => x.uuid === uuid);
            if (!a) return;

            const dateStr = new Date(a.sched_date).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });

            $('#summary-service-name').text(a.service_name);
            $('#summary-doctor-name').text(`Dr. ${a.doctor_firstname} ${a.doctor_lastname}`);
            $('#summary-date').text(dateStr);
            $('#summary-time').text(a.sched_time);

            const isConfirmed = a.status === 'confirmed';
            const isPending = a.status === 'pending';
            let statusClass = 'bg-muted text-muted-foreground';
            let statusLabel = a.status.charAt(0).toUpperCase() + a.status.slice(1).replace('_', ' ');

            if (isConfirmed) {
                statusClass = 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400';
                statusLabel = 'Approved';
            } else if (isPending) {
                statusClass = 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400';
                statusLabel = 'Pending Approval';
            } else if (a.status === 'rescheduled') {
                statusClass = 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400';
                statusLabel = 'Reschedule Approval';
            } else if (a.status === 'cancelled') {
                statusClass = 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400';
                statusLabel = 'Cancelled';
            }

            $('#summary-status').text(statusLabel).attr('class', '').addClass(`px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider ${statusClass}`);

            if (a.notes) {
                $('#summary-notes-container').removeClass('hidden');
                $('#summary-notes').text(a.notes);
            } else {
                $('#summary-notes-container').addClass('hidden');
            }

            $('#summary-modal').removeClass('hidden').addClass('flex');
        });
    });
</script>