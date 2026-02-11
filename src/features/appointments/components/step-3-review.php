<?php
/**
 * Appointment Booking - Step 3: Review & Confirm (Feature Component)
 *
 * @param string $role (patient|admin)
 * @param array $notes (label, placeholder)
 * @param array $alert (title, text)
 */
$role = $role ?? 'patient';
?>

<div class="w-full">

    <!-- Progress Stepper -->
    <?= featured('appointments', 'components/progress-stepper', [
        'currentStep' => 3,
        'title' => 'Review & Confirm',
    ]) ?>

    <div class="space-y-8">
        <!-- Main Summary Card -->
        <div class="bg-card rounded-[2.5rem] shadow-sm border border-border overflow-hidden">
            <div class="p-10 space-y-10" id="review-content">
                <!-- Summary Section 1: Service -->
                <div class="flex items-start gap-6" id="service-review-loading">
                    <div class="size-24 bg-muted animate-pulse rounded-[1.5rem]"></div>
                    <div class="flex-1 space-y-3">
                        <div class="h-4 w-24 bg-muted animate-pulse rounded"></div>
                        <div class="h-8 w-64 bg-muted animate-pulse rounded"></div>
                        <div class="h-20 w-full bg-muted animate-pulse rounded"></div>
                    </div>
                </div>

                <div class="hidden" id="service-review-data">
                    <div class="flex items-start gap-6">
                        <div
                            class="flex items-center justify-center rounded-[1.5rem] bg-primary/10 text-primary p-5 shrink-0 shadow-inner">
                            <span class="material-symbols-outlined text-5xl">psychology</span>
                        </div>
                        <div class="flex flex-col">
                            <p class="text-xs font-black text-muted-foreground uppercase tracking-[0.2em] mb-2">
                                Service Type
                            </p>
                            <p class="text-3xl font-black text-foreground tracking-tight" id="service-name">Loading...
                            </p>
                            <p class="text-base text-muted-foreground mt-2 max-w-lg font-medium leading-relaxed"
                                id="service-desc"></p>
                        </div>
                    </div>
                </div>

                <hr class="border-border/50" />

                <!-- Summary Section 2: Date & Time -->
                <div class="flex items-start gap-6">
                    <div
                        class="flex items-center justify-center rounded-[1.5rem] bg-primary/10 text-primary p-5 shrink-0 shadow-inner">
                        <span class="material-symbols-outlined text-5xl">calendar_today</span>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-xs font-black text-muted-foreground uppercase tracking-[0.2em] mb-2">
                            Scheduled For
                        </p>
                        <p class="text-3xl font-black text-foreground tracking-tight" id="review-date">Loading...</p>
                        <p class="text-2xl font-black text-primary mt-2" id="review-time"></p>
                    </div>
                </div>

                <hr class="border-border/50" />

                <!-- Summary Section 3: Doctor -->
                <div class="flex items-start gap-6" id="doctor-review-loading">
                    <div class="size-24 bg-muted animate-pulse rounded-[2rem]"></div>
                    <div class="flex-1 space-y-3">
                        <div class="h-4 w-24 bg-muted animate-pulse rounded"></div>
                        <div class="h-8 w-48 bg-muted animate-pulse rounded"></div>
                    </div>
                </div>

                <div class="hidden" id="doctor-review-data">
                    <div class="flex items-start gap-6">
                        <div class="relative shrink-0">
                            <div
                                class="size-24 bg-muted rounded-[2rem] overflow-hidden border-4 border-border shadow-xl">
                                <img id="doctor-img" src="" class="size-full object-cover" />
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 bg-green-500 border-4 border-card size-8 rounded-full shadow-lg">
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <p class="text-xs font-black text-muted-foreground uppercase tracking-[0.2em] mb-2">
                                Healthcare Provider
                            </p>
                            <p class="text-3xl font-black text-foreground tracking-tight" id="doctor-name">Dr.</p>
                            <p class="text-base text-muted-foreground mt-2 font-medium" id="doctor-specialization"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            <div class="bg-muted/10 p-10 border-t border-border">
                <label class="block text-sm font-black text-foreground mb-4 uppercase tracking-wider" for="notes">
                    <?= $notes['label'] ?? 'Notes' ?>
                </label>
                <textarea
                    class="w-full rounded-[1.5rem] border border-border bg-card text-base font-medium focus:ring-4 focus:ring-primary/10 focus:border-primary placeholder:text-muted-foreground/40 transition-all p-6 min-h-[160px]"
                    id="notes" placeholder="<?= $notes['placeholder'] ?? 'Add instructions...' ?>"></textarea>
            </div>
        </div>

        <!-- Disclaimer Alert -->
        <div
            class="flex gap-6 items-start p-8 rounded-[2rem] bg-amber-50 dark:bg-amber-900/10 border border-amber-200/50 dark:border-amber-800/30">
            <span class="material-symbols-outlined text-amber-600 dark:text-amber-500 text-3xl shrink-0">info</span>
            <div class="flex flex-col gap-2">
                <p class="text-sm font-black text-amber-900 dark:text-amber-200 uppercase tracking-[0.2em] italic">
                    <?= $alert['title'] ?? 'Information' ?>
                </p>
                <p class="text-base text-amber-800/80 dark:text-amber-300/80 leading-relaxed font-medium">
                    <?= $alert['text'] ?? 'Please review carefully.' ?>
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col-reverse sm:flex-row items-center gap-6 pt-6">
            <a href="#" id="back-btn"
                class="flex items-center justify-center gap-2 py-4 px-8 border-2 border-border text-foreground font-bold rounded-2xl hover:bg-muted transition-all">
                <span class="material-symbols-outlined">arrow_back</span>
                Edit Selection
            </a>
            <button id="confirm-booking-btn"
                class="w-full flex-1 px-12 py-5 bg-primary text-white text-xl font-black rounded-[1.5rem] shadow-2xl shadow-primary/30 hover:opacity-95 transform transition-all active:scale-[0.98] flex items-center justify-center gap-3 group">
                Create Appointment
                <span
                    class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">check_circle</span>
            </button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Page Configurations from URL Params (CSR)
        const params = new URLSearchParams(window.location.search);
        const config = {
            serviceUuid: params.get('service') || '',
            doctorUuid: params.get('doctor_uuid') || '',
            patientUuid: params.get('patient_uuid') || '',
            rescheduleUuid: params.get('reschedule_uuid') || '',
            editUuid: params.get('edit_uuid') || '',
            schedDate: params.get('date') || new Date().toISOString().split('T')[0],
            schedTime: params.get('time_slot') || '', // Match Step 2 param
            notes: params.get('notes') || ''
        };

        config.appointmentUuid = config.rescheduleUuid || config.editUuid;

        // Initialize UI
        $('#notes').val(config.notes);
        $('#review-time').text(config.schedTime || 'Time not set');

        const dateObj = new Date(config.schedDate);
        const displayDate = dateObj.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        $('#review-date').text(displayDate);
        config.displayDate = displayDate; // For modal

        // Dynamic Header & Labels
        if (config.appointmentUuid) {
            $('#page-title').text('Update Request');
            $('#page-desc').text('Review your changes before confirming the update.');
            $('#confirm-booking-btn').contents().first()[0].textContent = 'Update Appointment '; // Safer text replacement
        } else {
            $('#page-title').text('Review Selection');
            $('#page-desc').text('Review your changes before confirming the update.');
        }

        setupNavigation();
        getServiceDetails();
        getDoctorDetails();

        function setupNavigation() {
            const backParams = new URLSearchParams();
            if (config.serviceUuid) backParams.append('service', config.serviceUuid);
            if (config.doctorUuid) backParams.append('doctor_uuid', config.doctorUuid);
            if (config.schedDate) backParams.append('date', config.schedDate);
            if (config.schedTime) backParams.append('time', config.schedTime); // Use 'time' to match Step 2 input expectations if it reads 'time' or 'time_slot'
            // Wait, Step 2 reads 'time' from URL: `time: params.get('time')` logic in Step 2.
            // But Step 2 *submits* `time_slot`.
            // My Step 2 refactor: `nextParams.append('time_slot', timeSlot);`
            // So Step 3 receives `time_slot`.
            // But Step 2 *initializes* from `config.time` which reads `params.get('time')`.
            // AND Step 2 submit puts `time_slot` in the URL.
            // So if I go Back from Step 3 -> Step 2, I should use `time` or `time_slot`?
            // Helper: Step 2: `time: params.get('time') || ''`.
            // So Step 2 expects `time` in URL to pre-select.
            // BUT `step-2-schedule.php` form submits `time_slot` to `step-3`.
            // So Step 3 URL has `time_slot`.
            // When going back to Step 2, I should append `time` so Step 2 can read it.
            if (config.schedTime) backParams.append('time', config.schedTime);

            if (config.rescheduleUuid) backParams.append('reschedule_uuid', config.rescheduleUuid);
            if (config.editUuid) backParams.append('edit_uuid', config.editUuid);
            if (config.patientUuid) backParams.append('patient_uuid', config.patientUuid);
            if (config.notes) backParams.append('notes', config.notes);

            $('#back-btn').attr('href', `step-2-schedule.php?${backParams.toString()}`);
        }

        function getServiceDetails() {
            $.ajax({
                url: apiUrl("shared") + "services.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (!response.success) return;

                    const s = response.data.find(x => x.uuid === config.serviceUuid);
                    if (s) {
                        $('#service-name').text(s.name);
                        $('#service-desc').text(s.description);
                        $('#service-review-loading').addClass('hidden');
                        $('#service-review-data').removeClass('hidden');
                    }
                }
            });
        }

        function getDoctorDetails() {
            $.ajax({
                url: apiUrl("shared") + "doctors.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (!response.success) return;

                    const d = response.data.find(x => x.uuid === config.doctorUuid);
                    if (d) {
                        $('#doctor-name').text(`Dr. ${d.firstname} ${d.lastname}`);
                        $('#doctor-specialization').text(d.specialization);
                        $('#doctor-img').attr('src', `https://ui-avatars.com/api/?name=${encodeURIComponent(d.firstname + ' ' + d.lastname)}&background=random`);
                        $('#doctor-review-loading').addClass('hidden');
                        $('#doctor-review-data').removeClass('hidden');
                    }
                }
            });
        }

        // Confirm Booking
        $('#confirm-booking-btn').on('click', function () {
            const btn = $(this);
            btn.prop('disabled', true).html('<span class="loading loading-spinner"></span> Processing...');

            const bookingData = {
                service_uuid: config.serviceUuid,
                doctor_uuid: config.doctorUuid,
                sched_date: config.schedDate,
                sched_time: config.schedTime,
                notes: $('#notes').val()
            };

            if (config.appointmentUuid) {
                bookingData.appointment_uuid = config.appointmentUuid;
            }

            if (config.patientUuid) {
                bookingData.patient_uuid = config.patientUuid;
            }

            // console.log('bookingData', bookingData);
            // return false;

            $.ajax({
                url: apiUrl("appointments") + "book.php",
                method: "POST",
                contentType: 'application/json',
                data: JSON.stringify(bookingData),
                success: function (response) {
                    console.log('response', response);
                    if (!response.success) {
                        alert('Error: ' + response.message);
                        btn.prop('disabled', false).html('Confirm Appointment <span class="material-symbols-outlined text-xl">check_circle</span>');
                        return;
                    }

                    // Update modal with real info
                    const isUpdate = !!config.appointmentUuid;
                    const title = isUpdate ? 'Appointment Updated!' : 'Appointment Requested!';
                    const modalDesc = isUpdate
                        ? `Your changes for <strong>${config.displayDate}</strong> have been saved successfully.`
                        : `Your request for <strong>${config.displayDate}</strong> has been sent to the clinical team.`;

                    $('#success-title').text(title);
                    $('#success-description').html(modalDesc);

                    // Show Modal
                    $('#success-modal').removeClass('hidden').addClass('flex');
                },
                error: function () {
                    alert('An unexpected error occurred. Please try again.');
                    btn.prop('disabled', false).html('Confirm Appointment <span class="material-symbols-outlined text-xl">check_circle</span>');
                }
            });
        });
    });
</script>

<!-- Success Modal -->
<?= featured('appointments', 'components/success-modal', [
    'role' => $role,
    'date' => 'Oct 25th',
    'doctor' => ($role == 'admin' ? 'Dr. Mitchell' : 'Dr. Sarah Mitchell, MD'),
]) ?>