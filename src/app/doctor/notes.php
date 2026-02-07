<?php
/**
 * Doctor Clinical Notes Page
 */
$pageTitle = "Clinical Notes - MindTrack Doctor";

// The layout already takes care of the main headbar, but we don't need the standard headbar contents here
// because this page has a very custom, immersive editor layout.
// We'll pass empty header data or custom data if needed.
$headerData = null;

include_once __DIR__ . '/layout.php';
?>

<div class="flex h-full overflow-hidden -m-8"> <!-- Negative margin to bleed into the parent padding if necessary -->
    <!-- Inner Sidebar: Session List -->
    <aside class="w-80 border-r border-border bg-card flex flex-col shrink-0">
        <div class="p-6 border-b border-border">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-black text-foreground tracking-tight">Recent Sessions</h3>
                <button
                    class="text-[10px] bg-primary/10 text-primary hover:bg-primary hover:text-white px-3 py-1.5 rounded-lg font-black uppercase tracking-widest transition-all shadow-sm shadow-primary/10 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-sm font-variation-settings-['wght'_600]">add</span>
                    New
                </button>
            </div>
            <div class="relative group">
                <span
                    class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-muted-foreground group-focus-within:text-primary transition-colors text-lg font-variation-settings-['wght'_400]">search</span>
                <input
                    class="w-full pl-11 pr-4 py-2.5 bg-muted/30 border border-border rounded-xl text-sm focus:border-primary focus:ring-1 focus:ring-primary/20 transition-all placeholder:text-muted-foreground/60"
                    placeholder="Filter patients..." type="text" />
            </div>
        </div>

        <div class="flex-1 overflow-y-auto scrollbar-hide">
            <!-- Active Session Card -->
            <div class="bg-primary/5 border-l-4 border-primary p-5 cursor-pointer relative group transition-all">
                <div class="flex justify-between items-start mb-1.5">
                    <span class="font-black text-foreground text-sm tracking-tight">Eleanor Rigby</span>
                    <span
                        class="text-[9px] font-black uppercase tracking-widest text-orange-600 bg-orange-100 dark:bg-orange-950/50 px-2 py-0.5 rounded shadow-sm">Pending</span>
                </div>
                <p class="text-[11px] font-bold text-muted-foreground/80 mb-3 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[14px]">event</span>
                    Oct 26, 2023 • 10:30 AM
                </p>
                <p
                    class="text-xs text-muted-foreground italic line-clamp-2 leading-relaxed opacity-80 group-hover:opacity-100 transition-opacity">
                    "Patient reports increased anxiety following..."
                </p>
                <div class="absolute inset-y-0 right-0 w-1 bg-primary/10"></div>
            </div>

            <!-- Previous Session Cards -->
            <?php
            $history = [
                ['name' => 'John Doe', 'status' => 'Signed', 'date' => 'Oct 24, 2023 • 02:15 PM', 'preview' => 'Follow-up: Neuropathy check', 'color' => 'emerald'],
                ['name' => 'Sarah Jenkins', 'status' => 'Signed', 'date' => 'Oct 24, 2023 • 11:00 AM', 'preview' => 'Initial Consultation: Sleep Apnea', 'color' => 'emerald'],
                ['name' => 'Robert Vance', 'status' => 'Signed', 'date' => 'Oct 23, 2023 • 09:45 AM', 'preview' => 'Bi-annual review: Migraine mgmt', 'color' => 'emerald'],
                ['name' => 'Alice Cooper', 'status' => 'Signed', 'date' => 'Oct 22, 2023 • 01:30 PM', 'preview' => 'Chronic pain management review', 'color' => 'emerald']
            ];
            foreach ($history as $h): ?>
                <div class="hover:bg-muted/30 p-5 cursor-pointer transition-all border-b border-border/60 group">
                    <div class="flex justify-between items-start mb-1.5">
                        <span
                            class="font-bold text-foreground/80 group-hover:text-foreground text-sm transition-colors tracking-tight">
                            <?= $h['name'] ?>
                        </span>
                        <span
                            class="text-[9px] font-black uppercase tracking-widest text-<?= $h['color'] ?>-600 bg-<?= $h['color'] ?>-100 dark:bg-<?= $h['color'] ?>-950/50 px-2 py-0.5 rounded shadow-sm opacity-80">
                            <?= $h['status'] ?>
                        </span>
                    </div>
                    <p class="text-[11px] font-bold text-muted-foreground/60 mb-2">
                        <?= $h['date'] ?>
                    </p>
                    <p
                        class="text-xs text-muted-foreground line-clamp-1 opacity-70 group-hover:opacity-90 transition-opacity">
                        <?= $h['preview'] ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
    </aside>

    <!-- Main Note Editor -->
    <section class="flex-1 flex flex-col bg-background-light dark:bg-background-dark overflow-hidden">
        <!-- Patient Header Sticky Bar -->
        <div
            class="px-8 py-6 border-b border-border flex flex-wrap gap-y-4 items-center justify-between sticky top-0 bg-background/95 backdrop-blur-md z-40">
            <div class="flex items-center gap-6">
                <div>
                    <h1 class="text-2xl font-black text-foreground tracking-tight">Eleanor Rigby</h1>
                    <div
                        class="flex items-center gap-5 mt-1.5 text-[11px] font-bold text-muted-foreground uppercase opacity-80">
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-base text-primary/70">cake</span>
                            DOB: 05/12/1982 (41y)
                        </span>
                        <span class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-base text-primary/70">badge</span>
                            MRN-88210
                        </span>
                    </div>
                </div>
                <div class="h-10 w-px bg-border hidden md:block"></div>
                <div class="hidden md:block">
                    <p class="text-[10px] font-black text-muted-foreground uppercase tracking-widest">Session Type</p>
                    <p class="text-sm font-bold text-primary mt-0.5 tracking-wide uppercase">Initial Consultation</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center -space-x-1">
                    <button class="p-2.5 text-muted-foreground hover:bg-muted rounded-full transition-all"
                        title="Print Note">
                        <span class="material-symbols-outlined font-variation-settings-['wght'_400]">print</span>
                    </button>
                    <button class="p-2.5 text-muted-foreground hover:bg-muted rounded-full transition-all"
                        title="Share Note">
                        <span class="material-symbols-outlined font-variation-settings-['wght'_400]">ios_share</span>
                    </button>
                    <button class="p-2.5 text-muted-foreground hover:bg-muted rounded-full transition-all">
                        <span class="material-symbols-outlined font-variation-settings-['wght'_400]">more_horiz</span>
                    </button>
                </div>
                <div
                    class="size-10 rounded-xl bg-muted border border-border flex items-center justify-center text-muted-foreground shadow-sm">
                    <span class="material-symbols-outlined font-variation-settings-['FILL'_1]">person</span>
                </div>
            </div>
        </div>

        <!-- Editor Content (Scrollable) -->
        <div class="flex-1 overflow-y-auto p-8 lg:p-12">
            <div class="space-y-12">
                <!-- Subjective -->
                <div class="space-y-5 group">
                    <div
                        class="flex items-center gap-4 text-primary border-b border-primary/10 pb-3 transition-all group-focus-within:border-primary/30">
                        <div class="size-8 bg-primary/10 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl">forum</span>
                        </div>
                        <h4 class="font-black text-sm uppercase tracking-widest">Subjective</h4>
                    </div>
                    <div class="space-y-3">
                        <label
                            class="block text-[10px] font-black text-muted-foreground uppercase tracking-widest opacity-60">Patient's
                            Report & Symptoms</label>
                        <textarea
                            class="w-full min-h-[160px] p-6 bg-card border border-border rounded-2xl focus:ring-2 focus:ring-primary/5 focus:border-primary text-foreground/90 placeholder:text-muted-foreground/40 leading-relaxed shadow-sm transition-all"
                            placeholder="Enter patient reports, family history, and chief concerns...">Patient reports persistent tension headaches localized behind the right eye for the last 3 weeks. Severity fluctuates between 4/10 and 8/10. Notes increased frequency during stressful work periods. No relief from over-the-counter NSAIDs. Sleep quality has declined due to inability to settle.</textarea>
                    </div>
                </div>

                <!-- Objective -->
                <div class="space-y-6 group">
                    <div
                        class="flex items-center gap-4 text-primary border-b border-primary/10 pb-3 transition-all group-focus-within:border-primary/30">
                        <div class="size-8 bg-primary/10 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl">visibility</span>
                        </div>
                        <h4 class="font-black text-sm uppercase tracking-widest">Objective</h4>
                    </div>
                    <div class="space-y-6">
                        <label
                            class="block text-[10px] font-black text-muted-foreground uppercase tracking-widest opacity-60">Observations
                            & Vitals</label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                            <div
                                class="bg-card p-5 rounded-2xl border border-border shadow-sm hover:border-primary/20 transition-colors">
                                <p
                                    class="text-[10px] text-muted-foreground uppercase font-black tracking-widest opacity-70 mb-2">
                                    Blood Pressure</p>
                                <p class="text-2xl font-black text-foreground tracking-tighter">120/80 <span
                                        class="text-xs font-bold text-muted-foreground opacity-60 ml-1">mmHg</span></p>
                            </div>
                            <div
                                class="bg-card p-5 rounded-2xl border border-border shadow-sm hover:border-primary/20 transition-colors">
                                <p
                                    class="text-[10px] text-muted-foreground uppercase font-black tracking-widest opacity-70 mb-2">
                                    Heart Rate</p>
                                <p class="text-2xl font-black text-foreground tracking-tighter">72 <span
                                        class="text-xs font-bold text-muted-foreground opacity-60 ml-1">bpm</span></p>
                            </div>
                            <div
                                class="bg-card p-5 rounded-2xl border border-border shadow-sm hover:border-primary/20 transition-colors">
                                <p
                                    class="text-[10px] text-muted-foreground uppercase font-black tracking-widest opacity-70 mb-2">
                                    Weight</p>
                                <p class="text-2xl font-black text-foreground tracking-tighter">68.5 <span
                                        class="text-xs font-bold text-muted-foreground opacity-60 ml-1">kg</span></p>
                            </div>
                        </div>
                        <textarea
                            class="w-full min-h-[140px] p-6 bg-card border border-border rounded-2xl focus:ring-2 focus:ring-primary/5 focus:border-primary text-foreground/90 leading-relaxed shadow-sm transition-all"
                            placeholder="Enter physical examination findings...">Neurological exam: Cranial nerves II-XII intact. Fundoscopic exam normal bilaterally. Neck ROM slightly restricted on lateral rotation to the right. Muscle tone normal.</textarea>
                    </div>
                </div>

                <!-- Assessment -->
                <div class="space-y-5 group">
                    <div
                        class="flex items-center gap-4 text-primary border-b border-primary/10 pb-3 transition-all group-focus-within:border-primary/30">
                        <div class="size-8 bg-primary/10 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl">analytics</span>
                        </div>
                        <h4 class="font-black text-sm uppercase tracking-widest">Assessment</h4>
                    </div>
                    <div class="space-y-3">
                        <label
                            class="block text-[10px] font-black text-muted-foreground uppercase tracking-widest opacity-60">Diagnosis
                            & Clinical Impression</label>
                        <textarea
                            class="w-full min-h-[120px] p-6 bg-card border border-border rounded-2xl focus:ring-2 focus:ring-primary/5 focus:border-primary text-foreground/90 leading-relaxed shadow-sm transition-all"
                            placeholder="Summarize diagnosis...">1. Chronic tension-type headache (G44.22) - Likely stress-related exacerbation.
