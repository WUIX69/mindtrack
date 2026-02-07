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
            <button id="theme-toggle"
                class="group relative inline-flex h-7 w-12 flex-shrink-0 cursor-pointer items-center rounded-full bg-muted px-1 transition-all duration-300 ease-in-out hover:ring-2 hover:ring-primary/20 focus:outline-none dark:bg-primary/20">
                <span class="sr-only">Toggle theme</span>
                <div
                    class="pointer-events-none flex h-5 w-5 transform items-center justify-center rounded-full bg-background shadow-md transition duration-300 ease-in-out translate-x-0 dark:translate-x-5 group-active:scale-90">
                    <span class="material-symbols-outlined text-[14px] text-orange-400 dark:hidden">light_mode</span>
                    <span class="material-symbols-outlined text-[14px] text-blue-400 hidden dark:block">dark_mode</span>
                </div>
            </button>

            <a href="<?= app('auth'); ?>"
                class="flex min-w-[100px] items-center justify-center rounded-lg h-9 px-6 border border-primary text-primary hover:bg-primary/5 text-sm font-bold transition-all">
                Login
            </a>
        </div>
    </div>
</header>