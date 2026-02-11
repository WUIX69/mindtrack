<?php
/**
 * Appointment Booking - Step 1: Select Service (Feature Component)
 *
 * @param string $role (patient|admin)
 */
$role = $role ?? 'patient';
$patient_placeholder = 'Search patients...';


// Check if we are in edit mode
$isEditMode = isset($_GET['edit_uuid']) && !empty($_GET['edit_uuid']);
?>

<div class="w-full">
    <!-- Progress Stepper -->
    <?= featured('appointments', 'components/progress-stepper', [
        'currentStep' => 1,
        'title' => 'Select Service',
    ]) ?>

    <!-- Service Selection Grid -->
    <form id="booking-form-step-1" action="step-2-schedule.php" method="GET" class="space-y-10">

        <?php if ($role === 'admin'): ?>
            <!-- Patient Selection (Admin Only) -->
            <div class="bg-card p-8 rounded-[2rem] border border-border shadow-sm space-y-6">
                <!-- Header -->
                <div class="flex items-center gap-4">
                    <div class="size-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl">person_search</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-foreground tracking-tight">
                            <?= $isEditMode ? 'Selected Patient' : 'Select Patient' ?>
                        </h3>
                        <p class="text-sm text-muted-foreground font-medium">
                            <?= $isEditMode ? 'This appointment is for:' : 'Choose a patient from the directory.' ?>
                        </p>
                    </div>
                </div>

                <?php if ($isEditMode): ?>
                    <!-- Edit Mode: Read-only Patient Info -->
                    <div id="patient-read-only" class="w-full bg-muted/30 border border-border rounded-2xl py-4 px-6">
                        <div class="flex flex-col gap-1">
                            <span id="ro-patient-name" class="text-sm font-black text-foreground">Loading...</span>
                            <span id="ro-patient-email" class="text-xs font-bold text-muted-foreground">Please wait</span>
                        </div>
                    </div>
                    <!-- Hidden input to carry the patient_uuid forward -->
                    <input type="hidden" name="patient_uuid" id="patient_uuid_hidden">
                <?php else: ?>
                    <!-- Create Mode: Dropdown -->
                    <div class="relative">
                        <select name="patient_uuid" id="patient_uuid" required
                            class="w-full bg-muted/30 border-border rounded-2xl py-4 px-6 text-sm font-bold appearance-none focus:ring-4 focus:ring-primary/10 focus:border-primary transition-all">
                            <option value="" disabled selected><?= $patient_placeholder ?></option>
                        </select>
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-muted-foreground">
                            <span class="material-symbols-outlined">expand_more</span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div id="services-grid" class="grid grid-cols-1 md:grid-cols-3 gap-6 min-h-[400px]">
            <!-- Skeleton items while loading -->
            <?php for ($i = 0; $i < 3; $i++): ?>
                <div class="h-[300px] bg-card/50 rounded-[2rem] border border-border/50 animate-pulse"></div>
            <?php endfor; ?>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-8 border-t border-border">
            <a href="index.php"
                class="inline-flex items-center justify-center rounded-2xl h-14 px-10 bg-muted text-foreground font-black hover:bg-muted/80 transition-colors shadow-sm">
                Cancel
            </a>
            <button type="submit" id="continue-btn"
                class="inline-flex items-center justify-center rounded-2xl h-14 px-12 bg-primary text-white font-black shadow-xl shadow-primary/20 hover:opacity-95 transform transition-all active:scale-[0.98] group">
                Continue to Schedule
                <span
                    class="material-symbols-outlined ml-2 group-hover:translate-x-1 transition-transform">arrow_forward</span>
            </button>
        </div>
    </form>
</div>

