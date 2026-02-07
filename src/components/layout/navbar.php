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
            <a class="text-sm font-semibold hover:text-primary transition-colors" href="<?= app(); ?>">Home</a>
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
            <!-- Theme Toggle -->
            <button id="theme-toggle"
                class="relative inline-flex h-9 w-9 items-center justify-center rounded-lg border border-border bg-background text-foreground hover:bg-accent transition-all">
                <span class="material-symbols-outlined dark:hidden text-[20px]">light_mode</span>
                <span class="material-symbols-outlined hidden dark:block text-[20px]">dark_mode</span>
            </button>

            <a href="<?= app('auth'); ?>"
                class="flex min-w-[100px] items-center justify-center rounded-lg h-9 px-6 border border-primary text-primary hover:bg-primary/5 text-sm font-bold transition-all">
                Login
            </a>
        </div>
    </div>
</header>

<script>
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
    }
</script>