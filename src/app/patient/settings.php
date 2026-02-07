<?php
/**
 * Patient Account Settings Page
 */

$pageTitle = "Account Settings";
$bodyClass = "bg-muted/50 dark:bg-background text-foreground font-display transition-colors duration-200";
// Set current page for sidebar highlighting
$headerData = [
    'title' => 'Account Settings',
    'description' => 'Manage your personal information, security, and notification preferences.'
];
$currentPage = 'settings';

include __DIR__ . '/layout.php';
?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-10">
    <div class="lg:col-span-2 space-y-8">
        <!-- Profile Information Section -->
        <section class="bg-card dark:bg-card rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-border">
                <h3 class="font-bold text-lg">Profile Information</h3>
            </div>
            <div class="p-6">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="flex flex-col items-center gap-4">
                        <div class="relative group">
                            <div class="w-32 h-32 rounded-full bg-cover bg-center border-4 border-background dark:border-border shadow-md"
                                style="background-image: url('https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?q=80&w=200&auto=format&fit=crop')">
                            </div>
                            <button
                                class="absolute bottom-0 right-0 bg-primary text-primary-foreground p-2 rounded-full shadow-lg hover:scale-105 active:scale-95 transition-all">
                                <span class="material-symbols-outlined text-sm">photo_camera</span>
                            </button>
                        </div>
                        <p class="text-xs text-muted-foreground font-medium text-center">Update your profile photo</p>
                    </div>
                    <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-bold text-foreground mb-1">Full Name</label>
                            <input
                                class="w-full px-4 py-2 bg-muted/30 dark:bg-muted/10 border border-border rounded-lg text-sm focus:ring-primary focus:border-primary transition-all font-medium"
                                type="text" value="Alex Henderson" />
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-bold text-foreground mb-1">Email Address</label>
                            <input
                                class="w-full px-4 py-2 bg-muted/30 dark:bg-muted/10 border border-border rounded-lg text-sm focus:ring-primary focus:border-primary transition-all font-medium"
                                type="email" value="alex.henderson@email.com" />
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-bold text-foreground mb-1">Phone Number</label>
                            <input
                                class="w-full px-4 py-2 bg-muted/30 dark:bg-muted/10 border border-border rounded-lg text-sm focus:ring-primary focus:border-primary transition-all font-medium"
                                type="tel" value="+1 (555) 123-4567" />
                        </div>
                    </div>
                </div>
                <div class="mt-8 flex justify-end">
                    <button
                        class="bg-primary hover:bg-primary/90 text-primary-foreground px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md shadow-primary/20">
                        Save Changes
                    </button>
                </div>
            </div>
        </section>

        <!-- Security Section -->
        <section class="bg-card dark:bg-card rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-border flex items-center gap-2">
                <h3 class="font-bold text-lg">Security</h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <p class="font-bold text-sm">Change Password</p>
                        <p class="text-xs text-muted-foreground font-medium">Update your account password regularly to
                            stay
                            secure.</p>
                    </div>
                    <button
                        class="px-4 py-2 text-primary font-bold text-sm border border-primary/20 rounded-lg hover:bg-primary/5 transition-colors">
                        Update Password
                    </button>
                </div>
                <div
                    class="pt-6 border-t border-border flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <p class="font-bold text-sm">Two-Factor Authentication</p>
                        <p class="text-xs text-muted-foreground font-medium">Add an extra layer of security to your
                            account.
                        </p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer" checked>
                        <div
                            class="w-11 h-6 bg-muted/50 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                        </div>
                    </label>
                </div>
            </div>
        </section>

        <!-- Notification Preferences Section -->
        <section class="bg-card dark:bg-card rounded-xl border border-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-border">
                <h3 class="font-bold text-lg">Notification Preferences</h3>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <!-- Email Reminders -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-muted-foreground">mail</span>
                            <div>
                                <p class="font-bold text-sm">Email Reminders</p>
                                <p class="text-xs text-muted-foreground font-medium">Receive reminders for upcoming
                                    appointments via email.</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" checked>
                            <div
                                class="w-11 h-6 bg-muted/50 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                            </div>
                        </label>
                    </div>

                    <!-- SMS Alerts -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-muted-foreground">sms</span>
                            <div>
                                <p class="font-bold text-sm">SMS Alerts</p>
                                <p class="text-xs text-muted-foreground font-medium">Get text message notifications for
                                    immediate updates.</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer">
                            <div
                                class="w-11 h-6 bg-muted/50 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                            </div>
                        </label>
                    </div>

                    <!-- Newsletter Subscription -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-muted-foreground">newspaper</span>
                            <div>
                                <p class="font-bold text-sm">Newsletter Subscription</p>
                                <p class="text-xs text-muted-foreground font-medium">Stay informed with mental health
                                    tips
                                    and clinic updates.</p>
                            </div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" value="" class="sr-only peer" checked>
                            <div
                                class="w-11 h-6 bg-muted/50 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dangerous Zone Section -->
        <section
            class="bg-red-50/50 dark:bg-red-900/10 rounded-xl border border-red-100 dark:border-red-900/30 shadow-sm overflow-hidden">
            <div class="p-6 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="font-bold text-red-700 dark:text-red-400 text-lg">Deactivate Account</h3>
                    <p class="text-xs text-red-600 dark:text-red-300/70 font-medium">Permanently delete your account and
                        all
                        associated health records. This action is irreversible.</p>
                </div>
                <button
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-lg font-bold text-sm transition-all shadow-md shadow-red-600/20 whitespace-nowrap">
                    Delete Account
                </button>
            </div>
        </section>
    </div>

    <!-- Decorative Sidebar Image -->
    <div class="hidden lg:block space-y-6">
        <div class="relative h-full min-h-[600px] rounded-2xl overflow-hidden border border-border group shadow-lg">
            <img src="https://images.unsplash.com/photo-1506126613408-eca07ce68773?q=80&w=1000&auto=format&fit=crop"
                alt="Mindfulness"
                class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
            <div class="absolute bottom-0 left-0 p-8 text-white">
                <div
                    class="mb-4 inline-flex items-center justify-center w-12 h-12 rounded-xl bg-white/20 backdrop-blur-md border border-white/30">
                    <span class="material-symbols-outlined text-white">self_improvement</span>
                </div>
                <h3 class="text-2xl font-black mb-2 leading-tight tracking-tight">Focus on Your Well-being</h3>
                <p class="text-white/80 text-sm font-medium leading-relaxed">
                    Take a moment to breathe and reflect. Your mental health journey is our priority.
                </p>
                <div class="mt-8 pt-6 border-t border-white/20">
                    <p class="text-[10px] uppercase tracking-[0.2em] font-black text-white/50 mb-4 text-center">Quote of
                        the Day</p>
                    <p class="text-base font-medium italic text-center leading-relaxed">
                        "Your mental health is a priority. Your happiness is an essential. Your self-care is a
                        necessity."
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>