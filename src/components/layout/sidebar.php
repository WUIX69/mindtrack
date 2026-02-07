<?php
/**
 * Shared Sidebar Component (Support for Patient & Admin)
 */
$isAdmin = $isAdmin ?? false;
$currentPage = $currentPage ?? uriPagePath();

// Define Navigation Items
$navItems = [
    'admin' => [
        ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'url' => app('admin')],
        ['id' => 'appointments', 'label' => 'Appointments', 'icon' => 'pending_actions', 'url' => app('admin/appointments.php')],
        ['id' => 'patients', 'label' => 'Patient Records', 'icon' => 'patient_list', 'url' => app('admin/patients.php')],
        ['id' => 'doctors', 'label' => 'Doctor Management', 'icon' => 'medical_services', 'url' => app('admin/doctors.php')],
        ['id' => 'logs', 'label' => 'System Logs', 'icon' => 'terminal', 'url' => app('admin/logs.php')],
    ],
    'patient' => [
        ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'url' => app('patient')],
        ['id' => 'appointments', 'label' => 'Appointments', 'icon' => 'calendar_month', 'url' => app('patient/appointments.php')],
        ['id' => 'records', 'label' => 'My Records', 'icon' => 'description', 'url' => app('patient/records.php')],
        ['id' => 'resources', 'label' => 'Resources', 'icon' => 'menu_book', 'url' => app('patient/resources.php')],
    ]
];

$activeNav = $isAdmin ? $navItems['admin'] : $navItems['patient'];
?>
<aside class="w-64 bg-card dark:bg-sidebar border-r border-border flex flex-col fixed h-full z-20">
    <div class="p-6 flex items-center gap-3">
        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-primary-foreground">
            <span class="material-symbols-outlined text-2xl">psychology</span>
        </div>
        <div>
            <h1 class="text-xl font-bold tracking-tight">MindTrack</h1>
            <p class="text-xs text-muted-foreground"><?= $isAdmin ? 'Clinic Management' : 'Wayside Psyche Center' ?></p>
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

        <div class="pt-4 mt-4 border-t border-border">
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= $currentPage === 'settings' ? 'bg-primary/10 text-primary font-semibold' : 'text-muted-foreground hover:bg-muted dark:text-gray-400 dark:hover:bg-white/5 transition-colors' ?>"
                href="<?= $isAdmin ? app('admin/settings.php') : app('patient/settings.php') ?>">
                <span class="material-symbols-outlined">settings</span>
                <span class="text-sm">Settings</span>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-error/80 hover:bg-error/10 transition-all font-semibold"
                href="<?= app('logout') ?>">
                <span class="material-symbols-outlined">logout</span>
                <span class="text-sm">Logout</span>
            </a>
        </div>
    </nav>

    <div class="p-4 border-t border-border">
        <div class="flex items-center gap-3 p-2 rounded-xl bg-muted dark:bg-muted/20">
            <div class="w-10 h-10 rounded-full bg-cover bg-center" data-alt="User profile photo avatar"
                style="background-image: url('<?= $isAdmin ? 'https://lh3.googleusercontent.com/aida-public/AB6AXuDVQVEYnYP3RNwtH688PAaJcRKYUqn-FqE3R99MdZw7cuBlzeuvQOFMORRPCTmvE4fxogYwfMKbwhwRUiudJq_c-ki4wFS2Den4x0RusJ8YALmX_o5qbk7tNd90GqS1rQrJcVzNi_BStArnQRfyO2JjIiLPCK129vP_lgAJndDhaHwV8ElpfmYp-qrzx1H5uvznW6wac1YOp4zmsyQT6dxGJBckI7bTPWXUho97ooiVdBuyiEl9uBysl1uW03DFIIYr7LhKk5DS8kM' : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCwUDx00gZK6krtBkGrAjs8OlgCSukAKpmdeiY9SSpuk_oHQxq_aXj7NhqtbTmoH4_HFuf_kSuMriX_vCT4EOydYTg5_Ca7gJbSHteacm67tY1XAX7u7n1bNc6h5zxLenLvdPNpqUgC5EKdWwfWtpHhMu7EiJyB6I6H1hPY52FLVMLJ5vmIFY1Lk64rcXtkaJY19hIBqsb5YwOYQdzXTSFA4XNNS3qfWefhTUx3LCP4I0xt9RJJHZaz1s1iPNd9xhQMh8UrdGqWGQY' ?>')">
            </div>
            <div class="flex-1 overflow-hidden">
                <p class="text-sm font-bold truncate"><?= $isAdmin ? 'Admin Staff' : 'Alex Henderson' ?></p>
                <p class="text-xs text-muted-foreground truncate italic">
                    <?= $isAdmin ? 'Wayside Psyche Center' : 'Patient ID: #29402' ?>
                </p>
            </div>
        </div>
    </div>
</aside>