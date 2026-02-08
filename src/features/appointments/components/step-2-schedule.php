<?php
/**
 * Appointment Booking - Step 2: Schedule & Provider (Feature Component)
 * 
 * @param string $role (patient|admin)
 * @param array $header (title, description)
 * @param array $calendar (title)
 * @param array $slots (title, prefix)
 * @param array $provider_selector (title, default, note)
 * @param string $back_label
 * @param string $continue_label
 */
$role = $role ?? 'patient';

// UI Strings
$header_title = $header['title'] ?? 'Schedule & Provider';
$header_desc = $header['description'] ?? 'Select a date and time that works for you, then choose your preferred specialist.';

$date_title = $calendar['title'] ?? 'Select Date';
$slots_title = $slots['title'] ?? 'Available Slots';
$slots_prefix = $slots['prefix'] ?? 'Times for';

$provider_title = $provider_selector['title'] ?? 'Preferred Specialist';
$provider_default = $provider_selector['default'] ?? 'Any available provider';
$provider_note = $provider_selector['note'] ?? 'Selecting a specific specialist may limit the available time slots above.';

$back_label = $back_label ?? 'Back to Service';
$continue_label = $continue_label ?? 'Review Appointment Details';

// Mock data for providers
$providers = [
    ['id' => 1, 'name' => 'Dr. Sarah Mitchell', 'role' => 'Clinical Psychologist'],
    ['id' => 2, 'name' => 'Dr. James Wilson', 'role' => 'Psychiatrist'],
    ['id' => 3, 'name' => 'Elena Rodriguez', 'role' => 'Mental Health Counselor'],
    ['id' => 4, 'name' => 'Dr. Kevin Park', 'role' => 'Child & Adolescent Specialist']
];

// Mock data for time slots
$timeSlots = ['9:00 AM', '10:30 AM', '11:00 AM', '2:00 PM', '3:30 PM', '4:45 PM'];
?>

