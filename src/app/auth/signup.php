<?php
/**
 * MindTrack Sign-Up Page (Refactored)
 */

$pageTitle = "MindTrack - Start Your Journey";
// Custom head content for the aesthetic hero section
$headContent = <<<'HTML'
<style>
    .scroll-hide::-webkit-scrollbar {
        display: none;
    }
    .scroll-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
HTML;

include __DIR__ . '/layout.php';
?>

<div class="flex flex-col lg:flex-row min-h-screen w-full overflow-hidden bg-background">
    <!-- Left Side: Calming Aesthetic Hero -->
    <div
        class="relative hidden lg:flex lg:w-[42%] flex-col justify-between p-12 bg-primary/5 dark:bg-primary/10 overflow-hidden">
        <!-- Decorative Background Elements -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary/20 rounded-full blur-[80px]"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-blue-400/10 dark:bg-blue-900/10 rounded-full blur-[80px]">
        </div>

        <div class="relative z-10">
            <div class="flex items-center gap-4 mb-14 drop-shadow-sm">
                <div
                    class="size-12 bg-primary rounded-xl flex items-center justify-center text-white shadow-xl shadow-primary/20">
                    <span class="material-symbols-outlined text-3xl">psychology</span>
                </div>
                <h2 class="text-3xl font-black tracking-tighter uppercase text-foreground">MindTrack</h2>
            </div>

            <div class="space-y-8">
                <h1 class="text-6xl font-black leading-[1.05] text-primary tracking-tighter">
                    Begin your path <br />to clarity.
                </h1>
                <p class="text-xl text-muted-foreground max-w-sm leading-relaxed font-bold">
                    MindTrack helps you monitor your mental well-being with professional tools and compassionate care.
                </p>
            </div>
        </div>

        <div class="relative z-10 max-w-md">
            <div class="bg-card/70 dark:bg-card/40 backdrop-blur-xl p-8 rounded-2xl border border-border/50 shadow-2xl">
                <div class="flex gap-1.5 text-primary mb-4">
                    <span class="material-symbols-outlined fill-1 text-2xl">star</span>
                    <span class="material-symbols-outlined fill-1 text-2xl">star</span>
                    <span class="material-symbols-outlined fill-1 text-2xl">star</span>
                    <span class="material-symbols-outlined fill-1 text-2xl">star</span>
                    <span class="material-symbols-outlined fill-1 text-2xl">star</span>
                </div>
                <p class="italic text-lg font-bold text-foreground mb-6 leading-relaxed">
                    "This platform completely changed how I track my moods. The insights are incredibly helpful."
                </p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full ring-4 ring-primary/5 bg-cover bg-center shadow-lg"
                        style="background-image: url('https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200&auto=format&fit=crop')">
                    </div>
                    <div>
                        <p class="text-base font-black text-foreground">Sarah Jenkins</p>
                        <p class="text-xs font-bold text-muted-foreground uppercase tracking-widest">Verified Patient
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Background texture overlay -->
        <div class="absolute inset-0 opacity-10 mix-blend-multiply pointer-events-none"
            style="background-image: url('https://images.unsplash.com/photo-1558591710-4b4a1ae0f04d?q=80&w=1200&auto=format&fit=crop')">
        </div>
    </div>

    <!-- Right Side: Registration Form -->
    <div class="flex-1 flex flex-col justify-center items-center p-6 lg:p-20 bg-background overflow-y-auto scroll-hide">
        <div class="w-full max-w-[540px]">
            <!-- Mobile Header -->
            <div class="flex lg:hidden items-center gap-3 mb-12 text-primary">
                <div
                    class="size-10 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined text-2xl">psychology</span>
                </div>
                <h2 class="text-2xl font-black tracking-tighter uppercase">MindTrack</h2>
            </div>

            <div class="mb-12">
                <h2 class="text-4xl font-black mb-3 tracking-tight text-foreground">Create Your Account</h2>
                <p class="text-lg text-muted-foreground font-bold">Join our community and start prioritizing your health
                    today.</p>
            </div>

            <!-- Progress Stepper -->
            <div class="mb-12 p-1">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-primary">Registration
                        Progress</span>
                    <span class="text-xs font-black text-foreground">50% Complete</span>
                </div>
                <div class="w-full h-3 bg-muted rounded-full overflow-hidden shadow-inner p-0.5">
                    <div class="h-full bg-primary rounded-full transition-all duration-700 shadow-sm"
                        style="width: 50%;"></div>
                </div>
            </div>

            <!-- Form section -->
            <?= featured('auth', 'components/signup-form') ?>

            <!-- Legal Footer -->
            <div
                class="mt-20 flex items-center justify-center flex-wrap gap-8 text-[11px] font-black uppercase tracking-[0.2em] text-muted-foreground/40">
                <a class="hover:text-primary transition-colors duration-300" href="#">Support</a>
                <a class="hover:text-primary transition-colors duration-300" href="#">Help Center</a>
                <a class="hover:text-primary transition-colors duration-300" href="#">Data Security</a>
            </div>
        </div>
    </div>
</div>