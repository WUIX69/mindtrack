<?php
/**
 * Shared Notification List Component
 *
 * @param string $role - 'admin', 'doctor', or 'patient'
 */
$role = $role ?? 'patient';

?>

<div class="flex flex-col gap-4" id="notifications-list-container">
    <!-- Skeleton Loaders -->
    <div id="notifications-skeleton">
        <?php for ($i = 0; $i < 5; $i++): ?>
            <div
                class="notification-item flex flex-col md:flex-row md:items-center justify-between gap-4 p-4 rounded-2xl bg-card border border-border shadow-sm animate-pulse">
                <div class="flex items-start gap-4 flex-1 w-full">
                    <div class="h-12 w-12 shrink-0 rounded-xl bg-muted/60"></div>
                    <div class="flex flex-col flex-1 gap-2 py-1">
                        <div class="h-4 bg-muted/60 rounded w-1/3"></div>
                        <div class="h-3 bg-muted/60 rounded w-3/4"></div>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-1 shrink-0 pt-2 md:pt-0 w-full md:w-auto">
                    <div class="h-3 bg-muted/60 rounded w-16"></div>
                </div>
            </div>
        <?php endfor; ?>
    </div>

    <!-- Dynamic Content Container -->
    <div id="notifications-content" class="flex flex-col gap-4 hidden">
        <!-- JS rendered items will go here -->
    </div>
</div>

<!-- Empty State Template -->
<div id="notifications-empty" class="hidden flex flex-col items-center justify-center py-12 px-4 text-center">
    <div class="h-16 w-16 mb-4 rounded-full bg-muted flex items-center justify-center text-muted-foreground">
        <span class="material-symbols-outlined text-3xl">notifications_off</span>
    </div>
    <h3 class="text-lg font-medium text-foreground">No notifications yet</h3>
    <p class="text-sm text-muted-foreground mt-1 max-w-sm">When you get notifications, they'll show up here.</p>
</div>

<!-- Table Footer component for pagination -->
<?= shared('components', 'table-footer') ?>

