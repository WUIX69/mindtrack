<?php
/**
 * Add/Edit Specialization Modal
 *
 * A reuseable modal for creating and editing specializations.
 * Handles styling adaptation from oklch to project theme.
 */
?>
<!-- Modal Overlay -->
<div id="specialization-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 modal-overlay hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity opacity-0" id="spec-modal-backdrop">
    </div>

    <!-- Modal Content -->
    <div class="bg-card dark:bg-card w-full max-w-lg rounded-xl shadow-2xl overflow-hidden flex flex-col max-h-[95vh] relative z-10 transform scale-95 opacity-0 transition-all duration-300"
        id="spec-modal-panel">

        <!-- Header -->
        <div class="px-8 py-6 border-b border-border flex justify-between items-center bg-card sticky top-0 z-10">
            <div>
                <h3 class="text-xl font-bold text-foreground" id="spec-modal-title">Add Specialization</h3>
                <p class="text-xs text-muted-foreground font-medium mt-1 uppercase tracking-wider"
                    id="spec-modal-subtitle">
                    New Clinical Area</p>
            </div>
            <button type="button"
                class="text-muted-foreground hover:text-foreground transition-colors spec-modal-close">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Scrollable Body -->
        <div class="flex-1 overflow-y-auto p-8">
            <form id="specialization-form" class="space-y-8">
                <input type="hidden" name="id" id="spec-id">

                <!-- Section: Details -->
                <div class="space-y-4">
                    <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">category</span> Specialization Details
                    </h4>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Name -->
                            <div>
                                <label for="spec-name"
                                    class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Name</label>
                                <input type="text" name="name" id="spec-name"
                                    class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all"
                                    placeholder="e.g. Clinical Psychology" required>
                            </div>
                            <!-- Status -->
                            <div>
                                <label for="spec-status"
                                    class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Status</label>
                                <div class="relative">
                                    <select name="status" id="spec-status"
                                        class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all appearance-none">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    <span
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-muted-foreground pointer-events-none">
                                        <span class="material-symbols-outlined text-sm">expand_more</span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="spec-desc"
                                class="block text-[11px] font-bold text-muted-foreground uppercase tracking-wider mb-1.5">Description</label>
                            <textarea name="description" id="spec-desc" rows="6"
                                class="w-full bg-muted/50 border border-border rounded-lg py-2 px-3 text-sm focus:ring-primary focus:border-primary transition-all resize-none"
                                placeholder="Brief description of requirements..."></textarea>
                        </div>
                    </div>

                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="px-8 py-6 border-t border-border flex justify-end gap-3 bg-card sticky bottom-0 z-10">
            <button type="button" id="spec-cancel-btn"
                class="px-6 py-2.5 text-sm font-bold text-muted-foreground hover:text-foreground transition-all spec-modal-close">Cancel</button>
            <button type="submit" form="specialization-form" id="spec-save-btn"
                class="px-8 py-2.5 bg-primary text-primary-foreground rounded-lg text-sm font-bold hover:opacity-90 transition-all shadow-lg shadow-primary/25">
                Save Specialization
            </button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const $modal = $('#specialization-modal');
        const $backdrop = $('#spec-modal-backdrop');
        const $panel = $('#spec-modal-panel');
        const $form = $('#specialization-form');
        const $submitBtn = $('#spec-save-btn');

        // Animation Helpers
        function openModal() {
            $modal.removeClass('hidden');
            setTimeout(() => {
                $backdrop.removeClass('opacity-0');
                $panel.removeClass('scale-95 opacity-0');
            }, 10);
        }

        window.closeSpecializationModal = function () {
            $backdrop.addClass('opacity-0');
            $panel.addClass('scale-95 opacity-0');
            setTimeout(() => {
                $modal.addClass('hidden');
                $form[0].reset();
                $('#spec-id').val('');
                $submitBtn.text('Save Specialization');
            }, 300);
        }

        // Global function to trigger modal
        window.openSpecializationModal = function (mode, data = {}) {
            if (mode === 'edit') {
                $('#spec-modal-title').text('Edit Specialization');
                $('#spec-modal-subtitle').text('Update Clinical Area');
                $submitBtn.text('Save Changes');

                $('#spec-id').val(data.id);
                $('#spec-name').val(data.name);
                $('#spec-id').val(data.id);
                $('#spec-name').val(data.name);
                $('#spec-desc').val(data.description);
                $('#spec-status').val(data.status || 'active');
            } else {
                $('#spec-modal-title').text('Add Specialization');
                $('#spec-modal-subtitle').text('New Clinical Area');
                $submitBtn.text('Save Specialization');

                $form[0].reset();
                $('#spec-id').val('');
            }
            openModal();
        };

        // Close handlers
        $(document).on('click', '.spec-modal-close', function () {
            closeSpecializationModal();
        });

        $modal.on('click', function (e) {
            if ($(e.target).is($modal)) {
                closeSpecializationModal();
            }
        });

        // Trigger open from buttons
        // Add
        $('.manage-specialization-btn').on('click', function () {
            window.openSpecializationModal('add');
        });

        // Edit
        $('#specializations-table').on('click', '.edit-btn', function () {
            const id = $(this).data('id');
            const data = window.getSingleSpecialization(id);
            if (data) {
                window.openSpecializationModal('edit', data);
            } else {
                // Fallback if not found in memory (unlikely if table loaded)
                console.error('Specialization not found in memory');
            }
        });

        // Save Logic
        $form.on('submit', function (e) {
            e.preventDefault();
            const formData = $form.serializeArray();
            const data = {};
            formData.forEach(item => data[item.name] = item.value);

            // Basic Validation
            if (!data.name) {
                alert('Name is required');
                return;
            }

            // Determine action
            data.action = data.id ? 'update' : 'create';

            // Loading State
            const originalText = $submitBtn.text();
            $submitBtn.prop('disabled', true).html('<span class="material-symbols-outlined animate-spin text-sm">progress_activity</span> Saving...');

            $.ajax({
                url: apiUrl("specializations") + "manage-specialization.php",
                method: 'POST',
                data: data,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        closeSpecializationModal();
                        $('#specializations-table').DataTable().ajax.reload();
                    } else {
                        alert(response.message || 'An error occurred.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                    alert('Failed to save specialization.');
                },
                complete: function () {
                    $submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });
    });
</script>