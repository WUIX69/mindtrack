<!-- Widget 1: Documentation Compliance -->
<div class="bg-card rounded-2xl border border-border shadow-sm p-6 relative overflow-hidden group">
    <div
        class="absolute inset-0 bg-gradient-to-br from-primary/[0.03] to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
    </div>
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-sm font-bold text-foreground">Documentation Compliance</h3>
        <button class="text-muted-foreground hover:text-foreground transition-colors p-1 rounded-lg hover:bg-muted">
            <span class="material-symbols-outlined text-[20px]">more_horiz</span>
        </button>
    </div>

    <!-- Compliance Donut Chart -->
    <div class="flex justify-center mb-6 relative">
        <div class="relative size-32" id="compliance-donut-container">
            <!-- Loading State -->
            <div class="absolute inset-0 flex items-center justify-center rounded-full border-4 border-muted border-t-primary animate-spin"
                id="donut-loader"></div>
            <!-- Chart SVGs -->
            <svg class="w-full h-full -rotate-90 hidden" id="donut-svg" viewBox="0 0 36 36"
                xmlns="http://www.w3.org/2000/svg">
                <!-- Background Circle -->
                <circle cx="18" cy="18" r="16" fill="none" class="stroke-muted" stroke-width="3" stroke-dasharray="100"
                    stroke-linecap="round"></circle>
                <!-- Progress Circle (Completed) -->
                <circle cx="18" cy="18" r="16" fill="none" class="stroke-primary" stroke-width="3"
                    stroke-dasharray="0, 100" stroke-linecap="round" id="donut-progress-circle"
                    style="transition: stroke-dasharray 1s ease-out;"></circle>
            </svg>
            <div class="absolute inset-0 flex flex-col items-center justify-center hidden" id="donut-text-content">
                <span class="text-2xl font-black text-foreground" id="compliance-signed-pct">0%</span>
                <span class="text-[10px] font-bold text-muted-foreground uppercase tracking-wider">Signed</span>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <!-- Progress Bar 1 -->
        <div>
            <div class="flex justify-between text-xs mb-1.5">
                <span class="font-bold text-muted-foreground">Within 24 Hours</span>
                <span class="font-bold text-foreground" id="compliance-24h-pct">
                    <div class="h-4 w-8 bg-muted rounded animate-pulse inline-block"></div>
                </span>
            </div>
            <div class="w-full bg-muted rounded-full h-1.5 overflow-hidden">
                <div class="bg-emerald-500 h-1.5 rounded-full" id="bar-24h"
                    style="width: 0%; transition: width 1s ease-out;"></div>
            </div>
        </div>
        <!-- Progress Bar 2 -->
        <div>
            <div class="flex justify-between text-xs mb-1.5">
                <span class="font-bold text-muted-foreground">Late Submissions</span>
                <span class="font-bold text-foreground" id="compliance-late-pct">
                    <div class="h-4 w-8 bg-muted rounded animate-pulse inline-block"></div>
                </span>
            </div>
            <div class="w-full bg-muted rounded-full h-1.5 overflow-hidden">
                <div class="bg-amber-500 h-1.5 rounded-full" id="bar-late"
                    style="width: 0%; transition: width 1s ease-out;"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const statsEndpoint = apiUrl('notes') + 'stats.php';

        window.fetchDocumentationCompliance = function () {
            // Reset to loading state
            $('#donut-loader').removeClass('hidden');
            $('#donut-svg').addClass('hidden');
            $('#donut-text-content').addClass('hidden').removeClass('flex');

            $.ajax({
                url: statsEndpoint + '?action=getDocumentationCompliance',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success && response.data) {
                        renderCompliance(response.data);
                    } else {
                        renderComplianceError();
                    }
                },
                error: function () {
                    renderComplianceError();
                }
            });
        };

        // Initial fetch
        window.fetchDocumentationCompliance();

        function renderCompliance(data) {
            // Hide loaders, reveal chart
            $('#donut-loader').addClass('hidden');
            $('#donut-svg').removeClass('hidden');
            $('#donut-text-content').removeClass('hidden').addClass('flex');

            // Set Data
            $('#compliance-signed-pct').text(data.signed_percent + '%');

            // Set SVG stroke-dasharray (Circumference is approx 100 on r=16 for this specific viewbox drawing)
            setTimeout(() => {
                $('#donut-progress-circle').attr('stroke-dasharray', `${data.signed_percent}, 100`);
            }, 50);

            // Set progress bars
            $('#compliance-24h-pct').text(data.within_24h_percent + '%');
            $('#bar-24h').css('width', data.within_24h_percent + '%');

            $('#compliance-late-pct').text(data.late_percent + '%');
            $('#bar-late').css('width', data.late_percent + '%');
        }

        function renderComplianceError() {
            $('#donut-loader').addClass('hidden');
            $('#donut-text-content').removeClass('hidden').addClass('flex');
            $('#compliance-signed-pct').text('--');
            $('#compliance-24h-pct').html('--');
            $('#compliance-late-pct').html('--');
        }
    });
</script>