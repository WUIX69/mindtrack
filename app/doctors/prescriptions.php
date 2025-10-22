<?php
require_once __DIR__ . '/../../core/app.php';

// Check if user is logged in and is doctor
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'doctor') {
    header('Location: ' . app('auth'));
    exit;
}

$doctor_uuid = $_SESSION['user_uuid'] ?? null;
$doctor_name = $_SESSION['username'] ?? 'Doctor';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>Prescriptions - MindTrack</title>
    <?php shared('components/elements/styles'); ?>
</head>

<body class="bg-gradient-to-br from-blue-100 via-cyan-50 to-blue-50 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php shared('components/layout/sidebar') ?>

        <!-- Main Content -->
        <div class="flex-1 p-8 overflow-y-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-prescription-bottle-alt"></i> Manage Prescriptions
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Create and manage patient prescriptions</p>
                </div>
            </div>

            <!-- Success/Error Messages -->
            <div id="successMessage" class="ui positive message hidden">
                <i class="close icon"></i>
                <div class="header">Success!</div>
                <p id="successText"></p>
            </div>

            <div id="errorMessage" class="ui negative message hidden">
                <i class="close icon"></i>
                <div class="header">Error</div>
                <p id="errorText"></p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
                <div class="bg-white rounded-lg p-4 shadow-sm border border-blue-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Prescriptions</p>
                            <p class="text-2xl font-bold text-blue-600" id="totalCount">0</p>
                        </div>
                        <i class="fas fa-pills text-3xl text-blue-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-green-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">This Month</p>
                            <p class="text-2xl font-bold text-green-600" id="monthCount">0</p>
                        </div>
                        <i class="fas fa-calendar-alt text-3xl text-green-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-purple-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Active Patients</p>
                            <p class="text-2xl font-bold text-purple-600" id="activePatients">0</p>
                        </div>
                        <i class="fas fa-users text-3xl text-purple-600 opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Appointments with Prescriptions -->
            <div class="bg-white rounded-lg shadow-sm border border-blue-50 mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-list-alt"></i> Patient Appointments & Prescriptions
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Manage prescriptions for completed appointments</p>
                </div>

                <div id="loadingAppointments" class="text-center p-10">
                    <div class="ui active inline loader"></div>
                    <p class="mt-4 text-gray-600">Loading appointments...</p>
                </div>

                <div id="appointmentsContainer" class="hidden p-6">
                    <div id="appointmentsList" class="space-y-4">
                        <!-- Populated by JavaScript -->
                    </div>
                </div>

                <div id="noAppointments" class="hidden p-10 text-center">
                    <i class="fas fa-clipboard-list text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 text-lg">No appointments found</p>
                    <p class="text-gray-500 text-sm mt-2">Complete appointments to add prescriptions</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Prescription Modal -->
    <div class="ui large modal" id="prescriptionModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="prescription icon"></i>
            <span id="modalTitle">Add Prescription</span>
        </div>
        <div class="content">
            <form class="ui form" id="prescriptionForm">
                <input type="hidden" id="appointmentUuid" name="uuid">

                <!-- Patient Info -->
                <div class="ui segment">
                    <h4 class="ui header">
                        <i class="user icon"></i>
                        Patient Information
                    </h4>
                    <div class="two fields">
                        <div class="field">
                            <label>Patient Name</label>
                            <input type="text" id="patientName" readonly>
                        </div>
                        <div class="field">
                            <label>Appointment Date</label>
                            <input type="text" id="appointmentDate" readonly>
                        </div>
                    </div>
                </div>

                <!-- Prescription -->
                <div class="field required">
                    <label>Prescription Details</label>
                    <textarea name="prescription" id="prescriptionText" rows="8" placeholder="Enter medication details, dosage, and instructions...

