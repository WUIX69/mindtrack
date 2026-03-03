<!-- Demographics Widget -->
<div class="bg-card rounded-xl border border-border p-6 shadow-sm">
    <h3 class="text-sm font-bold mb-4 flex items-center gap-2 uppercase tracking-tight text-foreground">
        <span class="material-symbols-outlined text-primary text-[20px]">analytics</span>
        Patient Demographics
    </h3>
    <div class="space-y-4" id="demographics-container">
        <!-- Loading -->
        <div class="animate-pulse space-y-4">
            <div class="h-6 bg-muted/40 rounded"></div>
            <div class="h-6 bg-muted/40 rounded"></div>
            <div class="h-6 bg-muted/40 rounded"></div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        const statsEndpoint = apiUrl('patients') + 'stats.php';

        function loadDemographics() {
            $.ajax({
                url: statsEndpoint + '?action=getPatientsDemographic',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success && response.data) {
                        renderDemographics(response.data);
                    } else {
                        renderError();
                    }
                },
                error: function () {
                    renderError();
                }
            });
        }

        function renderDemographics(data) {
            const adults = data.adults_percent || 0;
            const adolescents = data.adolescents_percent || 0;
            const seniors = data.seniors_percent || 0;

            const html = `
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">Adults (18-65)</span>
                        <span class="text-foreground">${adults}%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-primary rounded-full transition-all duration-700" style="width: 0%" data-width="${adults}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">Adolescents (12-17)</span>
                        <span class="text-foreground">${adolescents}%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-blue-400 rounded-full transition-all duration-700 delay-100" style="width: 0%" data-width="${adolescents}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-[11px] font-bold uppercase tracking-wider mb-1.5">
                        <span class="text-muted-foreground">Seniors (65+)</span>
                        <span class="text-foreground">${seniors}%</span>
                    </div>
                    <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                        <div class="h-full bg-warning rounded-full transition-all duration-700 delay-200" style="width: 0%" data-width="${seniors}%"></div>
                    </div>
                </div>
            `;
            $('#demographics-container').html(html);

            // Animate progress bars
            setTimeout(() => {
                $('#demographics-container .rounded-full[data-width]').each(function () {
                    $(this).css('width', $(this).data('width'));
                });
            }, 50);
        }

        function renderError() {
            $('#demographics-container').html(`
                <div class="py-4 text-center text-xs text-red-500 font-medium">
                    Failed to load demographics.
                </div>
            `);
        }

        loadDemographics();
    });
</script>