<!-- Capacity Widget -->
<div class="bg-card rounded-xl border border-border p-6 shadow-sm">
    <h3 class="text-sm font-bold mb-4 flex items-center gap-2 uppercase tracking-tight text-foreground">
        <span class="material-symbols-outlined text-success text-[20px]" id="capacity-icon">group_add</span>
        Provider Capacity
    </h3>
    <div class="flex items-end gap-2 mb-4">
        <span class="text-3xl font-bold text-foreground" id="capacity-percentage">
            <span class="inline-block w-20 h-8 bg-muted/40 rounded animate-pulse"></span>
        </span>
        <span class="text-xs font-bold text-success mb-1 flex items-center" id="capacity-status-badge">
            <span class="inline-block w-16 h-4 bg-muted/40 rounded animate-pulse"></span>
        </span>
    </div>
    <div class="flex items-center gap-1 h-12" id="capacity-bars">
        <div class="flex-1 bg-muted/40 rounded-t h-[70%] animate-pulse"></div>
        <div class="flex-1 bg-muted/40 rounded-t h-[85%] animate-pulse"></div>
        <div class="flex-1 bg-muted/40 rounded-t h-[75%] animate-pulse"></div>
        <div class="flex-1 bg-muted/40 rounded-t h-[95%] animate-pulse"></div>
        <div class="flex-1 bg-muted/40 rounded-t h-[80%] animate-pulse"></div>
        <div class="flex-1 bg-muted/40 rounded-t h-[90%] animate-pulse"></div>
        <div class="flex-1 bg-muted/40 rounded-t h-[85%] animate-pulse"></div>
    </div>
    <p class="mt-4 text-[11px] text-muted-foreground font-medium leading-relaxed" id="capacity-desc">
        <span class="inline-block w-full h-3 bg-muted/40 rounded animate-pulse mb-1"></span>
        <span class="inline-block w-2/3 h-3 bg-muted/40 rounded animate-pulse"></span>
    </p>
</div>

<script>
    $(document).ready(function () {
        window.fetchDoctorCapacity = function () {
            $.ajax({
                url: apiUrl('doctors') + 'stats.php',
                type: 'GET',
                data: { action: 'getCapacityOverview' },
                dataType: 'json',
                success: function (response) {
                    if (response.success && response.data) {
                        const data = response.data;

                        // Percentage
                        $('#capacity-percentage').text(data.percentage + '%');

                        // Status Badge
                        let icon = 'trending_up';
                        let colorClass = 'text-success';

                        if (data.status === 'over capacity') {
                            icon = 'warning';
                            colorClass = 'text-destructive';
                        } else if (data.status === 'high utilization') {
                            icon = 'trending_flat';
                            colorClass = 'text-amber-500';
                        }

                        $('#capacity-status-badge')
                            .attr('class', `text-xs font-bold mb-1 flex items-center ${colorClass}`)
                            .html(`<span class="material-symbols-outlined text-[16px]">${icon}</span> ${data.status.replace(/\b\w/g, l => l.toUpperCase())}`);

                        $('#capacity-icon').attr('class', `material-symbols-outlined text-[20px] ${colorClass}`);

                        // Desc
                        let descHtml = `Current clinic capacity is <span class="text-foreground font-bold">${data.status}</span>.`;
                        if (data.status === 'over capacity' || data.status === 'high utilization') {
                            descHtml += ` Consider onboarding new specialists.`;
                        } else {
                            descHtml += ` Ready to accept new patients.`;
                        }
                        $('#capacity-desc').html(descHtml);

                        // Bars visual (simulated based on percentage for dynamic feel)
                        if (data.bar_count) {
                            let barsHtml = '';
                            const maxVal = Math.min(100, data.percentage + 15);
                            const minVal = Math.max(10, data.percentage - 15);

                            for (let i = 0; i < data.bar_count; i++) {
                                // Add random jitter around the percentage
                                const h = Math.floor(Math.random() * (maxVal - minVal + 1)) + minVal;
                                const isPeak = (i === Math.floor(data.bar_count / 2));
                                const opacity = isPeak ? '' : '/20';
                                const themeColor = data.status === 'over capacity' ? 'destructive' : (data.status === 'high utilization' ? 'amber-500' : 'primary');

                                barsHtml += `<div class="flex-1 bg-${themeColor}${opacity} rounded-t" style="height: ${h}%"></div>`;
                            }
                            $('#capacity-bars').html(barsHtml);
                        }
                    } else {
                        renderCapacityError();
                    }
                },
                error: function () {
                    renderCapacityError();
                }
            });
        };

        function renderCapacityError() {
            $('#capacity-percentage').text('--%');
            $('#capacity-status-badge').html('');
            $('#capacity-desc').text('Failed to load capacity overview.');
            $('#capacity-bars').empty();
        }

        // Init
        window.fetchDoctorCapacity();
    });
</script>