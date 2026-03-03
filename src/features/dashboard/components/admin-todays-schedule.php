<!-- Today's Schedule Sidebar Widget -->
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-bold">Today's Schedule</h3>
        <button class="p-1.5 rounded-lg border border-border hover:bg-muted transition-all">
            <span class="material-symbols-outlined text-[18px]">calendar_today</span>
        </button>
    </div>
    <div id="admin-schedule-container" class="bg-card rounded-xl border border-border p-5 shadow-sm">
        <!-- Loading State -->
        <div class="space-y-6 animate-pulse">
            <div class="flex items-start gap-3">
                <div class="size-[22px] rounded-full bg-muted/40 shrink-0"></div>
                <div class="flex-1 space-y-2">
                    <div class="w-24 h-3 bg-muted/40 rounded"></div>
                    <div class="w-32 h-4 bg-muted/40 rounded"></div>
                    <div class="w-20 h-3 bg-muted/40 rounded"></div>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="size-[22px] rounded-full bg-muted/40 shrink-0"></div>
                <div class="flex-1 space-y-2">
                    <div class="w-24 h-3 bg-muted/40 rounded"></div>
                    <div class="w-32 h-4 bg-muted/40 rounded"></div>
                    <div class="w-20 h-3 bg-muted/40 rounded"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        const scheduleContainer = $('#admin-schedule-container');
        const scheduleEndpoint = apiUrl('dashboard') + 'todays-schedule.php';

        const statusConfig = {
            'confirmed': { label: 'Confirmed', borderClass: 'border-primary', textClass: 'text-primary' },
            'pending': { label: 'Pending', borderClass: 'border-orange-500', textClass: 'text-orange-500' },
            'completed': { label: 'Completed', borderClass: 'border-green-500', textClass: 'text-green-500' },
            'cancelled': { label: 'Cancelled', borderClass: 'border-red-500', textClass: 'text-red-500' },
            'rescheduled': { label: 'Rescheduled', borderClass: 'border-amber-500', textClass: 'text-amber-500' },
            'no_show': { label: 'No Show', borderClass: 'border-gray-400', textClass: 'text-gray-400' }
        };

        function fetchAdminSchedule() {
            $.ajax({
                url: scheduleEndpoint,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        renderTimeline(response.data);
                    } else {
                        renderError();
                    }
                },
                error: function () {
                    renderError();
                }
            });
        }

        function formatTime(schedTime) {
            const parts = schedTime.split(':');
            const dateObj = new Date();
            dateObj.setHours(parseInt(parts[0]), parseInt(parts[1]));
            return dateObj.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        }

        function renderTimeline(appointments) {
            if (!appointments || appointments.length === 0) {
                scheduleContainer.html(`
                    <div class="flex flex-col items-center justify-center py-10 text-muted-foreground">
                        <span class="material-symbols-outlined text-4xl opacity-50 mb-2">event_busy</span>
                        <p class="text-sm font-medium">No appointments scheduled for today.</p>
                    </div>
                `);
                return;
            }

            const maxDisplay = 5;
            const displayAppointments = appointments.slice(0, maxDisplay);
            const remaining = appointments.length - maxDisplay;

            let timelineHtml = `<div class="relative space-y-6 before:absolute before:left-[11px] before:top-2 before:bottom-2 before:w-0.5 before:bg-muted">`;

            displayAppointments.forEach(function (apt, index) {
                const timeDisplay = formatTime(apt.sched_time);
                const status = statusConfig[apt.status] || { label: apt.status, borderClass: 'border-border', textClass: 'text-muted-foreground' };
                const patientName = (apt.patient_firstname || 'Unknown') + ' ' + (apt.patient_lastname || 'Patient');
                const doctorName = (apt.doctor_firstname || '') + ' ' + (apt.doctor_lastname || '');
                const isFirst = index === 0;

                timelineHtml += `
                    <div class="relative pl-8 group">
                        <div class="absolute left-0 top-1 size-[22px] rounded-full bg-card border-2 ${status.borderClass} ${isFirst ? 'ring-4 ring-primary/5' : ''} z-10"></div>
                        <div class="flex flex-col">
                            <span class="text-[10px] font-bold ${status.textClass} uppercase tracking-widest leading-none mb-1">
                                ${timeDisplay} - ${status.label}
                            </span>
                            <h4 class="text-sm font-bold text-foreground">${apt.service_name || 'Service'}</h4>
                            <p class="text-xs text-muted-foreground mt-0.5">Patient: ${patientName}</p>
                            <div class="mt-2 flex items-center gap-1.5 text-[10px] text-muted-foreground">
                                <span class="material-symbols-outlined text-[14px]">person</span> Dr. ${doctorName.trim()}
                            </div>
                        </div>
                    </div>
                `;
            });

            timelineHtml += `</div>`;

            if (remaining > 0) {
                timelineHtml += `
                    <p class="text-center text-xs text-muted-foreground mt-4 font-medium">
                        + ${remaining} more appointment${remaining > 1 ? 's' : ''} today
                    </p>
                `;
            }

            timelineHtml += `
                <button onclick="window.location.href='<?= app('admin/appointments') ?>'"
                    class="w-full mt-6 py-2.5 bg-muted text-muted-foreground text-xs font-bold rounded-lg hover:bg-muted/80 transition-all uppercase tracking-wider">
                    VIEW FULL CALENDAR
                </button>
            `;

            scheduleContainer.html(timelineHtml);
        }

        function renderError() {
            scheduleContainer.html(`
                <div class="flex flex-col items-center justify-center py-10 text-red-500">
                    <span class="material-symbols-outlined text-3xl mb-2">error</span>
                    <p class="text-sm font-medium">Failed to load schedule.</p>
                </div>
            `);
        }

        fetchAdminSchedule();
    });
</script>