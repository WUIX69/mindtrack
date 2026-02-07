<?php
/**
 * Landing Home Page
 */
$pageTitle = "MindTrack - Your Journey to Emotional Wellness";
include __DIR__ . '/../layout.php';
?>

<!-- Hero Section -->
<section class="relative px-6 py-16 md:py-24">
    <div class="max-w-[1200px] mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div class="flex flex-col gap-8">
            <div class="flex flex-col gap-4">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold tracking-wider uppercase w-fit">
                    Trusted Care Partner
                </span>
                <h1 class="text-4xl md:text-6xl font-extrabold leading-[1.1] tracking-tight">
                    Your Journey to Emotional Wellness Starts Here
                </h1>
                <p class="text-lg text-muted-foreground max-w-[540px] leading-relaxed">
                    Wayside Psyche Resources Center provides expert mental health support. We are dedicated
                    to your emotional well-being through personalized professional care.
                </p>
            </div>
            <div class="flex flex-wrap gap-4">
                <button
                    class="flex min-w-[180px] cursor-pointer items-center justify-center rounded-xl h-14 px-8 bg-primary text-primary-foreground text-base font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                    Book an Appointment
                </button>
                <button class="flex items-center gap-2 text-foreground font-bold px-6 h-14 hover:underline">
                    <span class="material-symbols-outlined">play_circle</span>
                    How it works
                </button>
            </div>
        </div>
        <div class="relative">
            <div class="aspect-square rounded-3xl overflow-hidden shadow-2xl bg-muted">
                <img alt="A smiling mental health professional" class="w-full h-full object-cover"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2u8GcbtxRjWW21GICs_seum7FKwDHzOnFFzzqzNUgAemFaiRB0CPWk6rM0-2BQBhCU9FMpcnT-U1f-oqnNME7GhNYQoYrYT8H-UwclpSW7UTIVTS_HQw_bLlUB72S2-Wv4feGXJMpaLxeeXJt1n9NOmOKiuJnJjy2KNMzH1L_CZkO9WJnw0OqgDojDGY-r9qM92-d5Z44uDs-72BLn6humlJIVarI1PAfdY607cqzRdaHc0vTn8xV_S1iksjVgPe9BOSgMuesH4A" />
            </div>
            <!-- Decorative floating elements -->
            <div
                class="absolute -bottom-6 -left-6 bg-card p-4 rounded-2xl shadow-xl flex items-center gap-4 border border-border">
                <div class="size-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                    <span class="material-symbols-outlined">verified</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-muted-foreground">Accredited</p>
                    <p class="text-sm font-extrabold">Licensed Specialists</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="bg-card/50 py-20 border-y border-border" id="services">
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="max-w-xl">
                <h2 class="text-3xl font-bold mb-4">Our Specialized Services</h2>
                <p class="text-muted-foreground">Comprehensive mental health solutions tailored to
                    individuals, couples, and families.</p>
            </div>
            <a class="text-primary font-bold flex items-center gap-1 hover:gap-2 transition-all"
                href="<?= app('landing/services'); ?>">
                View all services <span class="material-symbols-outlined">arrow_forward</span>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Card 1 -->
            <div
                class="group flex flex-col gap-4 rounded-2xl border border-border bg-card p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                <div
                    class="size-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-primary-foreground transition-colors">
                    <span class="material-symbols-outlined">psychology</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-2">Psychotherapy</h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">Individual sessions focused on
                        emotional growth and deep psychological insight.</p>
                </div>
            </div>
            <!-- Card 2 -->
            <div
                class="group flex flex-col gap-4 rounded-2xl border border-border bg-card p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                <div
                    class="size-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-primary-foreground transition-colors">
                    <span class="material-symbols-outlined">settings_suggest</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-2">CBT</h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">Evidence-based Cognitive
                        Behavioral Therapy for managing thoughts and behaviors.</p>
                </div>
            </div>
            <!-- Card 3 -->
            <div
                class="group flex flex-col gap-4 rounded-2xl border border-border bg-card p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                <div
                    class="size-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-primary-foreground transition-colors">
                    <span class="material-symbols-outlined">groups</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-2">Family Therapy</h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">Strengthening interpersonal
                        bonds and resolving conflicts within the home unit.</p>
                </div>
            </div>
            <!-- Card 4 -->
            <div
                class="group flex flex-col gap-4 rounded-2xl border border-border bg-card p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
                <div
                    class="size-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-primary-foreground transition-colors">
                    <span class="material-symbols-outlined">assignment</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-2">Testing</h3>
                    <p class="text-sm text-muted-foreground leading-relaxed">Comprehensive diagnostic
                        evaluations and psychological assessments.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Why MindTrack Section -->
<section class="py-24 px-6">
    <div class="max-w-[1200px] mx-auto">
        <div class="flex flex-col items-center text-center mb-16 gap-4">
            <h2 class="text-4xl font-bold tracking-tight">Why Choose MindTrack?</h2>
            <p class="text-muted-foreground max-w-2xl">We bridge the gap between world-class expertise and
                user-friendly technology for your mental health journey.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <div class="flex flex-col items-center text-center gap-6">
                <div class="size-16 rounded-full bg-muted flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-4xl">video_chat</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-3">Face-to-Face Access</h3>
                    <p class="text-muted-foreground text-sm leading-relaxed">Connect personally with our
                        specialists via secure video or in-person sessions in a safe environment.</p>
                </div>
            </div>
            <div class="flex flex-col items-center text-center gap-6">
                <div class="size-16 rounded-full bg-muted flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-4xl">workspace_premium</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-3">Professional Care</h3>
                    <p class="text-muted-foreground text-sm leading-relaxed">Access a team of highly vetted,
                        licensed, and experienced practitioners across multiple disciplines.</p>
                </div>
            </div>
            <div class="flex flex-col items-center text-center gap-6">
                <div class="size-16 rounded-full bg-muted flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-4xl">event_available</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-3">Easy Scheduling</h3>
                    <p class="text-muted-foreground text-sm leading-relaxed">Book, reschedule, and manage
                        your clinical appointments with just a few clicks in our portal.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Banner -->
<section class="px-6 pb-24">
    <div
        class="max-w-[1200px] mx-auto bg-primary rounded-[2rem] p-8 md:p-16 relative overflow-hidden text-primary-foreground">
        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10">
            <div class="max-w-xl text-center lg:text-left">
                <h2 class="text-3xl md:text-5xl font-extrabold mb-6 leading-tight">Ready to take the first
                    step towards wellness?</h2>
                <p class="opacity-90 text-lg">Join thousands of patients who have found clarity and support
                    through our network.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="<?= app('auth/register'); ?>"
                    class="bg-background text-primary px-10 py-4 rounded-xl font-bold text-lg hover:opacity-90 transition-all shadow-xl flex items-center justify-center">
                    Create Account
                </a>
                <a href="<?= app('landing/contact'); ?>"
                    class="bg-white/10 border border-white/30 backdrop-blur-sm text-white px-10 py-4 rounded-xl font-bold text-lg hover:bg-white/20 transition-all flex items-center justify-center">
                    Contact Support
                </a>
            </div>
        </div>
        <!-- Abstract Background Shape -->
        <div class="absolute top-0 right-0 w-1/2 h-full bg-white/10 -skew-x-12 translate-x-1/4 pointer-events-none">
        </div>
    </div>
</section>