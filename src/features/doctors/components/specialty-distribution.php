<!-- Specialty Distribution Widget -->
<div class="bg-card rounded-xl border border-border p-6 shadow-sm">
    <h3 class="text-sm font-bold mb-4 flex items-center gap-2 uppercase tracking-tight text-foreground">
        <span class="material-symbols-outlined text-primary text-[20px]">pie_chart</span>
        Specialty Distribution
    </h3>
    <div class="space-y-4" id="specialty-distribution-list">
        <!-- Skeleton Loaders -->
        <div>
            <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                <span class="inline-block w-24 h-3 bg-muted/40 rounded animate-pulse"></span>
                <span class="inline-block w-8 h-3 bg-muted/40 rounded animate-pulse"></span>
            </div>
            <div class="h-2 w-full bg-muted/40 rounded-full animate-pulse"></div>
        </div>
        <div>
            <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                <span class="inline-block w-20 h-3 bg-muted/40 rounded animate-pulse"></span>
                <span class="inline-block w-8 h-3 bg-muted/40 rounded animate-pulse"></span>
            </div>
            <div class="h-2 w-full bg-muted/40 rounded-full animate-pulse"></div>
        </div>
        <div>
            <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                <span class="inline-block w-28 h-3 bg-muted/40 rounded animate-pulse"></span>
                <span class="inline-block w-8 h-3 bg-muted/40 rounded animate-pulse"></span>
            </div>
            <div class="h-2 w-full bg-muted/40 rounded-full animate-pulse"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        window.fetchSpecialtyDistribution = function () {
            $.ajax({
                url: apiUrl('doctors') + 'stats.php',
                type: 'GET',
                data: { action: 'getSpecialtyDistribution' },
                dataType: 'json',
                success: function (response) {
                    const $list = $('#specialty-distribution-list');
                    if (response.success && response.data && response.data.length > 0) {
                        $list.empty();

                        response.data.forEach(item => {
                            const html = `
                                <div>
                                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                                        <span class="text-muted-foreground">${item.specialty}</span>
                                        <span class="text-foreground">${item.percentage}%</span>
                                    </div>
                                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                                        <div class="h-full bg-${item.color} rounded-full" style="width: ${item.percentage}%"></div>
                                    </div>
                                </div>
                            `;
                            $list.append(html);
                        });
                    } else {
                        renderSpecialtyError('No active specialties data found.');
                    }
                },
                error: function () {
                    renderSpecialtyError('Failed to load specialty distribution.');
                }
            });
        };

        function renderSpecialtyError(msg) {
            $('#specialty-distribution-list').html(`
                <div class="text-[11px] text-muted-foreground font-medium text-center py-4">
                    ${msg}
                </div>
            `);
        }

        // Init
        window.fetchSpecialtyDistribution();
    });
</script>