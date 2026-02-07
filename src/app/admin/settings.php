<?php
/**
 * Admin System Settings Page
 */
$pageTitle = "MindTrack Admin System Settings";

// Custom extra content for the header action buttons
ob_start(); ?>
<button
    class="px-4 py-2 text-sm font-semibold text-muted-foreground bg-card border border-border rounded-lg hover:bg-muted transition-colors">Discard</button>
<button
    class="px-4 py-2 text-sm font-semibold text-white bg-primary rounded-lg hover:bg-primary/90 shadow-lg shadow-primary/20 transition-all">Save
    Changes</button>
<?php
$extraHeaderContent = ob_get_clean();

$headerData = [
    'title' => 'System Settings',
    'description' => 'Manage clinic profile, operational rules, and security protocols.',
    'extraContent' => $extraHeaderContent,
    'mb' => 8
];

include_once __DIR__ . '/layout.php';
?>

<div class="space-y-6 w-full pb-12">
    <!-- 1. Clinic Profile -->
    <section class="bg-card rounded-xl border border-border shadow-sm overflow-hidden">
        <div class="p-6 border-b border-border/50 flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">domain</span>
            <h3 class="font-bold text-lg text-foreground">Clinic Profile</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2 flex items-center gap-6 pb-4">
                <div
                    class="size-24 rounded-xl bg-muted flex items-center justify-center relative group border-2 border-dashed border-border/50">
                    <img alt="Clinic Logo" class="w-full h-full rounded-xl object-cover"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuAFDDkoLvN5Qu70aTYMO1Xt65mv3Dw0YaOvwVftAJCE1XeOfKyrRvnk4W592FITNcVv644uFUq6hsN8zY9WhCNs0K6NcLPgX28ItxWThXsGnc3szqHXpaJM5vZH6GbJwEw0Ck3Q-J9PoZhK8VE-BG5SsPhvs8Mt7cRQ0DBW9-d_-b1cE-x3HzVQwikXx3vnLvRrZ1B-7nnfNF8F8Mzxa2Yb0EOJFOPfYzZ4yxEXElL-xDePpl3BsW_TEus64XqprdBAf_AmOE74rRY" />
                    <div
                        class="absolute inset-0 bg-black/40 rounded-xl opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity cursor-pointer">
                        <span class="material-symbols-outlined text-white">upload</span>
                    </div>
                </div>
                <div>
                    <h4 class="font-semibold text-foreground">Official Branding</h4>
                    <p class="text-xs text-muted-foreground mb-2">Logo will appear on invoices, patient reports, and the
                        portal.</p>
                    <button class="text-xs font-bold text-primary hover:underline">Update Logo</button>
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="text-sm font-medium text-foreground">Clinic Name</label>
                <input
                    class="w-full bg-muted/30 border border-border rounded-lg focus:ring-primary focus:border-primary text-sm px-4 py-2"
                    type="text" value="Wayside Psyche Resources Center" />
            </div>

            <div class="space-y-1.5">
                <label class="text-sm font-medium text-foreground">Contact Email</label>
                <input
                    class="w-full bg-muted/30 border border-border rounded-lg focus:ring-primary focus:border-primary text-sm px-4 py-2"
                    type="email" value="admin@waysidepsyche.org" />
            </div>

            <div class="space-y-1.5">
                <label class="text-sm font-medium text-foreground">Phone Number</label>
                <input
                    class="w-full bg-muted/30 border border-border rounded-lg focus:ring-primary focus:border-primary text-sm px-4 py-2"
                    type="text" value="+1 (555) 234-8901" />
            </div>

            <div class="space-y-1.5">
                <label class="text-sm font-medium text-foreground">Street Address</label>
                <input
                    class="w-full bg-muted/30 border border-border rounded-lg focus:ring-primary focus:border-primary text-sm px-4 py-2"
                    type="text" value="782 Wellness Way, Suite 400" />
            </div>
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- 2. Operational Rules -->
        <section class="bg-card rounded-xl border border-border shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-border/50 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">rule</span>
                <h3 class="font-bold text-lg text-foreground">Operational Rules</h3>
            </div>
            <div class="p-6 space-y-6 flex-1">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold uppercase tracking-wider text-muted-foreground">Lead Time
                            (Hours)</label>
                        <input class="w-full bg-muted/30 border border-border rounded-lg text-sm px-4 py-2"
                            type="number" value="24" />
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold uppercase tracking-wider text-muted-foreground">Daily Booking
                            Limit</label>
                        <input class="w-full bg-muted/30 border border-border rounded-lg text-sm px-4 py-2"
                            type="number" value="45" />
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="text-xs font-bold uppercase tracking-wider text-muted-foreground">Cancellation
                        Policy</label>
                    <textarea class="w-full bg-muted/30 border border-border rounded-lg text-sm px-4 py-2"
                        rows="3">Appointments cancelled within 24 hours of the scheduled time are subject to a 50% service fee.</textarea>
                </div>
                <div class="flex items-center justify-between py-2">
                    <div>
                        <p class="text-sm font-semibold text-foreground">Allow Walk-ins</p>
                        <p class="text-xs text-muted-foreground">Permit reception to book immediate slots</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div
                            class="w-9 h-5 bg-border peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary">
                        </div>
                    </label>
                </div>
            </div>
        </section>

        <!-- 3. Notification Settings -->
        <section class="bg-card rounded-xl border border-border shadow-sm overflow-hidden flex flex-col">
            <div class="p-6 border-b border-border/50 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">notifications_active</span>
                <h3 class="font-bold text-lg text-foreground">Notifications</h3>
            </div>
            <div class="p-6 space-y-4 flex-1">
                <div class="p-3 bg-muted/20 rounded-lg flex items-center justify-between border border-border/30">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-muted-foreground">mail</span>
                        <span class="text-sm font-medium text-foreground">Appointment Confirmation</span>
                    </div>
                    <button class="text-xs font-bold text-primary hover:underline">Edit Template</button>
                </div>
                <div class="p-3 bg-muted/20 rounded-lg flex items-center justify-between border border-border/30">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-muted-foreground">sms</span>
                        <span class="text-sm font-medium text-foreground">SMS Reminders (24h before)</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                        <input type="checkbox" class="sr-only peer" checked>
                        <div
                            class="w-9 h-5 bg-border peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary">
                        </div>
                    </label>
                </div>
                <div class="p-3 bg-muted/20 rounded-lg flex items-center justify-between border border-border/30">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-muted-foreground">campaign</span>
                        <span class="text-sm font-medium text-foreground">Clinical Follow-ups</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                        <input type="checkbox" class="sr-only peer">
                        <div
                            class="w-9 h-5 bg-border peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary">
                        </div>
                    </label>
                </div>
                <div class="pt-4">
                    <p class="text-[10px] font-bold text-muted-foreground uppercase tracking-widest mb-2">Automated
                        Triggers</p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2 py-1 bg-primary/10 text-primary text-[10px] font-bold rounded">New
                            Patient</span>
                        <span
                            class="px-2 py-1 bg-primary/10 text-primary text-[10px] font-bold rounded">Reschedule</span>
                        <span class="px-2 py-1 bg-primary/10 text-primary text-[10px] font-bold rounded">Survey
                            Send</span>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- 4. Security & Access -->
    <section class="bg-card rounded-xl border border-border shadow-sm overflow-hidden">
        <div class="p-6 border-b border-border/50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">security</span>
                <h3 class="font-bold text-lg text-foreground">Security & Access</h3>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-xs font-semibold text-muted-foreground">Enforce 2FA for all:</span>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div
                        class="w-11 h-6 bg-border peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-primary/50 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary">
                    </div>
                </label>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-muted/30 text-muted-foreground font-semibold border-b border-border">
                    <tr>
                        <th class="px-6 py-3">User</th>
                        <th class="px-6 py-3">Role</th>
                        <th class="px-6 py-3">Last Active</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border/50">
                    <tr>
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div
                                class="size-8 rounded bg-primary/10 text-primary flex items-center justify-center font-bold text-xs">
                                SJ</div>
                            <div>
                                <p class="font-semibold text-foreground">Sarah Jenkins</p>
                                <p class="text-[11px] text-muted-foreground">sarah.j@wayside.org</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 py-0.5 rounded text-[11px] font-bold bg-primary/10 text-primary">Admin</span>
                        </td>
                        <td class="px-6 py-4 text-muted-foreground">Just now</td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-muted-foreground hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-lg">edit</span>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div
                                class="size-8 rounded bg-blue-100 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400 flex items-center justify-center font-bold text-xs">
                                MK</div>
                            <div>
                                <p class="font-semibold text-foreground">Marcus Kren</p>
                                <p class="text-[11px] text-muted-foreground">m.kren@wayside.org</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 py-0.5 rounded text-[11px] font-bold bg-muted text-foreground">Staff</span>
                        </td>
                        <td class="px-6 py-4 text-muted-foreground">2 hours ago</td>
                        <td class="px-6 py-4 text-right">
                            <button class="text-muted-foreground hover:text-primary transition-colors">
                                <span class="material-symbols-outlined text-lg">edit</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-4 bg-muted/10 text-center border-t border-border">
            <button
                class="text-xs font-bold text-primary flex items-center justify-center gap-2 w-full hover:underline transition-all">
                <span class="material-symbols-outlined text-sm">add</span> Add New User
            </button>
        </div>
    </section>

    <!-- 5. Data Management -->
    <section class="bg-card rounded-xl border border-border shadow-sm overflow-hidden mb-12">
        <div class="p-6 border-b border-border/50 flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">database</span>
            <h3 class="font-bold text-lg text-foreground">Data Management</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h4 class="text-sm font-bold mb-1 text-foreground">Export Clinic Data</h4>
                <p class="text-xs text-muted-foreground mb-4">Generate a comprehensive portable archive of all clinic
                    records.</p>
                <div class="flex gap-2">
                    <button
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2 bg-muted hover:bg-muted/80 rounded-lg text-sm font-semibold text-foreground transition-colors">
                        <span class="material-symbols-outlined text-sm">description</span> CSV
                    </button>
                    <button
                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2 bg-muted hover:bg-muted/80 rounded-lg text-sm font-semibold text-foreground transition-colors">
                        <span class="material-symbols-outlined text-sm">picture_as_pdf</span> PDF
                    </button>
                </div>
            </div>
            <div class="p-4 bg-muted/10 rounded-xl border border-border/50 flex flex-col justify-center">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-muted-foreground uppercase tracking-widest">System Backup
                        Status</span>
                    <span
                        class="flex items-center gap-1 text-[10px] font-bold text-green-600 bg-green-50 dark:bg-green-900/20 px-2 py-0.5 rounded-full border border-green-200/50 dark:border-green-800/50">
                        <span class="size-1.5 rounded-full bg-green-600 animate-pulse"></span>
                        Healthy
                    </span>
                </div>
                <p class="text-lg font-bold leading-none text-foreground">Last Backup: 2 hours ago</p>
                <p class="text-[11px] text-muted-foreground mt-2">Automatic backups occur every 6 hours. Cloud storage
                    is 45% utilized.</p>
                <button class="mt-4 text-xs font-bold text-primary self-start hover:underline">View Backup History
                    →</button>
            </div>
        </div>
    </section>
</div>