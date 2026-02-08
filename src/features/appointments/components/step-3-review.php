<?php
/**
 * Appointment Booking - Step 3: Review & Confirm (Feature Component)
 * 
 * @param string $role (patient|admin)
 * @param array $header (title, description)
 * @param array $summary (service_label, date_label, provider_label)
 * @param array $notes (label, placeholder)
 * @param array $alert (title, text)
 * @param string $confirm_label
 * @param string $back_label
 */
$role = $role ?? 'patient';

// UI Strings
$header_title = $header['title'] ?? 'Review Selection';
$header_desc = $header['description'] ?? 'Please double-check the appointment details before confirming the request.';

$service_label = $summary['service_label'] ?? 'Service Type';
$date_label = $summary['date_label'] ?? 'Scheduled For';
$provider_label = $summary['provider_label'] ?? 'Healthcare Provider';

$notes_label = $notes['label'] ?? 'Notes';
$notes_placeholder = $notes['placeholder'] ?? 'Add instructions...';

$confirm_label = $confirm_label ?? 'Confirm';
$back_label = $back_label ?? 'Edit Selection';

$alert_title = $alert['title'] ?? 'Information';
$alert_text = $alert['text'] ?? 'Please review carefully.';
?>

<div class="w-full">
    <!-- Progress Stepper -->
    <?= featured('appointments', 'components/progress-stepper', [
        'currentStep' => 3,
        'title' => $header_title,
        'description' => $header_desc
    ]) ?>

    <div class="space-y-8">
        <!-- Main Summary Card -->
        <div class="bg-card rounded-[2.5rem] shadow-sm border border-border overflow-hidden">
            <div class="p-10 space-y-10">
                <!-- Summary Section 1: Service -->
                <div class="flex items-start gap-6">
                    <div
                        class="flex items-center justify-center rounded-[1.5rem] bg-primary/10 text-primary p-5 shrink-0 shadow-inner">
                        <span class="material-symbols-outlined text-5xl">psychology</span>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-xs font-black text-muted-foreground uppercase tracking-[0.2em] mb-2">
                            <?= $service_label ?>
                        </p>
                        <p class="text-3xl font-black text-foreground tracking-tight">Psychotherapy (60 min)</p>
                        <p class="text-base text-muted-foreground mt-2 max-w-lg font-medium leading-relaxed">Individual
                            therapeutic sessions focused
                            on long-term emotional well-being and personal growth.</p>
                    </div>
                </div>

                <hr class="border-border/50" />

                <!-- Summary Section 2: Date & Time -->
                <div class="flex items-start gap-6">
                    <div
                        class="flex items-center justify-center rounded-[1.5rem] bg-primary/10 text-primary p-5 shrink-0 shadow-inner">
                        <span class="material-symbols-outlined text-5xl">calendar_today</span>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-xs font-black text-muted-foreground uppercase tracking-[0.2em] mb-2">
                            <?= $date_label ?>
                        </p>
                        <p class="text-3xl font-black text-foreground tracking-tight">Wednesday, October 25th, 2023</p>
                        <p class="text-2xl font-black text-primary mt-2">02:30 PM - 03:30 PM (EST)</p>
                    </div>
                </div>

                <hr class="border-border/50" />

                <!-- Summary Section 3: Doctor -->
                <div class="flex items-start gap-6">
                    <div class="relative shrink-0">
                        <div class="size-24 bg-muted rounded-[2rem] overflow-hidden border-4 border-border shadow-xl">
                            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuApRbNdsRqxjXxX7W-pu-yGNEC_r-7ZJwrF56sAMzMocDnKY4XWg4wPAjwT6_XnIv3NL_TAWWRRxMZ-1jEAD4z0Vtp-aKrom6vAfqGiprHvB28eAnaq1u1mzTWuaTmijZ3nYgbd4w8xZ6DZbZJWx7TXBrxe5KMmUk3qwUwcLl2uH3-_vqlS0qWvAHT8APhAfbuoVc0kQWndH0gvQVwLqaRq2DjTkgz0u5O6c0xUjNUfsJaZYfJqsPwfzPpUPWrLjpv9BGHim0gdaQM"
                                class="size-full object-cover" />
                        </div>
                        <div
                            class="absolute -bottom-1 -right-1 bg-green-500 border-4 border-card size-8 rounded-full shadow-lg">
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-xs font-black text-muted-foreground uppercase tracking-[0.2em] mb-2">
                            <?= $provider_label ?></p>
                        <p class="text-3xl font-black text-foreground tracking-tight">Dr. Sarah Mitchell, MD</p>
                        <p class="text-base text-muted-foreground mt-2 font-medium">Clinical Psychologist • Cognitive
                            Behavioral
                            Therapy Specialist</p>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="bg-muted/10 p-10 border-t border-border">
                <label class="block text-sm font-black text-foreground mb-4 uppercase tracking-wider" for="notes">
                    <?= $notes_label ?>
                </label>
                <textarea
                    class="w-full rounded-[1.5rem] border-border bg-card text-base font-medium focus:ring-4 focus:ring-primary/10 focus:border-primary placeholder:text-muted-foreground/40 transition-all p-6 min-h-[160px]"
                    id="notes" placeholder="<?= $notes_placeholder ?>"></textarea>
            </div>
        </div>

        <!-- Disclaimer Alert -->
        <div
            class="flex gap-6 items-start p-8 rounded-[2rem] bg-amber-50 dark:bg-amber-900/10 border border-amber-200/50 dark:border-amber-800/30">
            <span class="material-symbols-outlined text-amber-600 dark:text-amber-500 text-3xl shrink-0">info</span>
            <div class="flex flex-col gap-2">
                <p class="text-sm font-black text-amber-900 dark:text-amber-200 uppercase tracking-[0.2em] italic">
                    <?= $alert_title ?>
                </p>
                <p class="text-base text-amber-800/80 dark:text-amber-300/80 leading-relaxed font-medium">
                    <?= $alert_text ?>
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col-reverse sm:flex-row items-center gap-6 pt-6">
            <a href="step-2-schedule.php"
                class="w-full sm:w-auto px-12 py-5 text-sm font-black text-muted-foreground hover:bg-muted rounded-[1.5rem] transition-all flex items-center justify-center gap-3 border border-border shadow-sm">
                <span class="material-symbols-outlined text-xl">arrow_back</span>
                <?= $back_label ?>
            </a>
            <button
                onclick="document.getElementById('success-modal').classList.remove('hidden'); document.getElementById('success-modal').classList.add('flex');"
                class="w-full flex-1 px-12 py-5 bg-primary text-white text-xl font-black rounded-[1.5rem] shadow-2xl shadow-primary/30 hover:opacity-95 transform transition-all active:scale-[0.98] flex items-center justify-center gap-3 group">
                <?= $confirm_label ?>
                <span
                    class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">check_circle</span>
            </button>
        </div>
    </div>
</div>

<!-- Success Modal -->
<?= featured('appointments', 'components/success-modal', [
    'role' => $role,
    'date' => 'Oct 25th',
    'doctor' => ($role == 'admin' ? 'Dr. Mitchell' : 'Dr. Sarah Mitchell, MD'),
]) ?>