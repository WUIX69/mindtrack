<?php
$pageTitle = "MindTrack - Start Your Journey";
$showNavbar = false;
$showFooter = false;

// Custom head content for the specific background/texture
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

include __DIR__ . '/../layout.php';
?>

<div class="flex flex-col lg:flex-row min-h-screen w-full overflow-hidden">
    <!-- Left Side: Calming Aesthetic Hero -->
    <div class="relative hidden lg:flex lg:w-[40%] flex-col justify-between p-12 bg-primary/10 overflow-hidden">
        <!-- Decorative Background Element -->
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary/20 rounded-full blur-3xl text-primary"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-blue-300/20 rounded-full blur-3xl text-blue-500"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-12">
                <div class="size-10 bg-primary rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-2xl">psychology</span>
                </div>
                <h2 class="text-2xl font-bold tracking-tight text-base-content">MindTrack</h2>
            </div>
            <div class="space-y-6">
                <h1 class="text-5xl font-extrabold leading-[1.1] text-primary">
                    Begin your path <br />to clarity.
                </h1>
                <p class="text-lg text-base-content/70 max-w-sm leading-relaxed">
                    MindTrack helps you monitor your mental well-being with professional tools and compassionate care.
                </p>
            </div>
        </div>
        <div class="relative z-10">
            <div class="bg-base-100/80 backdrop-blur-md p-6 rounded-xl border border-base-content/10 shadow-sm">
                <div class="flex gap-1 text-primary mb-3">
                    <span class="material-symbols-outlined fill-1">star</span>
                    <span class="material-symbols-outlined fill-1">star</span>
                    <span class="material-symbols-outlined fill-1">star</span>
                    <span class="material-symbols-outlined fill-1">star</span>
                    <span class="material-symbols-outlined fill-1">star</span>
                </div>
                <p class="italic text-base-content mb-4">
                    "This platform completely changed how I track my moods. The insights are incredibly helpful."
                </p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-base-300 bg-cover bg-center"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDhL03HClg9KpUWNo_UXaSKlpkMUhYYHkltjsMkCOfbozi0hI3H-rltTDtZypH1Et0umfbCJfHa6EbfmhXYPAgPGLQ1rRGFtHYE37WKK0v-kXT76nLrf3utICi1rRAZe0wHfU99-AkuXX3dnrks51tZBUqTwp1UaFG1jR5fDoE8W_S99LkB7ksafruj3hkg2431L_Gn1GpIE0hYREHbVU7scE5rSer2dK8pmRwv69rI3-rO2HcadljKAonJvZp1DvfGayhlnRuos3E')">
                    </div>
                    <div>
                        <p class="text-sm font-bold">Sarah Jenkins</p>
                        <p class="text-xs text-base-content/60">Verified Patient</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Background Image Overlay for Texture -->
        <div class="absolute inset-0 opacity-10 pointer-events-none"
            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuC24LLGZQ51yElONqbvn0FVIbW2ZlMhqAidKfZX4MQbcmmPMD9buZjynjUxTr9Pfog-Gskr8vhpPMVssor4ECbCemJiZV5MxuQpa2k8YY1EPahGJV8r4fWywEKKjetboMqXeFgFWs840qa2Lpjkj18aFKFa1d96PELB3LNiTlhqqe4LkCr7IAfDESNxW9XnkYaDDDQ6gutH14x6XLDMS6Cz8BxpixDxB02g5P-zu0mIDM6qr0YRhOmSMvRhNWNkDBjf9cXcHQjMBOA')">
        </div>
    </div>
    <!-- Right Side: Registration Form -->
    <div class="flex-1 flex flex-col justify-center items-center p-6 lg:p-20 bg-base-100 overflow-y-auto scroll-hide">
        <div class="w-full max-w-[520px]">
            <!-- Mobile Header Only -->
            <div class="flex lg:hidden items-center gap-2 mb-8">
                <div class="size-8 bg-primary rounded-lg flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-lg">psychology</span>
                </div>
                <h2 class="text-xl font-bold tracking-tight text-base-content">MindTrack</h2>
            </div>
            <div class="mb-10">
                <h2 class="text-3xl font-bold mb-2">Create Your Account</h2>
                <p class="text-base-content/70">Join our community and start prioritizing your health today.</p>
            </div>
            <!-- Progress Stepper -->
            <div class="mb-10">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-semibold text-primary">Registration Progress</span>
                    <span class="text-sm font-medium">50% Complete</span>
                </div>
                <div class="w-full h-2 bg-base-200 rounded-full overflow-hidden">
                    <div class="h-full bg-primary rounded-full transition-all duration-500" style="width: 50%;"></div>
                </div>
            </div>
            <!-- Multi-step Form Content -->
            <form class="space-y-8" action="#" method="POST">
                <!-- Section 1: Personal Details -->
                <div class="space-y-6">
                    <div class="flex items-center gap-2 border-b border-base-content/10 pb-2">
                        <span class="material-symbols-outlined text-primary">person</span>
                        <h3 class="text-lg font-bold">Personal Details</h3>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div class="form-control w-full">
                            <label class="label p-0 mb-2">
                                <span class="label-text font-medium text-base-content/80">Full Name</span>
                            </label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-base-content/40 text-xl">badge</span>
                                <input class="input input-bordered w-full pl-12 focus:input-primary h-12"
                                    placeholder="Enter your full name" type="text" name="name" required />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="form-control w-full">
                                <label class="label p-0 mb-2">
                                    <span class="label-text font-medium text-base-content/80">Email Address</span>
                                </label>
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-base-content/40 text-xl">mail</span>
                                    <input class="input input-bordered w-full pl-12 focus:input-primary h-12"
                                        placeholder="name@example.com" type="email" name="email" required />
                                </div>
                            </div>
                            <div class="form-control w-full">
                                <label class="label p-0 mb-2">
                                    <span class="label-text font-medium text-base-content/80">Phone Number</span>
                                </label>
                                <div class="relative">
                                    <span
                                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-base-content/40 text-xl">call</span>
                                    <input class="input input-bordered w-full pl-12 focus:input-primary h-12"
                                        placeholder="+1 (555) 000-0000" type="tel" name="phone" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Section 2: Security -->
                <div class="space-y-6 pt-4">
                    <div class="flex items-center gap-2 border-b border-base-content/10 pb-2">
                        <span class="material-symbols-outlined text-primary">security</span>
                        <h3 class="text-lg font-bold">Security</h3>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div class="form-control w-full">
                            <label class="label p-0 mb-2">
                                <span class="label-text font-medium text-base-content/80">Create Password</span>
                            </label>
                            <div class="relative flex items-center">
                                <span
                                    class="material-symbols-outlined absolute left-4 text-base-content/40 text-xl">lock</span>
                                <input class="input input-bordered w-full pl-12 pr-12 focus:input-primary h-12"
                                    placeholder="••••••••" type="password" name="password" required />
                                <button
                                    class="absolute right-4 text-base-content/40 hover:text-primary transition-colors"
                                    type="button">
                                    <span class="material-symbols-outlined text-xl">visibility</span>
                                </button>
                            </div>
                            <!-- Password Strength Indicator -->
                            <div class="mt-2 space-y-2">
                                <div class="flex gap-1 h-1.5 w-full">
                                    <div class="flex-1 bg-success rounded-full"></div>
                                    <div class="flex-1 bg-success rounded-full"></div>
                                    <div class="flex-1 bg-success rounded-full"></div>
                                    <div class="flex-1 bg-base-200 rounded-full"></div>
                                </div>
                                <ul class="text-xs space-y-1 text-base-content/60 grid grid-cols-2">
                                    <li class="flex items-center gap-1.5 text-success">
                                        <span class="material-symbols-outlined text-sm font-bold">check_circle</span> 8+
                                        characters
                                    </li>
                                    <li class="flex items-center gap-1.5 text-success">
                                        <span class="material-symbols-outlined text-sm font-bold">check_circle</span>
                                        Uppercase letter
                                    </li>
                                    <li class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-sm">circle</span> One number
                                    </li>
                                    <li class="flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-sm">circle</span> Special symbol
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-control w-full">
                            <label class="label p-0 mb-2">
                                <span class="label-text font-medium text-base-content/80">Confirm Password</span>
                            </label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-base-content/40 text-xl">lock_reset</span>
                                <input
                                    class="input input-bordered input-success w-full pl-12 pr-12 focus:input-primary h-12"
                                    placeholder="••••••••" type="password" name="confirm_password" required />
                                <span
                                    class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-success text-xl">check_circle</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Terms and Conditions -->
                <div class="form-control p-0">
                    <label class="flex items-start gap-3 py-2 cursor-pointer group">
                        <input class="checkbox checkbox-primary checkbox-sm mt-1" id="terms" type="checkbox" required />
                        <span class="text-sm text-base-content/70 group-hover:text-base-content transition-colors">
                            I agree to the <a class="text-primary hover:underline font-semibold" href="#">Terms of
                                Service</a> and <a class="text-primary hover:underline font-semibold" href="#">Privacy
                                Policy</a>.
                        </span>
                    </label>
                </div>
                <!-- CTA Actions -->
                <div class="flex flex-col gap-4 pt-4">
                    <button
                        class="btn btn-primary w-full h-14 text-white font-bold shadow-lg shadow-primary/20 rounded-xl"
                        type="submit">
                        <span>Start Your Journey</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                    <p class="text-center text-sm text-base-content/70">
                        Already have an account?
                        <a class="text-primary font-bold hover:underline" href="index.php">Sign In</a>
                    </p>
                </div>
            </form>
            <!-- Footer Links -->
            <div class="mt-12 flex items-center justify-center gap-6 text-xs text-base-content/40">
                <a class="hover:text-primary transition-colors" href="#">Support</a>
                <a class="hover:text-primary transition-colors" href="#">Help Center</a>
                <a class="hover:text-primary transition-colors" href="#">Data Security</a>
            </div>
        </div>
    </div>
</div>