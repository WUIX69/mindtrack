<?php
/**
 * Patient Wellness Resources Portal
 */

$pageTitle = "Wellness Resources";
$bodyClass = "bg-muted/50 dark:bg-background text-foreground font-display transition-colors duration-200";
// Set current page for sidebar highlighting
$currentPage = 'resources';

include __DIR__ . '/layout.php';
?>

<header class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <h2 class="text-3xl font-bold text-foreground tracking-tight">Wellness Resources</h2>
        <p class="text-muted-foreground mt-1 font-medium">Educational materials and self-help guides for your journey.
        </p>
    </div>
    <div class="relative w-full max-w-md">
        <span
            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground">search</span>
        <input
            class="w-full pl-10 pr-4 py-3 bg-card dark:bg-card border border-border rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm font-medium"
            placeholder="Search resources..." type="text" />
    </div>
</header>

<section class="mb-12">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-black tracking-tight text-foreground">Featured Articles</h3>
        <a class="text-sm font-bold text-primary hover:underline underline-offset-4" href="#">View all</a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div
            class="group bg-card dark:bg-card rounded-2xl border border-border shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
            <div class="h-56 bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                style="background-image: url('https://images.unsplash.com/photo-1499209974431-9dac3adaf471?q=80&w=800&auto=format&fit=crop')">
            </div>
            <div class="p-6">
                <div class="flex items-center gap-2 mb-3">
                    <span
                        class="px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-wider">Mental
                        Well-being</span>
                    <span class="text-[11px] text-muted-foreground font-bold">8 min read</span>
                </div>
                <h4 class="text-xl font-black mb-2 group-hover:text-primary transition-colors leading-tight">
                    Understanding
                    Anxiety: Root Causes and Coping Mechanisms</h4>
                <p class="text-sm text-muted-foreground font-medium line-clamp-2 leading-relaxed">Learn how anxiety
                    affects the brain and discover evidence-based strategies to manage daily stress and panic symptoms.
                </p>
                <button class="mt-4 text-sm font-black text-primary flex items-center gap-1 group/btn">
                    Read More <span
                        class="material-symbols-outlined text-sm group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
                </button>
            </div>
        </div>
        <div
            class="group bg-card dark:bg-card rounded-2xl border border-border shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
            <div class="h-56 bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                style="background-image: url('https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=800&auto=format&fit=crop')">
            </div>
            <div class="p-6">
                <div class="flex items-center gap-2 mb-3">
                    <span
                        class="px-3 py-1 rounded-full bg-purple-500/10 text-purple-600 dark:text-purple-400 text-[10px] font-black uppercase tracking-wider">Mindfulness</span>
                    <span class="text-[11px] text-muted-foreground font-bold">6 min read</span>
                </div>
                <h4 class="text-xl font-black mb-2 group-hover:text-primary transition-colors leading-tight">The Power
                    of
                    Mindfulness in Modern Daily Life</h4>
                <p class="text-sm text-muted-foreground font-medium line-clamp-2 leading-relaxed">Practical ways to
                    integrate mindfulness practices into your routine to improve focus and emotional regulation.</p>
                <button class="mt-4 text-sm font-black text-primary flex items-center gap-1 group/btn">
                    Read More <span
                        class="material-symbols-outlined text-sm group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
                </button>
            </div>
        </div>
    </div>
