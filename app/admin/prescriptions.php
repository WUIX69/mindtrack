<?php
require_once __DIR__ . '/../../core/app.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: ' . app('auth'));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>Prescriptions - MindTrack Admin</title>
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
                        <i class="fas fa-prescription-bottle-alt"></i> Prescriptions Overview
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Monitor all prescriptions across the system</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">
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

                <div class="bg-white rounded-lg p-4 shadow-sm border border-orange-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Active Doctors</p>
                            <p class="text-2xl font-bold text-orange-600" id="activeDoctors">0</p>
                        </div>
                        <i class="fas fa-user-md text-3xl text-orange-600 opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Prescriptions List -->
            <div class="bg-white rounded-lg shadow-sm border border-blue-50 mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-list-alt"></i> All Prescriptions
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">System-wide prescription records</p>
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
                    <p class="text-gray-600 text-lg">No prescriptions found</p>
                </div>
            </div>
        </div>
    </div>

    <!-- View Prescription Modal -->
    <div class="ui large modal" id="viewPrescriptionModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="prescription icon"></i>
            Prescription Details
        </div>
        <div class="content">
            <div class="ui grid">
                <div class="eight wide column">
                    <h4 class="ui dividing header">Patient Information</h4>
                    <div class="ui relaxed list">
                        <div class="item">
                            <strong>Patient:</strong> <span id="viewPatientName">-</span>
                        </div>
                        <div class="item">
                            <strong>Patient ID:</strong> <span id="viewPatientId">-</span>
                        </div>
                        <div class="item">
                            <strong>Appointment:</strong> <span id="viewAppointmentDate">-</span>
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
                            <strong>Service:</strong> <span id="viewServiceType">-</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ui divider"></div>

            <div class="mb-4">
                <h4 class="ui header">
                    <i class="pills icon"></i>
                    Prescription
                </h4>
                <div class="ui segment" style="background: #e8f5e9;">
                    <div id="viewPrescriptionContent" class="text-gray-700" style="white-space: pre-wrap;"></div>
                </div>
            </div>

            <div id="diagnosisSection">
                <h4 class="ui header">
                    <i class="stethoscope icon"></i>
                    Diagnosis
                </h4>
                <div class="ui segment" style="background: #fff3e0;">
                    <div id="viewDiagnosisContent" class="text-gray-700" style="white-space: pre-wrap;"></div>
                </div>
            </div>
        </div>
        <div class="actions">
            <button class="ui button" data-action="close">Close</button>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        let prescriptionsData = [];

        $(document).ready(function () {
            loadPrescriptions();
        });

        /**
         * Load all prescriptions
         */
        function loadPrescriptions() {
            $.ajax({
                url: apiURL('appointments') + 'appointments.php?action=list',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Filter appointments with prescriptions
                        prescriptionsData = response.data.filter(apt =>
                            apt.prescription && apt.prescription.trim() !== ''
                        );
                        displayPrescriptions(prescriptionsData);
                        updateStats(prescriptionsData);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Failed to load prescriptions');
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

            prescriptions.sort((a, b) => new Date(b.appointment_date) - new Date(a.appointment_date));

            prescriptions.forEach(function (apt) {
                const card = `
                    <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-4 mb-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-pills text-blue-600 text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            ${escapeHtml(apt.patient_name || 'Unknown Patient')}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            <i class="calendar icon"></i>
                                            ${formatDate(apt.appointment_date)}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-3">
                                    <div>
                                        <p class="text-xs text-gray-500">Doctor</p>
                                        <p class="text-sm font-medium">${escapeHtml(apt.doctor_name || 'Not assigned')}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Service</p>
                                        <p class="text-sm font-medium">${escapeHtml(apt.service_type)}</p>
                                    </div>
                                </div>

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

                                <div class="flex items-center gap-2">
                                    ${apt.diagnosis ? '<span class="ui mini label blue"><i class="stethoscope icon"></i> Has Diagnosis</span>' : ''}
                                    <code class="text-xs bg-gray-100 px-2 py-1 rounded">${escapeHtml(apt.booking_code)}</code>
                                </div>
                            </div>

                            <div class="ml-4">
                                <button class="ui blue button" onclick="viewPrescription('${apt.uuid}')">
                                    <i class="eye icon"></i>
                                    View Details
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
        function updateStats(prescriptions) {
            const total = prescriptions.length;

            const now = new Date();
            const thisMonth = prescriptions.filter(p => {
                const date = new Date(p.appointment_date);
                return date.getMonth() === now.getMonth() && date.getFullYear() === now.getFullYear();
            }).length;

            const uniquePatients = [...new Set(prescriptions.map(p => p.patient_uuid))].length;
            const uniqueDoctors = [...new Set(prescriptions.map(p => p.doctor_uuid))].length;

            $('#totalCount').text(total);
            $('#monthCount').text(thisMonth);
            $('#activePatients').text(uniquePatients);
            $('#activeDoctors').text(uniqueDoctors);
        }

        /**
         * View prescription details
         */
        function viewPrescription(uuid) {
            const apt = prescriptionsData.find(a => a.uuid === uuid);
            if (!apt) return;

            $('#viewPatientName').text(apt.patient_name || 'Unknown');
            $('#viewPatientId').text(apt.patient_custom_id || 'N/A');
            $('#viewAppointmentDate').text(formatDate(apt.appointment_date));
            $('#viewDoctorName').text(apt.doctor_name || 'Not assigned');
            $('#viewSpecialization').text(apt.specialization || 'General Practitioner');
            $('#viewServiceType').text(apt.service_type);
            $('#viewPrescriptionContent').text(apt.prescription);

            if (apt.diagnosis && apt.diagnosis.trim() !== '') {
                $('#diagnosisSection').show();
                $('#viewDiagnosisContent').text(apt.diagnosis);
            } else {
                $('#diagnosisSection').hide();
            }

            $('#viewPrescriptionModal').modal('show');
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