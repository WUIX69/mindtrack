<!-- Quick Insights -->
<div class="bg-card dark:bg-card p-6 rounded-xl border border-border shadow-sm">
    <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-primary">insights</span>
        <h3 class="font-bold">Quick Insights</h3>
    </div>
    <div class="space-y-4" id="patient-insights-container">
        <!-- Skeleton Loaders -->
        <div class="p-4 bg-primary/5 rounded-lg border border-primary/10 animate-pulse">
            <div class="h-3 bg-primary/20 rounded w-1/2 mb-3"></div>
            <div class="h-5 bg-muted/40 rounded w-3/4 mb-2"></div>
            <div class="h-3 bg-muted/40 rounded w-1/3 mt-2"></div>
        </div>
        <div class="space-y-3 animate-pulse">
            <div class="h-3 bg-muted/40 rounded w-1/3 mb-2"></div>
            <div class="flex items-center justify-between mb-1">
                <div class="h-3 bg-muted/40 rounded w-1/2"></div>
                <div class="h-3 bg-muted/40 rounded w-8"></div>
            </div>
            <div class="w-full bg-muted/20 dark:bg-muted/10 rounded-full h-1.5 mb-3"></div>
            <div class="flex items-center justify-between mb-1">
                <div class="h-3 bg-muted/40 rounded w-1/2"></div>
                <div class="h-3 bg-muted/40 rounded w-8"></div>
            </div>
            <div class="w-full bg-muted/20 dark:bg-muted/10 rounded-full h-1.5"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const container = $('#patient-insights-container');

        window.fetchPatientInsights = function () {
            $.ajax({
                url: apiUrl('notes') + 'insights.php',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success && response.data) {
                        renderInsights(response.data);
                    } else {
                        renderError();
                    }
                },
                error: renderError
            });
        };

        function renderInsights(data) {
            container.empty();

            // 1. Most Recent Diagnosis
            let diagnosisHtml = '';
            if (data.recent_diagnosis) {
                diagnosisHtml = `
                    <p class="text-xl font-bold leading-snug">${data.recent_diagnosis.text}</p>
                    <p class="text-xs text-muted-foreground mt-2 font-medium">Recorded on ${data.recent_diagnosis.date_formatted}</p>
                `;
            } else {
                diagnosisHtml = `
                    <p class="text-[14px] font-bold text-muted-foreground">No recent diagnosis</p>
                    <p class="text-xs text-muted-foreground mt-2 font-medium">No completed records exist yet.</p>
                `;
            }

            container.append(`
                <div class="p-4 bg-primary/5 rounded-lg border border-primary/10 transition-all hover:bg-primary/10">
                    <p class="text-[10px] font-bold text-primary uppercase tracking-wider mb-2">Most Recent Diagnosis</p>
                    ${diagnosisHtml}
                </div>
            `);

            // 2. Health Summary (Adherence & Attendance bars)
            const adherenceColorClass = data.adherence_percentage >= 80 ? 'bg-green-500' : (data.adherence_percentage >= 50 ? 'bg-amber-500' : 'bg-red-500');
            const adherenceTextClass = data.adherence_percentage >= 80 ? 'text-green-600 dark:text-green-400' : (data.adherence_percentage >= 50 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400');

            const attendanceColorClass = data.attendance_percentage >= 80 ? 'bg-primary' : (data.attendance_percentage >= 50 ? 'bg-amber-500' : 'bg-red-500');
            const attendanceTextClass = data.attendance_percentage >= 80 ? 'text-primary' : (data.attendance_percentage >= 50 ? 'text-amber-600 dark:text-amber-400' : 'text-red-600 dark:text-red-400');

            container.append(`
                <div class="space-y-4 pt-2">
                    <h4 class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest">Health Summary</h4>
                    
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-semibold">Treatment Adherence</span>
                            <span class="text-xs font-bold ${adherenceTextClass}">${data.adherence_percentage}%</span>
                        </div>
                        <div class="w-full bg-muted dark:bg-muted/30 rounded-full h-1.5 overflow-hidden">
                            <div class="${adherenceColorClass} h-full rounded-full transition-all duration-1000 ease-out" style="width: 0%" data-width="${data.adherence_percentage}%"></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-semibold">Session Attendance</span>
                            <span class="text-xs font-bold ${attendanceTextClass}">${data.attendance_percentage}%</span>
                        </div>
                        <div class="w-full bg-muted dark:bg-muted/30 rounded-full h-1.5 overflow-hidden">
                            <div class="${attendanceColorClass} h-full rounded-full transition-all duration-1000 ease-out" style="width: 0%" data-width="${data.attendance_percentage}%"></div>
                        </div>
                    </div>
                </div>
            `);

            // Trigger animations shortly after appending
            setTimeout(() => {
                container.find('[data-width]').each(function () {
                    $(this).css('width', $(this).attr('data-width'));
                });
            }, 50);
        }

        function renderError() {
            container.html(`
                <div class="bg-red-50 text-red-500 p-4 rounded-xl border border-red-100 text-center text-sm">
                    Failed to load insights.
                </div>
            `);
        }

        window.fetchPatientInsights();
    });
</script>