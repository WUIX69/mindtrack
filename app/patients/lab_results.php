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
    <title>Lab Results - MindTrack</title>
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
                        <i class="fas fa-flask"></i> Lab Results
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">View your medical test results and findings</p>
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
                <div class="bg-white rounded-lg p-4 shadow-sm border border-blue-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Tests</p>
                            <p class="text-2xl font-bold text-blue-600" id="totalCount">0</p>
                        </div>
                        <i class="fas fa-vial text-3xl text-blue-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-green-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Completed</p>
                            <p class="text-2xl font-bold text-green-600" id="completedCount">0</p>
                        </div>
                        <i class="fas fa-check-circle text-3xl text-green-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-orange-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Pending</p>
                            <p class="text-2xl font-bold text-orange-600" id="pendingCount">0</p>
                        </div>
                        <i class="fas fa-clock text-3xl text-orange-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-purple-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Latest Test</p>
                            <p class="text-sm font-bold text-purple-600" id="latestTest">N/A</p>
                        </div>
                        <i class="fas fa-calendar-check text-3xl text-purple-600 opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Lab Results List -->
            <div class="bg-white rounded-lg shadow-sm border border-blue-50 mb-6">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">
                                <i class="fas fa-list-alt"></i> Test Results History
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">All your medical test results</p>
                        </div>
                        <!-- Filter by status -->
                        <div class="ui buttons">
                            <button class="ui button active" data-filter="all">All</button>
                            <button class="ui button" data-filter="completed">Completed</button>
                            <button class="ui button" data-filter="pending">Pending</button>
                        </div>
                    </div>
                </div>

                <div id="loadingResults" class="text-center p-10">
                    <div class="ui active inline loader"></div>
                    <p class="mt-4 text-gray-600">Loading lab results...</p>
                </div>

                <div id="resultsContainer" class="hidden p-6">
                    <div id="resultsList" class="space-y-4">
                        <!-- Populated by JavaScript -->
                    </div>
                </div>

                <div id="noResults" class="hidden p-10 text-center">
                    <i class="fas fa-microscope text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 text-lg">No lab results yet</p>
                    <p class="text-gray-500 text-sm mt-2">Your medical test results will appear here</p>
                </div>
            </div>
        </div>
    </div>

    <!-- View Lab Result Details Modal -->
    <div class="ui large modal" id="viewResultModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="flask icon"></i>
            <span id="modalTestName">Lab Result Details</span>
        </div>
        <div class="content">
            <!-- Test Information -->
            <div class="ui grid">
                <div class="eight wide column">
                    <h4 class="ui dividing header">Test Information</h4>
                    <div class="ui relaxed list">
                        <div class="item">
                            <strong>Test Type:</strong> <span id="viewTestType">-</span>
                        </div>
                        <div class="item">
                            <strong>Test Date:</strong> <span id="viewTestDate">-</span>
                        </div>
                        <div class="item">
                            <strong>Status:</strong> <span id="viewStatus">-</span>
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

            <!-- Result Summary -->
            <div id="summarySection" class="mb-4">
                <h4 class="ui header">
                    <i class="clipboard check icon"></i>
                    <div class="content">
                        Result Summary
                        <div class="sub header">Brief overview of test results</div>
                    </div>
                </h4>
                <div class="ui segment" style="background: #e3f2fd;">
                    <p id="viewResultSummary" class="text-gray-700" style="white-space: pre-wrap;">-</p>
                </div>
            </div>

            <!-- Detailed Results -->
            <div id="detailedSection" class="mb-4">
                <h4 class="ui header">
                    <i class="file alternate icon"></i>
                    <div class="content">
                        Detailed Results
                        <div class="sub header">Complete test results and measurements</div>
                    </div>
                </h4>
                <div class="ui segment" style="background: #f1f8e9;">
                    <div id="viewDetailedResults" class="text-gray-700"
                        style="white-space: pre-wrap; font-size: 14px; line-height: 1.8;">
                        -
                    </div>
                </div>
            </div>

            <!-- Reference Values -->
            <div id="referenceSection" class="mb-4">
                <h4 class="ui header">
                    <i class="info circle icon"></i>
                    <div class="content">
                        Reference Values
                        <div class="sub header">Normal ranges for comparison</div>
                    </div>
                </h4>
                <div class="ui segment" style="background: #fff3e0;">
                    <p id="viewReferenceValues" class="text-gray-700" style="white-space: pre-wrap;">-</p>
                </div>
            </div>

            <!-- Findings -->
            <div id="findingsSection" class="mb-4">
                <h4 class="ui header">
                    <i class="stethoscope icon"></i>
                    <div class="content">
                        Medical Findings
                        <div class="sub header">Doctor's interpretation and analysis</div>
                    </div>
                </h4>
                <div class="ui segment" style="background: #fce4ec;">
                    <p id="viewFindings" class="text-gray-700" style="white-space: pre-wrap;">-</p>
                </div>
            </div>

            <!-- Recommendations -->
            <div id="recommendationsSection" class="mb-4">
                <h4 class="ui header">
                    <i class="lightbulb icon"></i>
                    <div class="content">
                        Recommendations
                        <div class="sub header">Next steps and advice</div>
                    </div>
                </h4>
                <div class="ui segment" style="background: #e8f5e9;">
                    <p id="viewRecommendations" class="text-gray-700" style="white-space: pre-wrap;">-</p>
                </div>
            </div>

            <!-- Notes -->
            <div id="notesSection" class="mb-4">
                <h4 class="ui header">
                    <i class="sticky note icon"></i>
                    Additional Notes
                </h4>
                <div class="ui segment">
                    <p id="viewNotes" class="text-gray-700" style="white-space: pre-wrap;">-</p>
                </div>
            </div>
        </div>
        <div class="actions">
            <button class="ui primary button" onclick="window.print()">
                <i class="print icon"></i>
                Print Results
            </button>
            <button class="ui button" data-action="close">Close</button>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        let labResultsData = [];
        let currentFilter = 'all';

        $(document).ready(function () {
            // Load lab results on page load
            loadLabResults();

            // Close messages
            $('.message .close').on('click', function () {
                $(this).closest('.message').transition('fade');
            });

            // Filter buttons
            $('.ui.buttons button').on('click', function () {
                $('.ui.buttons button').removeClass('active');
                $(this).addClass('active');
                currentFilter = $(this).data('filter');
                displayLabResults(labResultsData, currentFilter);
            });
        });

        /**
         * Load all patient lab results
         */
        function loadLabResults() {
            $.ajax({
                url: apiURL('lab_results') + 'lab_results.php?action=list',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        labResultsData = response.data;
                        displayLabResults(labResultsData, currentFilter);
                        updateStats(labResultsData);
                    } else {
                        showError(response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to load lab results');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Load Lab Results Error');
                },
                complete: function () {
                    $('#loadingResults').addClass('hidden');
                }
            });
        }

        /**
         * Display lab results
         */
        function displayLabResults(results, filter = 'all') {
            // Filter results
            let filteredResults = results;
            if (filter !== 'all') {
                filteredResults = results.filter(r => r.result_status === filter);
            }

            if (filteredResults.length === 0) {
                $('#resultsContainer').addClass('hidden');
                $('#noResults').removeClass('hidden');
                return;
            }

            $('#resultsContainer').removeClass('hidden');
            $('#noResults').addClass('hidden');

            const container = $('#resultsList');
            container.empty();

            // Sort by date (newest first)
            filteredResults.sort((a, b) => new Date(b.test_date) - new Date(a.test_date));

            filteredResults.forEach(function (result) {
                const statusClass = result.result_status === 'completed' ? 'green' :
                    result.result_status === 'reviewed' ? 'blue' : 'orange';

                const statusIcon = result.result_status === 'completed' ? 'check circle' :
                    result.result_status === 'reviewed' ? 'eye' : 'clock';

                const testTypeIcon = getTestTypeIcon(result.test_type);

                const card = `
                    <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <!-- Header -->
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class="${testTypeIcon} text-2xl text-purple-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            ${escapeHtml(result.test_name)}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            <i class="calendar icon"></i>
                                            ${formatDate(result.test_date)}
                                        </p>
                                    </div>
                                    <span class="ui label ${statusClass}">
                                        <i class="${statusIcon} icon"></i>
                                        ${result.result_status.charAt(0).toUpperCase() + result.result_status.slice(1)}
                                    </span>
                                </div>

                                <!-- Test Info -->
                                <div class="grid grid-cols-2 gap-4 mb-3">
                                    <div class="flex items-center gap-2">
                                        <i class="vial icon text-gray-500"></i>
                                        <span class="text-sm text-gray-700">
                                            <strong>Type:</strong> ${escapeHtml(result.test_type)}
                                        </span>
                                    </div>
                                    ${result.doctor_name ? `
                                        <div class="flex items-center gap-2">
                                            <i class="user md icon text-gray-500"></i>
                                            <span class="text-sm text-gray-700">
                                                <strong>Doctor:</strong> ${escapeHtml(result.doctor_name)}
                                            </span>
                                        </div>
                                    ` : ''}
                                </div>

                                <!-- Result Summary Preview -->
                                ${result.result_summary ? `
                                    <div class="bg-blue-50 p-3 rounded mb-3">
                                        <p class="text-sm text-gray-700 mb-0" style="
                                            display: -webkit-box;
                                            -webkit-line-clamp: 2;
                                            -webkit-box-orient: vertical;
                                            overflow: hidden;
                                        ">
                                            <i class="clipboard check icon"></i>
                                            ${escapeHtml(result.result_summary).substring(0, 150)}${result.result_summary.length > 150 ? '...' : ''}
                                        </p>
                                    </div>
                                ` : ''}

                                <!-- Additional Info Tags -->
                                <div class="flex items-center gap-2 flex-wrap">
                                    ${result.detailed_results ? '<span class="ui mini label"><i class="file alternate icon"></i> Detailed Results</span>' : ''}
                                    ${result.findings ? '<span class="ui mini label pink"><i class="stethoscope icon"></i> Findings</span>' : ''}
                                    ${result.recommendations ? '<span class="ui mini label green"><i class="lightbulb icon"></i> Recommendations</span>' : ''}
                                </div>
                            </div>

                            <!-- Action Button -->
                            <div class="ml-4">
                                <button class="ui blue button" onclick="viewLabResult('${result.uuid}')">
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
         * Get icon for test type
         */
        function getTestTypeIcon(testType) {
            const type = testType.toLowerCase();
            if (type.includes('blood')) return 'fas fa-tint';
            if (type.includes('x-ray') || type.includes('xray')) return 'fas fa-x-ray';
            if (type.includes('mri') || type.includes('ct') || type.includes('scan')) return 'fas fa-brain';
            if (type.includes('urine')) return 'fas fa-vial';
            if (type.includes('ecg') || type.includes('ekg') || type.includes('cardiac')) return 'fas fa-heartbeat';
            return 'fas fa-microscope';
        }

        /**
         * Update statistics
         */
        function updateStats(results) {
            const total = results.length;
            const completed = results.filter(r => r.result_status === 'completed' || r.result_status === 'reviewed').length;
            const pending = results.filter(r => r.result_status === 'pending').length;

            $('#totalCount').text(total);
            $('#completedCount').text(completed);
            $('#pendingCount').text(pending);

            if (results.length > 0) {
                const latest = results.sort((a, b) => new Date(b.test_date) - new Date(a.test_date))[0];
                $('#latestTest').text(formatDate(latest.test_date));
            } else {
                $('#latestTest').text('N/A');
            }
        }

        /**
         * View full lab result details
         */
        function viewLabResult(uuid) {
            $.ajax({
                url: apiURL('lab_results') + 'lab_results.php?action=single&uuid=' + uuid,
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success && response.data) {
                        const result = response.data;

                        // Populate modal
                        $('#modalTestName').text(result.test_name);
                        $('#viewTestType').text(result.test_type);
                        $('#viewTestDate').text(formatDate(result.test_date));

                        const statusClass = result.result_status === 'completed' ? 'green' :
                            result.result_status === 'reviewed' ? 'blue' : 'orange';
                        $('#viewStatus').html(`<span class="ui label ${statusClass}">${result.result_status.charAt(0).toUpperCase() + result.result_status.slice(1)}</span>`);

                        // Doctor info
                        $('#viewDoctorName').text(result.doctor_name || 'Not assigned');
                        $('#viewSpecialization').text(result.specialization || 'General Practitioner');
                        $('#viewDoctorPhone').text(result.doctor_phone || 'N/A');

                        // Show/hide sections based on data
                        toggleSection('summarySection', 'viewResultSummary', result.result_summary);
                        toggleSection('detailedSection', 'viewDetailedResults', result.detailed_results);
                        toggleSection('referenceSection', 'viewReferenceValues', result.reference_values);
                        toggleSection('findingsSection', 'viewFindings', result.findings);
                        toggleSection('recommendationsSection', 'viewRecommendations', result.recommendations);
                        toggleSection('notesSection', 'viewNotes', result.notes);

                        $('#viewResultModal').modal('show');
                    } else {
                        showError(response.message || 'Failed to load lab result details');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to load lab result details');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'View Lab Result Error');
                }
            });
        }

        /**
         * Toggle section visibility
         */
        function toggleSection(sectionId, contentId, data) {
            if (data && data.trim() !== '') {
                $(`#${sectionId}`).show();
                $(`#${contentId}`).text(data);
            } else {
                $(`#${sectionId}`).hide();
            }
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