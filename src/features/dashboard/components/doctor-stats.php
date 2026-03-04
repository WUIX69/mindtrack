<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div
                class="size-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                <span class="material-symbols-outlined">event_available</span>
            </div>
        </div>
        <p class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Today's Sessions</p>
        <h3 class="text-3xl font-extrabold mt-1 text-foreground" id="stat-todays-sessions">
            <span class="inline-block w-12 h-8 bg-muted/40 rounded animate-pulse"></span>
        </h3>
    </div>
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div
                class="size-10 rounded-lg bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600">
                <span class="material-symbols-outlined">pending_actions</span>
            </div>
        </div>
        <p class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Pending Notes</p>
        <h3 class="text-3xl font-extrabold mt-1 text-foreground" id="stat-pending-notes">
            <span class="inline-block w-8 h-8 bg-muted/40 rounded animate-pulse"></span>
        </h3>
    </div>
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div
                class="size-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600">
                <span class="material-symbols-outlined">medical_services</span>
            </div>
            <span class="text-xs font-bold text-muted-foreground">Total this week</span>
        </div>
        <p class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Consultations</p>
        <h3 class="text-3xl font-extrabold mt-1 text-foreground" id="stat-weekly-consultations">
            <span class="inline-block w-12 h-8 bg-muted/40 rounded animate-pulse"></span>
        </h3>
    </div>
    <div class="bg-card p-6 rounded-xl border border-border shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <div
                class="size-10 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                <span class="material-symbols-outlined">timer</span>
            </div>
            <span class="text-xs font-bold text-muted-foreground">Total this week</span>
        </div>
        <p class="text-sm font-medium text-muted-foreground uppercase tracking-wider">Clinical Hours</p>
        <h3 class="text-3xl font-extrabold mt-1 text-foreground" id="stat-weekly-hours">
            <span class="inline-block w-16 h-8 bg-muted/40 rounded animate-pulse"></span>
        </h3>
    </div>
</div>

<script>
    $(document).ready(function () {
        window.fetchDoctorDashboardStats = function () {
            $.ajax({
                url: apiUrl('dashboard') + 'quick-stats.php',
                type: 'GET',
                data: { action: 'getDoctorStats' },
                dataType: 'json',
                success: function (response) {
                    if (response.success && response.data) {
                        $('#stat-todays-sessions').text(response.data.todays_sessions);
                        $('#stat-pending-notes').text(response.data.pending_notes);
                        $('#stat-weekly-consultations').text(response.data.weekly_consultations);
                        $('#stat-weekly-hours').text(response.data.weekly_hours);
                    } else {
                        renderStatsError();
                    }
                },
                error: renderStatsError
            });
        };

        function renderStatsError() {
            $('#stat-todays-sessions, #stat-pending-notes, #stat-weekly-consultations, #stat-weekly-hours').text('-');
        }

        window.fetchDoctorDashboardStats();
    });
</script>