<?php
/**
 * Resources Page
 */
$pageTitle = "Wellness Resources - MindTrack";
include __DIR__ . '/../layout.php';
?>

<div class="max-w-[1200px] mx-auto w-full px-6 py-12">
    <!-- Header -->
    <div class="mb-12 text-center md:text-left">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight text-foreground">Mental Health Resources</h1>
        <p class="text-lg text-muted-foreground mb-8 max-w-2xl">Discover expert articles, self-help guides, and
            community support tools.</p>
        <div class="relative max-w-2xl">
            <span
                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground/60">search</span>
            <input type="text"
                class="w-full pl-12 pr-4 py-4 rounded-2xl border border-border bg-card text-foreground focus:ring-2 focus:ring-primary outline-none"
                placeholder="Search resources..." />
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-12">
        <!-- Sidebar -->
        <aside class="w-full lg:w-64 flex-shrink-0">
            <div class="sticky top-28 space-y-8">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-muted-foreground/60 mb-4">Categories
                    </h3>
                    <ul class="space-y-2">
                        <li><a class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary text-primary-foreground font-semibold"
                                href="#"><span class="material-symbols-outlined text-xl">article</span>Articles</a></li>
                        <li><a class="flex items-center gap-3 px-4 py-3 rounded-xl text-foreground hover:bg-accent transition-colors"
                                href="#"><span class="material-symbols-outlined text-xl">auto_stories</span>Self-Help
                                Guides</a></li>
                        <li><a class="flex items-center gap-3 px-4 py-3 rounded-xl text-foreground hover:bg-accent transition-colors"
                                href="#"><span class="material-symbols-outlined text-xl">forum</span>Community
                                Support</a></li>
                    </ul>
                </div>
                <div class="flex flex-wrap gap-2">
                    <span
                        class="px-3 py-1 bg-muted text-muted-foreground text-xs rounded-full border border-border/50">Anxiety</span>
                    <span
                        class="px-3 py-1 bg-muted text-muted-foreground text-xs rounded-full border border-border/50">Meditation</span>
                    <span
                        class="px-3 py-1 bg-muted text-muted-foreground text-xs rounded-full border border-border/50">CBT</span>
                </div>
                <div class="p-6 rounded-2xl bg-primary/5 border border-primary/10">
                    <h4 class="font-bold text-sm mb-2 text-foreground">Need immediate help?</h4>
                    <p class="text-xs text-muted-foreground mb-4">Our professionals are available for emergency
                        consultations.</p>
                    <button class="w-full py-2.5 bg-primary text-primary-foreground text-xs font-bold rounded-lg">Get
                        Help Now</button>
                </div>
            </div>
        </aside>

        <!-- Articles Grid -->
        <div class="flex-1">
            <div class="mb-16">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-2xl font-bold text-foreground">Latest Articles</h2>
                    <a class="text-sm font-bold text-primary flex items-center gap-1 hover:underline" href="#">View all
                        <span class="material-symbols-outlined text-lg">chevron_right</span></a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <article
                        class="group bg-card border border-border rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all">
                        <div class="aspect-video overflow-hidden bg-muted flex items-center justify-center">
                            <span class="material-symbols-outlined text-6xl text-muted-foreground/40">spa</span>
                        </div>
                        <div class="p-6">
                            <span
                                class="text-[10px] font-bold uppercase text-primary bg-primary/10 px-2.5 py-1 rounded">Mental
                                Health</span>
                            <h3
                                class="text-xl font-bold mt-3 mb-3 text-foreground group-hover:text-primary transition-colors">
                                Managing Anxiety at Home</h3>
                            <p class="text-muted-foreground text-sm mb-4">Learn simple, evidence-based strategies to
                                calm your mind and body.</p>
                            <button class="flex items-center gap-2 text-sm font-bold text-primary">Read More <span
                                    class="material-symbols-outlined text-lg">arrow_forward</span></button>
                        </div>
                    </article>
                    <article
                        class="group bg-card border border-border rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all">
                        <div class="aspect-video overflow-hidden bg-muted flex items-center justify-center">
                            <span class="material-symbols-outlined text-6xl text-muted-foreground/40">psychology</span>
                        </div>
                        <div class="p-6">
                            <span
                                class="text-[10px] font-bold uppercase text-primary bg-primary/10 px-2.5 py-1 rounded">Therapy</span>
                            <h3
                                class="text-xl font-bold mt-3 mb-3 text-foreground group-hover:text-primary transition-colors">
                                Understanding CBT</h3>
                            <p class="text-muted-foreground text-sm mb-4">A deep dive into Cognitive Behavioral Therapy
                                and its benefits.</p>
                            <button class="flex items-center gap-2 text-sm font-bold text-primary">Read More <span
                                    class="material-symbols-outlined text-lg">arrow_forward</span></button>
                        </div>
                    </article>
                </div>
            </div>

            <!-- Self-Help Guides -->
            <div class="mb-16">
                <h2 class="text-2xl font-bold text-foreground mb-8">Self-Help Guides</h2>
                <div class="space-y-4">
                    <div
                        class="flex items-center gap-6 p-5 rounded-2xl bg-card border border-border hover:border-primary/30 transition-all">
                        <div
                            class="size-16 rounded-xl bg-orange-100 dark:bg-orange-500/10 text-orange-600 dark:text-orange-400 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-3xl">lightbulb</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-foreground">The Sleep Hygiene Workbook</h4>
                            <p class="text-sm text-muted-foreground">Improve your sleep quality for better mental
                                health.</p>
                        </div>
                        <button
                            class="px-6 py-2.5 rounded-lg border border-border text-foreground text-sm font-bold hover:bg-accent hidden md:block">Download
                            PDF</button>
                    </div>
                    <div
                        class="flex items-center gap-6 p-5 rounded-2xl bg-card border border-border hover:border-primary/30 transition-all">
                        <div
                            class="size-16 rounded-xl bg-blue-100 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-3xl">mindfulness</span>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-lg text-foreground">Daily Mindfulness Journaling</h4>
                            <p class="text-sm text-muted-foreground">21 prompts to help you stay grounded and present.
                            </p>
                        </div>
                        <button
                            class="px-6 py-2.5 rounded-lg border border-border text-foreground text-sm font-bold hover:bg-accent hidden md:block">Download
                            PDF</button>
                    </div>
                </div>
            </div>

            <!-- Community Support -->
            <div>
                <h2 class="text-2xl font-bold text-foreground mb-8">Community Support</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-6 rounded-2xl bg-card border border-border hover:shadow-md transition-all">
                        <span class="material-symbols-outlined text-primary mb-4 text-3xl">groups</span>
                        <h4 class="font-bold mb-2 text-foreground">Group Sessions</h4>
                        <p class="text-xs text-muted-foreground mb-4">Join moderated weekly group calls with peers.</p>
                        <a class="text-xs font-bold text-primary hover:underline" href="#">Learn More</a>
                    </div>
                    <div class="p-6 rounded-2xl bg-card border border-border hover:shadow-md transition-all">
                        <span class="material-symbols-outlined text-primary mb-4 text-3xl">chat_bubble</span>
                        <h4 class="font-bold mb-2 text-foreground">Patient Forum</h4>
                        <p class="text-xs text-muted-foreground mb-4">Secure, anonymous discussion board.</p>
                        <a class="text-xs font-bold text-primary hover:underline" href="#">Join Forum</a>
                    </div>
                    <div class="p-6 rounded-2xl bg-card border border-border hover:shadow-md transition-all">
                        <span class="material-symbols-outlined text-primary mb-4 text-3xl">volunteer_activism</span>
                        <h4 class="font-bold mb-2 text-foreground">Buddy System</h4>
                        <p class="text-xs text-muted-foreground mb-4">Get paired with a recovery mentor.</p>
                        <a class="text-xs font-bold text-primary hover:underline" href="#">Sign Up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>