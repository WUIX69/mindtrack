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
                                <!-- Options will be populated dynamically -->
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
                                    name="duration" id="service-duration" placeholder="60" type="number" />
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
                                    name="price" id="service-price" placeholder="150.00" type="number" />
                            </div>
                        </div>
                        <input type="hidden" name="uuid" id="service-uuid">
                    </div>
                </div>

                <!-- Active Status & Specialization -->
                <div class="grid grid-cols-2 gap-6 pt-4 border-t border-border items-end">
                    <!-- Specialization -->
                    <div>
                        <label class="block text-xs font-bold text-muted-foreground uppercase tracking-wider mb-2"
                            for="service-specialization">
                            Specialization
                        </label>
                        <div class="relative">
                            <select
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                                id="service-specialization" name="specialization_id">
                                <option disabled="" selected="" value="">Select a specialization (Optional)</option>
                                <!-- Options will be populated dynamically -->
                            </select>
                        </div>
                    </div>

                    <!-- Status Toggle -->
                    <div
                        class="flex items-center justify-between p-2 bg-muted/30 rounded-lg border border-border h-full">
                        <div class="flex flex-col gap-1">
                            <span class="text-sm font-bold text-foreground">Active Status</span>
                            <span class="text-xs text-muted-foreground">Enable service</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input checked="" class="sr-only peer" type="checkbox" name="status" value="active" />
                            <div
                                class="w-10 h-5 bg-muted peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-primary shadow-inner">
                            </div>
                        </label>
                    </div>
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
                $('#service-uuid').val(data.uuid);
                $('#service-name').val(data.name);
                $('#service-category').val(data.category_id);
                $('#service-specialization').val(data.specialization_id); // Populate Specialization
                $('#service-desc').val(data.description);
                $('#service-duration').val(data.duration);
                $('#service-price').val(data.price);
                // Set checkbox based on status 'active' or 'inactive'
                $('input[name="status"]').prop('checked', data.status === 'active');
            } else {
                $('#service-modal-title').text('Add New Clinical Service');
                $form[0].reset();
                $('#service-uuid').val('');
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

        // Service Submit
        $form.on('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            const uuid = $('#service-uuid').val();
            // Append explicit action if not present (though usually expected by backend)
            // But manage-services.php might check 'action' or request method. 
            // Previous code appended 'action' manually.
            formData.append('action', uuid ? 'update' : 'store');

            $.ajax({
                url: apiUrl('services') + 'manage-services.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (!response.success) return alert(response.message);
                    alert(response.message);
                    window.closeServiceModal();
                    $(document).trigger('service-saved');
                },
                error: ajaxErrorHandler
            });
        });
    });
</script>