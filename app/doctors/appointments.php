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
    <title>My Appointments - MindTrack</title>
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
                        <i class="fas fa-calendar-check"></i> My Appointments
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Manage and view patient appointments</p>
                </div>
                <button class="ui primary button" id="addAppointmentBtn">
                    <i class="plus icon"></i>
                    Schedule Appointment
                </button>
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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">
                <div class="bg-white rounded-lg p-4 shadow-sm border border-blue-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="text-2xl font-bold text-blue-600" id="totalCount">0</p>
                        </div>
                        <i class="fas fa-calendar text-3xl text-blue-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-green-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Scheduled</p>
                            <p class="text-2xl font-bold text-green-600" id="scheduledCount">0</p>
                        </div>
                        <i class="fas fa-clock text-3xl text-green-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Completed</p>
                            <p class="text-2xl font-bold text-gray-600" id="completedCount">0</p>
                        </div>
                        <i class="fas fa-check-circle text-3xl text-gray-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-red-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Cancelled</p>
                            <p class="text-2xl font-bold text-red-600" id="cancelledCount">0</p>
                        </div>
                        <i class="fas fa-times-circle text-3xl text-red-600 opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Filters & Search -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="ui search">
                        <div class="ui icon input w-full">
                            <input type="text" placeholder="Search by patient name..." id="searchInput">
                            <i class="search icon"></i>
                        </div>
                    </div>

                    <select class="ui dropdown" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="no-show">No-Show</option>
                    </select>

                    <input type="date" class="ui input" id="dateFilter" placeholder="Filter by date">

                    <button class="ui button" id="resetFilters">
                        <i class="redo icon"></i>
                        Reset Filters
                    </button>
                </div>
            </div>

            <!-- Appointments Table -->
            <div class="bg-white rounded-lg shadow-sm border border-blue-50 overflow-hidden">
                <div class="p-5 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-800">Appointments List</h3>
                </div>

                <div id="loadingSpinner" class="text-center p-10">
                    <div class="ui active inline loader"></div>
                    <p class="mt-4 text-gray-600">Loading appointments...</p>
                </div>

                <div id="appointmentsTableContainer" class="hidden">
                    <table class="ui celled table" id="appointmentsTable">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Date & Time</th>
                                <th>Service Type</th>
                                <th>Status</th>
                                <th>Booking Code</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="appointmentsTableBody">
                            <!-- Populated by JavaScript -->
                        </tbody>
                    </table>
                </div>

                <div id="noAppointments" class="hidden p-10 text-center">
                    <i class="far fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 text-lg">No appointments found</p>
                    <button class="ui primary button mt-4" id="addFirstAppointment">
                        <i class="plus icon"></i>
                        Schedule Your First Appointment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Appointment Modal -->
    <div class="ui modal" id="appointmentModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="calendar plus icon"></i>
            <span id="modalTitle">Schedule New Appointment</span>
        </div>
        <div class="content">
            <form class="ui form" id="appointmentForm">
                <input type="hidden" id="appointmentUuid" name="uuid">

                <div class="field required">
                    <label>Patient</label>
                    <select name="patient_uuid" id="patientSelect" class="ui search dropdown">
                        <option value="">Select Patient</option>
                        <!-- Populated by JavaScript -->
                    </select>
                </div>

                <div class="two fields">
                    <div class="field required">
                        <label>Appointment Date</label>
                        <input type="date" name="appointment_date" id="appointmentDate" min="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="field required">
                        <label>Appointment Time</label>
                        <input type="time" name="appointment_time" id="appointmentTime">
                    </div>
                </div>

                <div class="field required">
                    <label>Service Type</label>
                    <select name="service_type" id="serviceType" class="ui dropdown">
                        <option value="">Select Service</option>
                        <option value="Consultation">Consultation</option>
                        <option value="Therapy Session">Therapy Session</option>
                        <option value="Follow-up">Follow-up</option>
                        <option value="Evaluation">Evaluation</option>
                        <option value="Counseling">Counseling</option>
                    </select>
                </div>

                <div class="field">
                    <label>Remarks</label>
                    <textarea name="remarks" id="remarks" rows="3"
                        placeholder="Additional notes or special instructions..."></textarea>
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui cancel button">Cancel</button>
            <button class="ui positive button" id="saveAppointmentBtn">
                <i class="save icon"></i>
                Save Appointment
            </button>
        </div>
    </div>

    <!-- View Appointment Details Modal -->
    <div class="ui modal" id="viewAppointmentModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="info circle icon"></i>
            Appointment Details
        </div>
        <div class="content">
            <div class="ui grid">
                <div class="eight wide column">
                    <h4 class="ui dividing header">Patient Information</h4>
                    <div class="ui relaxed list">
                        <div class="item">
                            <strong>Name:</strong> <span id="viewPatientName">-</span>
                        </div>
                        <div class="item">
                            <strong>Patient ID:</strong> <span id="viewPatientId">-</span>
                        </div>
                        <div class="item">
                            <strong>Email:</strong> <span id="viewPatientEmail">-</span>
                        </div>
                        <div class="item">
                            <strong>Phone:</strong> <span id="viewPatientPhone">-</span>
                        </div>
                    </div>
                </div>
                <div class="eight wide column">
                    <h4 class="ui dividing header">Appointment Details</h4>
                    <div class="ui relaxed list">
                        <div class="item">
                            <strong>Date:</strong> <span id="viewDate">-</span>
                        </div>
                        <div class="item">
                            <strong>Time:</strong> <span id="viewTime">-</span>
                        </div>
                        <div class="item">
                            <strong>Service:</strong> <span id="viewService">-</span>
                        </div>
                        <div class="item">
                            <strong>Status:</strong> <span id="viewStatus">-</span>
                        </div>
                        <div class="item">
                            <strong>Booking Code:</strong> <span id="viewBookingCode">-</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui divider"></div>
            <div>
                <h4 class="ui header">Remarks</h4>
                <p id="viewRemarks" class="text-gray-600">-</p>
            </div>
            <div class="mt-4" id="viewMedicalNotesSection">
                <h4 class="ui header">Medical Notes</h4>
                <div class="ui segment">
                    <strong>Prescription:</strong>
                    <p id="viewPrescription" class="text-gray-600 mt-2">No prescription added</p>
                </div>
                <div class="ui segment">
                    <strong>Diagnosis:</strong>
                    <p id="viewDiagnosis" class="text-gray-600 mt-2">No diagnosis added</p>
                </div>
            </div>
        </div>
        <div class="actions">
            <button class="ui button" data-action="close">Close</button>
            <button class="ui blue button" id="addMedicalNotesBtn">
                <i class="file medical icon"></i>
                Add Medical Notes
            </button>
        </div>
    </div>

    <!-- Medical Notes Modal -->
    <div class="ui modal" id="medicalNotesModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="file medical icon"></i>
            Add Medical Notes
        </div>
        <div class="content">
            <form class="ui form" id="medicalNotesForm">
                <input type="hidden" id="medicalNotesUuid">

                <div class="field">
                    <label>Prescription</label>
                    <textarea name="prescription" id="prescriptionText" rows="4"
                        placeholder="Enter prescription details..."></textarea>
                </div>

                <div class="field">
                    <label>Diagnosis</label>
                    <textarea name="diagnosis" id="diagnosisText" rows="4" placeholder="Enter diagnosis..."></textarea>
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui cancel button">Cancel</button>
            <button class="ui positive button" id="saveMedicalNotesBtn">
                <i class="save icon"></i>
                Save Notes
            </button>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        let appointmentsData = [];
        let currentAppointmentUuid = null;

        $(document).ready(function () {
            // Initialize dropdowns
            $('.ui.dropdown').dropdown();

            // Load appointments on page load
            loadAppointments();

            // Load patients for dropdown
            loadPatients();

            // Close messages
            $('.message .close').on('click', function () {
                $(this).closest('.message').transition('fade');
            });

            // Event Listeners
            $('#addAppointmentBtn, #addFirstAppointment').on('click', openAddModal);
            $('#saveAppointmentBtn').on('click', saveAppointment);
            $('#resetFilters').on('click', resetFilters);
            $('#searchInput').on('keyup', filterAppointments);
            $('#statusFilter, #dateFilter').on('change', filterAppointments);
            $('#saveMedicalNotesBtn').on('click', saveMedicalNotes);
        });

        /**
         * Load all appointments from server
         */
        function loadAppointments() {
            $('#loadingSpinner').removeClass('hidden');
            $('#appointmentsTableContainer').addClass('hidden');
            $('#noAppointments').addClass('hidden');

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
                    $('#loadingSpinner').addClass('hidden');
                }
            });
        }

        /**
         * Display appointments in table
         */
        function displayAppointments(appointments) {
            const tbody = $('#appointmentsTableBody');
            tbody.empty();

            if (appointments.length === 0) {
                $('#appointmentsTableContainer').addClass('hidden');
                $('#noAppointments').removeClass('hidden');
                return;
            }

            $('#appointmentsTableContainer').removeClass('hidden');
            $('#noAppointments').addClass('hidden');

            appointments.forEach(function (apt) {
                const statusClass = apt.status === 'scheduled' ? 'green' :
                    apt.status === 'completed' ? 'grey' :
                        apt.status === 'cancelled' ? 'red' : 'orange';

                const row = `
                    <tr data-uuid="${apt.uuid}">
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-200 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-semibold text-sm">
                                        ${apt.patient_name ? apt.patient_name.charAt(0).toUpperCase() : 'P'}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">${escapeHtml(apt.patient_name || 'N/A')}</p>
                                    <p class="text-xs text-gray-500">${escapeHtml(apt.patient_custom_id || '')}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <p class="font-medium text-gray-800">
                                    <i class="calendar icon"></i>
                                    ${formatDate(apt.appointment_date)}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <i class="clock icon"></i>
                                    ${formatTime(apt.appointment_time)}
                                </p>
                            </div>
                        </td>
                        <td>${escapeHtml(apt.service_type)}</td>
                        <td>
                            <span class="ui label ${statusClass}">
                                ${apt.status.charAt(0).toUpperCase() + apt.status.slice(1)}
                            </span>
                        </td>
                        <td><code>${escapeHtml(apt.booking_code)}</code></td>
                        <td>
                            <div class="ui mini buttons">
                                <button class="ui blue icon button" onclick="viewAppointment('${apt.uuid}')" data-tooltip="View Details">
                                    <i class="eye icon"></i>
                                </button>
                                ${apt.status === 'scheduled' ? `
                                <button class="ui positive icon button" onclick="updateStatus('${apt.uuid}', 'completed')" data-tooltip="Mark Completed">
                                    <i class="check icon"></i>
                                </button>
                                <button class="ui orange icon button" onclick="editAppointment('${apt.uuid}')" data-tooltip="Edit">
                                    <i class="edit icon"></i>
                                </button>
                                <button class="ui red icon button" onclick="cancelAppointment('${apt.uuid}')" data-tooltip="Cancel">
                                    <i class="times icon"></i>
                                </button>
                                ` : ''}
                            </div>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });

            // Initialize tooltips
            $('[data-tooltip]').popup();
        }

        /**
         * Update statistics
         */
        function updateStats(appointments) {
            const total = appointments.length;
            const scheduled = appointments.filter(a => a.status === 'scheduled').length;
            const completed = appointments.filter(a => a.status === 'completed').length;
            const cancelled = appointments.filter(a => a.status === 'cancelled').length;

            $('#totalCount').text(total);
            $('#scheduledCount').text(scheduled);
            $('#completedCount').text(completed);
            $('#cancelledCount').text(cancelled);
        }

        /**
         * Load patients for dropdown
         */
        function loadPatients() {
            $.ajax({
                url: apiURL('users') + 'users.php?action=patients',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success && response.data) {
                        const patients = response.data;
                        const $select = $('#patientSelect');

                        // Clear existing options except the first one
                        $select.find('option:not(:first)').remove();

                        // Populate dropdown with patients
                        patients.forEach(function (patient) {
                            const option = `<option value="${patient.uuid}">
                                ${escapeHtml(patient.full_name)} - ${escapeHtml(patient.patient_custom_id || 'N/A')}
                            </option>`;
                            $select.append(option);
                        });

                        // Refresh dropdown
                        $select.dropdown('refresh');

                        console.log(`Loaded ${patients.length} patients`);
                    } else {
                        console.error('Failed to load patients:', response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Error loading patients');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Load Patients Error');
                }
            });
        }

        /**
         * Open add appointment modal
         */
        function openAddModal() {
            $('#modalTitle').text('Schedule New Appointment');
            $('#appointmentForm')[0].reset();
            $('#appointmentUuid').val('');
            $('.ui.dropdown').dropdown('clear');
            $('#appointmentModal').modal('show');
        }

        /**
         * Edit appointment
         */
        function editAppointment(uuid) {
            const apt = appointmentsData.find(a => a.uuid === uuid);
            if (!apt) return;

            $('#modalTitle').text('Edit Appointment');
            $('#appointmentUuid').val(apt.uuid);
            $('#patientSelect').dropdown('set selected', apt.patient_uuid);
            $('#appointmentDate').val(apt.appointment_date);
            $('#appointmentTime').val(apt.appointment_time);
            $('#serviceType').dropdown('set selected', apt.service_type);
            $('#remarks').val(apt.remarks || '');

            $('#appointmentModal').modal('show');
        }

        /**
         * Save appointment (create or update)
         */
        function saveAppointment() {
            const uuid = $('#appointmentUuid').val();
            const isEdit = uuid !== '';

            const formData = {
                patient_uuid: $('#patientSelect').val(),
                appointment_date: $('#appointmentDate').val(),
                appointment_time: $('#appointmentTime').val(),
                service_type: $('#serviceType').val(),
                remarks: $('#remarks').val()
            };

            // Validation
            if (!formData.patient_uuid || !formData.appointment_date || !formData.appointment_time || !formData.service_type) {
                showError('Please fill in all required fields');
                return;
            }

            if (isEdit) {
                formData.uuid = uuid;
                formData.action = 'update';
            }

            const url = isEdit ?
                apiURL('appointments') + 'appointments.php' :
                apiURL('appointments') + 'appointments.php';

            const method = isEdit ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                method: method,
                data: formData,
                dataType: 'json',
                beforeSend: function () {
                    $('#saveAppointmentBtn').addClass('loading');
                },
                success: function (response) {
                    if (response.success) {
                        showSuccess(response.message);
                        $('#appointmentModal').modal('hide');
                        loadAppointments();
                    } else {
                        showError(response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to save appointment');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Save Appointment Error');
                },
                complete: function () {
                    $('#saveAppointmentBtn').removeClass('loading');
                }
            });
        }

        /**
         * View appointment details
         */
        function viewAppointment(uuid) {
            $.ajax({
                url: apiURL('appointments') + 'appointments.php?action=single&uuid=' + uuid,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success && response.data) {
                        const apt = response.data;

                        // Populate modal
                        $('#viewPatientName').text(apt.patient_name || 'N/A');
                        $('#viewPatientId').text(apt.patient_custom_id || 'N/A');
                        $('#viewPatientEmail').text(apt.patient_email || 'N/A');
                        $('#viewPatientPhone').text(apt.patient_phone || 'N/A');
                        $('#viewDate').text(formatDate(apt.appointment_date));
                        $('#viewTime').text(formatTime(apt.appointment_time));
                        $('#viewService').text(apt.service_type);
                        $('#viewStatus').html(`<span class="ui label">${apt.status}</span>`);
                        $('#viewBookingCode').text(apt.booking_code);
                        $('#viewRemarks').text(apt.remarks || 'No remarks');
                        $('#viewPrescription').text(apt.prescription || 'No prescription added');
                        $('#viewDiagnosis').text(apt.diagnosis || 'No diagnosis added');

                        // Store current UUID for medical notes
                        currentAppointmentUuid = uuid;

                        $('#viewAppointmentModal').modal('show');
                    } else {
                        showError(response.message || 'Failed to load appointment details');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to load appointment details');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'View Appointment Error');
                }
            });
        }

        /**
         * Open medical notes modal
         */
        $('#addMedicalNotesBtn').on('click', function () {
            if (!currentAppointmentUuid) return;

            $('#medicalNotesUuid').val(currentAppointmentUuid);
            $('#prescriptionText').val($('#viewPrescription').text() !== 'No prescription added' ? $('#viewPrescription').text() : '');
            $('#diagnosisText').val($('#viewDiagnosis').text() !== 'No diagnosis added' ? $('#viewDiagnosis').text() : '');

            $('#viewAppointmentModal').modal('hide');
            $('#medicalNotesModal').modal('show');
        });

        /**
         * Save medical notes
         */
        function saveMedicalNotes() {
            const uuid = $('#medicalNotesUuid').val();
            const prescription = $('#prescriptionText').val();
            const diagnosis = $('#diagnosisText').val();

            $.ajax({
                url: apiURL('appointments') + 'appointments.php',
                method: 'PUT',
                data: {
                    action: 'medical_notes',
                    uuid: uuid,
                    prescription: prescription,
                    diagnosis: diagnosis
                },
                dataType: 'json',
                beforeSend: function () {
                    $('#saveMedicalNotesBtn').addClass('loading');
                },
                success: function (response) {
                    if (response.success) {
                        showSuccess(response.message);
                        $('#medicalNotesModal').modal('hide');
                        loadAppointments();
                    } else {
                        showError(response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to save medical notes');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Save Medical Notes Error');
                },
                complete: function () {
                    $('#saveMedicalNotesBtn').removeClass('loading');
                }
            });
        }

        /**
         * Update appointment status
         */
        function updateStatus(uuid, status) {
            if (!confirm(`Are you sure you want to mark this appointment as ${status}?`)) {
                return;
            }

            $.ajax({
                url: apiURL('appointments') + 'appointments.php',
                method: 'PUT',
                data: {
                    action: 'status',
                    uuid: uuid,
                    status: status
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        showSuccess(response.message);
                        loadAppointments();
                    } else {
                        showError(response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to update status');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Update Status Error');
                }
            });
        }

        /**
         * Cancel appointment
         */
        function cancelAppointment(uuid) {
            if (!confirm('Are you sure you want to cancel this appointment?')) {
                return;
            }

            updateStatus(uuid, 'cancelled');
        }

        /**
         * Filter appointments
         */
        function filterAppointments() {
            const searchTerm = $('#searchInput').val().toLowerCase();
            const statusFilter = $('#statusFilter').val();
            const dateFilter = $('#dateFilter').val();

            const filtered = appointmentsData.filter(function (apt) {
                const matchesSearch = !searchTerm ||
                    (apt.patient_name && apt.patient_name.toLowerCase().includes(searchTerm)) ||
                    (apt.patient_custom_id && apt.patient_custom_id.toLowerCase().includes(searchTerm));

                const matchesStatus = !statusFilter || apt.status === statusFilter;
                const matchesDate = !dateFilter || apt.appointment_date === dateFilter;

                return matchesSearch && matchesStatus && matchesDate;
            });

            displayAppointments(filtered);
        }

        /**
         * Reset filters
         */
        function resetFilters() {
            $('#searchInput').val('');
            $('#statusFilter').dropdown('clear');
            $('#dateFilter').val('');
            displayAppointments(appointmentsData);
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
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
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