<!-- Header / Navigation -->
<header class="sticky top-0 z-50 w-full border-b border-border bg-background/80 backdrop-blur-md">
    <div class="max-w-[1200px] mx-auto px-6 h-16 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center size-10 rounded-lg bg-primary text-primary-foreground">
                <span class="material-symbols-outlined text-2xl text-white">neurology</span>
            </div>
            <h2 class="text-xl font-bold leading-tight tracking-tight">MindTrack</h2>
        </div>
        <nav class="hidden md:flex items-center gap-10">
            <a class="text-sm font-semibold hover:text-primary transition-colors" href="<?= app('landing'); ?>">Home</a>
            <a class="text-sm font-semibold hover:text-primary transition-colors"
                href="<?= app('landing/about'); ?>">About</a>
            <a class="text-sm font-semibold hover:text-primary transition-colors"
                href="<?= app('landing/services'); ?>">Services</a>
            <a class="text-sm font-semibold hover:text-primary transition-colors"
                href="<?= app('landing/resources'); ?>">Resources</a>
            <a class="text-sm font-semibold hover:text-primary transition-colors"
                href="<?= app('landing/contact'); ?>">Contact</a>
        </nav>
        <div class="flex items-center gap-4">
            <!-- Theme Toggle Switch -->
            <!-- Theme Toggle Switch (DaisyUI) -->
            <label class="swap swap-rotate btn btn-ghost btn-circle hover:bg-muted/50">
                <!-- this hidden checkbox controls the state -->
                <input type="checkbox" id="theme-toggle" />

                <!-- sun icon (shows when checked/dark mode - click to switch to light) -->
                <span class="swap-on material-symbols-outlined text-orange-400 text-xl">light_mode</span>

                <!-- moon icon (shows when unchecked/light mode - click to switch to dark) -->
                <span class="swap-off material-symbols-outlined text-blue-400 text-xl">dark_mode</span>
            </label>

            <a href="<?= app('auth'); ?>"
                class="flex min-w-[100px] items-center justify-center rounded-lg h-9 px-6 border border-primary text-primary hover:bg-primary/5 text-sm font-bold transition-all">
                Login
            </a>
        </div>
    </div>
</header>