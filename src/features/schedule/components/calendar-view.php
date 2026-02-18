<style>
    .calendar-grid {
        display: grid;
        grid-template-columns: 80px repeat(7, 1fr);
    }

    .time-slot {
        height: 80px;
        border-bottom: 1px solid theme('colors.border');
        border-right: 1px solid theme('colors.border');
    }

    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>

<!-- Main Calendar Area -->
<div class="flex-1 flex flex-col min-w-0 bg-card rounded-2xl border border-border shadow-sm overflow-hidden h-full">

    <!-- Controls Toolbar (Added for Navigation) -->
    <div class="flex items-center justify-between px-4 py-3 border-b border-border bg-card">
        <div class="flex items-center gap-2">
            <button id="btn-prev-week" class="p-1 rounded-md hover:bg-muted text-muted-foreground transition-colors">
                <span class="material-symbols-outlined text-lg">chevron_left</span>
            </button>
            <button id="btn-today"
                class="px-3 py-1 text-xs font-semibold text-primary bg-primary/10 rounded-md hover:bg-primary/20 transition-colors">
                Today
            </button>
            <button id="btn-next-week" class="p-1 rounded-md hover:bg-muted text-muted-foreground transition-colors">
                <span class="material-symbols-outlined text-lg">chevron_right</span>
            </button>
        </div>
        <span id="week-label" class="text-sm font-bold text-foreground"></span>
    </div>

    <!-- Calendar Header Row -->
    <div class="sticky top-0 z-20 calendar-grid bg-card border-b border-border shrink-0" id="calendar-header-row">
        <div class="h-12 flex items-center justify-center border-r border-border"></div>
        <!-- Headers injected via JS -->
    </div>

    <!-- Scrollable Grid -->
    <div class="flex-1 overflow-y-auto scrollbar-hide relative" id="calendar-scroller">
        <div class="calendar-grid relative">
            <!-- Time Column -->
            <div class="col-start-1 bg-muted/30">
                <?php
                // Times can remain static or be generated. Keeping static for structure simplicity.
                $times = ['08:00 AM', '09:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM', '05:00 PM', '06:00 PM'];
                foreach ($times as $index => $time): ?>
                    <div
                        class="time-slot flex justify-center pt-2 text-[11px] font-semibold text-muted-foreground <?= $index === count($times) - 1 ? 'border-b-0' : '' ?>">
                        <?= $time ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Days Columns Content & Appointments -->
            <div class="col-span-7 grid grid-cols-7 relative">
                <!-- Mesh background -->
                <div class="contents">
                    <?php for ($i = 0; $i < 77; $i++): ?>
                        <div class="time-slot <?= ($i >= 70) ? 'border-b-0' : '' ?>"></div>
                    <?php endfor; ?>
                </div>

                <!-- Appointment Cards Overlay -->
                <div id="appointments-container" class="absolute inset-0 grid grid-cols-7 pointer-events-none">
                    <!-- Cards injected via JS -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /**
     * CalendarManager
     * Handles fetching and rendering of schedule events.
     */
    class CalendarManager {
        constructor() {
            this.currentDate = new Date();
            this.apiUrl = apiUrl('schedule') + '/schedules.php';
            this.init();
        }

        init() {
            this.cacheDom();
            this.bindEvents();
            this.render();
        }

        cacheDom() {
            this.$headerRow = $('#calendar-header-row');
            this.$appointmentsContainer = $('#appointments-container');
            this.$weekLabel = $('#week-label');
            this.$btnPrev = $('#btn-prev-week');
            this.$btnNext = $('#btn-next-week');
            this.$btnToday = $('#btn-today');
        }

        bindEvents() {
            this.$btnPrev.on('click', () => {
                this.currentDate.setDate(this.currentDate.getDate() - 7);
                this.render();
            });

            this.$btnNext.on('click', () => {
                this.currentDate.setDate(this.currentDate.getDate() + 7);
                this.render();
            });

            this.$btnToday.on('click', () => {
                this.currentDate = new Date();
                this.render();
            });
        }

        getStartOfWeek(date) {
            const d = new Date(date);
            const day = d.getDay();
            const diff = d.getDate() - day + (day === 0 ? -6 : 1); // Adjust when day is sunday
            return new Date(d.setDate(diff));
        }

        formatDate(date) {
            return date.toISOString().split('T')[0];
        }

        render() {
            const startOfWeek = this.getStartOfWeek(this.currentDate);
            this.renderHeader(startOfWeek);
            this.updateWeekLabel(startOfWeek);
            this.fetchEvents(startOfWeek);
        }

        updateWeekLabel(startOfWeek) {
            const endOfWeek = new Date(startOfWeek);
            endOfWeek.setDate(endOfWeek.getDate() + 6);

            const options = { month: 'short', day: 'numeric', year: 'numeric' };
            const label = `${startOfWeek.toLocaleDateString('en-US', options)} - ${endOfWeek.toLocaleDateString('en-US', options)}`;
            this.$weekLabel.text(label);
        }

        renderHeader(startOfWeek) {
            // Remove existing day columns (keep the first time spacer)
            this.$headerRow.find('div:not(:first-child)').remove();

            const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            const todayStr = this.formatDate(new Date());

            days.forEach((dayName, index) => {
                const currentDay = new Date(startOfWeek);
                currentDay.setDate(startOfWeek.getDate() + index);
                const dateNum = currentDay.getDate();
                const isToday = this.formatDate(currentDay) === todayStr;

                const activeBg = isToday ? 'bg-primary/5' : '';
                const activeText = isToday ? 'text-primary' : 'text-muted-foreground';
                const activeNum = isToday ? 'text-primary' : 'text-foreground';

                const html = `
                    <div class="h-12 flex flex-col items-center justify-center border-r border-border ${activeBg}">
                        <span class="text-[10px] font-bold ${activeText} uppercase">${dayName}</span>
                        <span class="text-sm font-bold ${activeNum}">${dateNum}</span>
                    </div>
                `;
                this.$headerRow.append(html);
            });
        }

        fetchEvents(startOfWeek) {
            const start = this.formatDate(startOfWeek);
            const endOfWeek = new Date(startOfWeek);
            endOfWeek.setDate(endOfWeek.getDate() + 6);
            const end = this.formatDate(endOfWeek);

            $.ajax({
                url: this.apiUrl,
                method: 'GET',
                data: { action: 'fetch_range', start: start, end: end },
                success: (response) => {
                    const res = typeof response === 'string' ? JSON.parse(response) : response;
                    if (res.success) {
                        // Populate global appointments for modals (merge)
                        window.allAppointments = window.allAppointments || [];
                        res.data.forEach(evt => {
                            const idx = window.allAppointments.findIndex(a => a.uuid === evt.uuid);
                            if (idx > -1) {
                                window.allAppointments[idx] = evt;
                            } else {
                                window.allAppointments.push(evt);
                            }
                        });
                        this.renderEvents(res.data, startOfWeek);
                    } else {
                        console.error('Failed to fetch schedule:', res.message);
                    }
                },
                error: (xhr, status, error) => console.error('Fetch error:', error)
            });
        }

        renderEvents(events, startOfWeek) {
            this.$appointmentsContainer.empty();

            events.forEach(event => {
                const eventDate = new Date(event.sched_date);
                // Calculate Column (0=Mon, 6=Sun)
                // getDay(): 0=Sun, 1=Mon. We want Mon=0.
                let dayIndex = eventDate.getDay() - 1;
                if (dayIndex === -1) dayIndex = 6; // Sunday is 6

                // Calculate Valid Column (0-6)
                if (dayIndex < 0 || dayIndex > 6) return;

                // Calculate Top Position and Height
                // Grid starts at 08:00 AM. 1 hour = 80px.
                const [hours, minutes] = event.sched_time.split(':').map(Number);
                const startHour = 8;
                if (hours < startHour) return; // Skip before 8am

                const hoursDiff = hours - startHour;
                const top = (hoursDiff * 80) + (minutes * (80 / 60));

                // Duration
                // Default to 60 if not set
                const duration = event.service_duration || 60;
                const height = duration * (80 / 60);

                // Styling based on service or status (Optional mapping)
                // Using dynamic service_color if available or random/hashed based on ID
                // For now, using standard colors similar to design
                const colorClasses = this.getColorClasses(event.service_name);

                const cardHtml = `
                    <div class="view-summary-btn absolute left-1 right-1 p-2 rounded-r-md border-l-4 shadow-sm hover:z-20 transition-all cursor-pointer pointer-events-auto group flex flex-col justify-center ${colorClasses.bg} ${colorClasses.border}"
                         data-uuid="${event.uuid}"
                         style="top: ${top}px; min-height: ${height}px; grid-column: ${dayIndex + 1} / span 1; z-index: 10;">
                        <p class="text-[10px] font-bold ${colorClasses.text} uppercase truncate leading-tight">${event.service_name}</p>
                        <p class="text-xs font-bold text-foreground truncate leading-tight">${event.patient_firstname} ${event.patient_lastname}</p>
                        <div class="text-[9px] ${colorClasses.subtext} font-medium mt-0.5 leading-none">${this.formatTime(event.sched_time)} - ${this.calculateEndTime(event.sched_time, duration)}</div>
                    </div>
                `;

                this.$appointmentsContainer.append(cardHtml);
            });
        }

        getColorClasses(serviceName) {
            // Simple hash or mapping to rotate colors
            // Defaulting to existing palette styles
            const palette = [
                { bg: 'bg-purple-100 dark:bg-purple-900/40', border: 'border-purple-500', text: 'text-purple-700 dark:text-purple-300', subtext: 'text-purple-600/70 dark:text-purple-300/70' },
                { bg: 'bg-sky-100 dark:bg-sky-900/40', border: 'border-sky-500', text: 'text-sky-700 dark:text-sky-300', subtext: 'text-sky-600/70 dark:text-sky-300/70' },
                { bg: 'bg-emerald-100 dark:bg-emerald-900/40', border: 'border-emerald-500', text: 'text-emerald-700 dark:text-emerald-300', subtext: 'text-emerald-600/70 dark:text-emerald-300/70' },
                { bg: 'bg-amber-100 dark:bg-amber-900/40', border: 'border-amber-500', text: 'text-amber-700 dark:text-amber-300', subtext: 'text-amber-600/70 dark:text-amber-300/70' }
            ];

            // rudimentary hash
            const hash = serviceName ? serviceName.length % palette.length : 0;
            return palette[hash];
        }

        formatTime(timeStr) {
            const [h, m] = timeStr.split(':');
            const date = new Date();
            date.setHours(h, m);
            return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        }

        calculateEndTime(startTime, durationMinutes) {
            const [h, m] = startTime.split(':').map(Number);
            const date = new Date();
            date.setHours(h, m + parseInt(durationMinutes));
            return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        }
    }

    $(document).ready(function () {
        new CalendarManager();
    });
</script>