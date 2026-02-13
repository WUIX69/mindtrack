<?php
/**
 * Service Modal
 * 
 * Modal for creating and editing clinical services.
 */
?>
<!-- Modal Overlay -->
<div id="service-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 modal-overlay hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity opacity-0" id="service-modal-backdrop">
    </div>

    <!-- Modal Content -->
    <div class="bg-card dark:bg-card w-full max-w-2xl rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[95vh] relative z-10 transform scale-95 opacity-0 transition-all duration-300"
        id="service-modal-panel">

        <!-- Header -->
        <div class="px-8 py-6 border-b border-border flex justify-between items-center bg-card sticky top-0 z-10">
            <div>
                <h3 class="text-xl font-bold text-foreground" id="service-modal-title">Add New Clinical Service</h3>
                <p class="text-xs text-muted-foreground font-medium mt-1 uppercase tracking-wider"
                    id="service-modal-subtitle">
                    Service Parameters</p>
            </div>
            <button type="button"
                class="text-muted-foreground hover:text-foreground transition-colors service-modal-close">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Scrollable Body -->
        <div class="flex-1 overflow-y-auto p-8">
            <form id="service-form" class="space-y-8">

                <!-- Section 1: Basic Information -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">info</span> Basic Information
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5"
                                for="service-name">Service Name</label>
                            <input
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                                id="service-name" name="name" placeholder="e.g. EMDR Therapy" type="text" />
                        </div>
                        <div class="space-y-2">
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5"
                                for="service-category">Service Category</label>
                            <select
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                                id="service-category" name="category">
                                <option disabled="" selected="" value="">Select a category</option>
                                <option value="therapy">Therapy</option>
                                <option value="assessment">Assessment</option>
                                <option value="consultation">Consultation</option>
                                <option value="programs">Programs</option>
                                <option value="general">General</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Clinical Details -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">clinical_notes</span> Clinical Details
                    </h4>
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5"
                            for="service-desc">Service Description</label>
                        <textarea
                            class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all resize-none"
                            id="service-desc" name="description" placeholder="Describe the therapeutic intent..."
                            rows="4"></textarea>
                    </div>
                </div>

                <!-- Section 3: Operational Information -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">settings_suggest</span> Operational Information
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Standard
                                Duration (Minutes)</label>
                            <div class="relative">
                                <span
                                    class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-muted-foreground text-lg">schedule</span>
                                <input
                                    class="w-full bg-muted/50 border border-border rounded-lg pl-10 pr-3 py-2 text-sm focus:ring-primary focus:border-primary transition-all"
                                    name="duration" placeholder="60" type="number" />
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Base
                                Rate</label>
                            <div class="relative">
                                <span
                                    class="absolute left-3 top-1/2 -translate-y-1/2 text-muted-foreground font-medium">₱</span>
                                <input
                                    class="w-full bg-muted/50 border border-border rounded-lg pl-8 pr-3 py-2 text-sm focus:ring-primary focus:border-primary transition-all"
                                    name="rate" placeholder="150.00" type="number" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Status -->
                <div class="pt-4 border-t border-border flex items-center justify-between">
                    <div class="flex flex-col">
                        <span class="text-sm font-bold text-foreground">Active Status</span>
                        <span class="text-xs text-muted-foreground">Enable or disable this service across the
                            platform.</span>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input checked="" class="sr-only peer" type="checkbox" name="active" />
                        <div
                            class="w-14 h-7 bg-muted peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary shadow-inner">
                        </div>
                    </label>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="px-8 py-6 border-t border-border flex justify-end gap-3 bg-card sticky bottom-0 z-10">
            <button type="button"
                class="px-6 py-2.5 text-sm font-bold text-muted-foreground hover:text-foreground transition-all service-modal-close">
                Cancel
            </button>
            <button type="submit" form="service-form"
                class="px-8 py-2.5 bg-primary text-primary-foreground rounded-lg text-sm font-bold hover:opacity-90 transition-all shadow-lg shadow-primary/25">
                Save Service
            </button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const $modal = $('#service-modal');
        const $backdrop = $('#service-modal-backdrop');
        const $panel = $('#service-modal-panel');
        const $form = $('#service-form');

        // Open Modal Function
        window.openServiceModal = function (mode = 'add', data = null) {
            $modal.removeClass('hidden');
            setTimeout(() => {
                $backdrop.removeClass('opacity-0');
                $panel.removeClass('scale-95 opacity-0');
            }, 10);

            if (mode === 'edit' && data) {
                $('#service-modal-title').text('Edit Clinical Service');
                $('#service-name').val(data.name);
                // Populate other fields...
            } else {
                $('#service-modal-title').text('Add New Clinical Service');
                $form[0].reset();
            }
        };

        // Close Modal Function
        window.closeServiceModal = function () {
            $backdrop.addClass('opacity-0');
            $panel.addClass('scale-95 opacity-0');
            setTimeout(() => {
                $modal.addClass('hidden');
            }, 300);
        };

        // Close events
        $('.service-modal-close').on('click', closeServiceModal);
        $modal.on('click', function (e) {
            if ($(e.target).is($modal)) closeServiceModal();
        });
    });
</script>