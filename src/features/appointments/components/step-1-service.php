<?php
/**
 * Appointment Booking - Step 1: Select Service (Feature Component)
 * 
 * @param string $role (patient|admin)
 * @param array $header (title, description)
 * @param array $patient_selector (title, description, placeholder)
 * @param string $cancel_label
 * @param string $continue_label
 */
$role = $role ?? 'patient';

// UI Strings
$header_title = $header['title'] ?? 'Select Service';
$header_desc = $header['description'] ?? 'Please choose the clinical service you require to continue with your booking.';

$patient_title = $patient_selector['title'] ?? 'Select Patient';
$patient_desc = $patient_selector['description'] ?? 'Search or select a patient for this appointment.';
$patient_placeholder = $patient_selector['placeholder'] ?? 'Search for a patient email or name...';

$cancel_label = $cancel_label ?? 'Cancel';
$continue_label = $continue_label ?? 'Continue to Schedule';

// Mock data for patients (only for admin)
$patients = [
    ['id' => 1, 'name' => 'Alice Thompson', 'email' => 'alice.t@example.com'],
    ['id' => 2, 'name' => 'Bob Richards', 'email' => 'bob.r@example.com'],
    ['id' => 3, 'name' => 'Charlie Davis', 'email' => 'charlie.d@example.com'],
    ['id' => 4, 'name' => 'Diana Prince', 'email' => 'diana.p@example.com'],
];
?>

<div class="w-full">
    <!-- Progress Stepper -->
    <?= featured('appointments', 'components/progress-stepper', [
        'currentStep' => 1,
        'title' => $header_title,
        'description' => $header_desc
    ]) ?>

    <!-- Service Selection Grid -->
    <form action="step-2-schedule.php" method="GET" class="space-y-10">

        <?php if ($role === 'admin'): ?>
            <!-- Patient Selection (Admin Only) -->
            <div class="bg-card p-8 rounded-[2rem] border border-border shadow-sm space-y-6">
                <div class="flex items-center gap-4">
                    <div class="size-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl">person_search</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-foreground tracking-tight"><?= $patient_title ?></h3>
                        <p class="text-sm text-muted-foreground font-medium"><?= $patient_desc ?></p>
                    </div>
                </div>

                <div class="relative">
                    <select name="patient_id" required
                        class="w-full bg-muted/30 border-border rounded-2xl py-4 px-6 text-sm font-bold appearance-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                        <option value="" disabled selected><?= $patient_placeholder ?></option>
                        <?php foreach ($patients as $p): ?>
                            <option value="<?= $p['id'] ?>">
                                <?= $p['name'] ?> (
                                <?= $p['email'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-muted-foreground">
                        <span class="material-symbols-outlined">expand_more</span>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Psychotherapy Card -->
            <label class="relative group cursor-pointer h-full">
                <input type="radio" name="service" value="psychotherapy" class="peer absolute opacity-0" checked />
                <div
                    class="h-full flex flex-col p-8 bg-card rounded-[2rem] border-2 border-transparent shadow-sm peer-checked:border-primary peer-checked:bg-primary/5 transition-all hover:shadow-md ring-primary/20 peer-checked:ring-4">
                    <div
                        class="w-16 h-16 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-4xl">diversity_1</span>
                    </div>
                    <h3 class="text-foreground text-2xl font-black mb-3 tracking-tight">Psychotherapy</h3>
                    <p class="text-muted-foreground text-sm font-medium leading-relaxed mb-8">
                        Individual therapeutic sessions focused on long-term emotional well-being and personal growth.
                    </p>
                    <div class="mt-auto flex items-center justify-between">
                        <div class="flex items-center gap-2 text-muted-foreground text-sm font-bold">
                            <span class="material-symbols-outlined text-xl">schedule</span>
                            60 mins
                        </div>
                        <div
                            class="w-8 h-8 rounded-full border-2 border-border peer-checked:bg-primary flex items-center justify-center transition-all shadow-sm">
                            <span
                                class="material-symbols-outlined text-white text-xl hidden peer-checked:block">check</span>
                        </div>
                    </div>
                </div>
            </label>

            <!-- CBT Card -->
            <label class="relative group cursor-pointer h-full">
                <input type="radio" name="service" value="cbt" class="peer absolute opacity-0" />
                <div
                    class="h-full flex flex-col p-8 bg-card rounded-[2rem] border-2 border-transparent shadow-sm peer-checked:border-primary peer-checked:bg-primary/5 transition-all hover:shadow-md ring-primary/20 peer-checked:ring-4">
                    <div
                        class="w-16 h-16 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-2xl flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-4xl">auto_graph</span>
                    </div>
                    <h3 class="text-foreground text-2xl font-black mb-3 tracking-tight">CBT</h3>
                    <p class="text-muted-foreground text-sm font-medium leading-relaxed mb-8">
                        Structured, evidence-based sessions targeting specific negative thought patterns and behaviors.
                    </p>
                    <div class="mt-auto flex items-center justify-between">
                        <div class="flex items-center gap-2 text-muted-foreground text-sm font-bold">
                            <span class="material-symbols-outlined text-xl">schedule</span>
                            45 mins
                        </div>
                        <div
                            class="w-8 h-8 rounded-full border-2 border-border peer-checked:bg-primary flex items-center justify-center transition-all shadow-sm">
                            <span
                                class="material-symbols-outlined text-white text-xl hidden peer-checked:block">check</span>
                        </div>
                    </div>
                </div>
            </label>

            <!-- Psychological Testing Card -->
            <label class="relative group cursor-pointer h-full">
                <input type="radio" name="service" value="testing" class="peer absolute opacity-0" />
                <div
                    class="h-full flex flex-col p-8 bg-card rounded-[2rem] border-2 border-transparent shadow-sm peer-checked:border-primary peer-checked:bg-primary/5 transition-all hover:shadow-md ring-primary/20 peer-checked:ring-4">
                    <div
                        class="w-16 h-16 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-4xl">fact_check</span>
                    </div>
                    <h3 class="text-foreground text-2xl font-black mb-3 tracking-tight">Diagnostic Testing</h3>
                    <p class="text-muted-foreground text-sm font-medium leading-relaxed mb-8">
                        Comprehensive clinical assessments, neuro-psych evaluations, and formal diagnostic screenings.
                    </p>
                    <div class="mt-auto flex items-center justify-between">
                        <div class="flex items-center gap-2 text-muted-foreground text-sm font-bold">
                            <span class="material-symbols-outlined text-xl">schedule</span>
                            120 mins
                        </div>
                        <div
                            class="w-8 h-8 rounded-full border-2 border-border peer-checked:bg-primary flex items-center justify-center transition-all shadow-sm">
                            <span
                                class="material-symbols-outlined text-white text-xl hidden peer-checked:block">check</span>
                        </div>
                    </div>
                </div>
            </label>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-8 border-t border-border">
            <a href="index.php"
                class="inline-flex items-center justify-center rounded-2xl h-14 px-10 bg-muted text-foreground font-black hover:bg-muted/80 transition-colors shadow-sm">
                <?= $cancel_label ?>
            </a>
            <button type="submit"
                class="inline-flex items-center justify-center rounded-2xl h-14 px-12 bg-primary text-white font-black shadow-xl shadow-primary/20 hover:opacity-95 transform transition-all active:scale-[0.98] group">
                <?= $continue_label ?>
                <span
                    class="material-symbols-outlined ml-2 group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
        </div>
    </form>
</div>