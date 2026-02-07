<?php include_once __DIR__ . '/../../core/app.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= shared('components', 'elements/meta'); ?>
    <title>Contact Us - MindTrack | Wayside Psyche Resources Center</title>
    <?= shared('components', 'elements/styles'); ?>
    <style>
        .glass-card {
            background: oklch(from var(--card) l c h / 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border);
        }

        .floating-label-group {
            position: relative;
        }

        .floating-input {
            border: none;
            border-bottom: 1px solid var(--border);
            background: transparent !important;
            padding: 24px 0 8px 0;
            width: 100%;
            transition: all 0.3s ease;
            color: var(--foreground);
        }

        .floating-input:focus {
            outline: none;
            box-shadow: none;
            border-bottom: 2px solid var(--primary);
        }

        .floating-label {
            position: absolute;
            top: 24px;
            left: 0;
            pointer-events: none;
            transition: all 0.3s ease;
            color: var(--muted-foreground);
        }

        .floating-input:focus~.floating-label,
        .floating-input:not(:placeholder-shown)~.floating-label {
            top: 0;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--primary);
        }

        .silver-map {
            filter: grayscale(1) contrast(1.1) brightness(1.05);
        }

        .dark .silver-map {
            filter: grayscale(1) invert(0.9) contrast(0.9);
        }
    </style>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>