</section>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-10">
    <div class="lg:col-span-2">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-black tracking-tight text-foreground">Video Library</h3>
            <a class="text-sm font-bold text-primary hover:underline underline-offset-4" href="#">Browse Gallery</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="relative group cursor-pointer overflow-hidden rounded-2xl border border-border shadow-sm">
                <div class="aspect-video bg-muted relative">
                    <img alt="Yoga meditation"
                        class="object-cover w-full h-full opacity-80 group-hover:scale-105 transition-transform duration-500"
                        src="https://images.unsplash.com/photo-1510894347713-fc3ed6fdf539?q=80&w=600&auto=format&fit=crop" />
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div
                            class="w-14 h-14 bg-white/90 dark:bg-primary/90 rounded-full flex items-center justify-center text-primary dark:text-white shadow-xl group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all duration-300">
                            <span class="material-symbols-outlined text-4xl">play_arrow</span>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-card dark:bg-card">
                    <p class="text-sm font-black leading-tight">10-Minute Morning Meditation</p>
                    <p class="text-[11px] text-muted-foreground font-bold mt-1">Guided Session • 10:24</p>
                </div>
            </div>
            <div class="relative group cursor-pointer overflow-hidden rounded-2xl border border-border shadow-sm">
                <div class="aspect-video bg-muted relative">
                    <img alt="Therapy explanation"
                        class="object-cover w-full h-full opacity-80 group-hover:scale-105 transition-transform duration-500"
                        src="https://images.unsplash.com/photo-1527137342181-19aab11a8ee1?q=80&w=600&auto=format&fit=crop" />
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div
                            class="w-14 h-14 bg-white/90 dark:bg-primary/90 rounded-full flex items-center justify-center text-primary dark:text-white shadow-xl group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all duration-300">
                            <span class="material-symbols-outlined text-4xl">play_arrow</span>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-card dark:bg-card">
                    <p class="text-sm font-black leading-tight">What is Cognitive Behavioral Therapy?</p>
                    <p class="text-[11px] text-muted-foreground font-bold mt-1">Expert Insights • 05:45</p>
                </div>
            </div>
            <div class="relative group cursor-pointer overflow-hidden rounded-2xl border border-border shadow-sm">
                <div class="aspect-video bg-muted relative">
                    <img alt="Sleep hygiene"
                        class="object-cover w-full h-full opacity-80 group-hover:scale-105 transition-transform duration-500"
                        src="https://images.unsplash.com/photo-1511295742364-903144575696?q=80&w=600&auto=format&fit=crop" />
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div
                            class="w-14 h-14 bg-white/90 dark:bg-primary/90 rounded-full flex items-center justify-center text-primary dark:text-white shadow-xl group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all duration-300">
                            <span class="material-symbols-outlined text-4xl">play_arrow</span>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-card dark:bg-card">
                    <p class="text-sm font-black leading-tight">Sleep Better: Evening Routines</p>
                    <p class="text-[11px] text-muted-foreground font-bold mt-1">Guided Session • 08:12</p>
                </div>
            </div>
            <div class="relative group cursor-pointer overflow-hidden rounded-2xl border border-border shadow-sm">
                <div class="aspect-video bg-muted relative">
                    <img alt="Deep breathing"
                        class="object-cover w-full h-full opacity-80 group-hover:scale-105 transition-transform duration-500"
                        src="https://images.unsplash.com/photo-1506126613408-eca07ce68773?q=80&w=600&auto=format&fit=crop" />
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div
                            class="w-14 h-14 bg-white/90 dark:bg-primary/90 rounded-full flex items-center justify-center text-primary dark:text-white shadow-xl group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all duration-300">
                            <span class="material-symbols-outlined text-4xl">play_arrow</span>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-card dark:bg-card">
                    <p class="text-sm font-black leading-tight">Deep Breathing for Instant Calm</p>
                    <p class="text-[11px] text-muted-foreground font-bold mt-1">Exercises • 04:20</p>
                </div>
            </div>
        </div>
    </div>
    <div>
        <h3 class="text-xl font-black tracking-tight text-foreground mb-6">Downloadable Guides</h3>
        <div class="space-y-4">
            <div
                class="bg-card dark:bg-card p-4 rounded-xl border border-border flex items-center gap-4 group hover:border-primary/30 transition-all cursor-pointer shadow-sm">
                <div class="w-12 h-12 rounded-lg bg-red-500/10 flex items-center justify-center text-red-500">
                    <span class="material-symbols-outlined">picture_as_pdf</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-black truncate">CBT Thought Record</p>
                    <p class="text-[11px] text-muted-foreground font-bold">PDF • 1.2 MB</p>
                </div>
                <button
                    class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/5 rounded-lg transition-colors">
                    <span class="material-symbols-outlined">download</span>
                </button>
            </div>
            <div
                class="bg-card dark:bg-card p-4 rounded-xl border border-border flex items-center gap-4 group hover:border-primary/30 transition-all cursor-pointer shadow-sm">
                <div class="w-12 h-12 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <span class="material-symbols-outlined">picture_as_pdf</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-black truncate">Sleep Hygiene Checklist</p>
                    <p class="text-[11px] text-muted-foreground font-bold">PDF • 850 KB</p>
                </div>
                <button
                    class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/5 rounded-lg transition-colors">
                    <span class="material-symbols-outlined">download</span>
                </button>
            </div>
            <div
                class="bg-card dark:bg-card p-4 rounded-xl border border-border flex items-center gap-4 group hover:border-primary/30 transition-all cursor-pointer shadow-sm">
                <div class="w-12 h-12 rounded-lg bg-green-500/10 flex items-center justify-center text-green-500">
                    <span class="material-symbols-outlined">picture_as_pdf</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-black truncate">Grounding Techniques</p>
                    <p class="text-[11px] text-muted-foreground font-bold">PDF • 1.5 MB</p>
                </div>
                <button
                    class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/5 rounded-lg transition-colors">
                    <span class="material-symbols-outlined">download</span>
                </button>
            </div>
            <div
                class="bg-card dark:bg-card p-4 rounded-xl border border-border flex items-center gap-4 group hover:border-primary/30 transition-all cursor-pointer shadow-sm">
                <div class="w-12 h-12 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-500">
                    <span class="material-symbols-outlined">picture_as_pdf</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-black truncate">Journaling Prompts</p>
                    <p class="text-[11px] text-muted-foreground font-bold">PDF • 2.1 MB</p>
                </div>
                <button
                    class="p-2 text-muted-foreground hover:text-primary hover:bg-primary/5 rounded-lg transition-colors">
                    <span class="material-symbols-outlined">download</span>
                </button>
            </div>
            <div
                class="mt-4 p-6 rounded-2xl bg-primary text-primary-foreground shadow-lg shadow-primary/20 relative overflow-hidden group">
                <div
                    class="absolute -right-4 -top-4 opacity-20 transition-transform duration-700 group-hover:rotate-12 group-hover:scale-110">
                    <span class="material-symbols-outlined text-8xl">contact_support</span>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-2">Need Help?</p>
                <p class="text-sm font-bold mb-4 leading-relaxed relative z-10">Can't find what you're looking for?
                    Reach out to your
                    counselor for specific materials.</p>
                <button
                    class="w-full py-2.5 bg-white text-primary text-xs font-black rounded-lg shadow-sm hover:bg-white/90 active:scale-95 transition-all relative z-10">Message
                    Care Team</button>
            </div>
        </div>
    </div>
</div>