<script src="<?= shared('data', 'notifications.js', true) ?>"></script>
<script>
    let allNotifications = [];

    // Helper to format date
    function formatTimeAgo(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toLocaleString(undefined, {
            month: 'short', day: 'numeric', year: 'numeric',
            hour: '2-digit', minute: '2-digit'
        });
    }

    $(document).ready(function () {
        const container = $('#notifications-content');
        const skeleton = $('#notifications-skeleton');
        const emptyState = $('#notifications-empty');

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

        function fetchNotifications() {
            $.ajax({
                url: apiUrl('shared') + 'notifications.php?action=all',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        allNotifications = response.data;
                        skeleton.addClass('hidden');
                        if (allNotifications.length === 0) {
                            emptyState.removeClass('hidden');
                            container.addClass('hidden');
                            footer.update(0);
                        } else {
                            renderList();
                            container.removeClass('hidden');
                        }

                        $(document).trigger('notifications:loaded', [allNotifications]);
                    }
                },
                error: function () {
                    skeleton.addClass('hidden');
                    emptyState.find('h3').text('Failed to load notifications');
                    emptyState.find('p').text('There was a problem reaching the server.');
                    emptyState.removeClass('hidden');
                }
            });
        }

        function createNotificationCard(item, index) {
            let parsedData = {};
            try {
                parsedData = JSON.parse(item.data) || {};
            } catch (e) {
                console.error("Invalid JSON data for notification", item.data);
            }

            const isUnread = Boolean(Number(item.is_read) === 0);
            const cardClass = isUnread
                ? 'bg-card border border-border hover:border-primary/30 shadow-sm hover:shadow-md transition-all cursor-pointer group unread-notification'
                : 'bg-card/50 dark:bg-card/20 border border-border shadow-none opacity-80 cursor-pointer group read-notification hover:opacity-100 transition-all';

            const colorClass = notificationColorsMap[parsedData.color] || 'bg-primary/10 text-primary';
            const icon = parsedData.icon || 'notifications';
            const title = parsedData.title || '';
            const desc = parsedData.description || '';
            const time = formatTimeAgo(item.created_at);

            let unreadBadge = '';
            if (isUnread) {
                unreadBadge = `<div class="h-2 w-2 rounded-full bg-primary unread-dot mt-1 md:mt-0 ml-auto md:ml-0 shadow-sm shadow-primary/40"></div>`;
            }

            return `
                <div class="notification-item flex flex-col md:flex-row md:items-center justify-between gap-4 p-4 rounded-2xl ${cardClass}"
                    data-id="${item.id}" data-index="${index}">
                    <div class="flex items-start gap-4 flex-1">
                        <div class="h-12 w-12 shrink-0 rounded-xl flex items-center justify-center ${colorClass}">
                            <span class="material-symbols-outlined">${icon}</span>
                        </div>
                        <div class="flex flex-col flex-1">
                            <span class="text-base font-semibold text-foreground group-hover:text-primary transition-colors">
                                ${title}
                            </span>
                            <span class="text-sm text-muted-foreground">
                                ${desc}
                            </span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-1 shrink-0 pt-2 md:pt-0 border-t md:border-t-0 border-border/50 md:border-transparent mt-2 md:mt-0 w-full md:w-auto text-right md:text-left">
                        <span class="text-xs font-medium text-muted-foreground">
                            ${time}
                        </span>
                        ${unreadBadge}
                    </div>
                </div>
            `;
        }

        function renderList() {
            const totalItems = allNotifications.length;
            const { startIdx, endIdx } = footer.update(totalItems);

            container.empty();

            const itemsToShow = allNotifications.slice(startIdx, endIdx);
            itemsToShow.forEach((item, index) => {
                container.append(createNotificationCard(item, startIdx + index));
            });
        }

        // Initial fetch
        fetchNotifications();

        // Mark all as read button
        $('#btn-mark-all-read').on('click', function () {
            const btn = $(this);
            const originalText = btn.html();
            btn.prop('disabled', true).html('<span class="material-symbols-outlined animate-spin text-sm">change_circle</span> Marking...');

            $.ajax({
                url: apiUrl('shared') + 'notifications.php',
                method: 'POST',
                data: { action: 'mark_all_read' },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('.unread-notification')
                            .removeClass('bg-card border-border hover:border-primary/30 shadow-sm hover:shadow-md unread-notification')
                            .addClass('bg-card/50 dark:bg-card/20 border border-border shadow-none opacity-80 read-notification hover:opacity-100');
                        $('.unread-dot').hide();

                        allNotifications = allNotifications.map(n => ({ ...n, is_read: 1 }));
                        $(document).trigger('notifications:readAll');
                    }
                },
                complete: function () {
                    btn.prop('disabled', false).html(originalText);
                }
            });
        });

        // Individual notification click
        $(document).on('click', '.notification-item', function () {
            const item = $(this);
            if (item.hasClass('unread-notification')) {
                const id = item.data('id');

                // Optimistic update
                item.removeClass('bg-card hover:border-primary/30 shadow-sm hover:shadow-md unread-notification')
                    .addClass('bg-card/50 dark:bg-card/20 shadow-none opacity-80 read-notification hover:opacity-100');
                item.find('.unread-dot').hide();

                const index = item.data('index');
                if (allNotifications[index]) {
                    allNotifications[index].is_read = 1;
                }

                $.ajax({
                    url: apiUrl('shared') + 'notifications.php',
                    method: 'POST',
                    data: { action: 'mark_read', id: id },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            $(document).trigger('notifications:read', [id]);
                        }
                    }
                });
            }
        });

        // Listen for new notifications via Pusher
        $(document).on('notifications:new', function (e, newNotification) {
            allNotifications.unshift(newNotification);
            if (allNotifications.length === 1) {
                emptyState.addClass('hidden');
                container.removeClass('hidden');
            }
            renderList();
        });
    });
</script>