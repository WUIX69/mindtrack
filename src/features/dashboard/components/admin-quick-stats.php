<!-- Quick Stats -->
<div id="quick-stats-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Total Patients -->
    <div class="bg-card p-6 rounded-2xl border border-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div
                class="size-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-primary-foreground transition-all">
                <span class="material-symbols-outlined text-2xl">group</span>
            </div>
        </div>
        <h3 class="text-muted-foreground text-sm font-medium">Total Online Support</h3>
        <p id="stat-total-patients" class="text-3xl font-black mt-1 text-foreground">
            <span class="inline-block w-16 h-8 bg-muted/40 rounded-lg animate-pulse"></span>
        </p>
    </div>

    <!-- Pending Requests -->
    <div class="bg-card p-6 rounded-2xl border border-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div
                class="size-12 rounded-xl bg-orange-500/10 flex items-center justify-center text-orange-500 group-hover:bg-orange-500 group-hover:text-primary-foreground transition-all">
                <span class="material-symbols-outlined text-2xl">schedule</span>
            </div>
        </div>
        <h3 class="text-muted-foreground text-sm font-medium">Pending Requests</h3>
        <p id="stat-pending-requests" class="text-3xl font-black mt-1 text-foreground">
            <span class="inline-block w-16 h-8 bg-muted/40 rounded-lg animate-pulse"></span>
        </p>
    </div>

    <!-- Active Providers -->
    <div class="bg-card p-6 rounded-2xl border border-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div
                class="size-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-primary-foreground transition-all">
                <span class="material-symbols-outlined text-2xl">medical_services</span>
            </div>
        </div>
        <h3 class="text-muted-foreground text-sm font-medium">Active Providers</h3>
        <p id="stat-active-providers" class="text-3xl font-black mt-1 text-foreground">
            <span class="inline-block w-16 h-8 bg-muted/40 rounded-lg animate-pulse"></span>
        </p>
    </div>

    <!-- Monthly Completed -->
    <div class="bg-card p-6 rounded-2xl border border-border shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div
                class="size-12 rounded-xl bg-green-500/10 flex items-center justify-center text-green-500 group-hover:bg-green-500 group-hover:text-primary-foreground transition-all">
                <span class="material-symbols-outlined text-2xl">forum</span>
            </div>
        </div>
        <h3 class="text-muted-foreground text-sm font-medium">Monthly Completed</h3>
        <p id="stat-monthly-completed" class="text-3xl font-black mt-1 text-foreground">
            <span class="inline-block w-16 h-8 bg-muted/40 rounded-lg animate-pulse"></span>
        </p>
    </div>
</div>
<script>
    $(function () {
        const statsEndpoint = apiUrl('dashboard') + 'quick-stats.php';

        window.fetchAdminQuickStats = function () {
            $.ajax({
                url: statsEndpoint,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (!response.success || !response.data) {
                        renderStatsError();
                        return;
                    }
                    renderStats(response.data);
                },
                error: function () {
                    renderStatsError();
                }
            });
        }

        function renderStats(data) {
            const totalPatients = parseInt(data.total_patients) || 0;
            const pendingRequests = parseInt(data.pending_requests) || 0;
            const activeProviders = parseInt(data.active_providers) || 0;
            const monthlyCompleted = parseInt(data.monthly_completed) || 0;

            $('#stat-total-patients').text(totalPatients.toLocaleString());
            $('#stat-pending-requests').text(pendingRequests.toLocaleString());
            $('#stat-active-providers').text(activeProviders.toLocaleString());
            $('#stat-monthly-completed').text(monthlyCompleted.toLocaleString());
        }

        function renderStatsError() {
            $('#stat-total-patients, #stat-pending-requests, #stat-active-providers, #stat-monthly-completed')
                .text('—')
                .addClass('text-muted-foreground');
        }

        window.fetchAdminQuickStats();
    });
</script>