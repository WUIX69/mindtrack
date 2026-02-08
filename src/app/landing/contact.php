<?php
/**
 * Contact Us Page
 */
$pageTitle = "Contact Us - MindTrack | Wayside Psyche Resources Center";
$headContent = '
<style>
.contact-form-input { @apply w-full px-5 py-4 rounded-xl border border-border bg-card text-foreground placeholder:text-muted-foreground/60 focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none; }
.contact-form-input:focus { box-shadow: 0 0 0 3px rgba(var(--primary),0.1); }
</style>';
include_once __DIR__ . '/layout.php';
?>

<!-- Hero Section -->
<section class="relative px-6 py-16 md:py-20 bg-card border-b border-border overflow-hidden">
    <div class="max-w-[1200px] mx-auto text-center relative z-10">
        <span
            class="inline-flex items-center px-4 py-1.5 rounded-full bg-primary/10 text-primary text-xs font-bold tracking-widest uppercase mb-6">Get
            In Touch</span>
        <h1 class="text-4xl md:text-6xl font-extrabold leading-[1.1] tracking-tight text-foreground mb-6">We'd Love to
            Hear From You</h1>
        <p class="text-xl text-muted-foreground max-w-2xl mx-auto">Have questions about MindTrack or the Wayside Psyche
            Resources Center? Reach out, and we'll get back to you soon.</p>
    </div>
</section>

<!-- Contact Content -->
<section class="py-16 md:py-20 bg-background">
    <div class="max-w-[1200px] mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16">
        <!-- Contact Info -->
        <div class="flex flex-col gap-8">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-foreground mb-4">Contact Information</h2>
                <p class="text-muted-foreground">Reach out via any of the following channels. Our support team is
                    available Monday–Saturday, 8:00 AM to 6:00 PM.</p>
            </div>
            <div class="space-y-6">
                <div class="flex items-start gap-5 p-5 rounded-2xl bg-card border border-border">
                    <div
                        class="size-14 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-2xl">location_on</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-foreground mb-1">Address</h4>
                        <p class="text-sm text-muted-foreground">Wayside Psyche Resources Center<br>456 Serenity Lane,
                            Metropolis, MP 12345</p>
                    </div>
                </div>
                <div class="flex items-start gap-5 p-5 rounded-2xl bg-card border border-border">
                    <div
                        class="size-14 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-2xl">call</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-foreground mb-1">Phone</h4>
                        <p class="text-sm text-muted-foreground">(123) 456-7890<br>Fax: (123) 456-7891</p>
                    </div>
                </div>
                <div class="flex items-start gap-5 p-5 rounded-2xl bg-card border border-border">
                    <div
                        class="size-14 rounded-xl bg-primary/10 text-primary flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-2xl">mail</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-foreground mb-1">Email</h4>
                        <p class="text-sm text-muted-foreground">hello@waysidepsyche.com<br>support@mindtrack.app</p>
                    </div>
                </div>
            </div>
            <!-- Map -->
            <div
                class="rounded-2xl overflow-hidden border border-border h-[250px] bg-muted flex items-center justify-center">
                <div class="text-center text-muted-foreground">
                    <span class="material-symbols-outlined text-4xl mb-2">map</span>
                    <p class="text-sm">Interactive map placeholder</p>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="bg-card border border-border rounded-3xl p-8 md:p-10 shadow-lg">
            <h2 class="text-2xl md:text-3xl font-bold text-foreground mb-2">Send Us a Message</h2>
            <p class="text-muted-foreground mb-8">Fill out the form and a representative will get back to you within 24
                hours.</p>
            <form class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-foreground mb-2">First Name</label>
                        <input type="text" placeholder="John"
                            class="w-full px-5 py-4 rounded-xl border border-border bg-background text-foreground focus:ring-2 focus:ring-primary outline-none" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-foreground mb-2">Last Name</label>
                        <input type="text" placeholder="Doe"
                            class="w-full px-5 py-4 rounded-xl border border-border bg-background text-foreground focus:ring-2 focus:ring-primary outline-none" />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-foreground mb-2">Email Address</label>
                    <input type="email" placeholder="you@example.com"
                        class="w-full px-5 py-4 rounded-xl border border-border bg-background text-foreground focus:ring-2 focus:ring-primary outline-none" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-foreground mb-2">Subject</label>
                    <select
                        class="w-full px-5 py-4 rounded-xl border border-border bg-background text-foreground focus:ring-2 focus:ring-primary outline-none">
                        <option value="">Select a subject</option>
                        <option value="general">General Inquiry</option>
                        <option value="appointment">Appointment Request</option>
                        <option value="support">Technical Support</option>
                        <option value="feedback">Feedback</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-foreground mb-2">Your Message</label>
                    <textarea rows="5" placeholder="How can we help you today?"
                        class="w-full px-5 py-4 rounded-xl border border-border bg-background text-foreground focus:ring-2 focus:ring-primary outline-none resize-none"></textarea>
                </div>
                <button type="submit"
                    class="w-full py-4 bg-primary text-primary-foreground font-bold text-lg rounded-xl shadow-lg hover:scale-[1.01] active:scale-95 transition-all">
                    Send Message
                </button>
            </form>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 bg-muted/30">
    <div class="max-w-[1200px] mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-foreground mb-4">Frequently Asked Questions</h2>
            <p class="text-muted-foreground">Quick answers to common questions about contacting us.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            <div class="p-6 rounded-2xl bg-card border border-border">
                <h4 class="font-bold text-foreground mb-2">What are your operating hours?</h4>
                <p class="text-sm text-muted-foreground">We are open Monday through Saturday, 8:00 AM to 6:00 PM. Closed
                    on Sundays and public holidays.</p>
            </div>
            <div class="p-6 rounded-2xl bg-card border border-border">
                <h4 class="font-bold text-foreground mb-2">How quickly will I get a response?</h4>
                <p class="text-sm text-muted-foreground">We aim to respond to all inquiries within 24 business hours.
                </p>
            </div>
            <div class="p-6 rounded-2xl bg-card border border-border">
                <h4 class="font-bold text-foreground mb-2">Can I book an appointment online?</h4>
                <p class="text-sm text-muted-foreground">Yes! Use the MindTrack app or website to book appointments
                    directly with our specialists.</p>
            </div>
            <div class="p-6 rounded-2xl bg-card border border-border">
                <h4 class="font-bold text-foreground mb-2">Is there parking available?</h4>
                <p class="text-sm text-muted-foreground">Free parking is available at our facility for all patients and
                    visitors.</p>
            </div>
        </div>
    </div>
</section>