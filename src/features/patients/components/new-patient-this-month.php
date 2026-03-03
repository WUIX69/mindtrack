<!-- Growth Widget -->
<div class="bg-card rounded-xl border border-border p-6 shadow-sm">
    <h3 class="text-sm font-bold mb-4 flex items-center gap-2 uppercase tracking-tight text-foreground">
        <span class="material-symbols-outlined text-success text-[20px]">person_add_alt</span>
        New Patients This Month
    </h3>
    <div id="new-patients-content">
        <!-- Loading -->
        <div class="animate-pulse">
            <div class="flex items-end gap-2 mb-4">
                <div class="h-8 w-12 bg-muted/40 rounded"></div>
                <div class="h-4 w-16 bg-muted/40 rounded mb-1"></div>
            </div>
            <div class="flex items-center gap-1 h-12">
                <div class="flex-1 bg-muted/40 rounded-t h-full"></div>
                <div class="flex-1 bg-muted/40 rounded-t h-full"></div>
                <div class="flex-1 bg-muted/40 rounded-t h-full"></div>
                <div class="flex-1 bg-muted/40 rounded-t h-full"></div>
                <div class="flex-1 bg-muted/40 rounded-t h-full"></div>
                <div class="flex-1 bg-muted/40 rounded-t h-full"></div>
                <div class="flex-1 bg-muted/40 rounded-t h-full"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        const statsEndpoint = apiUrl('patients') + 'stats.php';

        function loadNewPatients() {
            $.ajax({
                url: statsEndpoint + '?action=getPatientsThisMonthChart',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success && response.data) {
                        renderNewPatients(response.data);
                    } else {
                        renderError();
                    }
                },
                error: function () {
                    renderError();
                }
            });
        }

        function renderNewPatients(data) {
            const currentMonth = data.current_month || 0;
            const growthPercent = data.growth_percent || 0;
            const isPositive = growthPercent >= 0;

            const growthColor = isPositive ? 'success' : 'red-500';
            const growthIcon = isPositive ? 'trending_up' : 'trending_down';
            const growthSign = isPositive ? '+' : '';

            let chartHtml = '';

            if (data.weekly_breakdown && data.weekly_breakdown.length > 0) {
                // Find Max to set relative heights
                const maxCount = Math.max(...data.weekly_breakdown, 1); // minimum 1 to avoid div by zero

                data.weekly_breakdown.forEach((count, idx) => {
                    const isLast = idx === data.weekly_breakdown.length - 1;
                    const opacityClass = isLast ? 'bg-primary' : 'bg-primary/20';
                    const heightPercent = Math.max((count / maxCount) * 100, 5); // min 5% height so it's visible

                    chartHtml += `<div class="flex-1 ${opacityClass} rounded-t transition-all duration-700 ease-out flex items-end group relative" style="height: 0%" data-height="${heightPercent}%">
                        <div class="opacity-0 group-hover:opacity-100 absolute -top-8 left-1/2 -translate-x-1/2 bg-popover text-popover-foreground text-[10px] font-bold px-2 py-1 rounded shadow-md pointer-events-none transition-opacity z-10 whitespace-nowrap">
                            ${count} ${count === 1 ? 'patient' : 'patients'}
                        </div>
                    </div>`;
                });
            }

            const html = `
                <div class="flex items-end gap-2 mb-4">
                    <span class="text-3xl font-bold text-foreground">${currentMonth}</span>
                    <span class="text-xs font-bold text-${growthColor} mb-1 flex items-center">
                        <span class="material-symbols-outlined text-[16px]">${growthIcon}</span>
                        ${growthSign}${growthPercent}%
                    </span>
                </div>
                <div class="flex items-end gap-1 h-12">
                    ${chartHtml}
                </div>
            `;

            $('#new-patients-content').html(html);

            // Animate bar chart heights
            setTimeout(() => {
                $('#new-patients-content .flex-1[data-height]').each(function () {
                    $(this).css('height', $(this).data('height'));
                });
            }, 50);
        }

        function renderError() {
            $('#new-patients-content').html(`
                <div class="py-4 text-center text-xs text-red-500 font-medium">
                    Failed to load stats.
                </div>
            `);
        }

        loadNewPatients();
    });
</script>