Example:
1. Medication Name - 500mg, twice daily after meals
2. Duration: 7 days
3. Special instructions: Avoid alcohol"></textarea>
                </div>

                <!-- Diagnosis -->
                <div class="field">
                    <label>Diagnosis / Medical Assessment</label>
                    <textarea name="diagnosis" id="diagnosisText" rows="4"
                        placeholder="Enter diagnosis or medical assessment..."></textarea>
                </div>

                <!-- Recommendations -->
                <div class="field">
                    <label>Additional Recommendations</label>
                    <textarea name="remarks" id="remarksText" rows="3"
                        placeholder="Any additional recommendations or follow-up instructions..."></textarea>
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui button" data-action="close">Cancel</button>
            <button class="ui primary button" id="savePrescriptionBtn">
                <i class="save icon"></i>
                Save Prescription
            </button>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        let appointmentsData = [];

        $(document).ready(function () {
            // Load appointments
            loadAppointments();

            // Close messages
            $('.message .close').on('click', function () {
                $(this).closest('.message').transition('fade');
            });

            // Form validation
            $('#prescriptionForm').form({
                fields: {
                    prescription: 'empty'
                }
            });

            // Save prescription
            $('#savePrescriptionBtn').on('click', function () {
                if (!$('#prescriptionForm').form('is valid')) {
                    return;
                }
                savePrescription();
            });
        });

        /**
         * Load doctor's appointments
         */
        function loadAppointments() {
            $.ajax({
                url: apiURL('appointments') + 'appointments.php?action=list',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        appointmentsData = response.data;
                        displayAppointments(appointmentsData);
                        updateStats(appointmentsData);
                    } else {
                        showError(response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to load appointments');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Load Appointments Error');
                },
                complete: function () {
                    $('#loadingAppointments').addClass('hidden');
                }
            });
        }

        /**
         * Display appointments
         */
        function displayAppointments(appointments) {
            if (appointments.length === 0) {
                $('#appointmentsContainer').addClass('hidden');
                $('#noAppointments').removeClass('hidden');
                return;
            }

            $('#appointmentsContainer').removeClass('hidden');
            $('#noAppointments').addClass('hidden');

            const container = $('#appointmentsList');
            container.empty();

            // Sort by date (newest first)
            appointments.sort((a, b) => new Date(b.appointment_date) - new Date(a.appointment_date));

            appointments.forEach(function (apt) {
                const hasPrescription = apt.prescription && apt.prescription.trim() !== '';
                const prescriptionClass = hasPrescription ? 'green' : 'orange';
                const prescriptionText = hasPrescription ? 'Has Prescription' : 'No Prescription';
                const prescriptionIcon = hasPrescription ? 'check circle' : 'exclamation circle';

                const card = `
                    <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <!-- Patient & Date -->
                                <div class="flex items-center gap-4 mb-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600 text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            ${escapeHtml(apt.patient_name || 'Unknown Patient')}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            <i class="calendar icon"></i>
                                            ${formatDate(apt.appointment_date)} at ${formatTime(apt.appointment_time)}
                                        </p>
                                    </div>
                                </div>

                                <!-- Service & Status -->
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="ui label">
                                        <i class="stethoscope icon"></i>
                                        ${escapeHtml(apt.service_type)}
                                    </span>
                                    <span class="ui label ${prescriptionClass}">
                                        <i class="${prescriptionIcon} icon"></i>
                                        ${prescriptionText}
                                    </span>
                                    ${apt.diagnosis ? '<span class="ui label blue"><i class="clipboard icon"></i> Has Diagnosis</span>' : ''}
                                    <code class="text-xs bg-gray-100 px-2 py-1 rounded">${escapeHtml(apt.booking_code)}</code>
                                </div>

                                <!-- Prescription Preview -->
                                ${hasPrescription ? `
                                    <div class="bg-green-50 p-3 rounded">
                                        <p class="text-sm text-gray-700 mb-0" style="
                                            display: -webkit-box;
                                            -webkit-line-clamp: 2;
                                            -webkit-box-orient: vertical;
                                            overflow: hidden;
                                        ">
                                            <i class="pills icon"></i>
                                            ${escapeHtml(apt.prescription).substring(0, 150)}${apt.prescription.length > 150 ? '...' : ''}
                                        </p>
                                    </div>
                                ` : ''}
                            </div>

                            <!-- Action Buttons -->
                            <div class="ml-4 flex flex-col gap-2">
                                <button class="ui ${hasPrescription ? 'blue' : 'primary'} button" onclick="openPrescriptionModal('${apt.uuid}', ${hasPrescription})">
                                    <i class="${hasPrescription ? 'edit' : 'plus'} icon"></i>
                                    ${hasPrescription ? 'Edit' : 'Add'} Prescription
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                container.append(card);
            });
        }

        /**
         * Update statistics
         */
        function updateStats(appointments) {
            const total = appointments.filter(a => a.prescription && a.prescription.trim() !== '').length;

            // Count this month's prescriptions
            const now = new Date();
            const thisMonth = appointments.filter(a => {
                if (!a.prescription || a.prescription.trim() === '') return false;
                const aptDate = new Date(a.appointment_date);
                return aptDate.getMonth() === now.getMonth() && aptDate.getFullYear() === now.getFullYear();
            }).length;

            // Count unique active patients with prescriptions
            const uniquePatients = [...new Set(appointments
                .filter(a => a.prescription && a.prescription.trim() !== '')
                .map(a => a.patient_uuid))].length;

            $('#totalCount').text(total);
            $('#monthCount').text(thisMonth);
            $('#activePatients').text(uniquePatients);
        }

        /**
         * Open prescription modal
         */
        function openPrescriptionModal(uuid, hasPrescription) {
            const apt = appointmentsData.find(a => a.uuid === uuid);
            if (!apt) return;

            $('#modalTitle').text(hasPrescription ? 'Edit Prescription' : 'Add Prescription');
            $('#appointmentUuid').val(uuid);
            $('#patientName').val(apt.patient_name || 'Unknown');
            $('#appointmentDate').val(formatDate(apt.appointment_date));
            $('#prescriptionText').val(apt.prescription || '');
            $('#diagnosisText').val(apt.diagnosis || '');
            $('#remarksText').val(apt.remarks || '');

            $('#prescriptionModal').modal('show');
        }

        /**
         * Save prescription
         */
        function savePrescription() {
            const formData = new URLSearchParams({
                action: 'medical_notes',
                uuid: $('#appointmentUuid').val(),
                prescription: $('#prescriptionText').val().trim(),
                diagnosis: $('#diagnosisText').val().trim()
            });

            $('#savePrescriptionBtn').addClass('loading disabled');

            $.ajax({
                url: apiURL('appointments') + 'appointments.php',
                method: 'PUT',
                data: formData.toString(),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        showSuccess('Prescription saved successfully!');
                        $('#prescriptionModal').modal('hide');
                        loadAppointments(); // Reload data
                    } else {
                        showError(response.message || 'Failed to save prescription');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to save prescription');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Save Prescription Error');
                },
                complete: function () {
                    $('#savePrescriptionBtn').removeClass('loading disabled');
                }
            });
        }

        /**
         * Show success message
         */
        function showSuccess(message) {
            $('#successText').text(message);
            $('#successMessage').removeClass('hidden');
            setTimeout(() => $('#successMessage').addClass('hidden'), 3000);
        }

        /**
         * Show error message
         */
        function showError(message) {
            $('#errorText').text(message);
            $('#errorMessage').removeClass('hidden');
            setTimeout(() => $('#errorMessage').addClass('hidden'), 5000);
        }

        /**
         * Format date
         */
        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        }

        /**
         * Format time
         */
        function formatTime(timeString) {
            if (!timeString) return 'N/A';
            const [hours, minutes] = timeString.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour % 12 || 12;
            return `${displayHour}:${minutes} ${ampm}`;
        }

        /**
         * Escape HTML
         */
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</body>

</html>