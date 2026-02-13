<?php
/**
 * Reusable Filter Bar Component
 *
 * @param array $config Configuration for filters
 *
 * $config Structure:
 * [
 *   'primary' => [
 *      'name' => 'status',
 *      'label' => 'Status:',
 *      'options' => [
 *          ['value' => 'all', 'label' => 'All', 'count_id' => 'count-all'],
 *          ['value' => 'active', 'label' => 'Active', 'count_id' => 'count-active'],
 *      ]
 *   ],
 *   'secondary_filters' => [
 *      [
 *          'type' => 'select',
 *          'name' => 'service',
 *          'icon' => 'medical_services',
 *          'placeholder' => 'All Services',
 *          'options' => [ ... ] // Optional static options
 *      ],
 *      [
 *          'type' => 'date',
 *          'name' => 'date',
 *          'icon' => 'calendar_month'
 *      ],
 *      [
 *          'type' => 'search',
 *          'name' => 'search',
 *          'placeholder' => 'Search...'
 *      ]
 *   ],
 *   'actions' => [
 *      [
 *          'label' => 'Reset',
 *          'icon' => 'filter_alt_off',
 *          'id' => 'reset-filters'
 *      ]
 *   ]
 * ]
 */

$isTransparent = $isTransparent ?? false;
$mb = $mb ?? '6';
$mt = $mt ?? '5';
$primary = $config['primary'] ?? $primary ?? null;
$secondary = $config['secondary_filters'] ?? $secondary_filters ?? [];
$actions = $config['actions'] ?? $actions ?? [];

// Default Reset Action if not provided but we have filters
if (empty($actions) && (!empty($primary) || !empty($secondary))) {
    $actions[] = [
        'label' => 'Reset',
        'icon' => 'filter_alt_off',
        'id' => 'reset-filters',
        'class' => 'text-primary hover:bg-primary/5'
    ];
}
?>

<div
    class="<?= $isTransparent ? '' : 'bg-card rounded-2xl border border-border shadow-sm py-2 px-4' ?> flex flex-wrap items-center gap-6 mb-<?= $mb ?> mt-<?= $mt ?> filter-bar-component">

    <!-- Primary Filter (Button Group) -->
    <?php if ($primary): ?>
        <div class="flex items-center gap-3">
            <?php if (!empty($primary['label'])): ?>
                <span class="text-xs font-black text-muted-foreground uppercase tracking-widest">
                    <?= $primary['label'] ?>
                </span>
            <?php endif; ?>

            <div class="flex bg-muted p-1 rounded-xl" id="<?= $primary['name'] ?>-filter-group">
                <?php foreach ($primary['options'] as $idx => $opt):
                    $isActive = $idx === 0; // Default first to active
                    $baseClass = "filter-btn-" . $primary['name'];
                    $activeClass = $isActive ? "bg-card shadow-sm text-primary" : "text-muted-foreground hover:text-foreground";
                    ?>
                    <button data-value="<?= $opt['value'] ?>" data-group="<?= $primary['name'] ?>"
                        class="filter-primary-btn <?= $baseClass ?> px-5 py-2 text-xs font-bold rounded-lg transition-all <?= $activeClass ?>">
                        <?= $opt['label'] ?>
                        <?php if (!empty($opt['count_id'])): ?>
                            (<span id="<?= $opt['count_id'] ?>">0</span>)
                        <?php endif; ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <?php if (!empty($secondary)): ?>
            <div class="h-8 w-px bg-border hidden lg:block"></div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Secondary Filters -->
    <div class="flex flex-wrap items-center gap-4 flex-1">
        <?php foreach ($secondary as $filter): ?>
            <?php if ($filter['type'] === 'select'): ?>
                <div class="relative flex-1 min-w-[200px]">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg text-muted-foreground">
                        <?= $filter['icon'] ?? 'filter_list' ?>
                    </span>
                    <select id="<?= $filter['name'] ?>-filter" name="<?= $filter['name'] ?>"
                        class="filter-input w-full pl-10 pr-4 py-2.5 bg-muted border-none rounded-xl text-xs font-bold text-foreground focus:ring-2 focus:ring-primary/20 cursor-pointer appearance-none transition-all">
                        <option value="">
                            <?= $filter['placeholder'] ?? 'All' ?>
                        </option>
                        <?php if (!empty($filter['options'])): ?>
                            <?php foreach ($filter['options'] as $val => $label): ?>
                                <option value="<?= $val ?>">
                                    <?= $label ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            <?php elseif ($filter['type'] === 'date'): ?>
                <div class="relative flex-1 min-w-[200px]">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg text-muted-foreground">
                        <?= $filter['icon'] ?? 'calendar_month' ?>
                    </span>
                    <input id="<?= $filter['name'] ?>-filter" name="<?= $filter['name'] ?>"
                        class="filter-input w-full pl-10 pr-4 py-2.5 bg-muted border-none rounded-xl text-xs font-bold text-foreground focus:ring-2 focus:ring-primary/20 transition-all"
                        type="date" placeholder="<?= $filter['placeholder'] ?? '' ?>" />
                </div>
            <?php elseif ($filter['type'] === 'search'): ?>
                <div class="relative flex-1 min-w-[200px]">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-lg text-muted-foreground">
                        <?= $filter['icon'] ?? 'search' ?>
                    </span>
                    <input id="<?= $filter['name'] ?>-filter" name="<?= $filter['name'] ?>"
                        class="filter-input w-full pl-10 pr-4 py-2.5 bg-muted border-none rounded-xl text-xs font-bold text-foreground focus:ring-2 focus:ring-primary/20 transition-all placeholder:text-muted-foreground/70"
                        type="text" placeholder="<?= $filter['placeholder'] ?? 'Search...' ?>" />
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Actions -->
    <?php foreach ($actions as $action): ?>
        <button id="<?= $action['id'] ?>"
            class="flex items-center gap-2 text-xs font-bold transition-all p-2 rounded-lg <?= $action['class'] ?? 'text-primary hover:bg-primary/5' ?>">
            <?php if (!empty($action['icon'])): ?>
                <span class="material-symbols-outlined text-lg">
                    <?= $action['icon'] ?>
                </span>
            <?php endif; ?>
            <?= $action['label'] ?>
        </button>
    <?php endforeach; ?>