<body class="bg-background font-display text-foreground transition-colors duration-300">
    <div class="relative flex min-h-screen w-full flex-col">

        <?= shared('components', 'layout/navbar'); ?>

        <main class="flex-1">
            <!-- Hero Heading -->
            <section class="relative px-6 pt-24 pb-20 bg-background">
                <div class="max-w-[1200px] mx-auto text-center">
                    <span
                        class="inline-block px-4 py-1.5 mb-6 text-xs font-bold tracking-widest uppercase text-primary bg-primary/10 rounded-full">Support
                        Center</span>
                    <h1 class="text-5xl md:text-7xl font-bold mb-8 tracking-tight text-foreground">
                        Let's Connect with <span class="text-primary italic font-serif">Care</span>.
                    </h1>
                    <p class="text-muted-foreground max-w-2xl mx-auto text-xl leading-relaxed font-light">
                        Reach out to Wayside Psyche Resources Center. Whether it's clinical inquiries or MindTrack
                        technical support, our team is ready to guide you.
                    </p>
                </div>
            </section>

            <!-- Contact Grid -->
            <section class="px-6 py-12">
                <div class="max-w-[1200px] mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                    <!-- Contact Sidebar -->
                    <div class="lg:col-span-5 space-y-6">
                        <h2 class="text-2xl font-bold mb-8 text-foreground">Reach our team</h2>

                        <div class="glass-card p-6 rounded-2xl transition-all duration-300 hover:translate-x-2 group">
                            <div class="flex items-center gap-5">
                                <div
                                    class="size-14 rounded-2xl bg-muted text-primary flex items-center justify-center transition-colors duration-300 group-hover:bg-primary group-hover:text-primary-foreground">
                                    <span class="material-symbols-outlined text-3xl">location_on</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-foreground">Main Clinic</h3>
                                    <p class="text-muted-foreground text-sm leading-relaxed">123 Healing Path, Suite
                                        500<br />Wellness City, WC 45678</p>
                                </div>
                            </div>
                        </div>

                        <div class="glass-card p-6 rounded-2xl transition-all duration-300 hover:translate-x-2 group">
                            <div class="flex items-center gap-5">
                                <div
                                    class="size-14 rounded-2xl bg-muted text-primary flex items-center justify-center transition-colors duration-300 group-hover:bg-primary group-hover:text-primary-foreground">
                                    <span class="material-symbols-outlined text-3xl">call</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-foreground">Direct Line</h3>
                                    <p class="text-muted-foreground text-sm">+1 (555) 123-4567</p>
                                    <p
                                        class="text-[10px] uppercase tracking-wider text-muted-foreground/60 mt-1 font-bold">
                                        Mon-Fri: 09:00 - 18:00</p>
                                </div>
                            </div>
                        </div>

                        <div class="glass-card p-6 rounded-2xl transition-all duration-300 hover:translate-x-2 group">
                            <div class="flex items-center gap-5">
                                <div
                                    class="size-14 rounded-2xl bg-muted text-primary flex items-center justify-center transition-colors duration-300 group-hover:bg-primary group-hover:text-primary-foreground">
                                    <span class="material-symbols-outlined text-3xl">alternate_email</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-foreground">Email Enquiries</h3>
                                    <p class="text-muted-foreground text-sm">care@waysidepsyche.com</p>
                                    <p class="text-muted-foreground text-sm">support@mindtrack.com</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-8">
                            <h4 class="text-xs font-bold uppercase tracking-[0.2em] text-muted-foreground/50 mb-6">
                                Digital Presence</h4>
                            <div class="flex gap-4">
                                <a class="size-12 rounded-full flex items-center justify-center border border-border text-muted-foreground hover:text-primary hover:border-primary transition-all duration-300"
                                    href="#">
                                    <svg class="size-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z">
                                        </path>
                                    </svg>
                                </a>
                                <a class="size-12 rounded-full flex items-center justify-center border border-border text-muted-foreground hover:text-primary hover:border-primary transition-all duration-300"
                                    href="#">
                                    <svg class="size-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="lg:col-span-7">
                        <div class="bg-card p-12 rounded-[2.5rem] shadow-2xl border border-border">
                            <h2 class="text-3xl font-bold mb-2 text-foreground">Send a Message</h2>
                            <p class="text-muted-foreground mb-10 text-sm">We typically respond within 12 business
                                hours.</p>

                            <form class="space-y-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="floating-label-group">
                                        <input class="floating-input" id="name" placeholder=" " required type="text" />
                                        <label class="floating-label" for="name">Full Name</label>
                                    </div>
                                    <div class="floating-label-group">
                                        <input class="floating-input" id="email" placeholder=" " required
                                            type="email" />
                                        <label class="floating-label" for="email">Email Address</label>
                                    </div>
                                </div>
                                <div class="floating-label-group">
                                    <input class="floating-input" id="subject" placeholder=" " required type="text" />
                                    <label class="floating-label" for="subject">Department / Subject</label>
                                </div>
                                <div class="floating-label-group">
                                    <textarea class="floating-input resize-none" id="message" placeholder=" " required
                                        rows="4"></textarea>
                                    <label class="floating-label" for="message">Your Message</label>
                                </div>
                                <div class="pt-4">
                                    <button
                                        class="group relative w-full bg-primary text-primary-foreground py-5 rounded-2xl font-bold text-lg hover:-translate-y-1 hover:shadow-2xl hover:shadow-primary/40 transition-all duration-300 overflow-hidden"
                                        type="submit">
                                        <span class="relative z-10 flex items-center justify-center gap-2">
                                            Send Secure Message
                                            <span
                                                class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform">send</span>
                                        </span>
                                        <div
                                            class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity">
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Map Section -->
            <section class="mt-20">
                <div class="w-full h-[500px] relative overflow-hidden bg-muted">
                    <div class="absolute inset-0 silver-map opacity-70 bg-cover bg-center"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBquTNCcEn5z_9Nxd6nNJaKmwOgmECs4xXAMOIvEuh16VgJyuHOc-hYKI_4TI6k_kkks-_GK4WjaHMxmiThzA4XGlHDMovdKE6X4O1ivLxfcTFBlbsD48D_up7f6-Z1acSjZ8movDtF3tG3-b4NBKj05UTrDdVYRHAqh8bDEOihSN2Z-3O0OeSz_-7DSmAwKfmMmYlwsWRHfDnt7lARnBRbohe5rfP9mwrmA2ESbLFH6pZ7juKb_gXpuIw4FtTE7RZIM2edA6ZGkpQ');">
                    </div>
                    <div class="absolute inset-0 bg-primary/5 pointer-events-none"></div>

                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 flex flex-col items-center">
                        <div class="relative">
                            <div class="absolute inset-0 scale-150 animate-ping rounded-full bg-primary/20"></div>
                            <div class="relative bg-card p-2 rounded-2xl shadow-2xl border border-border">
                                <div
                                    class="size-12 rounded-xl bg-primary text-primary-foreground flex items-center justify-center">
                                    <span class="material-symbols-outlined font-normal">psychiatry</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 bg-card px-6 py-3 rounded-xl shadow-xl border border-border text-center">
                            <p class="font-bold text-sm text-foreground">Wayside Psyche Center</p>
                            <p class="text-[10px] text-muted-foreground uppercase font-bold tracking-widest mt-1">Our
                                Headquarters</p>
                        </div>
                    </div>

                    <div class="absolute bottom-10 left-10">
                        <a class="inline-flex items-center gap-3 bg-card/90 backdrop-blur-md px-6 py-4 rounded-2xl shadow-xl border border-border hover:bg-card transition-all group"
                            href="#">
                            <span class="material-symbols-outlined text-primary">directions</span>
                            <div class="text-left">
                                <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-tighter">Get
                                    Directions</p>
                                <p class="text-sm font-bold text-foreground">Open in Google Maps</p>
                            </div>
                            <span
                                class="material-symbols-outlined text-muted-foreground/30 group-hover:text-primary transition-colors">arrow_outward</span>
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <?= shared('components', 'layout/footer'); ?>

    </div>
    <?= shared('components', 'elements/scripts'); ?>
</body>

</html>