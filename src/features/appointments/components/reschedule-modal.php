<!-- Reschedule Modal -->
<div id="reschedule-modal"
    class="fixed inset-0 z-[60] hidden items-center justify-center p-4 bg-background/80 backdrop-blur-sm">
    <div class="bg-card w-full max-w-lg rounded-[2.5rem] border border-border shadow-2xl p-8 transform transition-all">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-black text-foreground tracking-tight">Reschedule Session</h3>
            <button onclick="$('#reschedule-modal').addClass('hidden').removeClass('flex')"
                class="p-2 hover:bg-muted rounded-full transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="space-y-6">
            <!-- Summary Info -->
            <div class="flex items-center gap-4 p-4 rounded-3xl bg-muted/50 border border-border">
                <div class="size-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">schedule</span>
                </div>
                <div>
                    <p class="text-[10px] text-muted-foreground font-bold uppercase tracking-widest mb-0.5">Current
                        Specialist</p>
                    <p class="text-base font-black text-foreground" id="reschedule-summary-doctor">---</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="space-y-2">
                    <label class="text-xs font-black text-muted-foreground uppercase tracking-wider ml-1">New
                        Date</label>
                    <div class="relative">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground">calendar_today</span>
                        <input type="date" id="reschedule-date"
                            class="w-full pl-12 pr-6 py-4 bg-muted/30 border border-border rounded-2xl text-sm font-bold focus:ring-4 focus:ring-primary/10 focus:border-primary outline-none transition-all"
                            min="" value="">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black text-muted-foreground uppercase tracking-wider ml-1">Available
                        Times</label>
                    <div class="grid grid-cols-3 gap-3" id="reschedule-time-slots">
                        <!-- Rendered via JS -->
                    </div>
                </div>
            </div>
        </div>

        <button id="confirm-reschedule-btn"
            class="w-full mt-10 py-4 bg-primary text-white font-black rounded-2xl hover:opacity-95 shadow-xl shadow-primary/20 transform transition-all active:scale-[0.98] flex items-center justify-center gap-2">
            Confirm New Schedule
            <span class="material-symbols-outlined text-xl">event_available</span>
        </button>
    </div>
</div>
<script>
    $(function () {

        // Initialize global array if not already present
        window.allAppointments = window.allAppointments || [];

        let activeRescheduleUuid = null;
        let activeRescheduleService = null;
        let activeRescheduleDoctor = null;
        let activeRescheduleNotes = null;
        const MODAL_TIME_SLOTS = ['9:00 AM', '10:30 AM', '11:00 AM', '2:00 PM', '3:30 PM', '4:45 PM'];

        function initModalDates() {
            const today = new Date().toISOString().split('T')[0];
            $('#reschedule-date').attr('min', today).val(today);
        }

        initModalDates();

        $('body').on('click', '.reschedule-btn', function () {
            const uuid = $(this).data('uuid');
            const service = $(this).data('service');
            const doctor = $(this).data('doctor');
            const notes = $(this).data('notes');
            const a = window.allAppointments.find(x => x.uuid === uuid);

            if (!a) return;

            activeRescheduleUuid = uuid;
            activeRescheduleService = service;
            activeRescheduleDoctor = doctor;
            activeRescheduleNotes = notes;

            $('#reschedule-summary-doctor').text(`Dr. ${a.doctor_firstname} ${a.doctor_lastname}`);
            renderRescheduleSlots();
            $('#reschedule-modal').removeClass('hidden').addClass('flex');
        });

        function renderRescheduleSlots() {
            let html = '';
            MODAL_TIME_SLOTS.forEach((time, index) => {
                html += `
                    <label class="cursor-pointer">
                        <input type="radio" name="reschedule_time" value="${time}"
                            class="peer absolute opacity-0" ${index === 0 ? 'checked' : ''} />
                        <div class="py-3 px-2 text-xs font-black rounded-xl border-2 border-transparent bg-muted/30 text-muted-foreground transition-all text-center peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary hover:border-primary/30">
                            ${time}
                        </div>
                    </label>
                `;
            });
            $('#reschedule-time-slots').html(html);
        }

        $('#confirm-reschedule-btn').on('click', function () {
            if (!activeRescheduleUuid) return;

            const btn = $(this);
            const date = $('#reschedule-date').val();
            const timeSlot = $('input[name="reschedule_time"]:checked').val();

            if (!date || !timeSlot) {
                alert('Please select a valid date and time.');
                return;
            }

            btn.prop('disabled', true).html('<span class="loading loading-spinner"></span> Rescheduling...');

            const bookingData = {
                appointment_uuid: activeRescheduleUuid,
                service_uuid: activeRescheduleService,
                doctor_uuid: activeRescheduleDoctor,
                sched_date: date,
                sched_time: timeSlot,
                notes: activeRescheduleNotes,
                is_reschedule: true
            };

            $.ajax({
                url: apiUrl("appointments") + "book.php",
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(bookingData),
                success: function (response) {
                    if (!response.success) {
                        alert('Error: ' + response.message);
                        return;
                    }
                    $('#reschedule-modal').addClass('hidden').removeClass('flex');
                    if (typeof window.fetchAppointments === 'function') {
                        window.fetchAppointments(); // Refresh list
                    }
                },
                error: function () {
                    alert('An unexpected error occurred. Please try again.');
                },
                complete: function () {
                    btn.prop('disabled', false).html('Confirm New Schedule <span class="material-symbols-outlined text-xl">event_available</span>');
                    activeRescheduleUuid = null;
                }
            });
        });
    });
</script>