</div>

<script>
    $(document).ready(function () {
        // Determine the primary filter name from DOM if exists
        const primaryGroup = $('.filter-primary-btn').first().data('group');

        function getFilterValues() {
            const values = {};

            // Primary Filter
            if (primaryGroup) {
                values[primaryGroup] = $(`.filter-primary-btn.bg-card[data-group="${primaryGroup}"]`).data('value');
                if (values[primaryGroup] === undefined) values[primaryGroup] = '';
            }

            // Secondary Filters
            $('.filter-input').each(function () {
                const name = $(this).attr('name');
                const val = $(this).val();
                // Map 'all' from selects to standard 'all' or empty string depending on preference
                // Keeping it as is for now, consumer handles it.
                values[name] = val;
            });

            return values;
        }

        function emitChange() {
            const filters = getFilterValues();
            // Trigger custom event on document
            $(document).trigger('filter:change', [filters]);
        }

        // Primary Button Click
        $('.filter-primary-btn').on('click', function () {
            const group = $(this).data('group');
            const $groupBtns = $(`.filter-primary-btn[data-group="${group}"]`);

            // Update UI
            $groupBtns.removeClass('bg-card shadow-sm text-primary').addClass('text-muted-foreground hover:text-foreground');
            $(this).removeClass('text-muted-foreground hover:text-foreground').addClass('bg-card shadow-sm text-primary');

            emitChange();
        });

        // Input/Select Change
        $('.filter-input').on('change keyup', function () {
            // Debounce search inputs if needed? For now simple change/keyup
            // For text inputs 'keyup' might be too aggressive, let's stick to 'change' + 'input' with debounce if needed.
            // For this implementation, 'change' is safest for selects/dates.
        });

        // Debounced input for text fields
        let timeout = null;
        $('input[type="text"].filter-input').on('input', function () {
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                emitChange();
            }, 300);
        });

        $('select.filter-input, input[type="date"].filter-input').on('change', function () {
            emitChange();
        });

        // Reset Action
        $('#reset-filters').on('click', function () {
            // Reset Primary
            if (primaryGroup) {
                const $btns = $(`.filter-primary-btn[data-group="${primaryGroup}"]`);
                $btns.removeClass('bg-card shadow-sm text-primary').addClass('text-muted-foreground hover:text-foreground');
                $btns.first().removeClass('text-muted-foreground hover:text-foreground').addClass('bg-card shadow-sm text-primary');
            }

            // Reset Secondary
            $('.filter-input').each(function () {
                if ($(this).is('select')) {
                    $(this).val(''); // Or first option
                    if ($(this).find('option[value=""]').length === 0) {
                        $(this).prop('selectedIndex', 0);
                    }
                } else {
                    $(this).val('');
                }
            });

            emitChange();
        });
    });
</script>