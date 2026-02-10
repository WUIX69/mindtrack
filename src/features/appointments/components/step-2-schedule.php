<?php
/**
 * Appointment Booking - Step 2: Schedule & Provider (Feature Component)
 *
 * @param string $role (patient|admin)
 */
$role = $role ?? 'patient';
?>

<div class="w-full">
    <!-- Progress Stepper -->
    <?= featured('appointments', 'components/progress-stepper', [
        'currentStep' => 2,
        'title' => 'Schedule Appointment',
    ]) ?>

    <form id="booking-form-step-2" action="step-3-review.php" method="GET" class="space-y-10">
        <input type="hidden" name="service" value="">
        <input type="hidden" name="date" id="selected-date" value="">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Calendar Widget -->
            <div class="lg:col-span-7 bg-card p-8 rounded-[2rem] border border-border shadow-sm">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-xl font-black text-foreground tracking-tight">Select Date</h3>
                    <div class="flex items-center gap-3">
                        <button type="button"
                            class="size-10 flex items-center justify-center hover:bg-muted rounded-xl transition-all border border-border">
                            <span class="material-symbols-outlined text-2xl">chevron_left</span>
                        </button>
                        <span
                            class="font-black min-w-[140px] text-center text-sm tracking-tight"><?= date('F Y') ?></span>
                        <button type="button"
                            class="size-10 flex items-center justify-center hover:bg-muted rounded-xl transition-all border border-border">
                            <span class="material-symbols-outlined text-2xl">chevron_right</span>
                        </button>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div
                    class="grid grid-cols-7 text-center text-[11px] font-black text-muted-foreground uppercase tracking-[0.2em] mb-6">
                    <div class="py-2">Sun</div>
                    <div class="py-2">Mon</div>
                    <div class="py-2">Tue</div>
                    <div class="py-2">Wed</div>
                    <div class="py-2">Thu</div>
                    <div class="py-2">Fri</div>
                    <div class="py-2">Sat</div>
                </div>

                <div class="grid grid-cols-7 gap-3" id="calendar-days">
                    <!-- Basic calendar rendering for today's month -->
                    <?php
                    $firstDay = date('w', strtotime(date('Y-m-01')));
                    $daysInMonth = date('t');
                    $today = (int) date('j');

                    // Placeholders for empty days at start
                    for ($i = 0; $i < $firstDay; $i++) {
                        echo '<div class="aspect-square"></div>';
                    }

                    for ($d = 1; $d <= $daysInMonth; $d++) {
                        $isToday = $d == $today;
                        $btnClass = $isToday
                            ? 'bg-primary text-white shadow-xl shadow-primary/30'
                            : 'hover:bg-primary/10 hover:text-primary border-transparent';
                        $dateVal = date('Y-m-') . str_pad($d, 2, '0', STR_PAD_LEFT);
                        ?>
                        <button type="button" data-date="<?= $dateVal ?>"
                            class="calendar-day aspect-square flex flex-col items-center justify-center rounded-2xl transition-all text-sm font-black border <?= $btnClass ?>">
                            <?= $d ?>
                            <?php if ($isToday): ?>
                                <!-- <span
                                    class="absolute -bottom-2 left-1/2 -translate-x-1/2 text-[9px] opacity-90 font-black uppercase tracking-tighter">Today</span> -->
                            <?php endif; ?>
                        </button>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <!-- Right Column: Time Slots & Provider -->
            <div class="lg:col-span-5 flex flex-col gap-8">
                <!-- Time Selection -->
                <div class="bg-card p-8 rounded-[2rem] border border-border shadow-sm">
                    <h3 class="text-xl font-black mb-6 flex items-center gap-3 text-foreground tracking-tight">
                        <span class="material-symbols-outlined text-primary text-3xl">schedule</span>
                        Available Slots
                    </h3>
                    <p class="text-sm font-medium text-muted-foreground mb-6 italic">Times for <span
                            id="display-selected-date" class="text-foreground font-black not-italic">Loading...</span>
                    </p>

                    <div class="grid grid-cols-2 gap-4">
                        <?php
                        $selected_time = '';
                        $timeSlots = ['9:00 AM', '10:30 AM', '11:00 AM', '2:00 PM', '3:30 PM', '4:45 PM'];
                        foreach ($timeSlots as $index => $time):
                            $checked = ($time === $selected_time) ? 'checked' : '';
                            ?>
                            <label class="cursor-pointer">
                                <input type="radio" name="time_slot" value="<?= $time ?>" class="peer absolute opacity-0"
                                    <?= $checked ?> />
                                <div
                                    class="py-4 px-4 text-sm font-black rounded-2xl border-2 border-transparent bg-muted/30 text-muted-foreground transition-all text-center peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary hover:border-primary/30 hover:scale-[1.02] active:scale-[0.98]">
                                    <?= $time ?>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Provider Selection -->
                <div class="bg-card p-8 rounded-[2rem] border border-border shadow-sm">
                    <h3 class="text-xl font-black mb-6 flex items-center gap-3 text-foreground tracking-tight">
                        <span class="material-symbols-outlined text-primary text-3xl">person</span>
                        Assign Specialist
                    </h3>
                    <div class="relative">
                        <select
                            class="w-full h-14 rounded-xl border border-border bg-muted/30 px-5 text-foreground font-semibold focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all duration-300 appearance-none"
                            id="doctor_uuid" name="doctor_uuid" required>
                            <option value="">Choosing an expert...</option>
                        </select>
                        <div
                            class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-muted-foreground">
                            <span class="material-symbols-outlined text-2xl">expand_more</span>
                        </div>
                    </div>
                    <p
                        class="mt-4 text-[11px] font-bold text-muted-foreground leading-relaxed uppercase tracking-wider opacity-70">
                        Selecting a specific specialist may limit the available time slots above.
                    </p>
                </div>
            </div>
        </div>

        <div class="pt-8 border-t border-border flex flex-col sm:flex-row justify-between items-center gap-4">

            <a href="#" id="back-btn"
                class="inline-flex items-center gap-3 px-10 py-4 rounded-2xl font-black text-sm bg-muted text-foreground hover:bg-muted/80 transition-colors w-full sm:w-auto justify-center shadow-sm">
                <span class="material-symbols-outlined text-xl">arrow_back</span>
                Back to Service
            </a>

            <div id="reschedule-spacer" class="hidden sm:block hidden"></div>

            <button type="submit"
                class="inline-flex items-center justify-center gap-3 px-12 py-4 rounded-2xl font-black text-sm bg-primary text-white shadow-xl shadow-primary/25 hover:opacity-95 transform transition-all active:scale-[0.98] w-full sm:w-auto group">
                Review Appointment Details
                <span
                    class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        const $doctorSelect = $('#doctor_uuid');
        const $selectedDateInput = $('#selected-date');
        const $displaySelectedDate = $('#display-selected-date');
        const $form = $('#booking-form-step-2');
        const $backBtn = $('#back-btn');
        const $rescheduleSpacer = $('#reschedule-spacer');

        // Page Configurations from URL Params (CSR)
        const params = new URLSearchParams(window.location.search);
        const config = {
            service: params.get('service') || '',
            doctorUuid: params.get('doctor_uuid') || '',
            rescheduleUuid: params.get('reschedule_uuid') || '',
            editUuid: params.get('edit_uuid') || '',
            patientId: params.get('patient_id') || '',
            notes: params.get('notes') || '',
            date: params.get('date') || new Date().toISOString().split('T')[0],
            time: params.get('time') || ''
        };

        // Initialize State
        $('input[name="service"]').val(config.service);
        $selectedDateInput.val(config.date);

        // Update Time Selection if exists in URL or default to first
        if (config.time) {
            $(`input[name="time_slot"][value="${config.time}"]`).prop('checked', true);
        } else {
            $('input[name="time_slot"]').first().prop('checked', true);
        }

        updateDateDisplay(config.date);
        setupNavigation();
        getDoctors();

        // Handle Calendar Clicks
        $('.calendar-day').on('click', function () {
            const date = $(this).data('date');
            if (!date) return;

            // Update UI
            $('.calendar-day').removeClass('bg-primary text-white shadow-xl shadow-primary/30').addClass('hover:bg-primary/10 hover:text-primary border-transparent');
            $(this).removeClass('hover:bg-primary/10 hover:text-primary border-transparent').addClass('bg-primary text-white shadow-xl shadow-primary/30');

            // Update Hidden Inputs
            $selectedDateInput.val(date);
            updateDateDisplay(date);
        });

        function updateDateDisplay(dateStr) {
            const formattedDate = new Date(dateStr).toLocaleDateString('en-US', {
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            });
            $displaySelectedDate.text(formattedDate);

            // Sync calendar active state if strictly matching (basic implementation)
            $('.calendar-day').each(function () {
                if ($(this).data('date') === dateStr) {
                    $(this).trigger('click'); // Trigger UI update
                }
            });
        }

        function getDoctors() {
            $.ajax({
                url: apiUrl("shared") + "doctors.php?service_uuid=" + encodeURIComponent(config.service),
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (!response.success) {
                        $doctorSelect.html('<option value="">Error loading doctors</option>');
                        return;
                    }

                    let html = '<option value="" disabled' + (!config.doctorUuid ? ' selected' : '') + '>Select a Provider</option>';
                    response.data.forEach(d => {
                        const selected = (d.uuid === config.doctorUuid) ? 'selected' : '';
                        html += `<option value="${d.uuid}" ${selected}>Dr. ${d.firstname} ${d.lastname}</option>`;
                    });
                    $doctorSelect.html(html);
                },
                error: function () {
                    $doctorSelect.html('<option value="">Failed to load providers</option>');
                }
            });
        }

        function setupNavigation() {
            // Back Button Logic
            if (config.rescheduleUuid) {
                // If rescheduling, hide back button and show spacer
                $backBtn.addClass('hidden');
                $rescheduleSpacer.removeClass('hidden');
            } else {
                const backParams = new URLSearchParams();
                if (config.service) backParams.append('service', config.service);
                if (config.doctorUuid) backParams.append('doctor_uuid', config.doctorUuid); // Maybe they selected a doctor in step 1?
                if (config.notes) backParams.append('notes', config.notes);
                if (config.editUuid) backParams.append('edit_uuid', config.editUuid);
                if (config.patientId) backParams.append('patient_id', config.patientId);

                $backBtn.attr('href', `step-1-service.php?${backParams.toString()}`);
            }
        }

        // Manual Navigation Handler
        $form.on('submit', function (e) {
            e.preventDefault();

            const doctorUuid = $doctorSelect.val();
            const service = $('input[name="service"]').val();
            const date = $selectedDateInput.val();
            const timeSlot = $('input[name="time_slot"]:checked').val();

            if (!doctorUuid) {
                alert('Please select a provider before continuing.');
                return false;
            }

            if (!date || !timeSlot) {
                alert('Please select a date and time.');
                return false;
            }

            const nextParams = new URLSearchParams();
            nextParams.append('service', service);
            nextParams.append('doctor_uuid', doctorUuid);
            nextParams.append('date', date);
            nextParams.append('time_slot', timeSlot); // Changed from 'time' to 'time_slot' to match input name for consistency

            if (config.rescheduleUuid) nextParams.append('reschedule_uuid', config.rescheduleUuid);
            if (config.editUuid) nextParams.append('edit_uuid', config.editUuid);
            if (config.patientId) nextParams.append('patient_id', config.patientId);
            if (config.notes) nextParams.append('notes', config.notes);

            window.location.href = `step-3-review.php?${nextParams.toString()}`;
            return false;
        });
    });
</script>