<!-- Widget 2: Recent Finalizations -->
<div class="bg-card rounded-2xl border border-border shadow-sm p-6 lg:col-span-2">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-sm font-bold text-foreground">Recent Finalizations</h3>
            <p class="text-xs text-muted-foreground mt-1">Recently signed clinical notes</p>
        </div>
        <span class="text-xs font-bold text-primary bg-primary/10 px-2 py-0.5 rounded text-center">Live</span>
    </div>

    <!-- Feed List -->
    <ul class="space-y-4 relative before:absolute before:inset-y-0 before:left-[19px] before:w-[2px] before:bg-border"
        id="recent-finalizations-list">
        <!-- Loading State -->
        <li class="relative pl-12">
            <div
                class="absolute left-0 top-1 size-10 rounded-full bg-muted border-4 border-card flex items-center justify-center animate-pulse">
            </div>
            <div class="bg-muted/30 rounded-xl p-3 border border-border/50 animate-pulse">
                <div class="h-4 bg-muted w-3/4 rounded mb-2"></div>
                <div class="h-3 bg-muted w-1/2 rounded"></div>
            </div>
        </li>
        <li class="relative pl-12">
            <div
                class="absolute left-0 top-1 size-10 rounded-full bg-muted border-4 border-card flex items-center justify-center animate-pulse">
            </div>
            <div class="bg-muted/30 rounded-xl p-3 border border-border/50 animate-pulse">
                <div class="h-4 bg-muted w-3/4 rounded mb-2"></div>
                <div class="h-3 bg-muted w-1/2 rounded"></div>
            </div>
        </li>
    </ul>
</div>

<script>
    $(document).ready(function () {
        const statsEndpoint = apiUrl('notes') + 'stats.php';
        const feedList = $('#recent-finalizations-list');

        window.fetchRecentFinalizations = function () {
            // Reset loading state
            feedList.html(`
                <li class="relative pl-12">
                    <div class="absolute left-0 top-1 size-10 rounded-full bg-muted border-4 border-card flex items-center justify-center animate-pulse z-10"></div>
                    <div class="space-y-2 py-1">
                        <div class="h-4 w-3/4 bg-muted rounded animate-pulse"></div>
                        <div class="h-3 w-1/2 bg-muted rounded animate-pulse"></div>
                    </div>
                </li>
                <li class="relative pl-12">
                    <div class="absolute left-0 top-1 size-10 rounded-full bg-muted border-4 border-card flex items-center justify-center animate-pulse z-10"></div>
                    <div class="space-y-2 py-1">
                        <div class="h-4 w-full bg-muted rounded animate-pulse"></div>
                        <div class="h-3 w-5/6 bg-muted rounded animate-pulse"></div>
                    </div>
                </li>
            `);

            $.ajax({
                url: statsEndpoint + '?action=getRecentFinalizations',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success && response.data && response.data.length > 0) {
                        renderFeed(response.data);
                    } else {
                        renderEmptyFeed();
                    }
                },
                error: function () {
                    renderEmptyFeed();
                }
            });
        };

        // Initial fetch
        window.fetchRecentFinalizations();

        function renderFeed(items) {
            feedList.empty();
            let html = '';

            items.forEach(function (item) {
                // Compute relative time string
                const timeStr = getRelativeTime(item.updated_at);

                html += `
                    <li class="relative pl-12 group">
                        <div class="absolute left-0 top-1 size-10 rounded-full bg-primary/10 border-4 border-card flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-primary-foreground transition-colors z-10">
                            <span class="material-symbols-outlined text-[18px]">verified</span>
                        </div>
                        <div class="bg-muted/30 rounded-xl p-3 border border-border/50 hover:bg-muted/50 hover:border-border transition-colors">
                            <div class="flex items-start justify-between gap-4 mb-1">
                                <p class="text-sm text-foreground">
                                    <span class="font-bold">${item.doctor_name}</span> signed a note for
                                    <span class="font-bold text-primary">${item.patient_name}</span>
                                </p>
                                <span class="text-[10px] font-bold text-muted-foreground whitespace-nowrap bg-background px-2 py-1 rounded-md border border-border/50 shadow-sm">${timeStr}</span>
                            </div>
                        </div>
                    </li>
                `;
            });
            feedList.html(html);
        }

        function renderEmptyFeed() {
            feedList.html(`
                <li class="relative pl-12 group">
                     <div class="absolute left-0 top-1 size-10 rounded-full bg-muted border-4 border-card flex items-center justify-center text-muted-foreground z-10">
                            <span class="material-symbols-outlined text-[18px]">info</span>
                        </div>
                    <div class="bg-muted/30 rounded-xl p-3 border border-border/50">
                        <p class="text-sm text-muted-foreground">No recent finalizations to report.</p>
                    </div>
                </li>
            `);
        }

        function getRelativeTime(dateString) {
            const date = new Date(dateString.replace(' ', 'T') + 'Z');
            const now = new Date();
            const diffMs = now - date;

            const diffSec = Math.floor(diffMs / 1000);
            const diffMin = Math.floor(diffSec / 60);
            const diffHr = Math.floor(diffMin / 60);
            const diffDay = Math.floor(diffHr / 24);

            if (diffMin < 1) return 'Just now';
            if (diffMin < 60) return diffMin + ' min' + (diffMin > 1 ? 's' : '') + ' ago';
            if (diffHr < 24) return diffHr + ' hr' + (diffHr > 1 ? 's' : '') + ' ago';
            if (diffDay === 1) return 'Yesterday';
            return diffDay + ' days ago';
        }
    });
</script>