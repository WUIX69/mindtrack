<?php
require_once __DIR__ . '/../../core/app.php';

use MindTrack\Models\Users;

// Check if user is logged in and is patient
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'patient') {
    header('Location: ' . app('auth'));
    exit;
}

$patient_uuid = $_SESSION['user_uuid'] ?? null;
$patient_name = $_SESSION['username'] ?? 'Patient';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>My Prescriptions - MindTrack</title>
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
                        <i class="fas fa-prescription-bottle-alt"></i> My Prescriptions
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">View your medication prescriptions and reminders</p>
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
                            <p class="text-sm text-gray-600">Active Prescriptions</p>
                            <p class="text-2xl font-bold text-green-600" id="activeCount">0</p>
                        </div>
                        <i class="fas fa-check-circle text-3xl text-green-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-purple-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Last Prescribed</p>
                            <p class="text-sm font-bold text-purple-600" id="lastPrescribed">N/A</p>
                        </div>
                        <i class="fas fa-calendar-alt text-3xl text-purple-600 opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Prescriptions List -->
            <div class="bg-white rounded-lg shadow-sm border border-blue-50 mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-list-alt"></i> Prescription History
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">All prescriptions from your appointments</p>
                </div>

                <div id="loadingPrescriptions" class="text-center p-10">
                    <div class="ui active inline loader"></div>
                    <p class="mt-4 text-gray-600">Loading prescriptions...</p>
                </div>

                <div id="prescriptionsContainer" class="hidden p-6">
                    <div id="prescriptionsList" class="space-y-4">
                        <!-- Populated by JavaScript -->
                    </div>
                </div>

                <div id="noPrescriptions" class="hidden p-10 text-center">
                    <i class="fas fa-prescription-bottle text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 text-lg">No prescriptions yet</p>
                    <p class="text-gray-500 text-sm mt-2">Your prescriptions will appear here after your doctor
                        appointments</p>
                </div>
            </div>
        </div>
    </div>

    <!-- View Prescription Details Modal -->
    <div class="ui large modal" id="viewPrescriptionModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="prescription icon"></i>
            Prescription Details
        </div>
        <div class="content">
            <!-- Appointment Info -->
            <div class="ui grid">
                <div class="eight wide column">
                    <h4 class="ui dividing header">Appointment Information</h4>
                    <div class="ui relaxed list">
                        <div class="item">
                            <strong>Date:</strong> <span id="viewAppointmentDate">-</span>
                        </div>
                        <div class="item">
                            <strong>Service Type:</strong> <span id="viewServiceType">-</span>
                        </div>
                        <div class="item">
                            <strong>Booking Code:</strong> <code id="viewBookingCode">-</code>
                        </div>
                    </div>
                </div>
                <div class="eight wide column">
                    <h4 class="ui dividing header">Doctor Information</h4>
                    <div class="ui relaxed list">
                        <div class="item">
                            <strong>Doctor:</strong> <span id="viewDoctorName">-</span>
                        </div>
                        <div class="item">
                            <strong>Specialization:</strong> <span id="viewSpecialization">-</span>
                        </div>
                        <div class="item">
                            <strong>Contact:</strong> <span id="viewDoctorPhone">-</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ui divider"></div>

            <!-- Prescription Details -->
            <div class="mb-4">
                <h4 class="ui header">
                    <i class="pills icon"></i>
                    <div class="content">
                        Prescription
                        <div class="sub header">Medication instructions and dosage</div>
                    </div>
                </h4>
                <div class="ui segment" style="background: #e8f5e9;">
                    <div id="viewPrescriptionContent" class="text-gray-700"
                        style="white-space: pre-wrap; font-size: 14px; line-height: 1.8;">
                        <!-- Populated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Diagnosis (if available) -->
            <div id="diagnosisSection" class="mb-4">
                <h4 class="ui header">
                    <i class="stethoscope icon"></i>
                    <div class="content">
                        Diagnosis
                        <div class="sub header">Medical assessment</div>
                    </div>
                </h4>
                <div class="ui segment" style="background: #fff3e0;">
                    <div id="viewDiagnosisContent" class="text-gray-700"
                        style="white-space: pre-wrap; font-size: 14px; line-height: 1.8;">
                        <!-- Populated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Reminders Section -->
            <div class="ui info message">
                <div class="header">
                    <i class="bell icon"></i>
                    Medication Reminders
                </div>
                <ul class="list">
                    <li>Take your medication as prescribed by your doctor</li>
                    <li>Follow the dosage instructions carefully</li>
                    <li>Complete the full course of treatment</li>
                    <li>Contact your doctor if you experience any side effects</li>
                </ul>
            </div>
        </div>
        <div class="actions">
            <button class="ui primary button" onclick="window.print()">
                <i class="print icon"></i>
                Print Prescription
            </button>
            <button class="ui button" data-action="close">Close</button>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        let prescriptionsData = [];

        $(document).ready(function () {
            // Load prescriptions on page load
            loadPrescriptions();

            // Close messages
            $('.message .close').on('click', function () {
                $(this).closest('.message').transition('fade');
            });
        });

        /**
         * Load all patient prescriptions from appointments
         */
        function loadPrescriptions() {
            $.ajax({
                url: apiURL('appointments') + 'appointments.php?action=list',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Filter appointments that have prescriptions
                        const appointmentsWithPrescriptions = response.data.filter(apt =>
                            apt.prescription && apt.prescription.trim() !== ''
                        );
                        prescriptionsData = appointmentsWithPrescriptions;
                        displayPrescriptions(prescriptionsData);
                        updateStats(prescriptionsData);
                    } else {
                        showError(response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to load prescriptions');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Load Prescriptions Error');
                },
                complete: function () {
                    $('#loadingPrescriptions').addClass('hidden');
                }
            });
        }

        /**
         * Display prescriptions
         */
        function displayPrescriptions(prescriptions) {
            if (prescriptions.length === 0) {
                $('#prescriptionsContainer').addClass('hidden');
                $('#noPrescriptions').removeClass('hidden');
                return;
            }

            $('#prescriptionsContainer').removeClass('hidden');
            $('#noPrescriptions').addClass('hidden');

            const container = $('#prescriptionsList');
            container.empty();

            // Sort by date (newest first)
            prescriptions.sort((a, b) => new Date(b.appointment_date) - new Date(a.appointment_date));

            prescriptions.forEach(function (apt) {
                const isActive = apt.status === 'completed' && isRecentPrescription(apt.appointment_date);
                const statusClass = isActive ? 'green' : 'grey';
                const statusText = isActive ? 'Active' : 'Past';

                const card = `
                    <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <!-- Header -->
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-pills text-2xl text-blue-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            ${escapeHtml(apt.service_type)}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            <i class="calendar icon"></i>
                                            ${formatDate(apt.appointment_date)}
                                        </p>
                                    </div>
                                    <span class="ui label ${statusClass}">
                                        ${statusText}
                                    </span>
                                </div>

                                <!-- Doctor Info -->
                                <div class="flex items-center gap-2 mb-3">
                                    <i class="user md icon text-gray-500"></i>
                                    <span class="text-sm text-gray-700">
                                        <strong>Doctor:</strong> ${escapeHtml(apt.doctor_name || 'Not assigned')}
                                    </span>
                                    ${apt.specialization ? `
                                        <span class="text-sm text-gray-500">
                                            (${escapeHtml(apt.specialization)})
                                        </span>
                                    ` : ''}
                                </div>

                                <!-- Prescription Preview -->
                                <div class="bg-green-50 p-3 rounded mb-3">
                                    <p class="text-sm text-gray-700 mb-0" style="
                                        display: -webkit-box;
                                        -webkit-line-clamp: 2;
                                        -webkit-box-orient: vertical;
                                        overflow: hidden;
                                    ">
                                        <i class="prescription icon"></i>
                                        ${escapeHtml(apt.prescription).substring(0, 150)}${apt.prescription.length > 150 ? '...' : ''}
                                    </p>
                                </div>

                                <!-- Booking Code -->
                                <div class="flex items-center gap-2">
                                    <code class="text-xs bg-gray-100 px-2 py-1 rounded">
                                        ${escapeHtml(apt.booking_code)}
                                    </code>
                                    ${apt.diagnosis ? '<span class="ui mini label blue"><i class="stethoscope icon"></i> Includes Diagnosis</span>' : ''}
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div class="ml-4">
                                <button class="ui blue button" onclick="viewPrescription('${apt.uuid}')">
                                    <i class="eye icon"></i>
                                    View Full
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                container.append(card);
            });
        }

        /**
         * Check if prescription is recent (within last 90 days)
         */
        function isRecentPrescription(dateString) {
            const prescriptionDate = new Date(dateString);
            const today = new Date();
            const diffTime = today - prescriptionDate;
            const diffDays = diffTime / (1000 * 60 * 60 * 24);
            return diffDays <= 90;
        }

        /**
         * Update statistics
         */
        function updateStats(prescriptions) {
            const total = prescriptions.length;
            const active = prescriptions.filter(p => isRecentPrescription(p.appointment_date)).length;

            $('#totalCount').text(total);
            $('#activeCount').text(active);

            if (prescriptions.length > 0) {
                const latest = prescriptions.sort((a, b) =>
                    new Date(b.appointment_date) - new Date(a.appointment_date)
                )[0];
                $('#lastPrescribed').text(formatDate(latest.appointment_date));
            } else {
                $('#lastPrescribed').text('N/A');
            }
        }

        /**
         * View full prescription details
         */
        function viewPrescription(uuid) {
            $.ajax({
                url: apiURL('appointments') + 'appointments.php?action=single&uuid=' + uuid,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success && response.data) {
                        const apt = response.data;

                        // Populate appointment info
                        $('#viewAppointmentDate').text(formatDate(apt.appointment_date));
                        $('#viewServiceType').text(apt.service_type);
                        $('#viewBookingCode').text(apt.booking_code);

                        // Populate doctor info
                        $('#viewDoctorName').text(apt.doctor_name || 'Not assigned');
                        $('#viewSpecialization').text(apt.specialization || 'General Practitioner');
                        $('#viewDoctorPhone').text(apt.doctor_phone || 'N/A');

                        // Populate prescription
                        $('#viewPrescriptionContent').html(formatPrescriptionText(apt.prescription));

                        // Populate diagnosis (if available)
                        if (apt.diagnosis && apt.diagnosis.trim() !== '') {
                            $('#diagnosisSection').show();
                            $('#viewDiagnosisContent').text(apt.diagnosis);
                        } else {
                            $('#diagnosisSection').hide();
                        }

                        $('#viewPrescriptionModal').modal('show');
                    } else {
                        showError(response.message || 'Failed to load prescription details');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to load prescription details');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'View Prescription Error');
                }
            });
        }

        /**
         * Format prescription text with better readability
         */
        function formatPrescriptionText(text) {
            if (!text) return 'No prescription available';

            // Escape HTML first
            const escaped = escapeHtml(text);

            // Add bullet points for lines that start with numbers or dashes
            return escaped.split('\n').map(line => {
                line = line.trim();
                if (!line) return '<br>';

                // Detect medication lines (usually start with numbers or drug names)
                if (/^\d+\./.test(line) || /^-/.test(line)) {
                    return `<div style="margin: 8px 0; padding-left: 12px;">
                        <i class="circle icon tiny" style="color: #4CAF50;"></i> ${line}
                    </div>`;
                }

                return `<div style="margin: 4px 0;">${line}</div>`;
            }).join('');
        }

        /**
         * Show success message
         */
        function showSuccess(message) {
            $('#successText').text(message);
            $('#successMessage').removeClass('hidden');
            setTimeout(function () {
                $('#successMessage').addClass('hidden');
            }, 3000);
        }

        /**
         * Show error message
         */
        function showError(message) {
            $('#errorText').text(message);
            $('#errorMessage').removeClass('hidden');
            setTimeout(function () {
                $('#errorMessage').addClass('hidden');
            }, 5000);
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