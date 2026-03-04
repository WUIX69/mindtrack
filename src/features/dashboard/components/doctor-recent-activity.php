<!-- Recent Activity -->
<div class="space-y-4">
    <h2 class="text-xl font-bold text-foreground">Recent Patient Activity</h2>
    <div class="bg-card rounded-xl border border-border overflow-hidden shadow-sm">
        <div id="recent-activity-list" class="divide-y divide-border min-h-[150px]">
            <!-- Skeleton Loader -->
            <div class="p-4 space-y-4 animate-pulse">
                <div class="flex items-start gap-3">
                    <div class="mt-1 size-8 rounded-full bg-muted/40 shrink-0"></div>
                    <div class="flex-1 space-y-2">
                        <div class="h-4 bg-muted/40 rounded w-3/4"></div>
                        <div class="h-3 bg-muted/40 rounded w-1/4"></div>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <div class="mt-1 size-8 rounded-full bg-muted/40 shrink-0"></div>
                    <div class="flex-1 space-y-2">
                        <div class="h-4 bg-muted/40 rounded w-2/3"></div>
                        <div class="h-3 bg-muted/40 rounded w-1/3"></div>
                    </div>
                </div>
            </div>
        </div>
        <button
            class="w-full py-3 bg-muted/30 text-[10px] font-bold text-muted-foreground uppercase tracking-widest hover:text-primary hover:bg-muted transition-all border-t border-border">
            View All Activity
        </button>
    </div>
</div>

<script>
    $(document).ready(function () {
        const activityContainer = $('#recent-activity-list');
        const endpoint = apiUrl('dashboard') + 'recent-patient-activity.php';

        window.fetchDoctorRecentActivity = function () {
            $.ajax({
                url: endpoint,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        renderActivities(response.data);
                    } else {
                        showError("Failed to load activity.");
                    }
                },
                error: function () {
                    showError("Error connecting to server.");
                }
            });
        };

        function renderActivities(activities) {
            activityContainer.empty();

            if (!activities || activities.length === 0) {
                activityContainer.html(`
                    <div class="p-8 text-center text-muted-foreground">
                        <span class="material-symbols-outlined text-4xl opacity-50 mb-2">history</span>
                        <p class="text-sm font-medium">No recent patient activity found.</p>
                    </div>
                `);
                return;
            }

            activities.forEach(act => {
                // Tailwind color mapping for icon background and text based on backend color spec
                const colors = {
                    'emerald': 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600',
                    'blue': 'bg-blue-100 dark:bg-blue-900/30 text-blue-600',
                    'amber': 'bg-amber-100 dark:bg-amber-900/30 text-amber-600',
                    'destructive': 'bg-red-100 dark:bg-red-900/30 text-red-600',
                    'primary': 'bg-primary/10 text-primary',
                    'muted': 'bg-muted text-muted-foreground'
                };

                const colorClass = colors[act.color] || colors['muted'];

                const html = `
                    <div class="p-4 hover:bg-muted/50 transition-colors">
                        <div class="flex items-start gap-3">
                            <div class="mt-1 size-8 rounded-full ${colorClass} flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-base">${act.icon}</span>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm text-foreground opacity-90">
                                    <span class="font-bold">${act.title}</span><br/>
                                    <span class="text-xs text-muted-foreground">${act.description}</span>
                                </p>
                                <span class="text-[10px] text-muted-foreground font-medium uppercase tracking-widest mt-1 block">
                                    ${act.time_ago}
                                </span>
                            </div>
                        </div>
                    </div>
                `;
                activityContainer.append(html);
            });
        }

        function showError(msg) {
            activityContainer.html(`<div class="p-4 text-center text-red-500 text-sm">${msg}</div>`);
        }

        window.fetchDoctorRecentActivity();
    });
</script>