<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-card dark:bg-card p-4 rounded-xl border border-border">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-muted-foreground text-xs font-semibold uppercase">Total Specializations</p>
                <h3 id="stat-total-specializations" class="text-2xl font-bold mt-1">
                    <span class="inline-block w-12 h-8 bg-muted/40 rounded animate-pulse"></span>
                </h3>
            </div>
            <div
                class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 text-blue-600 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">category</span>
            </div>
        </div>
    </div>
    <div class="bg-card dark:bg-card p-4 rounded-xl border border-border">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-muted-foreground text-xs font-semibold uppercase">Active Status</p>
                <h3 id="stat-active-status" class="text-2xl font-bold mt-1">
                    <span class="inline-block w-12 h-8 bg-muted/40 rounded animate-pulse"></span>
                </h3>
            </div>
            <div
                class="w-10 h-10 bg-green-100 dark:bg-green-900/30 text-green-600 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">check_circle</span>
            </div>
        </div>
    </div>
    <div class="bg-card dark:bg-card p-4 rounded-xl border border-border">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-muted-foreground text-xs font-semibold uppercase">Recently Updated</p>
                <h3 id="stat-recently-updated" class="text-2xl font-bold mt-1">
                    <span class="inline-block w-12 h-8 bg-muted/40 rounded animate-pulse"></span>
                </h3>
            </div>
            <div
                class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 text-amber-600 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">history</span>
            </div>
        </div>
    </div>
    <div class="bg-card dark:bg-card p-4 rounded-xl border border-border">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-muted-foreground text-xs font-semibold uppercase">Top Capacity</p>
                <h3 id="stat-top-capacity" class="text-2xl font-bold mt-1 text-primary">
                    <span class="inline-block w-20 h-8 bg-muted/40 rounded animate-pulse"></span>
                </h3>
            </div>
            <div class="w-10 h-10 bg-primary/10 text-primary rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">trending_up</span>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        const statsEndpoint = apiUrl('specializations') + 'stats.php';

        window.fetchSpecializationStats = function () {
            // Loading state
            $('#stat-total-specializations, #stat-active-status, #stat-recently-updated').html('<span class="inline-block w-12 h-8 bg-muted/40 rounded animate-pulse"></span>');
            $('#stat-top-capacity').html('<span class="inline-block w-20 h-8 bg-muted/40 rounded animate-pulse"></span>');

            $.ajax({
                url: statsEndpoint,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (!response.success) return renderError();
                    renderStats(response.data);
                },
                error: function () {
                    renderError();
                }
            });
        };

        function renderStats(data) {
            $('#stat-total-specializations').text((data.total_specializations || 0).toLocaleString());
            $('#stat-active-status').text((data.active_status || 0).toLocaleString());
            $('#stat-recently-updated').text((data.recently_updated || 0).toLocaleString());
            $('#stat-top-capacity').text(data.top_capacity || 'N/A');
        }

        function renderError() {
            $('#stat-total-specializations, #stat-active-status, #stat-recently-updated, #stat-top-capacity')
                .text('—')
                .addClass('text-muted-foreground');
        }

        window.fetchSpecializationStats();
    });
</script>