<script src="<?= shared('data', 'icons.js', true) ?>"></script>
<script>
    $(document).ready(function () {
        const $grid = $('#services-grid');
        const $form = $('#booking-form-step-1');
        const $continueBtn = $('#continue-btn');

        // Page Configurations from URL Params (CSR)
        const params = new URLSearchParams(window.location.search);
        const config = {
            preselectedService: params.get('service') || '',

            editUuid: params.get('edit_uuid') || '',
            doctorUuid: params.get('doctor_uuid') || '',
            notes: params.get('notes') || '',
            notes: params.get('notes') || '',
            patientUuid: params.get('patient_uuid') || '',
            date: params.get('date') || '',
            time: params.get('time') || ''
        };

        // Disable continue button initially
        $continueBtn.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');

        // Initial Load
        getServices();
        if ("<?= $role ?>" === "admin") {
            if (config.editUuid) {
                // Edit Mode: Fetch info just for display
                getPatientInfoForEdit(config.patientUuid);
            } else {
                // Create Mode: Load dropdown
                getPatients();
            }
        }

        // Fetch patient info for read-only display in edit mode
        function getPatientInfoForEdit(id) {
            if (!id) return;
            $('#patient_uuid_hidden').val(id); // Set hidden input

            // Reusing list.php as we don't have a specific 'get' endpoint yet
            // This is acceptable as the list isn't massive, but ideally should be replaced by get.php?id=X
            $.ajax({
                url: apiUrl("shared") + "list-patients.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (!response.success) {
                        $('#ro-patient-name').text('Error');
                        return;
                    }
                    const patient = response.data.find(p => p.id == id);
                    if (patient) {
                        $('#ro-patient-name').text(patient.name);
                        $('#ro-patient-email').text(patient.email);
                    } else {
                        $('#ro-patient-name').text('Unknown Patient');
                        $('#ro-patient-email').text('ID: ' + id);
                    }
                },
                error: function () {
                    $('#ro-patient-name').text('Error loading info');
                }
            });
        }

        function getPatients() {
            $.ajax({
                url: apiUrl("shared") + "list-patients.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (!response.success) {
                        $('#patient_uuid').html('<option value="">Error loading patients</option>');
                        return;
                    }
                    let html = '<option value="" disabled selected><?= $patient_placeholder ?></option>';
                    response.data.forEach(p => {
                        html += `<option value="${p.id}">${p.name} (${p.email})</option>`;
                    });
                    $('#patient_uuid').html(html);

                    if (config.patientUuid) {
                        $('#patient_uuid').val(config.patientUuid);
                    }
                },
                error: function () {
                    $('#patient_uuid').html('<option value="">Failed to connect to server</option>');
                }
            });
        }

        function getServices() {
            $.ajax({
                url: apiUrl("shared") + "services.php",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    if (!response.success) {
                        $grid.html('<p class="col-span-3 text-center text-muted-foreground">Error loading services.</p>');
                        return;
                    }
                    renderServices(response.data);
                },
                error: function () {
                    $grid.html('<p class="col-span-3 text-center text-muted-foreground">Failed to connect to server.</p>');
                }
            });
        }

        function renderServices(services) {
            let html = '';
            services.forEach((s, index) => {
                const icon = getServiceIcon(s.name);
                const isSelected = config.preselectedService ? (s.uuid === config.preselectedService) : (index === 0);
                const checked = isSelected ? 'checked' : '';
                html += `
                        <label class="relative group cursor-pointer h-full block">
                            <input type="radio" name="service" value="${s.uuid}" class="peer absolute opacity-0" ${checked} required />
                            <div class="h-full flex flex-col p-8 bg-card rounded-[2rem] border-2 border-transparent shadow-sm peer-checked:border-primary peer-checked:bg-primary/5 transition-all hover:shadow-md ring-primary/20 peer-checked:ring-4 relative">
                                <div class="w-16 h-16 bg-primary/10 text-primary rounded-2xl flex items-center justify-center mb-6">
                                    <span class="material-symbols-outlined text-4xl">${icon}</span>
                                </div>
                                <h3 class="text-foreground text-2xl font-black mb-3 tracking-tight">${s.name}</h3>
                                <p class="text-muted-foreground text-sm font-medium leading-relaxed mb-8">
                                    ${s.description}
                                </p>
                                <div class="mt-auto flex items-center justify-between">
                                    <div class="flex items-center gap-2 text-muted-foreground text-sm font-bold">
                                        <span class="material-symbols-outlined text-xl">schedule</span>
                                        ${s.duration} mins
                                    </div>
                                    <div class="w-8 h-8 rounded-full border-2 border-border flex items-center justify-center transition-all shadow-sm peer-checked:bg-primary">
                                        <span class="material-symbols-outlined text-white text-xl opacity-0 peer-checked:opacity-100 transition-opacity">check</span>
                                    </div>
                                </div>
                            </div>
                        </label>
                    `;
            });
            $grid.html(html);

            // Enable continue button
            $continueBtn.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');

            // Force selection if none
            if ($grid.find('input[name="service"]:checked').length === 0) {
                $grid.find('input[name="service"]').first().prop('checked', true);
            }
        }


        $form.on('submit', function (e) {
            e.preventDefault();

            const service = $('input[name="service"]:checked').val();
            // In edit mode, patientUuid comes from hidden input. In create mode, from select.
            const patientUuid = config.editUuid ? $('#patient_uuid_hidden').val() : $('select[name="patient_uuid"]').val();

            if (!service) {
                alert('Please select a service before continuing.');
                return false;
            }

            let targetUrl = `step-2-schedule.php?service=${encodeURIComponent(service)}`;
            if (patientUuid) targetUrl += `&patient_uuid=${encodeURIComponent(patientUuid)}`;
            if (config.editUuid) targetUrl += `&edit_uuid=${encodeURIComponent(config.editUuid)}`;
            if (config.doctorUuid) targetUrl += `&doctor_uuid=${encodeURIComponent(config.doctorUuid)}`;
            if (config.doctorUuid) targetUrl += `&doctor_uuid=${encodeURIComponent(config.doctorUuid)}`;
            if (config.notes) targetUrl += `&notes=${encodeURIComponent(config.notes)}`;
            if (config.date) targetUrl += `&date=${encodeURIComponent(config.date)}`;
            if (config.time) targetUrl += `&time=${encodeURIComponent(config.time)}`;

            window.location.href = targetUrl;
            return false;
        });
    });
</script>