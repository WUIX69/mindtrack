<?php include_once __DIR__ . '/../../core/app.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= shared('components', 'elements/meta'); ?>
    <title>MindTrack Services Directory | Wayside Psyche Resources Center</title>
    <?= shared('components', 'elements/styles'); ?>
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="bg-background font-display text-foreground transition-colors duration-200">
    <div class="relative flex min-h-screen w-full flex-col overflow-x-hidden">

        <?= shared('components', 'layout/navbar'); ?>

        <main class="flex-1">
            <section class="bg-card pt-12 pb-8 border-b border-border">
                <div class="max-w-[1200px] mx-auto px-6">
                    <nav aria-label="Breadcrumb" class="flex mb-4">
                        <ol
                            class="inline-flex items-center space-x-1 md:space-x-3 text-sm font-medium text-muted-foreground">
                            <li class="inline-flex items-center">
                                <a class="hover:text-primary transition-colors" href="<?= app('landing'); ?>">Home</a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <span class="material-symbols-outlined text-sm mx-2">chevron_right</span>
                                    <span class="text-muted-foreground/60">Our Services</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-3xl md:text-5xl font-extrabold text-foreground tracking-tight">Comprehensive Mental
                        Health Services</h1>
                    <p class="mt-4 text-lg text-muted-foreground max-w-2xl">
                        At Wayside Psyche Resources Center, we provide a wide range of specialized treatments tailored
                        to support your individual journey toward emotional stability and well-being.
                    </p>
                </div>
            </section>

            <section class="py-16">
                <div class="max-w-[1200px] mx-auto px-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                        <!-- Card 1 -->
                        <div
                            class="group bg-card border border-border p-8 rounded-2xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                            <div
                                class="size-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-primary-foreground transition-colors">
                                <span class="material-symbols-outlined text-3xl">psychology</span>
                            </div>
                            <h3 class="text-xl font-bold mb-4 text-primary">Psychotherapy</h3>
                            <p class="text-muted-foreground mb-6 leading-relaxed">
                                Our talk therapy sessions provide a safe, confidential space to explore your feelings
                                and behaviors. We focus on building emotional resilience and gaining deeper
                                psychological insight into personal challenges.
                            </p>
                            <a class="inline-flex items-center font-bold text-primary hover:underline group-hover:gap-2 transition-all"
                                href="#">
                                Learn More <span class="material-symbols-outlined text-lg ml-1">arrow_right_alt</span>
                            </a>
                        </div>
                        <!-- Card 2 -->
                        <div
                            class="group bg-card border border-border p-8 rounded-2xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                            <div
                                class="size-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-primary-foreground transition-colors">
                                <span class="material-symbols-outlined text-3xl">settings_suggest</span>
                            </div>
                            <h3 class="text-xl font-bold mb-4 text-primary">CBT</h3>
                            <p class="text-muted-foreground mb-6 leading-relaxed">
                                Cognitive Behavioral Therapy is a structured, goal-oriented approach aimed at changing
                                negative thought patterns. It is highly effective for managing anxiety, depression, and
                                stress through actionable coping strategies.
                            </p>
                            <a class="inline-flex items-center font-bold text-primary hover:underline group-hover:gap-2 transition-all"
                                href="#">
                                Learn More <span class="material-symbols-outlined text-lg ml-1">arrow_right_alt</span>
                            </a>
                        </div>
                        <!-- Card 3 -->
                        <div
                            class="group bg-card border border-border p-8 rounded-2xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                            <div
                                class="size-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-primary-foreground transition-colors">
                                <span class="material-symbols-outlined text-3xl">groups</span>
                            </div>
                            <h3 class="text-xl font-bold mb-4 text-primary">Family/Couple Therapy</h3>
                            <p class="text-muted-foreground mb-6 leading-relaxed">
                                We help families and partners navigate conflict and improve communication. These
                                sessions are designed to strengthen interpersonal bonds and foster a supportive
                                environment for all household members.
                            </p>
                            <a class="inline-flex items-center font-bold text-primary hover:underline group-hover:gap-2 transition-all"
                                href="#">
                                Learn More <span class="material-symbols-outlined text-lg ml-1">arrow_right_alt</span>
                            </a>
                        </div>
                        <!-- Card 4 -->
                        <div
                            class="group bg-card border border-border p-8 rounded-2xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                            <div
                                class="size-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-primary-foreground transition-colors">
                                <span class="material-symbols-outlined text-3xl">emergency</span>
                            </div>
                            <h3 class="text-xl font-bold mb-4 text-primary">Addiction Counseling</h3>
                            <p class="text-muted-foreground mb-6 leading-relaxed">
                                Specialized support for individuals struggling with substance use or behavioral
                                addictions. Our compassionate team provides tools for recovery, relapse prevention, and
                                long-term sobriety maintenance.
                            </p>
                            <a class="inline-flex items-center font-bold text-primary hover:underline group-hover:gap-2 transition-all"
                                href="#">
                                Learn More <span class="material-symbols-outlined text-lg ml-1">arrow_right_alt</span>
                            </a>
                        </div>
                        <!-- Card 5 -->
                        <div
                            class="group bg-card border border-border p-8 rounded-2xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                            <div
                                class="size-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-primary-foreground transition-colors">
                                <span class="material-symbols-outlined text-3xl">assignment</span>
                            </div>
                            <h3 class="text-xl font-bold mb-4 text-primary">Psychological Testing</h3>
                            <p class="text-muted-foreground mb-6 leading-relaxed">
                                Comprehensive diagnostic evaluations including personality assessments,
                                neuro-psychological testing, and developmental screenings. We provide clear, data-driven
                                insights to guide your treatment plan.
                            </p>
                            <a class="inline-flex items-center font-bold text-primary hover:underline group-hover:gap-2 transition-all"
                                href="#">
                                Learn More <span class="material-symbols-outlined text-lg ml-1">arrow_right_alt</span>
                            </a>
                        </div>
                        <!-- Card 6 -->
                        <div
                            class="group bg-card border border-border p-8 rounded-2xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                            <div
                                class="size-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-primary-foreground transition-colors">
                                <span class="material-symbols-outlined text-3xl">front_hand</span>
                            </div>
                            <h3 class="text-xl font-bold mb-4 text-primary">Occupational Therapy</h3>
                            <p class="text-muted-foreground mb-6 leading-relaxed">
                                Helping individuals develop, recover, and improve skills for daily living and working.
                                This therapy focuses on physical and cognitive interventions to enhance overall
                                functional independence.
                            </p>
                            <a class="inline-flex items-center font-bold text-primary hover:underline group-hover:gap-2 transition-all"
                                href="#">
                                Learn More <span class="material-symbols-outlined text-lg ml-1">arrow_right_alt</span>
                            </a>
                        </div>
                        <!-- Card 7 -->
                        <div
                            class="group bg-card border border-border p-8 rounded-2xl hover:shadow-2xl hover:-translate-y-1 transition-all">
                            <div
                                class="size-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-6 group-hover:bg-primary group-hover:text-primary-foreground transition-colors">
                                <span class="material-symbols-outlined text-3xl">extension</span>
                            </div>
                            <h3 class="text-xl font-bold mb-4 text-primary">Applied Behavioral Analysis (ABA)</h3>
                            <p class="text-muted-foreground mb-6 leading-relaxed">
                                Evidence-based therapy focused on improving specific behaviors, social skills, and
                                communication in children and adults with autism or other developmental conditions.
                            </p>
                            <a class="inline-flex items-center font-bold text-primary hover:underline group-hover:gap-2 transition-all"
                                href="#">
                                Learn More <span class="material-symbols-outlined text-lg ml-1">arrow_right_alt</span>
                            </a>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-6 pt-12 border-t border-border">
                        <div class="text-center">
                            <h2 class="text-2xl font-bold mb-2">Need a personalized care plan?</h2>
                            <p class="text-muted-foreground mb-8">Schedule a consultation with our experts today.</p>
                        </div>
                        <button
                            class="flex min-w-[240px] items-center justify-center rounded-2xl h-16 px-10 bg-primary text-primary-foreground text-lg font-bold shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                            Book Appointment
                        </button>
                    </div>
                </div>
            </section>
        </main>

        <?= shared('components', 'layout/footer'); ?>

    </div>
    <?= shared('components', 'elements/scripts'); ?>
</body>

</html>