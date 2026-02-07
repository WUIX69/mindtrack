<?php include_once __DIR__ . '/../../core/app.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= shared('components', 'elements/meta'); ?>
    <title>About Us - MindTrack | Wayside Psyche Resources Center</title>
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
            <!-- Hero Section -->
            <section class="relative px-6 py-20 md:py-32 bg-background overflow-hidden">
                <div class="max-w-[1200px] mx-auto text-center relative z-10">
                    <span
                        class="inline-flex items-center px-4 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-bold tracking-widest uppercase mb-6">
                        Our Mission
                    </span>
                    <h1
                        class="text-4xl md:text-6xl font-extrabold leading-[1.1] tracking-tight text-foreground mb-8 max-w-4xl mx-auto">
                        Advocating for a Healthier, More Mindful World
                    </h1>
                    <p class="text-xl text-muted-foreground max-w-2xl mx-auto leading-relaxed">
                        At MindTrack, our mission is to break down barriers to mental healthcare through innovation,
                        compassion, and unwavering dedication to every individual's emotional journey.
                    </p>
                </div>
                <!-- Background decoration -->
                <div class="absolute top-0 left-0 w-full h-full opacity-5 pointer-events-none">
                    <div
                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-primary rounded-full blur-[120px]">
                    </div>
                </div>
            </section>

            <!-- Who We Are Section -->
            <section class="py-24 bg-muted/30">
                <div class="max-w-[1200px] mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="relative">
                        <div class="aspect-[4/3] rounded-3xl overflow-hidden shadow-2xl bg-card">
                            <img alt="Wayside Psyche Resources Center Interior" class="w-full h-full object-cover"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2u8GcbtxRjWW21GICs_seum7FKwDHzOnFFzzqzNUgAemFaiRB0CPWk6rM0-2BQBhCU9FMpcnT-U1f-oqnNME7GhNYQoYrYT8H-UwclpSW7UTIVTS_HQw_bLlUB72S2-Wv4feGXJMpaLxeeXJt1n9NOmOKiuJnJjy2KNMzH1L_CZkO9WJnw0OqgDojDGY-r9qM92-d5Z44uDs-72BLn6humlJIVarI1PAfdY607cqzRdaHc0vTn8xV_S1iksjVgPe9BOSgMuesH4A" />
                        </div>
                        <div class="absolute -bottom-8 -right-8 bg-primary p-8 rounded-3xl shadow-2xl hidden md:block">
                            <p class="text-4xl font-bold text-primary-foreground mb-1">15+</p>
                            <p class="text-primary-foreground/90 text-sm font-medium">Years of Excellence</p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-6">
                        <h2 class="text-3xl md:text-4xl font-bold text-foreground">Who We Are</h2>
                        <p class="text-lg text-muted-foreground leading-relaxed">
                            The Wayside Psyche Resources Center is a premier mental health institution dedicated to
                            providing compassionate, high-quality psychiatric care. We believe that mental health is a
                            fundamental human right, not a luxury.
                        </p>
                        <p class="text-lg text-muted-foreground leading-relaxed">
                            Through MindTrack, we bring our clinical expertise into the digital age, offering a seamless
                            interface for patients to connect with licensed professionals who truly care about their
                            recovery and growth.
                        </p>
                        <div class="grid grid-cols-2 gap-6 mt-4">
                            <div class="flex flex-col gap-2">
                                <span class="material-symbols-outlined text-primary text-3xl">verified_user</span>
                                <h4 class="font-bold text-foreground">Fully Licensed</h4>
                                <p class="text-sm text-muted-foreground">Board-certified practitioners only.</p>
                            </div>
                            <div class="flex flex-col gap-2">
                                <span class="material-symbols-outlined text-primary text-3xl">volunteer_activism</span>
                                <h4 class="font-bold text-foreground">Patient First</h4>
                                <p class="text-sm text-muted-foreground">Care plans tailored to you.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Our Core Values Section -->
            <section class="py-24 bg-background">
                <div class="max-w-[1200px] mx-auto px-6">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4 text-foreground">Our Core Values</h2>
                        <p class="text-muted-foreground">The principles that guide every interaction and clinical
                            decision.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div
                            class="p-8 rounded-3xl border border-border bg-card text-center flex flex-col items-center gap-4 hover:shadow-lg transition-all">
                            <div
                                class="size-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                                <span class="material-symbols-outlined text-3xl">favorite</span>
                            </div>
                            <h3 class="text-xl font-bold text-foreground">Compassion</h3>
                            <p class="text-muted-foreground">We approach every patient with empathy, understanding, and
                                a non-judgmental heart.</p>
                        </div>
                        <div
                            class="p-8 rounded-3xl border border-border bg-card text-center flex flex-col items-center gap-4 hover:shadow-lg transition-all">
                            <div
                                class="size-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                                <span class="material-symbols-outlined text-3xl">school</span>
                            </div>
                            <h3 class="text-xl font-bold text-foreground">Professionalism</h3>
                            <p class="text-muted-foreground">Maintaining the highest standards of ethics and clinical
                                excellence in all we do.</p>
                        </div>
                        <div
                            class="p-8 rounded-3xl border border-border bg-card text-center flex flex-col items-center gap-4 hover:shadow-lg transition-all">
                            <div
                                class="size-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                                <span class="material-symbols-outlined text-3xl">science</span>
                            </div>
                            <h3 class="text-xl font-bold text-foreground">Evidence-Based Care</h3>
                            <p class="text-muted-foreground">Our treatments are grounded in the latest psychological
                                research and proven clinical methods.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Leadership Section -->
            <section class="py-24 bg-muted/30">
                <div class="max-w-[1200px] mx-auto px-6">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold mb-4 text-foreground">Meet Our Leadership</h2>
                        <p class="text-muted-foreground">The visionaries behind Wayside Psyche Resources Center.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Leader 1 -->
                        <div
                            class="group bg-card border border-border rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                            <div class="aspect-square bg-muted">
                                <img alt="Dr. Sarah Jenkins"
                                    class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2u8GcbtxRjWW21GICs_seum7FKwDHzOnFFzzqzNUgAemFaiRB0CPWk6rM0-2BQBhCU9FMpcnT-U1f-oqnNME7GhNYQoYrYT8H-UwclpSW7UTIVTS_HQw_bLlUB72S2-Wv4feGXJMpaLxeeXJt1n9NOmOKiuJnJjy2KNMzH1L_CZkO9WJnw0OqgDojDGY-r9qM92-d5Z44uDs-72BLn6humlJIVarI1PAfdY607cqzRdaHc0vTn8xV_S1iksjVgPe9BOSgMuesH4A" />
                            </div>
                            <div class="p-8">
                                <h3 class="text-xl font-bold text-foreground">Dr. Sarah Jenkins</h3>
                                <p class="text-primary font-semibold text-sm mb-4">Executive Director &amp; Clinical
                                    Lead</p>
                                <p class="text-muted-foreground text-sm leading-relaxed">Specializing in trauma-informed
                                    care with over 20 years of experience.</p>
                            </div>
                        </div>
                        <!-- Leader 2 -->
                        <div
                            class="group bg-card border border-border rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                            <div class="aspect-square bg-muted">
                                <img alt="Michael Chen"
                                    class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2u8GcbtxRjWW21GICs_seum7FKwDHzOnFFzzqzNUgAemFaiRB0CPWk6rM0-2BQBhCU9FMpcnT-U1f-oqnNME7GhNYQoYrYT8H-UwclpSW7UTIVTS_HQw_bLlUB72S2-Wv4feGXJMpaLxeeXJt1n9NOmOKiuJnJjy2KNMzH1L_CZkO9WJnw0OqgDojDGY-r9qM92-d5Z44uDs-72BLn6humlJIVarI1PAfdY607cqzRdaHc0vTn8xV_S1iksjVgPe9BOSgMuesH4A" />
                            </div>
                            <div class="p-8">
                                <h3 class="text-xl font-bold text-foreground">Michael Chen</h3>
                                <p class="text-primary font-semibold text-sm mb-4">Head of Operations</p>
                                <p class="text-muted-foreground text-sm leading-relaxed">Driving the technological
                                    integration and patient accessibility at MindTrack.</p>
                            </div>
                        </div>
                        <!-- Leader 3 -->
                        <div
                            class="group bg-card border border-border rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300">
                            <div class="aspect-square bg-muted">
                                <img alt="Dr. Elena Rodriguez"
                                    class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2u8GcbtxRjWW21GICs_seum7FKwDHzOnFFzzqzNUgAemFaiRB0CPWk6rM0-2BQBhCU9FMpcnT-U1f-oqnNME7GhNYQoYrYT8H-UwclpSW7UTIVTS_HQw_bLlUB72S2-Wv4feGXJMpaLxeeXJt1n9NOmOKiuJnJjy2KNMzH1L_CZkO9WJnw0OqgDojDGY-r9qM92-d5Z44uDs-72BLn6humlJIVarI1PAfdY607cqzRdaHc0vTn8xV_S1iksjVgPe9BOSgMuesH4A" />
                            </div>
                            <div class="p-8">
                                <h3 class="text-xl font-bold text-foreground">Dr. Elena Rodriguez</h3>
                                <p class="text-primary font-semibold text-sm mb-4">Chief Research Officer</p>
                                <p class="text-muted-foreground text-sm leading-relaxed">Ensuring all clinical protocols
                                    meet the highest standards of evidence-based care.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- CTA Banner -->
            <section class="max-w-[1200px] mx-auto px-6 pb-24 pt-12">
                <div
                    class="bg-primary rounded-[2rem] p-8 md:p-16 relative overflow-hidden text-primary-foreground shadow-2xl">
                    <div
                        class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-10 text-center lg:text-left">
                        <div class="max-w-xl">
                            <h2 class="text-3xl md:text-5xl font-extrabold mb-6 leading-tight">Join our journey to
                                wellness.</h2>
                            <p class="text-primary-foreground/90 text-lg">Experience the Wayside difference today. Our
                                team is ready to support you.</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button
                                class="bg-background text-primary px-10 py-4 rounded-xl font-bold text-lg hover:bg-accent transition-all shadow-xl">
                                Book Now
                            </button>
                            <button
                                class="bg-primary-foreground/10 border border-primary-foreground/20 backdrop-blur-sm text-primary-foreground px-10 py-4 rounded-xl font-bold text-lg hover:bg-primary-foreground/20 transition-all">
                                Our Team
                            </button>
                        </div>
                    </div>
                    <div
                        class="absolute top-0 right-0 w-1/2 h-full bg-white/10 -skew-x-12 translate-x-1/4 pointer-events-none">
                    </div>
                </div>
            </section>
        </main>

        <?= shared('components', 'layout/footer'); ?>

    </div>
    <?= shared('components', 'elements/scripts'); ?>
</body>

</html>