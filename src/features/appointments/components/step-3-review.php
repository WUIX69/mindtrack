<?php
/**
 * Appointment Booking - Step 3: Review & Confirm (Feature Component)
 * 
 * @param string $role (patient|admin)
 * @param array $header (title, description)
 * @param array $summary (service_label, date_label, provider_label)
 * @param array $notes (label, placeholder)
 * @param array $alert (title, text)
 * @param string $confirm_label
 * @param string $back_label
 */
$role = $role ?? 'patient';

// UI Strings
$header_title = $header['title'] ?? 'Review Selection';
$header_desc = $header['description'] ?? 'Please double-check the appointment details before confirming the request.';

$service_label = $summary['service_label'] ?? 'Service Type';
$date_label = $summary['date_label'] ?? 'Scheduled For';
$provider_label = $summary['provider_label'] ?? 'Healthcare Provider';

$notes_label = $notes['label'] ?? 'Notes';
$notes_placeholder = $notes['placeholder'] ?? 'Add instructions...';

$confirm_label = $confirm_label ?? 'Confirm';
$back_label = $back_label ?? 'Edit Selection';

$alert_title = $alert['title'] ?? 'Information';
$alert_text = $alert['text'] ?? 'Please review carefully.';
?>

<?php
// Get data from GET params - strictly for fetching details in JS
$service_uuid = $_GET['service'] ?? null;
$doctor_uuid = $_GET['doctor_uuid'] ?? null;
$sched_date = $_GET['date'] ?? date('Y-m-d');
$sched_time = $_GET['time_slot'] ?? null;

$display_date = date('l, F jS, Y', strtotime($sched_date));
?>

<div class="w-full">
    <!-- Progress Stepper -->
    <?= featured('appointments', 'components/progress-stepper', [
        'currentStep' => 3,
        'title' => $header_title,
        'description' => $header_desc
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
                                <?= $service_label ?>
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
                            <?= $date_label ?>
                        </p>
                        <p class="text-3xl font-black text-foreground tracking-tight"><?= $display_date ?></p>
                        <p class="text-2xl font-black text-primary mt-2"><?= $sched_time ?? 'Time not set' ?></p>
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
                                <?= $provider_label ?>
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
                    <?= $notes_label ?>
                </label>
                <textarea
                    class="w-full rounded-[1.5rem] border-border bg-card text-base font-medium focus:ring-4 focus:ring-primary/10 focus:border-primary placeholder:text-muted-foreground/40 transition-all p-6 min-h-[160px]"
                    id="notes" placeholder="<?= $notes_placeholder ?>"></textarea>
            </div>
        </div>

        <!-- Disclaimer Alert -->
        <div
            class="flex gap-6 items-start p-8 rounded-[2rem] bg-amber-50 dark:bg-amber-900/10 border border-amber-200/50 dark:border-amber-800/30">
            <span class="material-symbols-outlined text-amber-600 dark:text-amber-500 text-3xl shrink-0">info</span>
            <div class="flex flex-col gap-2">
                <p class="text-sm font-black text-amber-900 dark:text-amber-200 uppercase tracking-[0.2em] italic">
                    <?= $alert_title ?>
                </p>
                <p class="text-base text-amber-800/80 dark:text-amber-300/80 leading-relaxed font-medium">
                    <?= $alert_text ?>
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col-reverse sm:flex-row items-center gap-6 pt-6">
            <?php
            $back_params = [
                'service' => $service_uuid,
                'date' => $sched_date,
                'doctor_uuid' => $doctor_uuid,
                'time_slot' => $sched_time
            ];
            if (isset($_GET['patient_id']))
                $back_params['patient_id'] = $_GET['patient_id'];
            ?>
            <a href="step-2-schedule.php?<?= http_build_query($back_params) ?>"
                class="flex items-center justify-center gap-2 py-4 px-8 border-2 border-border text-foreground font-bold rounded-2xl hover:bg-muted transition-all">
                <span class="material-symbols-outlined">arrow_back</span>
                <?= $back_label ?>
            </a>
            <button id="confirm-booking-btn"
                class="w-full flex-1 px-12 py-5 bg-primary text-white text-xl font-black rounded-[1.5rem] shadow-2xl shadow-primary/30 hover:opacity-95 transform transition-all active:scale-[0.98] flex items-center justify-center gap-3 group">
                <?= $confirm_label ?>
                <span
                    class="material-symbols-outlined text-2xl group-hover:scale-110 transition-transform">check_circle</span>
            </button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const serviceUuid = '<?= $service_uuid ?>';
        const doctorUuid = '<?= $doctor_uuid ?>';
        const patientId = '<?= $_GET['patient_id'] ?? '' ?>';

        // Load Service Details
        $.ajax({
            url: apiUrl("appointments") + "list-services.php",
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    const s = response.data.find(x => x.uuid === serviceUuid);
                    if (s) {
                        $('#service-name').text(`${s.name} (${s.duration} min)`);
                        $('#service-desc').text(s.description);
                        $('#service-review-loading').addClass('hidden');
                        $('#service-review-data').removeClass('hidden');
                    }
                }
            }
        });

        // Load Doctor Details
        $.ajax({
            url: apiUrl("appointments") + "list-doctors.php",
            method: "GET",
            dataType: "json",
            success: function (response) {
                if (response.success) {
                    const d = response.data.find(x => x.uuid === doctorUuid);
                    if (d) {
                        $('#doctor-name').text(`Dr. ${d.firstname} ${d.lastname}`);
                        $('#doctor-specialization').text(d.specialization);
                        $('#doctor-img').attr('src', `https://ui-avatars.com/api/?name=${encodeURIComponent(d.firstname + ' ' + d.lastname)}&background=random`);
                        $('#doctor-review-loading').addClass('hidden');
                        $('#doctor-review-data').removeClass('hidden');
                    }
                }
            }
        });

        $('#confirm-booking-btn').on('click', function () {
            const btn = $(this);
            const originalContent = btn.html();

            btn.prop('disabled', true).html('<span class="loading loading-spinner"></span> Processing...');

            const bookingData = {
                service_uuid: serviceUuid,
                doctor_uuid: doctorUuid,
                sched_date: '<?= $sched_date ?>',
                sched_time: '<?= $sched_time ?>',
                notes: $('#notes').val()
            };

            if (patientId) {
                bookingData.patient_id = patientId;
            }

            $.ajax({
                url: apiUrl("appointments") + "book.php",
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(bookingData),
                success: function (response) {
                    if (response.success) {
                        // Update modal with real info
                        const doctorName = $('#doctor-name').text();
                        const displayDate = '<?= $display_date ?>';
                        const modalDesc = `Your appointment request for <strong>${displayDate}</strong> has been sent to ${doctorName}'s team. You can track its status in your dashboard.`;
                        $('#success-modal-description').html(modalDesc);

                        $('#success-modal').removeClass('hidden').addClass('flex');
                    } else {
                        alert('Error: ' + response.message);
                        btn.prop('disabled', false).html(originalContent);
                    }
                },
                error: function () {
                    alert('An unexpected error occurred. Please try again.');
                    btn.prop('disabled', false).html(originalContent);
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