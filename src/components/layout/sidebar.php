<?php
/**
 * Shared Sidebar Component (Support for Patient, Admin & Doctor)
 */
$role = $role ?? 'patient';
$currentPage = $currentPage ?? uriPagePath();

// Define Navigation Items
$navItems = [
    'admin' => [
        ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'url' => app('admin')],
        ['id' => 'appointments', 'label' => 'Appointment Requests', 'icon' => 'pending_actions', 'url' => app('admin/appointments/')],
        ['id' => 'patients', 'label' => 'Patients Record', 'icon' => 'patient_list', 'url' => app('admin/patients.php')],
        ['id' => 'doctors', 'label' => 'Doctors Management', 'icon' => 'medical_services', 'url' => app('admin/doctors.php')],
        ['id' => 'services', 'label' => 'Clinical Services', 'icon' => 'list_alt', 'url' => app('admin/services.php')],
    ],
    'doctor' => [
        ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'url' => app('doctor')],
        ['id' => 'schedule', 'label' => 'My Schedule', 'icon' => 'calendar_today', 'url' => app('doctor/schedule.php')],
        ['id' => 'patients', 'label' => 'Patients', 'icon' => 'group', 'url' => app('doctor/patients.php')],
        ['id' => 'notes', 'label' => 'Clinical Notes', 'icon' => 'description', 'url' => app('doctor/notes.php')],
    ],
    'patient' => [
        ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'url' => app('patient')],
        ['id' => 'appointments', 'label' => 'Appointments', 'icon' => 'calendar_month', 'url' => app('patient/appointments/')],
        ['id' => 'records', 'label' => 'My Records', 'icon' => 'description', 'url' => app('patient/records.php')],
        ['id' => 'resources', 'label' => 'Resources', 'icon' => 'menu_book', 'url' => app('patient/resources.php')],
    ]
];

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