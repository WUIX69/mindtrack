<!-- Widget 3: Quick Stats -->
<div class="grid grid-cols-2 gap-4">
    <div
        class="bg-card border border-border rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center text-center">
        <div
            class="size-10 rounded-full bg-amber-100 dark:bg-amber-950/30 text-amber-600 dark:text-amber-400 flex items-center justify-center mb-2">
            <span class="material-symbols-outlined text-[20px]">edit_document</span>
        </div>
        <span class="text-2xl font-black text-foreground" id="pending-notes-stat">
            <div class="h-8 w-12 bg-muted rounded animate-pulse inline-block"></div>
        </span>
        <span class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider mt-1">Pending Notes</span>
    </div>
    <div
        class="bg-card border border-border rounded-2xl p-4 shadow-sm flex flex-col items-center justify-center text-center">
        <div
            class="size-10 rounded-full bg-red-100 dark:bg-red-950/30 text-red-600 dark:text-red-400 flex items-center justify-center mb-2">
            <span class="material-symbols-outlined text-[20px]">warning</span>
        </div>
        <span class="text-2xl font-black text-foreground" id="critical-notes-stat">
            <div class="h-8 w-12 bg-muted rounded animate-pulse inline-block"></div>
        </span>
        <span class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider mt-1">Critical (>72h)</span>
    </div>
</div>

<script>
    $(document).ready(function () {
        const statsEndpoint = apiUrl('notes') + 'stats.php';
        const pendingNotesEl = $('#pending-notes-stat');
        const criticalNotesEl = $('#critical-notes-stat');

        window.fetchWidgetQuickStats = function () {
            // Reset loading state
            pendingNotesEl.html('<div class="h-8 w-12 bg-muted rounded animate-pulse inline-block"></div>');
            criticalNotesEl.html('<div class="h-8 w-12 bg-muted rounded animate-pulse inline-block"></div>');

            $.ajax({
                url: statsEndpoint + '?action=getWidgetQuickStats',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success && response.data) {
                        pendingNotesEl.text(response.data.pending_notes);
                        criticalNotesEl.text(response.data.critical_notes);
                    } else {
                        renderQuickStatsError();
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error (Widget Quick Stats):", status, error);
                    renderQuickStatsError();
                }
            });
        };

        // Initial fetch
        window.fetchWidgetQuickStats();

        function renderQuickStatsError() {
            pendingNotesEl.text('--');
            criticalNotesEl.text('--');
        }
    });
</script>