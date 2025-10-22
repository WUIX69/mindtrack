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
    <title>Booking Requests - MindTrack Admin</title>
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
                        <i class="fas fa-calendar-plus"></i> Booking Requests
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Manage patient appointment booking requests</p>
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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">
                <div class="bg-white rounded-lg p-4 shadow-sm border border-orange-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Pending</p>
                            <p class="text-2xl font-bold text-orange-600" id="pendingCount">0</p>
                        </div>
                        <i class="fas fa-hourglass-half text-3xl text-orange-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-green-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Approved</p>
                            <p class="text-2xl font-bold text-green-600" id="approvedCount">0</p>
                        </div>
                        <i class="fas fa-check-circle text-3xl text-green-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-red-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Rejected</p>
                            <p class="text-2xl font-bold text-red-600" id="rejectedCount">0</p>
                        </div>
                        <i class="fas fa-times-circle text-3xl text-red-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-blue-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="text-2xl font-bold text-blue-600" id="totalCount">0</p>
                        </div>
                        <i class="fas fa-list text-3xl text-blue-600 opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Booking Requests List -->
            <div class="bg-white rounded-lg shadow-sm border border-blue-50 mb-6">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">
                                <i class="fas fa-list-alt"></i> Appointment Requests
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Review and approve patient booking requests</p>
                        </div>
                        <!-- Filter -->
                        <div class="ui buttons">
                            <button class="ui button active" data-filter="all">All</button>
                            <button class="ui button orange" data-filter="pending">Pending</button>
                            <button class="ui button green" data-filter="approved">Approved</button>
                            <button class="ui button red" data-filter="rejected">Rejected</button>
                        </div>
                    </div>
                </div>

                <div id="loadingRequests" class="text-center p-10">
                    <div class="ui active inline loader"></div>
                    <p class="mt-4 text-gray-600">Loading booking requests...</p>
                </div>

                <div id="requestsContainer" class="hidden p-6">
                    <div id="requestsList" class="space-y-4">
                        <!-- Populated by JavaScript -->
                    </div>
                </div>

                <div id="noRequests" class="hidden p-10 text-center">
                    <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 text-lg">No booking requests found</p>
                </div>
            </div>
        </div>
    </div>

    <!-- View/Approve Request Modal -->
    <div class="ui large modal" id="viewRequestModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="info circle icon"></i>
            Booking Request Details
        </div>
        <div class="content">
            <div class="ui grid">
                <div class="eight wide column">
                    <h4 class="ui dividing header">Patient Information</h4>
                    <div class="ui relaxed list">
                        <div class="item">
                            <strong>Name:</strong> <span id="viewName">-</span>
                        </div>
                        <div class="item">
                            <strong>Email:</strong> <span id="viewEmail">-</span>
                        </div>
                        <div class="item">
                            <strong>Birthdate:</strong> <span id="viewBirthdate">-</span>
                        </div>
                        <div class="item">
                            <strong>Patient ID:</strong> <span id="viewPatientId">-</span>
                        </div>
                    </div>
                </div>
                <div class="eight wide column">
                    <h4 class="ui dividing header">Request Details</h4>
                    <div class="ui relaxed list">
                        <div class="item">
                            <strong>Service Type:</strong> <span id="viewService">-</span>
                        </div>
                        <div class="item">
                            <strong>Preferred Date:</strong> <span id="viewDate">-</span>
                        </div>
                        <div class="item">
                            <strong>Preferred Time:</strong> <span id="viewTime">-</span>
                        </div>
                        <div class="item">
                            <strong>Booking Code:</strong> <code id="viewCode">-</code>
                        </div>
                        <div class="item">
                            <strong>Status:</strong> <span id="viewStatus">-</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ui divider"></div>

            <div id="notesSection">
                <h4 class="ui header">
                    <i class="comment icon"></i>
                    Additional Notes
                </h4>
                <div class="ui segment">
                    <p id="viewNotes">No additional notes</p>
                </div>
            </div>

            <input type="hidden" id="currentRequestUuid">
            <input type="hidden" id="currentRequestStatus">
        </div>
        <div class="actions">
            <button class="ui button" data-action="close">Close</button>
            <button class="ui red button" id="rejectBtn" style="display: none;">
                <i class="times icon"></i>
                Reject
            </button>
            <button class="ui green button" id="approveBtn" style="display: none;">
                <i class="check icon"></i>
                Approve & Create Appointment
            </button>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        let requestsData = [];
        let currentFilter = 'all';

        $(document).ready(function () {
            loadRequests();

            // Close messages
            $('.message .close').on('click', function () {
                $(this).closest('.message').transition('fade');
            });

            // Filter buttons
            $('.ui.buttons button').on('click', function () {
                $('.ui.buttons button').removeClass('active');
                $(this).addClass('active');
                currentFilter = $(this).data('filter');
                displayRequests(requestsData, currentFilter);
            });

            // Approve button
            $('#approveBtn').on('click', function () {
                const uuid = $('#currentRequestUuid').val();
                updateRequestStatus(uuid, 'approved');
            });

            // Reject button
            $('#rejectBtn').on('click', function () {
                if (confirm('Are you sure you want to reject this booking request?')) {
                    const uuid = $('#currentRequestUuid').val();
                    updateRequestStatus(uuid, 'rejected');
                }
            });
        });

        /**
         * Load booking requests
         */
        function loadRequests() {
            $.ajax({
                url: apiURL('appointments') + 'booking_requests.php?action=list',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        requestsData = response.data;
                        displayRequests(requestsData, currentFilter);
                        updateStats(requestsData);
                    } else {
                        showError(response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to load booking requests');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Load Requests Error');
                },
                complete: function () {
                    $('#loadingRequests').addClass('hidden');
                }
            });
        }

        /**
         * Display requests
         */
        function displayRequests(requests, filter = 'all') {
            let filteredRequests = requests;
            if (filter !== 'all') {
                filteredRequests = requests.filter(r => r.status === filter);
            }

            if (filteredRequests.length === 0) {
                $('#requestsContainer').addClass('hidden');
                $('#noRequests').removeClass('hidden');
                return;
            }

            $('#requestsContainer').removeClass('hidden');
            $('#noRequests').addClass('hidden');

            const container = $('#requestsList');
            container.empty();

            filteredRequests.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

            filteredRequests.forEach(function (req) {
                const statusClass = req.status === 'pending' ? 'orange' :
                    req.status === 'approved' ? 'green' :
                        req.status === 'rejected' ? 'red' : 'grey';

                const statusIcon = req.status === 'pending' ? 'hourglass half' :
                    req.status === 'approved' ? 'check circle' :
                        req.status === 'rejected' ? 'times circle' : 'ban';

                const card = `
                    <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-4 mb-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600 text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            ${escapeHtml(req.first_name + ' ' + req.last_name)}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            <i class="envelope icon"></i>
                                            ${escapeHtml(req.email)}
                                        </p>
                                    </div>
                                    <span class="ui label ${statusClass}">
                                        <i class="${statusIcon} icon"></i>
                                        ${req.status.charAt(0).toUpperCase() + req.status.slice(1)}
                                    </span>
                                </div>

                                <div class="grid grid-cols-3 gap-4 mb-3">
                                    <div>
                                        <p class="text-xs text-gray-500">Service</p>
                                        <p class="text-sm font-medium">${escapeHtml(req.service_type)}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Preferred Date</p>
                                        <p class="text-sm font-medium">${formatDate(req.booking_date)}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Time</p>
                                        <p class="text-sm font-medium">${formatTime(req.booking_time)}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    <code class="text-xs bg-gray-100 px-2 py-1 rounded">${escapeHtml(req.booking_code)}</code>
                                    <span class="text-xs text-gray-500">
                                        Requested ${formatRelativeTime(req.created_at)}
                                    </span>
                                </div>
                            </div>

                            <div class="ml-4">
                                <button class="ui blue button" onclick="viewRequest('${req.uuid}')">
                                    <i class="eye icon"></i>
                                    Review
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
        function updateStats(requests) {
            const pending = requests.filter(r => r.status === 'pending').length;
            const approved = requests.filter(r => r.status === 'approved').length;
            const rejected = requests.filter(r => r.status === 'rejected').length;
            const total = requests.length;

            $('#pendingCount').text(pending);
            $('#approvedCount').text(approved);
            $('#rejectedCount').text(rejected);
            $('#totalCount').text(total);
        }

        /**
         * View request details
         */
        function viewRequest(uuid) {
            const req = requestsData.find(r => r.uuid === uuid);
            if (!req) return;

            $('#viewName').text(req.first_name + ' ' + req.last_name);
            $('#viewEmail').text(req.email);
            $('#viewBirthdate').text(formatDate(req.birthdate));
            $('#viewPatientId').text(req.patient_custom_id || 'Not assigned');
            $('#viewService').text(req.service_type);
            $('#viewDate').text(formatDate(req.booking_date));
            $('#viewTime').text(formatTime(req.booking_time));
            $('#viewCode').text(req.booking_code);

            const statusClass = req.status === 'pending' ? 'orange' :
                req.status === 'approved' ? 'green' :
                    req.status === 'rejected' ? 'red' : 'grey';
            $('#viewStatus').html(`<span class="ui label ${statusClass}">${req.status.charAt(0).toUpperCase() + req.status.slice(1)}</span>`);

            if (req.notes) {
                $('#viewNotes').text(req.notes);
            } else {
                $('#viewNotes').text('No additional notes');
            }

            $('#currentRequestUuid').val(uuid);
            $('#currentRequestStatus').val(req.status);

            // Show/hide action buttons based on status
            if (req.status === 'pending') {
                $('#approveBtn, #rejectBtn').show();
            } else {
                $('#approveBtn, #rejectBtn').hide();
            }

            $('#viewRequestModal').modal('show');
        }

        /**
         * Update request status
         */
        function updateRequestStatus(uuid, status) {
            const formData = new URLSearchParams({
                uuid: uuid,
                status: status
            });

            $.ajax({
                url: apiURL('appointments') + 'booking_requests.php',
                method: 'PUT',
                data: formData.toString(),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        showSuccess(`Booking request ${status} successfully!`);
                        $('#viewRequestModal').modal('hide');
                        loadRequests();
                    } else {
                        showError(response.message || `Failed to ${status} request`);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError(`Failed to ${status} request`);
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Update Request Error');
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
         * Format relative time
         */
        function formatRelativeTime(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            const now = new Date();
            const diff = now - date;
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));

            if (days === 0) return 'today';
            if (days === 1) return 'yesterday';
            if (days < 7) return `${days} days ago`;
            if (days < 30) return `${Math.floor(days / 7)} weeks ago`;
            return `${Math.floor(days / 30)} months ago`;
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