<!-- Today\'s Schedule -->
<div class="lg:col-span-2 space-y-4">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-foreground">Today\'s Schedule</h2>
        <button class="text-primary text-sm font-semibold hover:underline">View Full Calendar</button>
    </div>
    <div id="todays-schedule-list" class="space-y-4 min-h-[200px]">
        <!-- Loading State -->
        <div class="flex flex-col items-center justify-center h-48 space-y-4 animate-pulse">
            <div class="w-full h-24 bg-muted/40 rounded-xl"></div>
            <div class="w-full h-24 bg-muted/40 rounded-xl"></div>
        </div>
    </div>
</div>
<script>
    $(function () {
        const scheduleContainer = $('#todays-schedule-list');
        const endpoint = apiUrl('dashboard') + 'todays-schedule.php';

        function fetchSchedule() {
            $.ajax({
                url: endpoint,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        renderSchedule(response.data);
                    } else {
                        scheduleContainer.html(`<div class="p-4 text-center text-red-500">Failed to load schedule.</div>`);
                    }
                },
                error: function () {
                    scheduleContainer.html(`<div class="p-4 text-center text-red-500">Error connecting to server.</div>`);
                }
            });
        }

        function renderSchedule(appointments) {
            scheduleContainer.empty();

            if (!appointments || appointments.length === 0) {
                scheduleContainer.html(`
                    <div class="flex flex-col items-center justify-center h-48 text-muted-foreground border-2 border-dashed border-border rounded-xl">
                        <span class="material-symbols-outlined text-4xl opacity-50 mb-2">event_busy</span>
                        <p class="text-sm font-medium">No appointments scheduled for today.</p>
                    </div>
                `);
                return;
            }

            appointments.forEach(apt => {
                // Time Formatting
                const timeParts = apt.sched_time.split(':');
                const date = new Date();
                date.setHours(timeParts[0], timeParts[1]);
                const timeDisplay = date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' }).split(' ');

                // Patient Name & Initials
                const firstName = apt.patient_firstname || 'Unknown';
                const lastName = apt.patient_lastname || 'Patient';
                const fullName = `${firstName} ${lastName}`;
                const initials = firstName.charAt(0) + lastName.charAt(0);

                // Status Config
                const statusConfig = {
                    'confirmed': { label: 'Confirmed', class: 'bg-green-50 dark:bg-green-900/20 text-green-600' },
                    'pending': { label: 'Pending', class: 'bg-muted text-muted-foreground' },
                    'completed': { label: 'Completed', class: 'bg-blue-50 dark:bg-blue-900/20 text-blue-600' },
                    'cancelled': { label: 'Cancelled', class: 'bg-red-50 dark:bg-red-900/20 text-red-600' },
                    'rescheduled': { label: 'Rescheduled', class: 'bg-amber-50 dark:bg-amber-900/20 text-amber-600' },
                    'no_show': { label: 'No Show', class: 'bg-gray-100 dark:bg-gray-800 text-gray-500' }
                };
                const status = statusConfig[apt.status] || { label: apt.status, class: 'bg-muted text-muted-foreground' };

                // "Start Session" Button Logic
                const canStart = ['confirmed', 'rescheduled'].includes(apt.status);
                const btnClass = canStart
                    ? 'bg-primary text-primary-foreground hover:bg-primary/90 shadow-md shadow-primary/10'
                    : 'bg-muted text-muted-foreground cursor-not-allowed';
                const btnOnClick = canStart ? `onclick="window.location.href='<?= app('doctor/notes.php') ?>?appointment_uuid=${apt.uuid}'"` : 'disabled';

                const card = `
                    <div class="group bg-card p-5 rounded-xl border border-border shadow-sm hover:border-primary transition-all flex flex-col sm:flex-row items-start sm:items-center gap-4 ${canStart ? '' : 'opacity-80 hover:opacity-100'}">
                        <div class="w-16 flex flex-col items-center justify-center border-r border-border pr-4">
                            <span class="text-xs font-bold text-muted-foreground uppercase">${timeDisplay[0]}</span>
                            <span class="text-sm font-extrabold text-foreground">${timeDisplay[1]}</span>
                        </div>
                        <div class="flex-1 flex items-center gap-4 min-w-0">
                             <div class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary font-bold text-lg">
                                ${initials}
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-base truncate text-foreground">${fullName}</h4>
                                <p class="text-xs text-muted-foreground flex items-center gap-1">
                                    <span class="size-2 rounded-full ${canStart ? 'bg-primary' : 'bg-muted-foreground'}"></span>
                                    ${apt.service_name || 'Service'} • ${apt.service_duration || '?'}m
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 w-full sm:w-auto mt-2 sm:mt-0">
                            <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider rounded-md ${status.class}">
                                ${status.label}
                            </span>
                            <button ${btnOnClick} class="flex-1 sm:flex-none px-4 py-2 text-xs font-bold rounded-lg transition-all ${btnClass}">
                                Start Session
                            </button>
                        </div>
                    </div>
                `;
                scheduleContainer.append(card);
            });
        }

        // Init
        fetchSchedule();
    });
</script>