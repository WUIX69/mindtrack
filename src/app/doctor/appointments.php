<?php
/**
 * Doctor Schedule Page - Main Shell
 */
$pageTitle = "My Appointments - MindTrack Doctor";

$headerData = [
    'title' => 'My Appointments',
    'extraContent' => '
        <div class="bg-muted p-1 rounded-lg inline-flex">
            <button id="tab-calendar"
                class="px-4 py-2 rounded-md text-sm font-medium transition-all bg-card shadow-sm text-primary">
                Calendar View
            </button>
            <button id="tab-list"
                class="px-4 py-2 rounded-md text-sm font-medium transition-all text-muted-foreground hover:text-foreground">
                List View
            </button>
        </div>
    '
];

include_once __DIR__ . '/layout.php';

// Include DataTable Styles
shared('components', 'elements/dataTables/styles');
?>

<div class="flex flex-col lg:flex-row gap-8 min-h-0 h-full mb-0">
    <!-- Main Content Area -->
    <div class="flex-1 min-w-0 h-full">
        <!-- Calendar View Container -->
        <div id="calendar-view-container" class="h-full">
            <?= featured('appointments', 'components/calendar-view') ?>
        </div>

        <!-- List View Container -->
        <div id="list-view-container" class="hidden h-full">
            <?= featured('appointments', 'components/list-view') ?>
        </div>
    </div>

    <!-- Side Panel -->
    <div id="right-sidebar" class="w-full lg:w-80 shrink-0 space-y-8">
        <!-- Calendar Navigation (Always Visible) -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold flex items-center justify-between text-foreground/80">
                Calendar Navigation
                <span class="material-symbols-outlined text-muted-foreground text-lg">calendar_month</span>
            </h3>
            <div class="bg-card p-5 rounded-2xl border border-border shadow-sm">
                <div class="grid grid-cols-7 gap-1 text-center">
                    <?php foreach (['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $dayName): ?>
                        <span class="text-[10px] font-bold text-muted-foreground">
                            <?= $dayName ?>
                        </span>
                    <?php endforeach; ?>

                    <div class="text-xs p-1.5 text-muted-foreground/30">14</div>
                    <div class="text-xs p-1.5 text-muted-foreground/30">15</div>
                    <div
                        class="text-xs p-1.5 font-semibold hover:bg-muted rounded-lg cursor-pointer transition-colors text-foreground">
                        16</div>
                    <div
                        class="text-xs p-1.5 font-semibold hover:bg-muted rounded-lg cursor-pointer transition-colors text-foreground">
                        17</div>
                    <div
                        class="text-xs p-1.5 font-bold bg-primary text-primary-foreground rounded-lg cursor-pointer shadow-md shadow-primary/20">
                        18</div>
                    <div
                        class="text-xs p-1.5 font-semibold hover:bg-muted rounded-lg cursor-pointer transition-colors text-foreground">
                        19</div>
                    <div
                        class="text-xs p-1.5 font-semibold hover:bg-muted rounded-lg cursor-pointer transition-colors text-foreground">
                        20</div>
                </div>
            </div>
        </div>

        <!-- Upcoming Requests (Always Visible) -->
        <div class="space-y-4">
            <h3 class="text-sm font-bold flex items-center justify-between text-foreground/80">
                Upcoming Requests
                <span class="bg-primary text-primary-foreground text-[10px] px-2.5 py-1 rounded-full shadow-sm">3</span>
            </h3>
            <div class="space-y-3">
                <div
                    class="bg-card p-3.5 rounded-xl border border-border shadow-sm hover:border-primary/30 transition-all group">
                    <div class="flex items-center gap-3">
                        <img class="size-9 rounded-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBgZ5O4ZeiQPnCeFCkYe9R3m93uFqwNopkzpiJynk9qOmfuKCC1itOjJLeeSdPVfsfQZqnCPSjbLuoCsuT9fdYKQMQt1yjzE2cEnPyAJNDCzRFZw9ygISxuTDUaOMdmmUGN6GvU6NugfqKxWA-A7FwAwgwb87PxrkwWlI8C_dVV_rp_sHn-H4h-HacOW4dmPDAM-H_gQIBo8a4g6Uy8XJubcEDh3QWk9j2xLIhLdAjQrPm92ckFuFpA_XLOWr27Xe4GPz1uMRWIiLI"
                            alt="David Miller">
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold truncate text-foreground">David Miller</p>
                            <p class="text-[10px] text-muted-foreground mt-0.5">Requested: Oct 23</p>
                        </div>
                        <button
                            class="size-7 bg-primary/10 text-primary rounded-lg flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </button>
                    </div>
                </div>
                <div
                    class="bg-card p-3.5 rounded-xl border border-border shadow-sm hover:border-primary/30 transition-all group">
                    <div class="flex items-center gap-3">
                        <img class="size-9 rounded-full object-cover"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCAfb22TAnfpkFg7hBndFFxjAHCzhjPkLiQ3bJ_VlbRTKvSbI01uiuiUYEiUgPpTaTMlNVlnrlxsoH1VxsPdT3t_hcX2lnC_2cwCHruuduLbBl9bTT3fLP9Carv1_XiyUXqmTfToc_trexOJ5YTbNlEAvadxkCrhhTfGG9OVAdnAooDBEIXzJiRsL-8tzWiYEPOzSBSZx4UC7pdZMjqfimzZYMalDe0wPrGqqU8c6eiuh_S8yXQQwFbESVr4gtI78RiCrgAgBC6U1g"
                            alt="Lucia Fernandez">
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-bold truncate text-foreground">Lucia Fernandez</p>
                            <p class="text-[10px] text-muted-foreground mt-0.5">Requested: Oct 24</p>
                        </div>
                        <button
                            class="size-7 bg-primary/10 text-primary rounded-lg flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                            <span class="material-symbols-outlined text-sm">check</span>
                        </button>
                    </div>
                </div>
            </div>
            <button
                class="w-full py-2.5 text-[10px] font-bold text-muted-foreground uppercase tracking-widest hover:text-primary transition-colors">
                View All Requests
            </button>
        </div>

        <!-- Calendar Filters (Toggled) -->
        <div id="calendar-filters" class="space-y-4">
            <h3 class="text-sm font-bold text-foreground/80">Calendar Filters</h3>
            <div class="space-y-2.5">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input checked type="checkbox"
                        class="rounded border-border text-primary focus:ring-primary size-4 bg-muted">
                    <span
                        class="text-xs font-medium text-muted-foreground group-hover:text-foreground transition-colors">Confirmed
                        Sessions</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input checked type="checkbox"
                        class="rounded border-border text-primary focus:ring-primary size-4 bg-muted">
                    <span
                        class="text-xs font-medium text-muted-foreground group-hover:text-foreground transition-colors">Pending
                        Requests</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox"
                        class="rounded border-border text-primary focus:ring-primary size-4 bg-muted">
                    <span
                        class="text-xs font-medium text-muted-foreground group-hover:text-foreground transition-colors">Canceled/Postponed</span>
                </label>
            </div>
        </div>
    </div>
</div>

<?= featured('appointments', 'components/summary-modal') ?>
<?= shared('components', 'elements/dataTables/scripts'); ?>

<script src="<?= shared('data', 'appointment-statuses.js', true) ?>"></script>
<script>
    $(document).ready(function () {
        // Ensure global appointments array exists
        window.allAppointments = window.allAppointments || [];

        // --- Shared Logic ---

        // Tab Switching
        const $tabCalendar = $('#tab-calendar');
        const $tabList = $('#tab-list');
        const $calendarView = $('#calendar-view-container');
        const $listView = $('#list-view-container');
        const $rightSidebar = $('#right-sidebar');

        function switchTab(view) {
            if (view === 'calendar') {
                // Update Tabs
                $tabCalendar.addClass('bg-card shadow-sm text-primary').removeClass('text-muted-foreground hover:text-foreground');
                $tabList.removeClass('bg-card shadow-sm text-primary').addClass('text-muted-foreground hover:text-foreground');

                // Toggle Views
                $calendarView.removeClass('hidden');
                $listView.addClass('hidden');
                $rightSidebar.removeClass('hidden'); // Show Sidebar
            } else {
                // Update Tabs
                $tabList.addClass('bg-card shadow-sm text-primary').removeClass('text-muted-foreground hover:text-foreground');
                $tabCalendar.removeClass('bg-card shadow-sm text-primary').addClass('text-muted-foreground hover:text-foreground');

                // Toggle Views
                $listView.removeClass('hidden');
                $calendarView.addClass('hidden');
                $rightSidebar.addClass('hidden'); // Hide Sidebar
            }
        }

        $tabCalendar.on('click', () => switchTab('calendar'));
        $tabList.on('click', () => switchTab('list'));
    });
</script>