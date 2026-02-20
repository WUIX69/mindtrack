<?php
/**
 * MindTrack - Email Verification Page
 */

require_once dirname(__DIR__, 2) . '/core/app.php';

use Mindtrack\Server\Db\Users;

$pageTitle = "MindTrack - Email Verification";
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

$uuid = $_GET['uuid'] ?? null;
$verified = false;
$message = "No token provided.";

if ($uuid) {
    $result = Users::verifyEmail($uuid);
    $verified = $result['success'];
    $message = $result['message'];
}

include __DIR__ . '/layout.php';
?>

<div class="flex flex-col lg:flex-row min-h-screen w-full overflow-hidden">
    <!-- Left Side: Aesthetic Cover (Matched with Signup/SignIn themes) -->
    <div
        class="relative hidden lg:flex lg:w-[40%] flex-col justify-between p-12 bg-primary/10 dark:bg-primary/5 overflow-hidden">
        <div class="absolute -top-24 -left-24 w-[24rem] h-[24rem] bg-primary/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-blue-300/20 dark:bg-blue-900/10 rounded-full blur-3xl"></div>

        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-12">
                <div class="size-10 bg-primary rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-2xl">psychology</span>
                </div>
                <h2 class="text-2xl font-bold tracking-tight text-foreground">MindTrack</h2>
            </div>
            <div class="space-y-6">
                <h1 class="text-5xl font-extrabold leading-[1.1] text-primary">
                    Begin your path <br />to clarity.
                </h1>
                <p class="text-lg text-muted-foreground max-w-sm leading-relaxed">
                    MindTrack helps you monitor your mental well-being with professional tools and compassionate care.
                </p>
            </div>
        </div>

        <div class="relative z-10">
            <div class="bg-card/80 dark:bg-card/50 backdrop-blur-md p-6 rounded-2xl border border-border shadow-sm">
                <div class="flex gap-1 text-primary mb-3">
                    <span class="material-symbols-outlined fill-1">star</span>
                    <span class="material-symbols-outlined fill-1">star</span>
                    <span class="material-symbols-outlined fill-1">star</span>
                    <span class="material-symbols-outlined fill-1">star</span>
                    <span class="material-symbols-outlined fill-1">star</span>
                </div>
                <p class="italic text-foreground mb-4">
                    "This platform completely changed how I track my moods. The insights are incredibly helpful."
                </p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-cover bg-center bg-gray-200"
                        style="background-image: url('https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=200&auto=format&fit=crop');">
                    </div>
                    <div>
                        <p class="text-sm font-bold text-foreground">Sarah Jenkins</p>
                        <p class="text-xs text-muted-foreground uppercase tracking-wider">Verified Patient</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute inset-0 opacity-10 pointer-events-none mix-blend-multiply"
            style="background-image: url('https://images.unsplash.com/photo-1558591710-4b4a1ae0f04d?q=80&w=1200&auto=format&fit=crop'); background-size: cover;">
        </div>
    </div>

    <!-- Right Side: Verification Status -->
    <div class="flex-1 flex flex-col justify-center items-center p-6 lg:p-20 bg-background overflow-y-auto scroll-hide">
        <div class="w-full max-w-[520px] flex flex-col items-center text-center">

            <div class="flex lg:hidden items-center gap-2 mb-12 self-start">
                <div class="size-8 bg-primary rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-lg">psychology</span>
                </div>
                <h2 class="text-xl font-bold tracking-tight text-foreground">MindTrack</h2>
            </div>

            <?php if ($verified): ?>
                <!-- Success State -->
                <div class="relative mb-8">
                    <div class="size-24 bg-primary/10 rounded-full flex items-center justify-center">
                        <div
                            class="size-16 bg-primary rounded-full flex items-center justify-center shadow-lg shadow-primary/30">
                            <span class="material-symbols-outlined text-white text-4xl font-bold">check</span>
                        </div>
                    </div>
                    <div class="absolute -top-2 -right-2 size-6 bg-blue-400/20 rounded-full blur-sm"></div>
                </div>

                <div class="mb-10 space-y-4">
                    <h2 class="text-3xl font-extrabold text-foreground tracking-tight">Email Verified Successfully!</h2>
                    <p class="text-muted-foreground text-lg leading-relaxed px-4">
                        Your account has been verified. You can now access your personalized wellness dashboard and start
                        your journey with Wayside Psyche Resources Center.
                    </p>
                </div>

                <div class="w-full space-y-6">
                    <a class="block w-full bg-primary hover:bg-primary/90 hover:scale-[1.02] active:scale-[0.98] text-white font-bold py-4 px-8 rounded-2xl shadow-lg shadow-primary/25 transition-all flex items-center justify-center gap-2 group"
                        href="<?= app('auth/index') ?>">
                        <span>Go to Signin</span>
                        <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">login</span>
                    </a>
                </div>

            <?php else: ?>
                <!-- Error State -->
                <div class="relative mb-8">
                    <div class="size-24 bg-destructive/10 rounded-full flex items-center justify-center">
                        <div
                            class="size-16 bg-destructive rounded-full flex items-center justify-center shadow-lg shadow-destructive/30">
                            <span class="material-symbols-outlined text-white text-4xl font-bold">close</span>
                        </div>
                    </div>
                    <div class="absolute -top-2 -right-2 size-6 bg-red-400/20 rounded-full blur-sm"></div>
                </div>

                <div class="mb-10 space-y-4">
                    <h2 class="text-3xl font-extrabold text-foreground tracking-tight">Verification Failed</h2>
                    <p class="text-muted-foreground text-lg leading-relaxed px-4">
                        <?= htmlspecialchars($message) ?>
                    </p>
                </div>

                <div class="w-full space-y-6">
                    <a class="block w-full bg-muted hover:bg-muted/80 text-foreground font-bold py-4 px-8 rounded-2xl transition-all flex items-center justify-center gap-2 group"
                        href="<?= app('auth/index') ?>">
                        <span
                            class="material-symbols-outlined transition-transform group-hover:-translate-x-1">arrow_back</span>
                        <span>Return to Sign In</span>
                    </a>
                </div>
            <?php endif; ?>

            <div class="flex flex-col gap-4 mt-8">
                <a class="text-sm font-medium text-muted-foreground hover:text-primary transition-colors" href="#">
                    Need help? <span class="underline underline-offset-4 decoration-primary/30">Contact Support</span>
                </a>
            </div>

            <!-- Legal Footer -->
            <div
                class="mt-20 flex items-center justify-center gap-8 text-xs font-medium text-muted-foreground/60 uppercase tracking-widest">
                <a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <a class="hover:text-primary transition-colors" href="#">Terms of Use</a>
                <a class="hover:text-primary transition-colors" href="#">Help Center</a>
            </div>
        </div>
    </div>
</div>