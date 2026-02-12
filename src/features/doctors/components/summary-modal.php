<?php
/**
 * Doctor Summary Modal
 * 
 * Displays detailed information about a doctor.
 * Uses CSR for data population.
 */
?>
<!-- Doctor Summary Modal Overlay -->
<div id="doctor-summary-modal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 modal-overlay hidden"
    style="background-color: rgba(0, 0, 0, 0.6); backdrop-filter: blur(4px);">
    <!-- Modal Content -->
    <div
        class="bg-card dark:bg-card w-full max-w-2xl rounded-[0.75rem] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">

        <!-- Header -->
        <div class="px-8 py-6 border-b border-border flex justify-between items-center bg-card sticky top-0 z-10">
            <div class="flex items-center gap-4">
                <div id="summary-doc-image"
                    class="size-16 rounded-full bg-muted bg-cover bg-center border-2 border-primary/20">
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h3 id="summary-doc-name" class="text-xl font-bold text-foreground"></h3>
                        <span id="summary-doc-status"
                            class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase">
                            <span class="size-1.5 rounded-full bg-current"></span>
                            <span class="status-text"></span>
                        </span>
                    </div>
                    <p id="summary-doc-specialty"
                        class="text-xs text-primary font-bold uppercase tracking-wider mt-0.5"></p>
                </div>
            </div>
            <button id="close-summary-modal-btn"
                class="size-10 flex items-center justify-center rounded-full hover:bg-muted text-muted-foreground hover:text-foreground transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Scrollable Body -->
        <div class="flex-1 overflow-y-auto p-8 space-y-10">

            <!-- Professional Details -->
            <section class="space-y-6">
                <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">badge</span> Professional Details
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                    <div>
                        <label
                            class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Specialization</label>
                        <p id="summary-doc-specialty-detail" class="text-sm font-semibold text-foreground">-</p>
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">License
                            Number</label>
                        <p id="summary-doc-license" class="text-sm font-semibold text-foreground">-
                        </p>
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Email
                            Address</label>
                        <p id="summary-doc-email" class="text-sm font-semibold text-foreground">-</p>
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Phone
                            Number</label>
                        <p id="summary-doc-phone" class="text-sm font-semibold text-foreground">-</p>
                    </div>
                    <div class="md:col-span-2">
                        <label
                            class="block text-[10px] font-bold text-muted-foreground uppercase tracking-wider mb-1">Biography</label>
                        <p id="summary-doc-bio" class="text-sm text-muted-foreground leading-relaxed">
                            No biography available.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Schedule -->
            <section class="space-y-4">
                <h4 class="text-xs font-bold text-primary uppercase tracking-widest flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">event</span> Current Schedule
                </h4>
                <div class="bg-muted/30 p-6 rounded-xl border border-border">
                    <div id="summary-doc-schedule" class="space-y-3">
                        <!-- Dynamic Schedule Items injected here -->
                    </div>
                    <div class="mt-6 pt-4 border-t border-border flex items-center gap-2">
                        <span class="material-symbols-outlined text-muted-foreground text-sm">schedule</span>
                        <p class="text-[11px] text-muted-foreground font-medium">Timezone: America/Los_Angeles (PST)</p>
                    </div>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <div class="px-8 py-6 border-t border-border flex justify-end gap-3 bg-card sticky bottom-0 z-10">
            <button id="close-summary-modal-footer-btn"
                class="px-6 py-2.5 text-sm font-bold text-muted-foreground hover:text-foreground transition-all border border-border rounded-lg hover:border-foreground/20">Close</button>
            <button id="edit-doc-profile-btn"
                class="px-8 py-2.5 bg-primary text-primary-foreground rounded-lg text-sm font-bold hover:bg-primary/90 transition-all shadow-lg shadow-primary/25 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">edit</span>
                Edit Profile
            </button>
        </div>
    </div>
</div>

