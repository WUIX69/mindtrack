<!-- Appointment History Table -->
<div class="lg:col-span-2">
    <div class="bg-card rounded-xl border border-border overflow-hidden shadow-sm">
        <div class="px-6 py-5 border-b border-border flex items-center justify-between">
            <h3 class="font-bold text-lg">Recent Appointment History</h3>
            <a class="text-primary text-sm font-bold hover:underline" href="<?= app('patient/appointments/') ?>">View
                All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-xs uppercase tracking-wider text-muted-foreground bg-muted/50">
                        <th class="px-6 py-3 font-semibold">Date</th>
                        <th class="px-6 py-3 font-semibold">Service</th>
                        <th class="px-6 py-3 font-semibold">Provider</th>
                        <th class="px-6 py-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody id="appointment-history-body" class="divide-y divide-border">
                    <!-- Skeleton Loading -->
                    <?php for ($i = 0; $i < 3; $i++): ?>
                        <tr class="animate-pulse">
                            <td class="px-6 py-4">
                                <div class="h-4 w-24 bg-muted rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="h-4 w-32 bg-muted rounded"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="h-8 w-8 rounded-full bg-muted"></div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="h-4 w-16 bg-muted rounded"></div>
                            </td>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(function () {
        function fetchRecentHistory() {
            $.ajax({
                url: apiUrl("appointments") + "list-appointments.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (!response.success) {
                        $('#appointment-history-body').html('<tr><td colspan="4" class="px-6 py-10 text-center text-muted-foreground">Failed to load history.</td></tr>');
                        return;
                    }

                    const appointments = response.data;
                    if (appointments.length === 0) {
                        $('#appointment-history-body').html('<tr><td colspan="4" class="px-6 py-10 text-center text-muted-foreground">No appointments found.</td></tr>');
                        return;
                    }

                    // Sort by date descending and take top 5
                    const recent = appointments
                        .sort((a, b) => new Date(b.sched_date) - new Date(a.sched_date))
                        .slice(0, 5);

                    let html = '';
                    recent.forEach(a => {
                        const dateStr = new Date(a.sched_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                        const timeStr = a.sched_time;

                        let statusClass = 'bg-muted text-muted-foreground';
                        let statusLabel = a.status.charAt(0).toUpperCase() + a.status.slice(1).replace('_', ' ');

                        if (a.status === 'confirmed') {
                            statusClass = 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400';
                            statusLabel = 'Approved';
                        } else if (a.status === 'pending') {
                            statusClass = 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-400';
                            statusLabel = 'Pending';
                        } else if (a.status === 'completed') {
                            statusClass = 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-400';
                        }

                        html += `
                            <tr class="hover:bg-muted/30 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold">${dateStr}</p>
                                    <p class="text-xs text-muted-foreground">${timeStr}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm">${a.service_name}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-muted border border-border overflow-hidden">
                                            <img src="https://ui-avatars.com/api/?name=${encodeURIComponent('Dr. ' + a.doctor_firstname + ' ' + a.doctor_lastname)}&background=random" class="size-full object-cover" />
                                        </div>
                                        <span class="text-sm font-medium">Dr. ${a.doctor_firstname}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide ${statusClass}">${statusLabel}</span>
                                </td>
                            </tr>
                        `;
                    });
                    $('#appointment-history-body').html(html);
                },
                error: ajaxErrorHandler
            });
        }

        fetchRecentHistory();
    });
</script>