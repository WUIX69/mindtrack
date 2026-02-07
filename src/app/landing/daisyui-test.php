<?php
/**
 * DaisyUI Component Test Page
 * This page demonstrates various DaisyUI components to verify installation
 */
$pageTitle = "DaisyUI Test Page - MindTrack";
include __DIR__ . '/../layout.php';
?>

<!-- Hero Section -->
<section class="relative px-6 py-16 md:py-20 bg-card border-b border-border">
    <div class="max-w-[1200px] mx-auto text-center">
        <span class="inline-flex items-center px-4 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-bold tracking-widest uppercase mb-6">
            Component Library
        </span>
        <h1 class="text-4xl md:text-6xl font-extrabold leading-[1.1] tracking-tight text-foreground mb-6">
            DaisyUI Component Test
        </h1>
        <p class="text-xl text-muted-foreground max-w-2xl mx-auto">
            Testing DaisyUI v5.5.18 integration with TailwindCSS v4
        </p>
    </div>
</section>

<!-- Main Content -->
<section class="py-16 bg-background">
    <div class="max-w-[1200px] mx-auto px-6">
        
        <!-- Buttons Section -->
        <div class="card bg-card shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4 text-card-foreground">Buttons</h2>
            <div class="flex flex-wrap gap-2">
                <button class="btn">Default</button>
                <button class="btn btn-primary">Primary</button>
                <button class="btn btn-secondary">Secondary</button>
                <button class="btn btn-accent">Accent</button>
                <button class="btn btn-success">Success</button>
                <button class="btn btn-warning">Warning</button>
                <button class="btn btn-error">Error</button>
                <button class="btn btn-ghost">Ghost</button>
                <button class="btn btn-link">Link</button>
            </div>
            <div class="flex flex-wrap gap-2 mt-4">
                <button class="btn btn-sm">Small</button>
                <button class="btn">Normal</button>
                <button class="btn btn-lg">Large</button>
                <button class="btn btn-wide">Wide</button>
                <button class="btn btn-block">Block</button>
            </div>
        </div>

        <!-- Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="card bg-card shadow-xl">
                <div class="card-body">
                    <h3 class="card-title text-card-foreground">Card Title</h3>
                    <p class="text-muted-foreground">This is a basic DaisyUI card component with custom theme colors.</p>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary">Action</button>
                    </div>
                </div>
            </div>

            <div class="card bg-card shadow-xl">
                <figure class="px-6 pt-6">
                    <div class="bg-primary/10 h-32 w-full rounded-lg flex items-center justify-center">
                        <span class="text-primary text-4xl">📊</span>
                    </div>
                </figure>
                <div class="card-body">
                    <h3 class="card-title text-card-foreground">Card with Figure</h3>
                    <p class="text-muted-foreground">A card with an image/figure section.</p>
                </div>
            </div>
        </div>

        <!-- Forms Section -->
        <div class="card bg-card shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4 text-card-foreground">Form Controls</h2>
            <div class="space-y-4">
                <div class="form-control w-full max-w-xs">
                    <label class="label">
                        <span class="label-text">Text Input</span>
                    </label>
                    <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
                </div>

                <div class="form-control w-full max-w-xs">
                    <label class="label">
                        <span class="label-text">Select Dropdown</span>
                    </label>
                    <select class="select select-bordered">
                        <option disabled selected>Pick one</option>
                        <option>Option 1</option>
                        <option>Option 2</option>
                    </select>
                </div>

                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-3 w-fit">
                        <span class="label-text">Toggle Switch</span> 
                        <input type="checkbox" class="toggle toggle-primary" checked />
                    </label>
                </div>

                <div class="form-control">
                    <label class="label cursor-pointer justify-start gap-3 w-fit">
                        <span class="label-text">Checkbox</span> 
                        <input type="checkbox" class="checkbox checkbox-primary" checked />
                    </label>
                </div>

                <div class="form-control">
                    <label class="label">
                        <span class="label-text">Radio Buttons</span>
                    </label>
                    <div class="flex gap-4">
                        <label class="label cursor-pointer gap-2">
                            <input type="radio" name="radio-test" class="radio radio-primary" checked />
                            <span class="label-text">Option 1</span>
                        </label>
                        <label class="label cursor-pointer gap-2">
                            <input type="radio" name="radio-test" class="radio radio-primary" />
                            <span class="label-text">Option 2</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts Section -->
        <div class="card bg-card shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4 text-card-foreground">Alerts</h2>
            <div class="space-y-3">
                <div class="alert alert-info">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Info: DaisyUI components are working correctly!</span>
                </div>
                
                <div class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>Success: Your configuration is correct!</span>
                </div>
                
                <div class="alert alert-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    <span>Warning: Remember to test in both light and dark modes!</span>
                </div>

                <div class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>Error: This is just a demo alert.</span>
                </div>
            </div>
        </div>

        <!-- Badges Section -->
        <div class="card bg-card shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4 text-card-foreground">Badges</h2>
            <div class="flex flex-wrap gap-2">
                <span class="badge">Default</span>
                <span class="badge badge-primary">Primary</span>
                <span class="badge badge-secondary">Secondary</span>
                <span class="badge badge-accent">Accent</span>
                <span class="badge badge-success">Success</span>
                <span class="badge badge-warning">Warning</span>
                <span class="badge badge-error">Error</span>
                <span class="badge badge-ghost">Ghost</span>
                <span class="badge badge-outline">Outline</span>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="card bg-card shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4 text-card-foreground">Stats</h2>
            <div class="stats shadow">
                <div class="stat">
                    <div class="stat-title">Total Patients</div>
                    <div class="stat-value text-primary">1,234</div>
                    <div class="stat-desc">21% more than last month</div>
                </div>
                
                <div class="stat">
                    <div class="stat-title">Appointments</div>
                    <div class="stat-value text-secondary">567</div>
                    <div class="stat-desc">This month</div>
                </div>
                
                <div class="stat">
                    <div class="stat-title">Active Users</div>
                    <div class="stat-value">89</div>
                    <div class="stat-desc">Online now</div>
                </div>
            </div>
        </div>

        <!-- Loading States -->
        <div class="card bg-card shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold mb-4 text-card-foreground">Loading & Progress</h2>
            <div class="flex flex-col gap-4">
                <div class="flex gap-2">
                    <span class="loading loading-spinner loading-xs"></span>
                    <span class="loading loading-spinner loading-sm"></span>
                    <span class="loading loading-spinner loading-md"></span>
                    <span class="loading loading-spinner loading-lg"></span>
                </div>
                <progress class="progress w-56"></progress>
                <progress class="progress progress-primary w-56" value="40" max="100"></progress>
                <progress class="progress progress-success w-56" value="70" max="100"></progress>
            </div>
        </div>

        <!-- Dark Mode Toggle -->
        <div class="card bg-card shadow-lg p-6">
            <h2 class="text-2xl font-semibold mb-4 text-card-foreground">Dark Mode Test</h2>
            <p class="text-muted-foreground mb-4">Toggle dark mode using the theme switcher in the navbar to test DaisyUI components in both themes.</p>
            <div class="alert alert-info">
                <span>DaisyUI themes are disabled. Components use custom CSS variables from global.css for theming.</span>
            </div>
        </div>

    </div>
</section>

<script>
    console.log('DaisyUI Test Page Loaded');
    console.log('DaisyUI Version: 5.5.18');
    console.log('TailwindCSS Version: 4.1.18');
</script>