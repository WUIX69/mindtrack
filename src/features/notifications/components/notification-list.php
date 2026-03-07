<?php
/**
 * Shared Notification List Component
 *
 * @param string $role - 'admin', 'doctor', or 'patient'
 */
$role = $role ?? 'patient';

// Include Data Source
require_once dirname(__DIR__, 3) . '/data/notifications.php';

// Fetch Static Data for Phase 1 (Flattened)
$notifications = getStaticNotifications($role);

// Map color strings to Tailwind classes
$colorMap = getStaticNotificationColors();
?>

<div class="flex flex-col gap-4" id="notifications-list-container">
    <?php foreach ($notifications as $index => $item): ?>
        <?php
        $cardClass = $item['unread']
            ? 'bg-card border border-border hover:border-primary/30 shadow-sm hover:shadow-md transition-all cursor-pointer group unread-notification'
            : 'bg-card/50 dark:bg-card/20 border border-border shadow-none opacity-80 cursor-pointer group read-notification hover:opacity-100 transition-all';
        $colorClass = $colorMap[$item['color']] ?? 'bg-primary/10 text-primary';
        ?>
        <div class="notification-item flex flex-col md:flex-row md:items-center justify-between gap-4 p-4 rounded-2xl <?= $cardClass ?>"
            data-index="<?= $index ?>">
            <div class="flex items-start gap-4 flex-1">
                <div class="h-12 w-12 shrink-0 rounded-xl flex items-center justify-center <?= $colorClass ?>">
                    <span class="material-symbols-outlined">
                        <?= $item['icon'] ?>
                    </span>
                </div>
                <div class="flex flex-col flex-1">
                    <span class="text-base font-semibold text-foreground group-hover:text-primary transition-colors">
                        <?= $item['title'] ?>
                    </span>
                    <span class="text-sm text-muted-foreground">
                        <?= $item['desc'] ?>
                    </span>
                </div>
            </div>
            <div
                class="flex flex-col items-end gap-1 shrink-0 pt-2 md:pt-0 border-t md:border-t-0 border-border/50 md:border-transparent mt-2 md:mt-0 w-full md:w-auto text-right md:text-left">
                <span class="text-xs font-medium text-muted-foreground">
                    <?= $item['time'] ?>
                </span>
                <?php if ($item['unread']): ?>
                    <div
                        class="h-2 w-2 rounded-full bg-primary unread-dot mt-1 md:mt-0 ml-auto md:ml-0 shadow-sm shadow-primary/40">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Table Footer component for pagination -->
<?= shared('components', 'table-footer') ?>

<script>
    $(document).ready(function () {
        const notifications = $('.notification-item');
        const totalItems = notifications.length;

        // Initialize Pagination
        const footer = new TableFooter({
            currentPage: 1,
            onPageChange: function (page) {
                renderList();
            },
            onPerPageChange: function (perPage) {
                renderList();
            }
        });

        function renderList() {
            // Get rendering boundaries from the footer class
            const { startIdx, endIdx } = footer.update(totalItems);

            // Hide all
            notifications.addClass('hidden');

            // Show current page items
            notifications.slice(startIdx, endIdx).removeClass('hidden');
        }

        // Initial render
        renderList();

        // Mark all as read button
        $('#btn-mark-all-read').on('click', function () {
            $('.unread-notification')
                .removeClass('bg-card border-border hover:border-primary/30 shadow-sm hover:shadow-md unread-notification')
                .addClass('bg-card/50 dark:bg-card/20 border border-border shadow-none opacity-80 read-notification hover:opacity-100');
            $('.unread-dot').hide();
        });

        // Individual notification click
        $('.notification-item').on('click', function () {
            if ($(this).hasClass('unread-notification')) {
                $(this).removeClass('bg-card hover:border-primary/30 shadow-sm hover:shadow-md unread-notification')
                    .addClass('bg-card/50 dark:bg-card/20 shadow-none opacity-80 read-notification hover:opacity-100');
                $(this).find('.unread-dot').hide();
            }
        });
    });
</script>