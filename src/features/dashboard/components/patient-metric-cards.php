<!-- Metrics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8" id="patient-metrics-container">
    <!-- Skeleton Loaders -->
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm animate-pulse">
        <div class="flex items-center justify-between mb-4">
            <div class="h-4 bg-muted/40 rounded w-1/2"></div>
            <div class="w-10 h-10 rounded-lg bg-muted/40"></div>
        </div>
        <div class="h-8 bg-muted/40 rounded w-3/4 mb-2"></div>
        <div class="h-4 bg-muted/40 rounded w-1/3"></div>
    </div>
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm animate-pulse">
        <div class="flex items-center justify-between mb-4">
            <div class="h-4 bg-muted/40 rounded w-1/2"></div>
            <div class="w-10 h-10 rounded-lg bg-muted/40"></div>
        </div>
        <div class="h-8 bg-muted/40 rounded w-1/4 mb-2"></div>
        <div class="h-4 bg-muted/40 rounded w-1/2"></div>
    </div>
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm animate-pulse">
        <div class="flex items-center justify-between mb-4">
            <div class="h-4 bg-muted/40 rounded w-1/2"></div>
            <div class="w-10 h-10 rounded-lg bg-muted/40"></div>
        </div>
        <div class="h-8 bg-muted/40 rounded w-1/4 mb-2"></div>
        <div class="h-4 bg-muted/40 rounded w-1/2"></div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const container = $('#patient-metrics-container');

        window.fetchPatientMetrics = function () {
            $.ajax({
                url: apiUrl('dashboard') + 'metrics.php',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success && response.data) {
                        renderMetrics(response.data);
                    } else {
                        renderError();
                    }
                },
                error: renderError
            });
        };

        function renderMetrics(data) {
            container.empty();

            // 1. Upcoming Appointment Card
            let upcomingHtml = '';
            if (data.upcoming_appointment) {
                const apt = data.upcoming_appointment;
                upcomingHtml = `
                    <p class="text-2xl font-bold mb-1 text-foreground">${apt.datetime_formatted}</p>
                    <p class="text-sm text-primary font-semibold flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">schedule</span>
                        ${apt.relative_text} • ${apt.doctor_name}
                    </p>
                `;
            } else {
                upcomingHtml = `
                    <p class="text-lg font-bold mb-1 text-muted-foreground">No upcoming sessions</p>
                    <p class="text-sm text-muted-foreground flex items-center gap-1">
                        Book a new appointment above.
                    </p>
                `;
            }

            container.append(`
                <div class="bg-card p-6 rounded-xl border border-primary/20 shadow-sm relative overflow-hidden">
                    <div class="absolute inset-0 bg-primary/5 pointer-events-none"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <span class="text-muted-foreground text-sm font-medium">Upcoming Appointment</span>
                        <div class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined">event</span>
                        </div>
                    </div>
                    <div class="relative z-10">
                        ${upcomingHtml}
                    </div>
                </div>
            `);

            // 2. Completed Sessions
            container.append(`
                <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-muted-foreground text-sm font-medium">Completed Sessions</span>
                        <div class="w-10 h-10 rounded-lg bg-green-50 dark:bg-green-900/30 flex items-center justify-center text-green-600">
                            <span class="material-symbols-outlined">done_all</span>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold mb-1 text-foreground">${data.completed_sessions}</p>
                    <p class="text-sm text-muted-foreground">Total sessions attended</p>
                </div>
            `);

            // 3. Total Providers
            container.append(`
                <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-muted-foreground text-sm font-medium">Care Team</span>
                        <div class="w-10 h-10 rounded-lg bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600">
                            <span class="material-symbols-outlined">group</span>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold mb-1 text-foreground">${data.total_providers}</p>
                    <p class="text-sm text-muted-foreground">Different providers seen</p>
                </div>
            `);
        }

        function renderError() {
            container.html(`
                <div class="col-span-1 md:col-span-3 bg-red-50 text-red-500 p-4 rounded-xl border border-red-100 text-center text-sm">
                    Failed to load metrics. Please refresh the page.
                </div>
            `);
        }

        window.fetchPatientMetrics();
    });
</script>