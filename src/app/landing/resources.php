<?php include_once __DIR__ . '/../../core/app.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= shared('components', 'elements/meta'); ?>
    <title>Wellness Resources - MindTrack | Wayside Psyche Resources Center</title>
    <?= shared('components', 'elements/styles'); ?>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="bg-background font-sans text-foreground transition-colors duration-200">
    <div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">

        <?= shared('components', 'layout/navbar'); ?>

        <main class="flex-1 max-w-[1200px] mx-auto w-full px-6 py-12">
            <!-- Resources Header -->
            <div class="mb-12 text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight text-foreground font-display">Mental
                    Health Resources</h1>
                <p class="text-lg text-muted-foreground mb-8 max-w-2xl leading-relaxed">
                    Discover expert articles, self-help guides, and community support tools to help you navigate your
                    journey to emotional wellness.
                </p>
                <!-- Search Bar -->
                <div class="relative max-w-2xl">
                    <span
                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-muted-foreground/60">search</span>
                    <input type="text"
                        class="w-full pl-12 pr-4 py-4 rounded-2xl border border-border bg-card text-foreground focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none"
                        placeholder="Search for articles, guides, or topics..." />
                </div>
            </div>

            <!-- Content Layout with Sidebar -->
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Sidebar Navigation -->
                <aside class="w-full lg:w-64 flex-shrink-0">
                    <div class="sticky top-28 space-y-8">
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-widest text-muted-foreground/60 mb-4">
                                Categories</h3>
                            <ul class="space-y-2">
                                <li>
                                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary text-primary-foreground font-semibold shadow-sm"
                                        href="#">
                                        <span class="material-symbols-outlined text-xl">article</span>
                                        Articles
                                    </a>
                                </li>
                                <li>
                                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl text-foreground hover:bg-accent transition-colors font-medium"
                                        href="#">
                                        <span class="material-symbols-outlined text-xl">auto_stories</span>
                                        Self-Help Guides
                                    </a>
                                </li>
                                <li>
                                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl text-foreground hover:bg-accent transition-colors font-medium"
                                        href="#">
                                        <span class="material-symbols-outlined text-xl">forum</span>
                                        Community Support
                                    </a>
                                </li>
                                <li>
                                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl text-foreground hover:bg-accent transition-colors font-medium"
                                        href="#">
                                        <span class="material-symbols-outlined text-xl">video_library</span>
                                        Video Resources
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Popular Tags -->
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-widest text-muted-foreground/60 mb-4">
                                Popular Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                <span
                                    class="px-3 py-1 bg-muted text-muted-foreground text-xs font-medium rounded-full cursor-pointer hover:bg-primary/10 hover:text-primary transition-colors border border-border/50">Anxiety</span>
                                <span
                                    class="px-3 py-1 bg-muted text-muted-foreground text-xs font-medium rounded-full cursor-pointer hover:bg-primary/10 hover:text-primary transition-colors border border-border/50">Meditation</span>
                                <span
                                    class="px-3 py-1 bg-muted text-muted-foreground text-xs font-medium rounded-full cursor-pointer hover:bg-primary/10 hover:text-primary transition-colors border border-border/50">CBT</span>
                                <span
                                    class="px-3 py-1 bg-muted text-muted-foreground text-xs font-medium rounded-full cursor-pointer hover:bg-primary/10 hover:text-primary transition-colors border border-border/50">Stress</span>
                                <span
                                    class="px-3 py-1 bg-muted text-muted-foreground text-xs font-medium rounded-full cursor-pointer hover:bg-primary/10 hover:text-primary transition-colors border border-border/50">Relationships</span>
                            </div>
                        </div>

                        <!-- Help Widget -->
                        <div class="p-6 rounded-2xl bg-primary/5 border border-primary/10">
                            <h4 class="font-bold text-sm mb-2 text-foreground">Need immediate help?</h4>
                            <p class="text-xs text-muted-foreground mb-4">Our professionals are available for emergency
                                consultations.</p>
                            <button
                                class="w-full py-2.5 bg-primary text-primary-foreground text-xs font-bold rounded-lg hover:bg-primary/90 transition-all">Get
                                Help Now</button>
                        </div>
                    </div>
                </aside>

                <!-- Articles Grid -->
                <div class="flex-1">
                    <div class="mb-16">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-2xl font-bold text-foreground font-display">Latest Articles</h2>
                            <a class="text-sm font-bold text-primary flex items-center gap-1 hover:underline" href="#">
                                View all <span class="material-symbols-outlined text-lg">chevron_right</span>
                            </a>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Article 1 -->
                            <article
                                class="group bg-card border border-border rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                                <div class="aspect-video overflow-hidden">
                                    <img alt="Managing Anxiety"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2u8GcbtxRjWW21GICs_seum7FKwDHzOnFFzzqzNUgAemFaiRB0CPWk6rM0-2BQBhCU9FMpcnT-U1f-oqnNME7GhNYQoYrYT8H-UwclpSW7UTIVTS_HQw_bLlUB72S2-Wv4feGXJMpaLxeeXJt1n9NOmOKiuJnJjy2KNMzH1L_CZkO9WJnw0OqgDojDGY-r9qM92-d5Z44uDs-72BLn6humlJIVarI1PAfdY607cqzRdaHc0vTn8xV_S1iksjVgPe9BOSgMuesH4A" />
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span
                                            class="text-[10px] font-bold uppercase tracking-wider text-primary bg-primary/10 px-2.5 py-1 rounded">Mental
                                            Health</span>
                                        <span class="text-xs text-muted-foreground">5 min read</span>
                                    </div>
                                    <h3
                                        class="text-xl font-bold mb-3 leading-tight text-foreground group-hover:text-primary transition-colors font-display">
                                        Managing Anxiety at Home: Practical Techniques</h3>
                                    <p class="text-muted-foreground text-sm mb-6 line-clamp-2 leading-relaxed">Learn
                                        simple, evidence-based strategies to calm your mind and body when anxiety
                                        strikes in your daily life.</p>
                                    <button
                                        class="flex items-center gap-2 text-sm font-bold text-primary group-hover:gap-3 transition-all">
                                        Read More <span class="material-symbols-outlined text-lg">arrow_forward</span>
                                    </button>
                                </div>
                            </article>
                            <!-- Article 2 -->
                            <article
                                class="group bg-card border border-border rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                                <div class="aspect-video overflow-hidden bg-muted flex items-center justify-center">
                                    <span
                                        class="material-symbols-outlined text-6xl text-muted-foreground/40">psychology</span>
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span
                                            class="text-[10px] font-bold uppercase tracking-wider text-primary bg-primary/10 px-2.5 py-1 rounded">Therapy
                                            Types</span>
                                        <span class="text-xs text-muted-foreground">8 min read</span>
                                    </div>
                                    <h3
                                        class="text-xl font-bold mb-3 leading-tight text-foreground group-hover:text-primary transition-colors font-display">
                                        Understanding CBT: How It Rewires Your Thoughts</h3>
                                    <p class="text-muted-foreground text-sm mb-6 line-clamp-2 leading-relaxed">A deep
                                        dive into Cognitive Behavioral Therapy and why it remains one of the most
                                        effective tools in modern psychology.</p>
                                    <button
                                        class="flex items-center gap-2 text-sm font-bold text-primary group-hover:gap-3 transition-all">
                                        Read More <span class="material-symbols-outlined text-lg">arrow_forward</span>
                                    </button>
                                </div>
                            </article>
                        </div>
                    </div>

                    <!-- Self-Help Guides Section -->
                    <div class="mb-16">
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-2xl font-bold text-foreground font-display">Self-Help Guides</h2>
                            <a class="text-sm font-bold text-primary flex items-center gap-1 hover:underline" href="#">
                                Browse all guides <span class="material-symbols-outlined text-lg">chevron_right</span>
                            </a>
                        </div>
                        <div class="space-y-4">
                            <!-- Guide 1 -->
                            <div
                                class="flex items-center gap-6 p-5 rounded-2xl bg-card border border-border hover:border-primary/30 transition-all shadow-sm group">
                                <div
                                    class="size-16 rounded-xl bg-orange-100 dark:bg-orange-500/10 text-orange-600 dark:text-orange-400 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-3xl">lightbulb</span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-lg text-foreground font-display">The Sleep Hygiene
                                        Workbook</h4>
                                    <p class="text-sm text-muted-foreground leading-relaxed">Step-by-step guide to
                                        improving your sleep quality for better mental health.</p>
                                </div>
                                <button
                                    class="px-6 py-2.5 rounded-lg border border-border text-foreground text-sm font-bold hover:bg-accent hover:border-transparent transition-all hidden md:block">
                                    Download PDF
                                </button>
                            </div>
                            <!-- Guide 2 -->
                            <div
                                class="flex items-center gap-6 p-5 rounded-2xl bg-card border border-border hover:border-primary/30 transition-all shadow-sm group">
                                <div
                                    class="size-16 rounded-xl bg-blue-100 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 flex items-center justify-center flex-shrink-0">
                                    <span class="material-symbols-outlined text-3xl">mindfulness</span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-lg text-foreground font-display">Daily Mindfulness
                                        Journaling</h4>
                                    <p class="text-sm text-muted-foreground leading-relaxed">21 prompts to help you stay
                                        grounded and present throughout your week.</p>
                                </div>
                                <button
                                    class="px-6 py-2.5 rounded-lg border border-border text-foreground text-sm font-bold hover:bg-accent hover:border-transparent transition-all hidden md:block">
                                    Download PDF
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Community Support Section -->
                    <div>
                        <div class="flex items-center justify-between mb-8">
                            <h2 class="text-2xl font-bold text-foreground font-display">Community Support</h2>
                            <a class="text-sm font-bold text-primary flex items-center gap-1 hover:underline" href="#">
                                Join the community <span class="material-symbols-outlined text-lg">chevron_right</span>
                            </a>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div
                                class="p-6 rounded-2xl bg-card border border-border shadow-sm flex flex-col items-start hover:shadow-md transition-all">
                                <span class="material-symbols-outlined text-primary mb-4 text-3xl">groups</span>
                                <h4 class="font-bold mb-2 text-foreground">Group Sessions</h4>
                                <p class="text-xs text-muted-foreground mb-4 leading-relaxed">Join moderated weekly
                                    group calls with peers who share similar experiences.</p>
                                <a class="text-xs font-bold text-primary hover:underline flex items-center gap-1"
                                    href="#">
                                    Learn More <span class="material-symbols-outlined text-sm">open_in_new</span>
                                </a>
                            </div>
                            <div
                                class="p-6 rounded-2xl bg-card border border-border shadow-sm flex flex-col items-start hover:shadow-md transition-all">
                                <span class="material-symbols-outlined text-primary mb-4 text-3xl">chat_bubble</span>
                                <h4 class="font-bold mb-2 text-foreground">Patient Forum</h4>
                                <p class="text-xs text-muted-foreground mb-4 leading-relaxed">Secure, anonymous
                                    discussion board for MindTrack patients to connect.</p>
                                <a class="text-xs font-bold text-primary hover:underline flex items-center gap-1"
                                    href="#">
                                    Join Forum <span class="material-symbols-outlined text-sm">open_in_new</span>
                                </a>
                            </div>
                            <div
                                class="p-6 rounded-2xl bg-card border border-border shadow-sm flex flex-col items-start hover:shadow-md transition-all">
                                <span
                                    class="material-symbols-outlined text-primary mb-4 text-3xl">volunteer_activism</span>
                                <h4 class="font-bold mb-2 text-foreground">Buddy System</h4>
                                <p class="text-xs text-muted-foreground mb-4 leading-relaxed">Get paired with a recovery
                                    mentor who has successfully navigated their path.</p>
                                <a class="text-xs font-bold text-primary hover:underline flex items-center gap-1"
                                    href="#">
                                    Sign Up <span class="material-symbols-outlined text-sm">open_in_new</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?= shared('components', 'layout/footer'); ?>

    </div>
    <?= shared('components', 'elements/scripts'); ?>
</body>

</html>