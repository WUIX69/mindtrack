<?php
/**
 * Patient Dashboard Sidebar Component
 */
?>
<aside class="w-64 bg-card dark:bg-sidebar border-r border-border flex flex-col fixed h-full">
    <div class="p-6 flex items-center gap-3">
        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-primary-foreground">
            <span class="material-symbols-outlined text-2xl">psychology</span>
        </div>
        <div>
            <h1 class="text-xl font-bold tracking-tight">MindTrack</h1>
            <p class="text-xs text-muted-foreground">Wayside Psyche Center</p>
        </div>
    </div>
    <?php $currentPage = $currentPage ?? 'dashboard'; ?>
    <nav class="flex-1 px-4 mt-4 space-y-1">
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $currentPage === 'dashboard' ? 'bg-primary/10 text-primary font-semibold' : 'text-muted-foreground hover:bg-muted dark:text-gray-400 dark:hover:bg-white/5 transition-colors' ?>"
            href="<?= app('patient') ?>">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="text-sm">Dashboard</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $currentPage === 'appointments' ? 'bg-primary/10 text-primary font-semibold' : 'text-muted-foreground hover:bg-muted dark:text-gray-400 dark:hover:bg-white/5 transition-colors' ?>"
            href="<?= app('patient/appointments.php') ?>">
            <span class="material-symbols-outlined text-[24px]">calendar_month</span>
            <span class="text-sm">Appointments</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $currentPage === 'records' ? 'bg-primary/10 text-primary font-semibold' : 'text-muted-foreground hover:bg-muted dark:text-gray-400 dark:hover:bg-white/5 transition-colors' ?>"
            href="<?= app('patient/records.php') ?>">
            <span class="material-symbols-outlined">description</span>
            <span class="text-sm">My Records</span>
        </a>
        <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $currentPage === 'resources' ? 'bg-primary/10 text-primary font-semibold' : 'text-muted-foreground hover:bg-muted dark:text-gray-400 dark:hover:bg-white/5 transition-colors' ?>"
            href="<?= app('patient/resources.php') ?>">
            <span class="material-symbols-outlined">menu_book</span>
            <span class="text-sm">Resources</span>
        </a>
        <div class="pt-4 mt-4 border-t border-border">
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $currentPage === 'settings' ? 'bg-primary/10 text-primary font-semibold' : 'text-muted-foreground hover:bg-muted dark:text-gray-400 dark:hover:bg-white/5 transition-colors' ?>"
                href="<?= app('patient/settings.php') ?>">
                <span class="material-symbols-outlined">settings</span>
                <span class="text-sm">Settings</span>
            </a>
        </div>
    </nav>
    <div class="p-4 border-t border-border">
        <div class="flex items-center gap-3 p-2 rounded-xl bg-muted dark:bg-muted/20">
            <div class="w-10 h-10 rounded-full bg-cover bg-center" data-alt="Patient profile photo avatar"
                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCwUDx00gZK6krtBkGrAjs8OlgCSukAKpmdeiY9SSpuk_oHQxq_aXj7NhqtbTmoH4_HFuf_kSuMriX_vCT4EOydYTg5_Ca7gJbSHteacm67tY1XAX7u7n1bNc6h5zxLenLvdPNpqUgC5EKdWwfWtpHhMu7EiJyB6I6H1hPY52FLVMLJ5vmIFY1Lk64rcXtkaJY19hIBqsb5YwOYQdzXTSFA4XNNS3qfWefhTUx3LCP4I0xt9RJJHZaz1s1iPNd9xhQMh8UrdGqWGQY')">
            </div>
            <div class="flex-1 overflow-hidden">
                <p class="text-sm font-bold truncate">Alex Henderson</p>
                <p class="text-xs text-muted-foreground truncate italic">Patient ID: #29402</p>
            </div>
        </div>
    </div>
</aside>