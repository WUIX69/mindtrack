<!-- Doctor Workload Summary -->
<section class="bg-card rounded-xl border border-border p-6 shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-foreground">Provider Capacity Overview</h3>
        <div class="flex gap-2">
            <span class="flex items-center gap-1.5 text-xs font-medium text-muted-foreground">
                <span class="size-2 rounded-full bg-red-600"></span> High (≥80%)
            </span>
            <span class="flex items-center gap-1.5 text-xs font-medium text-muted-foreground">
                <span class="size-2 rounded-full bg-primary"></span> Normal
            </span>
            <span class="flex items-center gap-1.5 text-xs font-medium text-muted-foreground">
                <span class="size-2 rounded-full bg-muted-foreground/30"></span> Off Today
            </span>
        </div>
    </div>
    <div id="workload-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Loading State -->
        <div class="space-y-3 animate-pulse">
            <div class="flex justify-between">
                <div class="w-24 h-3 bg-muted/40 rounded"></div>
                <div class="w-8 h-3 bg-muted/40 rounded"></div>
            </div>
            <div class="h-2 w-full bg-muted/40 rounded-full"></div>
        </div>
        <div class="space-y-3 animate-pulse">
            <div class="flex justify-between">
                <div class="w-24 h-3 bg-muted/40 rounded"></div>
                <div class="w-8 h-3 bg-muted/40 rounded"></div>
            </div>
            <div class="h-2 w-full bg-muted/40 rounded-full"></div>
        </div>
        <div class="space-y-3 animate-pulse">
            <div class="flex justify-between">
                <div class="w-24 h-3 bg-muted/40 rounded"></div>
                <div class="w-8 h-3 bg-muted/40 rounded"></div>
            </div>
            <div class="h-2 w-full bg-muted/40 rounded-full"></div>
        </div>
        <div class="space-y-3 animate-pulse">
            <div class="flex justify-between">
                <div class="w-24 h-3 bg-muted/40 rounded"></div>
                <div class="w-8 h-3 bg-muted/40 rounded"></div>
            </div>
            <div class="h-2 w-full bg-muted/40 rounded-full"></div>
        </div>
    </div>
</section>
<script>
    $(function () {
        const workloadContainer = $('#workload-container');
        const workloadEndpoint = apiUrl('dashboard') + 'doctor-workload.php';

        function fetchWorkload() {
            $.ajax({
                url: workloadEndpoint,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success && response.data) {
                        renderWorkload(response.data);
                    } else {
                        renderWorkloadError();
                    }
                },
                error: function () {
                    renderWorkloadError();
                }
            });
        }

        function renderWorkload(doctors) {
            workloadContainer.empty();

            if (!doctors || doctors.length === 0) {
                workloadContainer.html(`
                    <div class="col-span-full flex flex-col items-center justify-center py-8 text-muted-foreground">
                        <span class="material-symbols-outlined text-3xl opacity-50 mb-2">person_off</span>
                        <p class="text-sm font-medium">No active providers found.</p>
                    </div>
                `);
                return;
            }

            doctors.forEach(function (doctor) {
                const workloadPercent = doctor.workload_percent;
                const isOff = doctor.available_minutes === 0;
                const isHigh = workloadPercent >= 80;

                let barColorClass = 'bg-primary';
                let textColorClass = 'text-primary';

                if (isOff) {
                    barColorClass = 'bg-muted-foreground/30';
                    textColorClass = 'text-muted-foreground';
                } else if (isHigh) {
                    barColorClass = 'bg-red-600';
                    textColorClass = 'text-red-600';
                }

                const displayPercent = isOff ? 'Off' : workloadPercent + '%';
                const barWidth = isOff ? 0 : workloadPercent;
                const appointmentLabel = doctor.appointments_today === 1 ? 'apt' : 'apts';

                const card = `
                    <div class="space-y-3" title="${doctor.appointments_today} ${appointmentLabel} today (${doctor.total_duration_minutes}min / ${doctor.available_minutes}min available)">
                        <div class="flex justify-between text-xs font-bold uppercase tracking-wide">
                            <span class="text-muted-foreground">Dr. ${doctor.doctor_name}</span>
                            <span class="${textColorClass}">${displayPercent}</span>
                        </div>
                        <div class="h-2 w-full bg-muted rounded-full overflow-hidden">
                            <div class="h-full ${barColorClass} rounded-full transition-all duration-500" style="width: ${barWidth}%"></div>
                        </div>
                    </div>
                `;
                workloadContainer.append(card);
            });
        }

        function renderWorkloadError() {
            workloadContainer.html(`
                <div class="col-span-full flex flex-col items-center justify-center py-8 text-red-500">
                    <span class="material-symbols-outlined text-3xl mb-2">error</span>
                    <p class="text-sm font-medium">Failed to load workload data.</p>
                </div>
            `);
        }

        fetchWorkload();
    });
</script>