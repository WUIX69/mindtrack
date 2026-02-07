<?php
/**
 * Doctor Settings Page
 */
$pageTitle = "Account Settings - MindTrack Doctor";

$headerData = [
    'title' => 'Account Settings',
    'description' => 'Manage your clinical profile, scheduling rules, and account security preferences.',
    'actionLabel' => 'Save Changes',
    'actionIcon' => 'save'
];

include_once __DIR__ . '/layout.php';
?>

<div class="flex flex-col gap-8 pb-12">
    <!-- 1. Professional Profile Section -->
    <section class="bg-card rounded-2xl border border-border overflow-hidden shadow-sm transition-all hover:shadow-md">
        <div class="px-6 py-4 border-b border-border bg-muted/30">
            <h3 class="font-black text-sm uppercase tracking-widest flex items-center gap-2 text-foreground">
                <span
                    class="material-symbols-outlined text-primary text-xl font-variation-settings-['FILL'_1]">account_circle</span>
                Professional Profile
            </h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="flex flex-col gap-2">
                <label class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">Full
                    Name</label>
                <input
                    class="w-full rounded-xl border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary px-4 py-2.5 text-sm font-bold text-foreground transition-all"
                    type="text" value="Dr. Aris" />
            </div>
            <div class="flex flex-col gap-2">
                <label
                    class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">Specialty</label>
                <select
                    class="w-full rounded-xl border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary px-4 py-2.5 text-sm font-bold text-foreground transition-all">
                    <option selected>Specialist</option>
                    <option>Senior Psychiatrist</option>
                    <option>Clinical Psychologist</option>
                    <option>Neurologist</option>
                    <option>Therapist</option>
                </select>
            </div>
            <div class="flex flex-col gap-2 md:col-span-2">
                <label
                    class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">Biography</label>
                <textarea
                    class="w-full rounded-xl border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary px-4 py-3 text-sm font-medium text-foreground/80 leading-relaxed transition-all"
                    placeholder="Enter your professional summary for patients to see..."
                    rows="4">Dr. Aris is a leading clinical specialist with a focus on holistic mental wellness and advanced neuropsychiatric care. With years of experience, he provides personalized treatment plans for his patients.</textarea>
            </div>
        </div>
    </section>

    <!-- 2. Availability Management -->
    <section class="bg-card rounded-2xl border border-border overflow-hidden shadow-sm transition-all hover:shadow-md">
        <div class="px-6 py-4 border-b border-border bg-muted/30 flex justify-between items-center">
            <h3 class="font-black text-sm uppercase tracking-widest flex items-center gap-2 text-foreground">
                <span
                    class="material-symbols-outlined text-primary text-xl font-variation-settings-['FILL'_1]">schedule</span>
                Availability Management
            </h3>
            <span
                class="text-[9px] bg-primary/10 text-primary px-2.5 py-1 rounded-full font-black uppercase tracking-widest border border-primary/20 shadow-sm">Timezone:
                UTC -5:00</span>
        </div>
        <div class="p-6">
            <div class="flex flex-col gap-1">
                <?php
                $days = [
                    ['day' => 'Monday', 'start' => '09:00', 'end' => '17:00', 'active' => true, 'note' => 'Face-to-face consultations'],
                    ['day' => 'Tuesday', 'start' => '09:00', 'end' => '17:00', 'active' => true, 'note' => ''],
                    ['day' => 'Wednesday', 'start' => '00:00', 'end' => '00:00', 'active' => false, 'note' => 'Closed / Unavailable'],
                    ['day' => 'Thursday', 'start' => '10:00', 'end' => '18:00', 'active' => true, 'note' => ''],
                    ['day' => 'Friday', 'start' => '09:00', 'end' => '15:00', 'active' => true, 'note' => '']
                ];

                foreach ($days as $d): ?>
                    <div
                        class="grid grid-cols-12 items-center gap-6 py-4 border-b border-border/50 last:border-0 <?= !$d['active'] ? 'opacity-40 grayscale-[0.5]' : '' ?>">
                        <div class="col-span-2 text-xs font-black text-foreground uppercase tracking-widest">
                            <?= $d['day'] ?>
                        </div>
                        <div class="col-span-8 flex items-center gap-5">
                            <input
                                class="rounded-lg border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary text-sm font-bold px-3 py-1.5 transition-all <?= !$d['active'] ? 'cursor-not-allowed' : '' ?>"
                                type="time" value="<?= $d['start'] ?>" <?= !$d['active'] ? 'disabled' : '' ?> />
                            <span
                                class="text-[10px] font-black text-muted-foreground uppercase opacity-40 tracking-tighter">to</span>
                            <input
                                class="rounded-lg border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary text-sm font-bold px-3 py-1.5 transition-all <?= !$d['active'] ? 'cursor-not-allowed' : '' ?>"
                                type="time" value="<?= $d['end'] ?>" <?= !$d['active'] ? 'disabled' : '' ?> />
                            <?php if ($d['note']): ?>
                                <span
                                    class="ml-4 text-[10px] font-bold text-muted-foreground italic flex items-center gap-1.5 uppercase tracking-tight">
                                    <span class="size-1 rounded-full bg-primary/40"></span>
                                    <?= $d['note'] ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="col-span-2 flex justify-end items-center gap-4">
                            <span class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-50">
                                <?= $d['active'] ? 'Active' : 'Off' ?>
                            </span>
                            <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                <input type="checkbox" class="sr-only peer" <?= $d['active'] ? 'checked' : '' ?>>
                                <div class="w-9 h-5 bg-border peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/50 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button
                class="mt-6 text-[10px] font-black text-primary flex items-center gap-2 hover:opacity-80 transition-all uppercase tracking-widest group">
                <span
                    class="material-symbols-outlined text-base transition-transform group-hover:rotate-180">history</span>
                Load Default Business Hours
            </button>
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- 3. Security Section -->
        <section
            class="bg-card rounded-2xl border border-border overflow-hidden shadow-sm transition-all hover:shadow-md">
            <div class="px-6 py-4 border-b border-border bg-muted/30">
                <h3 class="font-black text-sm uppercase tracking-widest flex items-center gap-2 text-foreground">
                    <span
                        class="material-symbols-outlined text-primary text-xl font-variation-settings-['FILL'_1]">security</span>
                    Security & Access
                </h3>
            </div>
            <div class="p-6 flex flex-col gap-6">
                <div class="flex flex-col gap-2">
                    <label
                        class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">Current
                        Password</label>
                    <input
                        class="w-full rounded-xl border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary px-4 py-2.5 text-sm font-bold text-foreground transition-all"
                        placeholder="••••••••" type="password" />
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-muted-foreground opacity-70">New
                        Password</label>
                    <input
                        class="w-full rounded-xl border border-border bg-muted/20 focus:ring-primary/20 focus:border-primary px-4 py-2.5 text-sm font-bold text-foreground transition-all"
                        placeholder="Min. 8 characters" type="password" />
                </div>
                <div class="flex flex-col gap-2 border-t border-border pt-6 mt-2">
                    <div class="flex items-center justify-between mb-1">
                        <p class="text-xs font-black text-foreground uppercase tracking-widest">Active Sessions</p>
                        <span
                            class="text-[9px] bg-emerald-500/10 text-emerald-500 px-2 py-0.5 rounded font-black uppercase">2
                            Connected</span>
                    </div>
                    <p class="text-[10px] text-muted-foreground font-bold leading-relaxed">You are currently logged in
                        on this browser and one mobile device.</p>
                    <button
                        class="w-full mt-3 text-[10px] font-black py-2.5 border-2 border-error/20 text-error hover:bg-error hover:text-white rounded-xl transition-all uppercase tracking-widest">
                        Revoke All Sessions
                    </button>
                </div>
            </div>
        </section>

        <!-- 4. Notification Preferences -->
        <section
            class="bg-card rounded-2xl border border-border overflow-hidden shadow-sm transition-all hover:shadow-md">
            <div class="px-6 py-4 border-b border-border bg-muted/30">
                <h3 class="font-black text-sm uppercase tracking-widest flex items-center gap-2 text-foreground">
                    <span
                        class="material-symbols-outlined text-primary text-xl font-variation-settings-['FILL'_1]">notifications</span>
                    Notification Preferences
                </h3>
            </div>
            <div class="p-6">
                <div class="flex flex-col gap-6">
                    <?php
                    $notifications = [
                        ['title' => 'New Appointment Alerts', 'desc' => 'Get instant email and push notifications when a patient books a slot.', 'active' => true],
                        ['title' => 'Clinical Note Reminders', 'desc' => 'Remind me to complete clinical notes 2 hours after a session ends.', 'active' => true],
                        ['title' => 'Patient Messaging', 'desc' => 'Notify me via email when I receive a direct message from a patient.', 'active' => false],
                        ['title' => 'Daily Schedule Digest', 'desc' => 'Receive a summary of today\'s appointments every morning at 7:00 AM.', 'active' => true],
                    ];

                    foreach ($notifications as $n): ?>
                        <div
                            class="flex items-start justify-between gap-6 pb-6 border-b border-border/50 last:border-0 last:pb-0">
                            <div class="flex flex-col gap-1">
                                <p class="text-xs font-black text-foreground uppercase tracking-widest">
                                    <?= $n['title'] ?>
                                </p>
                                <p
                                    class="text-[10px] text-muted-foreground font-bold max-w-[240px] leading-relaxed opacity-80">
                                    <?= $n['desc'] ?>
                                </p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                <input type="checkbox" class="sr-only peer" <?= $n['active'] ? 'checked' : '' ?>>
                                <div class="w-9 h-5 bg-border peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/50 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Mobile Footer Action (Tablet & Below) -->
<div
    class="lg:hidden fixed bottom-0 left-0 right-0 p-4 bg-background/80 backdrop-blur-md border-t border-border z-30 flex gap-3">
    <button
        class="flex-1 py-3 rounded-xl border-2 border-border text-[10px] font-black text-muted-foreground uppercase tracking-widest hover:bg-muted transition-all">Cancel</button>
    <button
        class="flex-1 py-3 rounded-xl bg-primary text-primary-foreground text-[10px] font-black uppercase tracking-widest shadow-lg shadow-primary/20 hover:shadow-primary/40 transition-all">Save
        All</button>
</div>