<div class="w-full">
    <!-- Progress Stepper -->
    <?= featured('appointments', 'components/progress-stepper', [
        'currentStep' => 2,
        'title' => $header_title,
        'description' => $header_desc
    ]) ?>

    <form action="step-3-review.php" method="GET" class="space-y-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Calendar Widget -->
            <div class="lg:col-span-7 bg-card p-8 rounded-[2rem] border border-border shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-black text-foreground tracking-tight"><?= $date_title ?></h3>
                    <div class="flex items-center gap-3">
                        <button type="button"
                            class="size-10 flex items-center justify-center hover:bg-muted rounded-xl transition-all border border-border">
                            <span class="material-symbols-outlined text-2xl">chevron_left</span>
                        </button>
                        <span class="font-black min-w-[140px] text-center text-sm tracking-tight">October 2023</span>
                        <button type="button"
                            class="size-10 flex items-center justify-center hover:bg-muted rounded-xl transition-all border border-border">
                            <span class="material-symbols-outlined text-2xl">chevron_right</span>
                        </button>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div
                    class="grid grid-cols-7 text-center text-[11px] font-black text-muted-foreground uppercase tracking-[0.2em] mb-6">
                    <div class="py-2">Sun</div>
                    <div class="py-2">Mon</div>
                    <div class="py-2">Tue</div>
                    <div class="py-2">Wed</div>
                    <div class="py-2">Thu</div>
                    <div class="py-2">Fri</div>
                    <div class="py-2">Sat</div>
                </div>

                <div class="grid grid-cols-7 gap-3">
                    <!-- Week 1 placeholders -->
                    <div class="aspect-square"></div>
                    <div class="aspect-square"></div>
                    <div class="aspect-square"></div>
                    <button type="button"
                        class="aspect-square flex flex-col items-center justify-center rounded-2xl hover:bg-primary/10 hover:text-primary transition-all text-sm font-black border border-transparent">1</button>
                    <button type="button"
                        class="aspect-square flex flex-col items-center justify-center rounded-2xl hover:bg-primary/10 hover:text-primary transition-all text-sm font-black border border-transparent">2</button>
                    <button type="button"
                        class="aspect-square flex flex-col items-center justify-center rounded-2xl hover:bg-primary/10 hover:text-primary transition-all text-sm font-black border border-transparent">3</button>
                    <button type="button"
                        class="aspect-square flex flex-col items-center justify-center rounded-2xl hover:bg-primary/10 hover:text-primary transition-all text-sm font-black border border-transparent">4</button>

                    <!-- Week 2 -->
                    <button type="button"
                        class="aspect-square flex flex-col items-center justify-center rounded-2xl bg-primary text-white shadow-xl shadow-primary/30 text-sm font-black relative group">
                        5
                        <span
                            class="absolute -bottom-2 left-1/2 -translate-x-1/2 text-[9px] opacity-90 font-black uppercase tracking-tighter">Today</span>
                    </button>
                    <?php for ($i = 6; $i <= 11; $i++): ?>
                        <button type="button"
                            class="aspect-square flex flex-col items-center justify-center rounded-2xl hover:bg-primary/10 hover:text-primary transition-all text-sm font-black border border-transparent">
                            <?= $i ?>
                        </button>
                    <?php endfor; ?>

                    <!-- Remaining placeholders for demonstration -->
                    <?php for ($i = 12; $i <= 31; $i++): ?>
                        <button type="button"
                            class="aspect-square flex flex-col items-center justify-center rounded-2xl hover:bg-primary/10 hover:text-primary transition-all text-sm font-black border border-transparent">
                            <?= $i ?>
                        </button>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Right Column: Time Slots & Provider -->
            <div class="lg:col-span-5 flex flex-col gap-8">
                <!-- Time Selection -->
                <div class="bg-card p-8 rounded-[2rem] border border-border shadow-sm">
                    <h3 class="text-xl font-black mb-6 flex items-center gap-3 text-foreground tracking-tight">
                        <span class="material-symbols-outlined text-primary text-3xl">schedule</span>
                        <?= $slots_title ?>
                    </h3>
                    <p class="text-sm font-medium text-muted-foreground mb-6 italic"><?= $slots_prefix ?> <span
                            class="text-foreground font-black not-italic">October 5, 2023</span></p>

                    <div class="grid grid-cols-2 gap-4">
                        <?php foreach ($timeSlots as $index => $time): ?>
                            <label class="cursor-pointer">
                                <input type="radio" name="time_slot" value="<?= $time ?>" class="peer absolute opacity-0"
                                    <?= $index === 0 ? 'checked' : '' ?> />
                                <div
                                    class="py-4 px-4 text-sm font-black rounded-2xl border-2 border-transparent bg-muted/30 text-muted-foreground transition-all text-center peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary hover:border-primary/30 hover:scale-[1.02] active:scale-[0.98]">
                                    <?= $time ?>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Provider Selection -->
                <div class="bg-card p-8 rounded-[2rem] border border-border shadow-sm">
                    <h3 class="text-xl font-black mb-6 flex items-center gap-3 text-foreground tracking-tight">
                        <span class="material-symbols-outlined text-primary text-3xl">person</span>
                        <?= $provider_title ?>
                    </h3>
                    <div class="relative">
                        <select name="provider_id"
                            class="w-full bg-muted/30 border-border rounded-2xl py-5 px-6 text-sm font-black appearance-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                            <option value=""><?= $provider_default ?></option>
                            <?php foreach ($providers as $p): ?>
                                <option value="<?= $p['id'] ?>">
                                    <?= $p['name'] ?> -
                                    <?= $p['role'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div
                            class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-muted-foreground">
                            <span class="material-symbols-outlined text-2xl">expand_more</span>
                        </div>
                    </div>
                    <p
                        class="mt-4 text-[11px] font-bold text-muted-foreground leading-relaxed uppercase tracking-wider opacity-70">
                        <?= $provider_note ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Sticky Bottom Navigation -->
        <div class="pt-8 border-t border-border flex flex-col sm:flex-row justify-between items-center gap-4">
            <a href="step-1-service.php"
                class="inline-flex items-center gap-3 px-10 py-4 rounded-2xl font-black text-sm bg-muted text-foreground hover:bg-muted/80 transition-colors w-full sm:w-auto justify-center shadow-sm">
                <span class="material-symbols-outlined text-xl">arrow_back</span>
                <?= $back_label ?>
            </a>
            <button type="submit"
                class="inline-flex items-center justify-center gap-3 px-12 py-4 rounded-2xl font-black text-sm bg-primary text-white shadow-xl shadow-primary/25 hover:opacity-95 transform transition-all active:scale-[0.98] w-full sm:w-auto group">
                <?= $continue_label ?>
                <span
                    class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
        </div>
    </form>
</div>