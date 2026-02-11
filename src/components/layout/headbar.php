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
 * @param string $role - User role (admin, patient, doctor)
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
$role = $role ?? 'patient';
$mb = $mb ?? 8;

// Load Real User Data
$user = userData();
$userName = $user['name'] ?? 'Guest User';
$userRole = $user['role'] ?? $role;
$userAvatar = $user['profile']; // already handled on media
$userSub = match ($userRole) {
    'doctor' => $user['specialization'] ?? 'Specialist',
    'patient' => "PID: " . $user['uuid'] ?? 'Patient',
    default => 'WAYSIDE PSYCHE CENTER',
};

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
    <div class="flex items-center gap-6">
        <div class="flex items-center gap-3">
            <?php if ($searchPlaceholder): ?>
                <div class="relative hidden lg:block">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground font-variation-settings-['FILL'_0,'wght'_400]">search</span>
                    <input id="global-search-input"
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
                        <span class="hidden lg:block"><?= $actionLabel ?></span>
                    </a>
                <?php else: ?>
                    <button
                        class="<?= $actionClass ?> px-5 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md shadow-primary/20 flex items-center gap-2 cursor-pointer">
                        <span class="material-symbols-outlined text-[20px] font-variation-settings-['FILL'_0,'wght'_400]">
                            <?= $actionIcon ?>
                        </span>
                        <span class="hidden lg:block"><?= $actionLabel ?></span>
                    </button>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($extraContent))
                echo $extraContent; ?>
        </div>

        <!-- User Identity Section -->
        <div class="flex items-center gap-4 border-l border-border pl-4">
            <!-- Theme Toggle Switch (Tailwind) -->
            <label
                class="relative inline-flex items-center justify-center size-10 rounded-full hover:bg-muted/50 transition-colors cursor-pointer group">
                <input type="checkbox" id="theme-toggle" class="absolute inset-0 opacity-0 cursor-pointer peer" />
                <!-- Sun Icon (Show when Dark/Checked) -->
                <span
                    class="material-symbols-outlined text-orange-400 text-xl absolute transition-all duration-300 transform scale-0 opacity-0 rotate-90 peer-checked:scale-100 peer-checked:opacity-100 peer-checked:rotate-0">light_mode</span>
                <!-- Moon Icon (Show when Light/Unchecked) -->
                <span
                    class="material-symbols-outlined text-blue-400 text-xl absolute transition-all duration-300 transform scale-100 opacity-100 rotate-0 peer-checked:scale-0 peer-checked:opacity-0 peer-checked:-rotate-90">dark_mode</span>
            </label>

            <button class="relative p-2 text-muted-foreground hover:bg-muted rounded-full transition-all group">
                <span
                    class="material-symbols-outlined text-2xl font-variation-settings-['FILL'_0,'wght'_400]">notifications</span>
                <span
                    class="absolute top-2 right-2 size-2.5 bg-error rounded-full border-2 border-background animate-pulse"></span>
            </button>

            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-black text-foreground capitalize leading-none"><?= $userName ?></p>
                    <p
                        class="text-[10px] font-bold text-primary uppercase tracking-widest mt-1 opacity-80 truncate w-25">
                        <?= $userSub ?>
                    </p>
                </div>
                <div
                    class="size-10 rounded-full border-2 border-primary/20 p-0.5 overflow-hidden shadow-sm shadow-primary/10">
                    <div class="size-full rounded-full bg-cover bg-center"
                        style="background-image: url('<?= $userAvatar ?>')"></div>
                </div>
            </div>
        </div>
    </div>
</header>