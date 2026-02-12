<?php
/**
 * Specialization Summary Modal
 * 
 * Displays detailed information about a specialization.
 * Uses CSR for data population.
 */
?>
<!-- Specialization Summary Modal Overlay -->
<div id="specialization-summary-modal"
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 modal-overlay hidden"
    style="background-color: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px);">
    <!-- Modal Content -->
    <div
        class="bg-card dark:bg-card w-full max-w-lg rounded-[0.75rem] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">

        <!-- Header -->
        <div class="px-8 py-6 border-b border-border flex justify-between items-center bg-card sticky top-0 z-10">
            <div class="flex items-center gap-4">
                <div
                    class="size-12 rounded-full bg-primary/10 flex items-center justify-center border-2 border-primary/20">
                    <span class="material-symbols-outlined text-primary text-2xl">category</span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 id="summary-spec-name" class="text-xl font-bold text-foreground"></h3>
                        <span id="summary-spec-status"
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase">
                            <span class="size-1.5 rounded-full bg-current"></span>
                            <span class="status-text"></span>
                        </span>
                    </div>
                    <p class="text-xs text-muted-foreground font-medium uppercase tracking-wider mt-0.5">Specialization
                        Details</p>
                </div>
            </div>
            <button id="close-summary-modal-btn"
                class="size-10 flex items-center justify-center rounded-full hover:bg-muted text-muted-foreground hover:text-foreground transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Scrollable Body -->
        <div class="flex-1 overflow-y-auto p-8 space-y-8">

            <!-- Description -->
            <section class="space-y-3">
                <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">description</span> Description
                </h4>
                <div class="bg-muted/30 p-4 rounded-xl border border-border">
                    <p id="summary-spec-desc" class="text-sm text-foreground leading-relaxed">
                        -
                    </p>
                </div>
            </section>

            <!-- Timestamps -->
            <section class="space-y-4">
                <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">history</span> History
                </h4>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-muted/30 p-4 rounded-xl border border-border">
                        <label
                            class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Created
                            At</label>
                        <p id="summary-spec-created" class="text-sm font-semibold text-foreground">-</p>
                    </div>
                    <div class="bg-muted/30 p-4 rounded-xl border border-border">
                        <label
                            class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Last
                            Updated</label>
                        <p id="summary-spec-updated" class="text-sm font-semibold text-foreground">-</p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <div class="px-8 py-6 border-t border-border flex justify-end gap-3 bg-card sticky bottom-0 z-10">
            <button id="close-summary-modal-footer-btn"
                class="px-6 py-2.5 text-sm font-bold text-muted-foreground hover:text-foreground transition-all border border-border rounded-lg hover:border-foreground/20">Close</button>
            <button id="edit-spec-btn"
                class="px-8 py-2.5 bg-primary text-primary-foreground rounded-lg text-sm font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/25 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">edit</span>
                Edit Specialization
            </button>
        </div>
    </div>
</div>

<script>
    const SpecializationSummaryModal = {
        $modal: $('#specialization-summary-modal'),

        open: function (data) {
            this.populate(data);
            this.$modal.removeClass('hidden');
            $('body').addClass('overflow-hidden');
        },

        close: function () {
            this.$modal.addClass('hidden');
            $('body').removeClass('overflow-hidden');
        },

        populate: function (data) {
            // Basic Info
            $('#summary-spec-name').text(data.name || 'Unknown');
            $('#summary-spec-desc').text(data.description || 'No description provided.');

            // Timestamps
            $('#summary-spec-created').text(this.formatDate(data.created_at));
            $('#summary-spec-updated').text(this.formatDate(data.updated_at));

            // Status
            const isActive = (data.status || 'active') === 'active';
            const statusClass = isActive
                ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400'
                : 'bg-slate-100 text-slate-700 dark:bg-slate-900/30 dark:text-slate-400';
            const dotClass = isActive ? 'bg-emerald-500' : 'bg-slate-500';
            const label = isActive ? 'Active' : 'Inactive';

            const $statusBadge = $('#summary-spec-status');
            $statusBadge.removeClass().addClass(`inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase ${statusClass}`);
            $statusBadge.find('.size-1.5').removeClass().addClass(`size-1.5 rounded-full ${dotClass}`);
            $statusBadge.find('.status-text').text(label);

            // Edit Button Data
            $('#edit-spec-btn').data('id', data.id);
        },

        formatDate: function (dateString) {
            if (!dateString) return '-';
            return new Date(dateString).toLocaleDateString('en-US', {
                weekday: 'short',
                year: 'numeric',
                month: 'short',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    };

    $(document).ready(function () {
        // Close handlers
        $('#close-summary-modal-btn, #close-summary-modal-footer-btn').on('click', function () {
            SpecializationSummaryModal.close();
        });

        // Close on escape
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape' && !$('#specialization-summary-modal').hasClass('hidden')) {
                SpecializationSummaryModal.close();
            }
        });

        // Close on click outside
        $('#specialization-summary-modal').on('click', function (e) {
            if (e.target === this) {
                SpecializationSummaryModal.close();
            }
        });

        // Edit button delegation
        $('#edit-spec-btn').on('click', function () {
            const id = $(this).data('id');
            SpecializationSummaryModal.close();
            // Trigger edit via the existing mechanism which handles modal opening
            // We use the same selector as the table buttons to trigger the logic
            // Since the logic is bound to .edit-btn inside #specializations-table, we can manually call openModal 
            // OR finding the row. But since we have getSingleSpecialization now:
            const data = window.getSingleSpecialization(id);
            if (data) {
                // Determine if we need to call window.openSpecializationModal (if we renamed it)
                // For now, looking at specializations.php, the function is 'openModal' inside a closure.
                // We need to expose it or trigger the click on the table button.
                // Triggering table button is safer to avoid scope issues unless we refactored specializations.php scope.
                $(`.edit-btn[data-id="${id}"]`).trigger('click');
            }
        });

        // Trigger Summary from Table View Button
        $('#specializations-table').on('click', '.view-btn', function () {
            const id = $(this).data('id');
            const data = window.getSingleSpecialization(id);
            if (data) {
                SpecializationSummaryModal.open(data);
            }
        });

        // Optional: Trigger Summary on Row Click (excluding action buttons)
        $('#specializations-table').on('click', 'tbody tr', function (e) {
            if ($(e.target).closest('button').length) return; // Ignore button clicks
            if ($(e.target).closest('.dataTables_empty').length) return; // Ignore empty row

            // Get data from DataTable row
            const table = $('#specializations-table').DataTable();
            const data = table.row(this).data();

            if (data) {
                SpecializationSummaryModal.open(data);
            }
        });
    });
</script>