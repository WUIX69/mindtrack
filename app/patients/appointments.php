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

// Get patient data
$patientAdds = Users::getPatientAdds($patient_uuid);
$patient_birthdate = $patientAdds['birthdate'] ?? '2000-01-01';
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
                    <p class="text-sm text-gray-600 mt-1">View your scheduled appointments and medical records</p>
                </div>
                <button class="ui primary button" id="requestAppointmentBtn">
                    <i class="plus icon"></i>
                    Request Appointment
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
                            <p class="text-sm text-gray-600">Upcoming</p>
                            <p class="text-2xl font-bold text-green-600" id="upcomingCount">0</p>
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

                <div class="bg-white rounded-lg p-4 shadow-sm border border-orange-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Next Appointment</p>
                            <p class="text-sm font-bold text-orange-600" id="nextAppointment">N/A</p>
                        </div>
                        <i class="fas fa-calendar-day text-3xl text-orange-600 opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Tabs for Upcoming, Requests, and Past -->
            <div class="bg-white rounded-lg shadow-sm border border-blue-50 mb-6">
                <div class="ui top attached tabular menu">
                    <a class="item active" data-tab="upcoming">
                        <i class="calendar check icon"></i>
                        Upcoming Appointments
                    </a>
                    <a class="item" data-tab="requests">
                        <i class="hourglass half icon"></i>
                        My Requests
                        <div class="ui mini circular blue label" id="pendingRequestsCount" style="display: none;">0
                        </div>
                    </a>
                    <a class="item" data-tab="history">
                        <i class="history icon"></i>
                        Appointment History
                    </a>
                </div>

                <!-- Upcoming Appointments Tab -->
                <div class="ui bottom attached tab segment !mb-0 active" data-tab="upcoming">
                    <div id="loadingUpcoming" class="text-center p-10">
                        <div class="ui active inline loader"></div>
                        <p class="mt-4 text-gray-600">Loading appointments...</p>
                    </div>

                    <div id="upcomingAppointmentsContainer" class="hidden">
                        <div id="upcomingAppointmentsList" class="space-y-4">
                            <!-- Populated by JavaScript -->
                        </div>
                    </div>

                    <div id="noUpcoming" class="hidden p-10 text-center">
                        <i class="far fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600 text-lg">No upcoming appointments</p>
                        <p class="text-gray-500 text-sm mt-2">Contact your doctor to schedule an appointment</p>
                    </div>
                </div>

                <!-- Booking Requests Tab -->
                <div class="ui bottom attached tab segment !mb-0" data-tab="requests">
                    <div id="loadingRequests" class="text-center p-10">
                        <div class="ui active inline loader"></div>
                        <p class="mt-4 text-gray-600">Loading requests...</p>
                    </div>

                    <div id="requestsContainer" class="hidden">
                        <div id="requestsList" class="space-y-4">
                            <!-- Populated by JavaScript -->
                        </div>
                    </div>

                    <div id="noRequests" class="hidden p-10 text-center">
                        <i class="far fa-calendar-plus text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600 text-lg">No booking requests</p>
                        <p class="text-gray-500 text-sm mt-2">Click "Request Appointment" to create a new booking
                            request</p>
                    </div>
                </div>

                <!-- Appointment History Tab -->
                <div class="ui bottom attached tab segment !mb-0" data-tab="history">
                    <div id="loadingHistory" class="text-center p-10">
                        <div class="ui active inline loader"></div>
                        <p class="mt-4 text-gray-600">Loading history...</p>
                    </div>

                    <div id="historyAppointmentsContainer" class="hidden">
                        <div id="historyAppointmentsList" class="space-y-4">
                            <!-- Populated by JavaScript -->
                        </div>
                    </div>

                    <div id="noHistory" class="hidden p-10 text-center">
                        <i class="far fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600 text-lg">No appointment history</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Appointment Modal -->
    <div class="ui large modal" id="requestAppointmentModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="calendar plus icon"></i>
            Request New Appointment
        </div>
        <div class="content">
            <form class="ui form" id="requestAppointmentForm">
                <div class="two fields">
                    <div class="field required">
                        <label>Service Type</label>
                        <select class="ui dropdown" name="service_type" id="serviceType" required>
                            <option value="">Select Service</option>
                            <option value="Consultation">Consultation</option>
                            <option value="Follow-up">Follow-up</option>
                            <option value="Therapy Session">Therapy Session</option>
                            <option value="Counseling">Counseling</option>
                            <option value="Psychiatric Evaluation">Psychiatric Evaluation</option>
                            <option value="General Check-up">General Check-up</option>
                        </select>
                    </div>
                    <div class="field required">
                        <label>Preferred Date</label>
                        <input type="date" name="booking_date" id="bookingDate" required
                            min="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>

                <div class="field required">
                    <label>Preferred Time</label>
                    <input type="time" name="booking_time" id="bookingTime" required>
                </div>

                <div class="field">
                    <label>Additional Notes</label>
                    <textarea name="notes" id="requestNotes" rows="3"
                        placeholder="Any specific concerns or requests..."></textarea>
                </div>

                <div class="ui info message">
                    <div class="header">
                        <i class="info circle icon"></i>
                        Request Process
                    </div>
                    <p>Your appointment request will be reviewed by our admin team. You will be notified once it's
                        approved or if any changes are needed.</p>
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui button" data-action="close">Cancel</button>
            <button class="ui primary button" id="submitRequestBtn">
                <i class="send icon"></i>
                Submit Request
            </button>
        </div>
    </div>

    <!-- View Appointment Details Modal -->
    <div class="ui large modal" id="viewAppointmentModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="info circle icon"></i>
            Appointment Details
        </div>
        <div class="content">
            <!-- Doctor & Appointment Info -->
            <div class="ui grid">
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
                            <strong>Email:</strong> <span id="viewDoctorEmail">-</span>
                        </div>
                        <div class="item">
                            <strong>Phone:</strong> <span id="viewDoctorPhone">-</span>
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
                            <strong>Booking Code:</strong> <code id="viewBookingCode">-</code>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ui divider"></div>

            <!-- Remarks -->
            <div class="mb-4">
                <h4 class="ui header">
                    <i class="comment icon"></i>
                    Appointment Notes
                </h4>
                <div class="ui segment">
                    <p id="viewRemarks" class="text-gray-600">No notes available</p>
                </div>
            </div>

            <!-- Medical Records Section -->
            <div id="medicalRecordsSection">
                <h4 class="ui header">
                    <i class="file medical icon"></i>
                    Medical Records
                </h4>

                <!-- Prescription -->
                <div class="ui segment">
                    <h5 class="text-sm font-semibold text-gray-700 mb-2">
                        <i class="prescription icon"></i>
                        Prescription
                    </h5>
                    <div id="viewPrescriptionContainer" class="bg-blue-50 p-4 rounded">
                        <p id="viewPrescription" class="text-gray-700 whitespace-pre-wrap">No prescription provided yet
                        </p>
                    </div>
                </div>

                <!-- Diagnosis -->
                <div class="ui segment">
                    <h5 class="text-sm font-semibold text-gray-700 mb-2">
                        <i class="stethoscope icon"></i>
                        Diagnosis
                    </h5>
                    <div id="viewDiagnosisContainer" class="bg-green-50 p-4 rounded">
                        <p id="viewDiagnosis" class="text-gray-700 whitespace-pre-wrap">No diagnosis provided yet</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="actions">
            <button class="ui button" data-action="close">Close</button>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        let appointmentsData = [];
        let bookingRequestsData = [];

        $(document).ready(function () {
            // Initialize tabs
            $('.menu .item').tab();

            // Initialize dropdowns
            $('.ui.dropdown').dropdown();

            // Initialize form validation
            $('#requestAppointmentForm').form({
                fields: {
                    service_type: 'empty',
                    booking_date: 'empty',
                    booking_time: 'empty'
                }
            });

            // Load data on page load
            loadAppointments();
            loadBookingRequests();

            // Close messages
            $('.message .close').on('click', function () {
                $(this).closest('.message').transition('fade');
            });

            // Request appointment button
            $('#requestAppointmentBtn').on('click', function () {
                $('#requestAppointmentModal').modal('show');
            });

            // Submit request appointment
            $('#submitRequestBtn').on('click', function (e) {
                e.preventDefault();

                if (!$('#requestAppointmentForm').form('is valid')) {
                    return;
                }

                submitAppointmentRequest();
            });
        });

        /**
         * Load all patient appointments from server
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
                    $('#loadingUpcoming, #loadingHistory').addClass('hidden');
                }
            });
        }

        /**
         * Display appointments in their respective tabs
         */
        function displayAppointments(appointments) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            // Separate upcoming and past appointments
            const upcoming = appointments.filter(apt => {
                const aptDate = new Date(apt.appointment_date);
                return aptDate >= today && apt.status === 'scheduled';
            }).sort((a, b) => new Date(a.appointment_date) - new Date(b.appointment_date));

            const history = appointments.filter(apt => {
                const aptDate = new Date(apt.appointment_date);
                return aptDate < today || apt.status !== 'scheduled';
            }).sort((a, b) => new Date(b.appointment_date) - new Date(a.appointment_date));

            // Display upcoming appointments
            if (upcoming.length === 0) {
                $('#upcomingAppointmentsContainer').addClass('hidden');
                $('#noUpcoming').removeClass('hidden');
            } else {
                $('#upcomingAppointmentsContainer').removeClass('hidden');
                $('#noUpcoming').addClass('hidden');
                renderAppointmentCards(upcoming, 'upcomingAppointmentsList');
            }

            // Display history
            if (history.length === 0) {
                $('#historyAppointmentsContainer').addClass('hidden');
                $('#noHistory').removeClass('hidden');
            } else {
                $('#historyAppointmentsContainer').removeClass('hidden');
                $('#noHistory').addClass('hidden');
                renderAppointmentCards(history, 'historyAppointmentsList');
            }
        }

        /**
         * Render appointment cards
         */
        function renderAppointmentCards(appointments, containerId) {
            const container = $(`#${containerId}`);
            container.empty();

            appointments.forEach(function (apt) {
                const statusClass = apt.status === 'scheduled' ? 'green' :
                    apt.status === 'completed' ? 'grey' :
                        apt.status === 'cancelled' ? 'red' : 'orange';

                const statusIcon = apt.status === 'scheduled' ? 'clock' :
                    apt.status === 'completed' ? 'check circle' :
                        apt.status === 'cancelled' ? 'times circle' : 'question circle';

                const hasMedicalRecords = apt.prescription || apt.diagnosis;

                const card = `
                    <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <!-- Date & Time -->
                                <div class="flex items-center gap-4 mb-3">
                                    <div class="bg-blue-100 rounded-lg p-3 text-center">
                                        <div class="text-2xl font-bold text-blue-600">${new Date(apt.appointment_date).getDate()}</div>
                                        <div class="text-xs text-blue-600">${formatMonthYear(apt.appointment_date)}</div>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            ${escapeHtml(apt.service_type)}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            <i class="clock icon"></i>
                                            ${formatTime(apt.appointment_time)}
                                        </p>
                                    </div>
                                </div>

                                <!-- Doctor Info -->
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-10 h-10 bg-teal-200 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-md text-teal-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">${escapeHtml(apt.doctor_name || 'To be assigned')}</p>
                                        <p class="text-xs text-gray-500">${escapeHtml(apt.specialization || 'General Practitioner')}</p>
                                    </div>
                                </div>

                                <!-- Status & Code -->
                                <div class="flex items-center gap-3">
                                    <span class="ui label ${statusClass}">
                                        <i class="${statusIcon} icon"></i>
                                        ${apt.status.charAt(0).toUpperCase() + apt.status.slice(1)}
                                    </span>
                                    <code class="text-xs bg-gray-100 px-2 py-1 rounded">${escapeHtml(apt.booking_code)}</code>
                                    ${hasMedicalRecords ? '<span class="ui mini label blue"><i class="file medical icon"></i> Records Available</span>' : ''}
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div>
                                <button class="ui blue button" onclick="viewAppointment('${apt.uuid}')">
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
        function updateStats(appointments) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const total = appointments.length;
            const upcoming = appointments.filter(apt => {
                const aptDate = new Date(apt.appointment_date);
                return aptDate >= today && apt.status === 'scheduled';
            }).length;
            const completed = appointments.filter(a => a.status === 'completed').length;

            // Find next appointment
            const nextApt = appointments
                .filter(apt => {
                    const aptDate = new Date(apt.appointment_date);
                    return aptDate >= today && apt.status === 'scheduled';
                })
                .sort((a, b) => new Date(a.appointment_date) - new Date(b.appointment_date))[0];

            $('#totalCount').text(total);
            $('#upcomingCount').text(upcoming);
            $('#completedCount').text(completed);

            if (nextApt) {
                $('#nextAppointment').text(formatDate(nextApt.appointment_date));
            } else {
                $('#nextAppointment').text('None scheduled');
            }
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

                        // Populate doctor info
                        $('#viewDoctorName').text(apt.doctor_name || 'Not assigned');
                        $('#viewSpecialization').text(apt.specialization || 'General Practitioner');
                        $('#viewDoctorEmail').text(apt.doctor_email || 'N/A');
                        $('#viewDoctorPhone').text(apt.doctor_phone || 'N/A');

                        // Populate appointment details
                        $('#viewDate').text(formatDate(apt.appointment_date));
                        $('#viewTime').text(formatTime(apt.appointment_time));
                        $('#viewService').text(apt.service_type);

                        const statusClass = apt.status === 'scheduled' ? 'green' :
                            apt.status === 'completed' ? 'grey' :
                                apt.status === 'cancelled' ? 'red' : 'orange';
                        $('#viewStatus').html(`<span class="ui label ${statusClass}">${apt.status.charAt(0).toUpperCase() + apt.status.slice(1)}</span>`);
                        $('#viewBookingCode').text(apt.booking_code);
                        $('#viewRemarks').text(apt.remarks || 'No notes available');

                        // Populate medical records
                        if (apt.prescription) {
                            $('#viewPrescription').text(apt.prescription);
                            $('#viewPrescriptionContainer').removeClass('bg-blue-50').addClass('bg-blue-100');
                        } else {
                            $('#viewPrescription').text('No prescription provided yet');
                            $('#viewPrescriptionContainer').removeClass('bg-blue-100').addClass('bg-blue-50');
                        }

                        if (apt.diagnosis) {
                            $('#viewDiagnosis').text(apt.diagnosis);
                            $('#viewDiagnosisContainer').removeClass('bg-green-50').addClass('bg-green-100');
                        } else {
                            $('#viewDiagnosis').text('No diagnosis provided yet');
                            $('#viewDiagnosisContainer').removeClass('bg-green-100').addClass('bg-green-50');
                        }

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
         * Format month and year
         */
        function formatMonthYear(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
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

        /**
         * Load all booking requests from server
         */
        function loadBookingRequests() {
            $.ajax({
                url: apiURL('appointments') + 'booking_requests.php?action=list',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        bookingRequestsData = response.data;
                        displayBookingRequests(bookingRequestsData);
                        updateRequestsCount(bookingRequestsData);
                    } else {
                        showError(response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to load booking requests');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Load Booking Requests Error');
                },
                complete: function () {
                    $('#loadingRequests').addClass('hidden');
                }
            });
        }

        /**
         * Display booking requests
         */
        function displayBookingRequests(requests) {
            if (requests.length === 0) {
                $('#requestsContainer').addClass('hidden');
                $('#noRequests').removeClass('hidden');
                return;
            }

            $('#requestsContainer').removeClass('hidden');
            $('#noRequests').addClass('hidden');

            const container = $('#requestsList');
            container.empty();

            requests.forEach(function (req) {
                const statusClass = req.status === 'pending' ? 'orange' :
                    req.status === 'approved' ? 'green' :
                        req.status === 'rejected' ? 'red' : 'grey';

                const statusIcon = req.status === 'pending' ? 'hourglass half' :
                    req.status === 'approved' ? 'check circle' :
                        req.status === 'rejected' ? 'times circle' : 'ban';

                const canCancel = req.status === 'pending';

                const card = `
                    <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <!-- Date & Time -->
                                <div class="flex items-center gap-4 mb-3">
                                    <div class="bg-orange-100 rounded-lg p-3 text-center">
                                        <div class="text-2xl font-bold text-orange-600">${new Date(req.booking_date).getDate()}</div>
                                        <div class="text-xs text-orange-600">${formatMonthYear(req.booking_date)}</div>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            ${escapeHtml(req.service_type)}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            <i class="clock icon"></i>
                                            ${formatTime(req.booking_time)}
                                        </p>
                                    </div>
                                </div>

                                <!-- Status & Code -->
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="ui label ${statusClass}">
                                        <i class="${statusIcon} icon"></i>
                                        ${req.status.charAt(0).toUpperCase() + req.status.slice(1)}
                                    </span>
                                    <code class="text-xs bg-gray-100 px-2 py-1 rounded">${escapeHtml(req.booking_code)}</code>
                                </div>

                                <!-- Notes -->
                                ${req.notes ? `
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-600">
                                            <i class="comment icon"></i>
                                            ${escapeHtml(req.notes)}
                                        </p>
                                    </div>
                                ` : ''}
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                ${canCancel ? `
                                    <button class="ui small red button" onclick="cancelBookingRequest('${req.uuid}')">
                                        <i class="times icon"></i>
                                        Cancel
                                    </button>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                `;
                container.append(card);
            });
        }

        /**
         * Update requests count badge
         */
        function updateRequestsCount(requests) {
            const pendingCount = requests.filter(r => r.status === 'pending').length;
            if (pendingCount > 0) {
                $('#pendingRequestsCount').text(pendingCount).show();
            } else {
                $('#pendingRequestsCount').hide();
            }
        }

        /**
         * Submit appointment request
         */
        function submitAppointmentRequest() {
            const formData = {
                service_type: $('#serviceType').val(),
                booking_date: $('#bookingDate').val(),
                booking_time: $('#bookingTime').val(),
                notes: $('#requestNotes').val(),
                birthdate: '<?php echo $patient_birthdate; ?>'
            };

            $('#submitRequestBtn').addClass('loading disabled');

            $.ajax({
                url: apiURL('appointments') + 'booking_requests.php',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        showSuccess('Appointment request submitted successfully! You will be notified once it\'s reviewed.');
                        $('#requestAppointmentModal').modal('hide');
                        $('#requestAppointmentForm').form('reset');
                        loadBookingRequests();
                    } else {
                        showError(response.message || 'Failed to submit request');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to submit appointment request');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Submit Request Error');
                },
                complete: function () {
                    $('#submitRequestBtn').removeClass('loading disabled');
                }
            });
        }

        /**
         * Cancel booking request
         */
        function cancelBookingRequest(uuid) {
            if (!confirm('Are you sure you want to cancel this booking request?')) {
                return;
            }

            $.ajax({
                url: apiURL('appointments') + 'booking_requests.php',
                method: 'DELETE',
                data: { uuid: uuid },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        showSuccess('Booking request cancelled successfully');
                        loadBookingRequests();
                    } else {
                        showError(response.message || 'Failed to cancel request');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to cancel booking request');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Cancel Request Error');
                }
            });
        }
    </script>
</body>

</html>