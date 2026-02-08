<?php
/**
 * Shared Sidebar Component (Support for Patient, Admin & Doctor)
 */
$role = $role ?? 'patient';
$currentPage = $currentPage ?? uriPagePath();

// Load Navigation Data
require_once __DIR__ . '/../../data/navigation.php';
$navItems = getNavigation();

$activeNav = $navItems[$role] ?? $navItems['patient'];
$subtitle = 'Wayside Psyche Center';
if ($role === 'admin')
    $subtitle = 'Clinic Management';
if ($role === 'doctor')
    $subtitle = 'Clinical Portal';
?>
<aside class="w-64 bg-card dark:bg-sidebar border-r border-border flex flex-col fixed h-full z-20">
    <div class="p-6 flex items-center gap-3">
        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-primary-foreground">
            <span class="material-symbols-outlined text-2xl">psychology</span>
        </div>
        <div>
            <h1 class="text-xl font-bold tracking-tight">MindTrack</h1>
            <p class="text-xs text-muted-foreground"><?= $subtitle ?></p>
        </div>
    </div>

    <nav class="flex-1 px-4 mt-4 space-y-1">
        <?php foreach ($activeNav as $item): ?>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= ($currentPage === $item['id'] || ($item['id'] === 'dashboard' && ($currentPage === 'index' || $currentPage === ''))) ? 'bg-primary/10 text-primary font-semibold' : 'text-muted-foreground hover:bg-muted dark:text-gray-400 dark:hover:bg-white/5 transition-colors' ?>"
                href="<?= $item['url'] ?>">
                <span class="material-symbols-outlined"><?= $item['icon'] ?></span>
                <span class="text-sm"><?= $item['label'] ?></span>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="px-4 py-6 border-t border-border space-y-1">
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $currentPage === 'settings' ? 'bg-primary/10 text-primary font-semibold' : 'text-muted-foreground hover:bg-muted dark:text-gray-400 dark:hover:bg-white/5 transition-colors' ?>"
            href="<?= app($role . '/settings.php') ?>">
            <span class="material-symbols-outlined">settings</span>
            <span class="text-sm">Settings</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-error/80 hover:bg-error/10 transition-all font-semibold"
            href="<?= app('logout') ?>">
            <span class="material-symbols-outlined">logout</span>
            <span class="text-sm">Logout</span>
        </a>
    </div>
</aside>