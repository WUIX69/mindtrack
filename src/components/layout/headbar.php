<?php
/**
 * Shared Headbar Component
 * 
 * @param string $title - Main page title
 * @param string $description - Sub-title description
 * @param string $searchPlaceholder - If provided, shows a search input
 * @param string $actionLabel - Label for the primary action button
 * @param string $actionIcon - Material icon name for the action button
 * @param string $actionUrl - URL for the action button (or '#' for button)
 * @param string $actionClass - Custom CSS classes for the action button
 * @param int $mb - Margin bottom utility (default: 8)
 * @param string $extraContent - HTML for additional actions or items
 */

$title = $title ?? '';
$description = $description ?? '';
$searchPlaceholder = $searchPlaceholder ?? '';
$actionLabel = $actionLabel ?? '';
$actionIcon = $actionIcon ?? 'add_circle';
$actionUrl = $actionUrl ?? '#';
$actionClass = $actionClass ?? 'bg-primary hover:bg-primary/90 text-primary-foreground';
$mb = $mb ?? 8;
?>

<header class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-<?= $mb ?>">
    <div>
        <h2 class="text-3xl font-black tracking-tight text-foreground">
            <?= $title ?>
        </h2>
        <?php if ($description): ?>
            <p class="text-muted-foreground mt-1">
                <?= $description ?>
            </p>
        <?php endif; ?>
    </div>
    <div class="flex items-center gap-3">
        <?php if ($searchPlaceholder): ?>
            <div class="relative hidden sm:block">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground font-variation-settings-['FILL'_0,'wght'_400]">search</span>
                <input
                    class="pl-10 pr-4 py-2 bg-card border border-border rounded-lg text-sm focus:ring-primary focus:border-primary w-64 transition-all placeholder:text-muted-foreground"
                    placeholder="<?= htmlspecialchars($searchPlaceholder) ?>" type="text" />
            </div>
        <?php endif; ?>

        <?php if ($actionLabel): ?>
            <?php if ($actionUrl !== '#'): ?>
                <a href="<?= $actionUrl ?>"
                    class="<?= $actionClass ?> px-5 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md shadow-primary/20 flex items-center gap-2 cursor-pointer">
                    <span class="material-symbols-outlined text-[20px]">
                        <?= $actionIcon ?>
                    </span>
                    <?= $actionLabel ?>
                </a>
            <?php else: ?>
                <button
                    class="<?= $actionClass ?> px-5 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md shadow-primary/20 flex items-center gap-2 cursor-pointer">
                    <span class="material-symbols-outlined text-[20px] font-variation-settings-['FILL'_0,'wght'_400]">
                        <?= $actionIcon ?>
                    </span>
                    <?= $actionLabel ?>
                </button>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (isset($extraContent))
            echo $extraContent; ?>
    </div>
</header>