<script>
    const DoctorSummaryModal = {
        $modal: $('#doctor-summary-modal'),

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

            data.name = data.firstname + ' ' + data.lastname;

            // Basic Info
            $('#summary-doc-name').text(data.name || 'Unknown Doctor');
            $('#summary-doc-specialty').text(data.specialty || 'General Practitioner');
            $('#summary-doc-specialty-detail').text(data.specialty || '-');
            $('#summary-doc-license').text(data.license_number || 'Not Provided');
            $('#summary-doc-email').text(data.email || '-');
            $('#summary-doc-phone').text(data.phone || '-');
            $('#summary-doc-bio').text(data.bio || 'No biography available.');

            // Image
            const initial = (data.name || 'D').charAt(0).toUpperCase();
            if (data.img) {
                $('#summary-doc-image').css('background-image', `url('${data.img}')`).text('');
            } else {
                $('#summary-doc-image').css('background-image', 'none').html(`<span class="flex items-center justify-center w-full h-full text-2xl font-bold text-muted-foreground">${initial}</span>`);
            }

            // Status
            const statusConfig = {
                'active': { class: 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400', label: 'Active', dot: 'bg-emerald-500' },
                'inactive': { class: 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400', label: 'Inactive', dot: 'bg-red-500' },
                'on_leave': { class: 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400', label: 'On Leave', dot: 'bg-amber-500' }
            };
            const status = statusConfig[data.status] || statusConfig['active'];

            const $statusBadge = $('#summary-doc-status');
            $statusBadge.removeClass().addClass(`inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase ${status.class}`);
            $statusBadge.find('.size-1.5').removeClass().addClass(`size-1.5 rounded-full ${status.dot}`);
            $statusBadge.find('.status-text').text(status.label);

            // Edit Button Data
            $('#edit-doc-profile-btn').data('id', data.uuid);

            // Schedule
            this.renderSchedule(data.availability);
        },

        renderSchedule: function (availability) {
            const $container = $('#summary-doc-schedule');
            $container.empty();

            if (!availability) {
                $container.html('<p class="text-sm text-slate-500">No schedule information available.</p>');
                return;
            }

            let schedule = availability;
            if (typeof schedule === 'string') {
                try {
                    schedule = JSON.parse(schedule);
                } catch (e) {
                    $container.html('<p class="text-sm text-slate-500">Invalid schedule format.</p>');
                    return;
                }
            }

            const days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

            days.forEach(day => {
                const dayData = schedule[day];
                const isActive = dayData && dayData.active;
                const hours = isActive ? `${this.formatTime(dayData.start)} - ${this.formatTime(dayData.end)}` : 'Unavailable';

                const html = `
                    <div class="flex items-center justify-between group ${!isActive ? 'opacity-50' : ''}">
                        <span class="text-xs font-bold ${isActive ? 'text-muted-foreground group-hover:text-primary' : 'text-muted-foreground'} w-24 capitalize transition-colors">${day}</span>
                        <div class="h-px flex-1 mx-4 bg-border"></div>
                        <span class="text-[11px] font-semibold ${isActive ? 'text-foreground' : 'text-muted-foreground uppercase tracking-tighter'}">${hours}</span>
                    </div>
                `;
                $container.append(html);
            });
        },

        formatTime: function (timeStr) {
            if (!timeStr) return '';
            // Simple conversion if needed, assuming input is HH:mm or similar
            // For now, returning as is or could use a flexible parser
            return timeStr;
        }
    };

    $(document).ready(function () {
        // Close handlers
        $('#close-summary-modal-btn, #close-summary-modal-footer-btn').on('click', function () {
            DoctorSummaryModal.close();
        });

        // Close on escape
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape' && !$('#doctor-summary-modal').hasClass('hidden')) {
                DoctorSummaryModal.close();
            }
        });

        // Close on click outside
        $('#doctor-summary-modal').on('click', function (e) {
            if (e.target === this) {
                DoctorSummaryModal.close();
            }
        });

        // Edit button delegation
        $('#edit-doc-profile-btn').on('click', function () {
            const id = $(this).data('id');
            DoctorSummaryModal.close();
            // Trigger existing manage modal
            // We can trigger the click on the button in the table if it exists, or call the open function directly
            if (window.openDoctorModal) {
                // Fetch data again for edit mode to be safe, or direct open if we had full data
                // Best to reuse the click handler logic from doctors.php
                $(`.manage-doctor-btn[data-id="${id}"]`).trigger('click');
            }
        });
    });
</script>