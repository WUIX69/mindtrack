<?php
/**
 * Shared Success Modal - Step 3
 * 
 * @param string $role (patient|admin)
 * @param string $date
 * @param string $doctor
 */
$role = $role ?? 'patient';
$date = $date ?? 'selected date';
$doctor = $doctor ?? 'the specialist';

$title = ($role === 'admin') ? 'Appointment Created!' : 'Request Submitted!';
$description = ($role === 'admin')
    ? "The appointment for <strong>$date</strong> has been successfully booked with $doctor. The patient has been notified."
    : "Your appointment request for <strong>$date</strong> has been sent to $doctor's team. You can track its status in your dashboard.";

$dashboardUrl = '../index.php';
$dashboardLabel = ($role === 'admin') ? 'Back to Dashboard' : 'Back to Dashboard';
$listUrl = '../index.php';
$listLabel = ($role === 'admin') ? 'View All Appointments' : 'View My Appointments';
?>

<!-- Success Modal -->
<div id="success-modal"
    class="hidden fixed inset-0 z-[100] bg-zinc-950/80 backdrop-blur-sm items-center justify-center">
    <div class="bg-card w-full max-w-md rounded-[2rem] shadow-2xl p-10 text-center border border-border">
        <div
            class="size-24 bg-green-100 dark:bg-green-900/30 text-green-600 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
            <span class="material-symbols-outlined text-5xl font-black">task_alt</span>
        </div>
        <h3 class="text-3xl font-black text-foreground mb-3 tracking-tight">
            <?= $title ?>
        </h3>
        <p class="text-muted-foreground mb-10 leading-relaxed font-medium">
            <?= $description ?>
        </p>
        <div class="grid grid-cols-1 gap-4">
            <a class="block w-full py-4 bg-primary text-white font-black rounded-2xl hover:opacity-90 transition-all shadow-lg shadow-primary/20"
                href="<?= $dashboardUrl ?>">
                <?= $dashboardLabel ?>
            </a>
            <a class="block w-full py-4 text-primary font-bold hover:bg-primary/5 rounded-2xl transition-all"
                href="<?= $listUrl ?>">
                <?= $listLabel ?>
            </a>
        </div>
    </div>
</div>