2. Moderate Sleep disturbance (G47.9)</textarea>
                    </div>
                </div>

                <!-- Plan -->
                <div class="space-y-5 group pb-24"> <!-- Bottom padding for sticky footer -->
                    <div
                        class="flex items-center gap-4 text-primary border-b border-primary/10 pb-3 transition-all group-focus-within:border-primary/30">
                        <div class="size-8 bg-primary/10 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl">assignment</span>
                        </div>
                        <h4 class="font-black text-sm uppercase tracking-widest">Plan</h4>
                    </div>
                    <div class="space-y-3">
                        <label
                            class="block text-[10px] font-black text-muted-foreground uppercase tracking-widest opacity-60">Next
                            Steps & Prescriptions</label>
                        <textarea
                            class="w-full min-h-[140px] p-6 bg-card border border-border rounded-2xl focus:ring-2 focus:ring-primary/5 focus:border-primary text-foreground/90 leading-relaxed shadow-sm transition-all"
                            placeholder="Outline medication, follow-up, and therapy...">- Prescribed Magnesium Glycinate 400mg nightly.
- Referral to Physical Therapy for cervical spine assessment.
- Patient advised to track headache triggers via MindTrack mobile app.
- Follow-up in 4 weeks.</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Footer Action Bar -->
        <footer
            class="shrink-0 bg-background/90 backdrop-blur-xl border-t border-border p-6 shadow-[0_-4px_20px_0_rgba(0,0,0,0.05)]">
            <div class="flex items-center justify-between">
                <div
                    class="flex items-center gap-3 text-muted-foreground text-[10px] font-black uppercase tracking-widest opacity-60 group">
                    <span
                        class="material-symbols-outlined text-sm text-emerald-500 font-variation-settings-['FILL'_1]">check_circle</span>
                    <span>Auto-saved at 10:45 AM</span>
                </div>
                <div class="flex gap-4">
                    <button
                        class="px-7 py-3 rounded-xl border-2 border-border text-foreground/70 font-black text-xs hover:bg-muted hover:text-foreground transition-all uppercase tracking-widest">
                        Save Draft
                    </button>
                    <button
                        class="px-10 py-3 rounded-xl bg-primary text-primary-foreground font-black text-xs shadow-lg shadow-primary/30 hover:shadow-primary/50 hover:-translate-y-0.5 transition-all flex items-center gap-3 uppercase tracking-widest">
                        <span class="material-symbols-outlined text-lg font-variation-settings-['wght'_600]">draw</span>
                        Finalize & Sign Note
                    </button>
                </div>
            </div>
        </footer>
    </section>
</div>

<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>