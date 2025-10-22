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
    <title>Lab Results - MindTrack Admin</title>
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
                        <i class="fas fa-flask"></i> Lab Results Overview
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Monitor all lab results across the system</p>
                </div>
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
                            <p class="text-sm text-gray-600">This Month</p>
                            <p class="text-2xl font-bold text-purple-600" id="monthCount">0</p>
                        </div>
                        <i class="fas fa-calendar-alt text-3xl text-purple-600 opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Lab Results List -->
            <div class="bg-white rounded-lg shadow-sm border border-blue-50 mb-6">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">
                                <i class="fas fa-list-alt"></i> All Lab Results
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">System-wide lab test results</p>
                        </div>
                        <!-- Filter -->
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
                    <p class="text-gray-600 text-lg">No lab results found</p>
                </div>
            </div>
        </div>
    </div>

    <!-- View Result Modal -->
    <div class="ui large modal" id="viewResultModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="flask icon"></i>
            <span id="modalTestName">Lab Result Details</span>
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
                    </div>
                </div>
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
                        <div class="item">
                            <strong>Doctor:</strong> <span id="viewDoctorName">-</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ui divider"></div>

            <div id="summarySection">
                <h4 class="ui header">
                    <i class="clipboard check icon"></i>
                    Result Summary
                </h4>
                <div class="ui segment" style="background: #e3f2fd;">
                    <p id="viewResultSummary">-</p>
                </div>
            </div>

            <div id="detailedSection">
                <h4 class="ui header">
                    <i class="file alternate icon"></i>
                    Detailed Results
                </h4>
                <div class="ui segment" style="background: #f1f8e9;">
                    <div id="viewDetailedResults" style="white-space: pre-wrap;">-</div>
                </div>
            </div>

            <div id="findingsSection">
                <h4 class="ui header">
                    <i class="stethoscope icon"></i>
                    Medical Findings
                </h4>
                <div class="ui segment" style="background: #fce4ec;">
                    <p id="viewFindings">-</p>
                </div>
            </div>
        </div>
        <div class="actions">
            <button class="ui button" data-action="close">Close</button>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        let labResultsData = [];
        let currentFilter = 'all';

        $(document).ready(function () {
            loadLabResults();

            // Filter buttons
            $('.ui.buttons button').on('click', function () {
                $('.ui.buttons button').removeClass('active');
                $(this).addClass('active');
                currentFilter = $(this).data('filter');
                displayLabResults(labResultsData, currentFilter);
            });
        });

        /**
         * Load lab results
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
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Failed to load lab results');
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

            filteredResults.sort((a, b) => new Date(b.test_date) - new Date(a.test_date));

            filteredResults.forEach(function (result) {
                const statusClass = result.result_status === 'completed' ? 'green' :
                    result.result_status === 'reviewed' ? 'blue' : 'orange';

                const testTypeIcon = getTestTypeIcon(result.test_type);

                const card = `
                    <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-200 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class="${testTypeIcon} text-2xl text-purple-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            ${escapeHtml(result.test_name)}
                                        </h3>
                                        <p class="text-sm text-gray-600">
                                            Patient: ${escapeHtml(result.patient_name || 'Unknown')}
                                        </p>
                                    </div>
                                    <span class="ui label ${statusClass}">
                                        ${result.result_status.charAt(0).toUpperCase() + result.result_status.slice(1)}
                                    </span>
                                </div>

                                <div class="grid grid-cols-3 gap-4 mb-3">
                                    <div>
                                        <p class="text-xs text-gray-500">Test Type</p>
                                        <p class="text-sm font-medium">${escapeHtml(result.test_type)}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Test Date</p>
                                        <p class="text-sm font-medium">${formatDate(result.test_date)}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Doctor</p>
                                        <p class="text-sm font-medium">${escapeHtml(result.doctor_name || 'N/A')}</p>
                                    </div>
                                </div>

                                ${result.result_summary ? `
                                    <div class="bg-blue-50 p-3 rounded">
                                        <p class="text-sm text-gray-700 mb-0" style="
                                            display: -webkit-box;
                                            -webkit-line-clamp: 2;
                                            -webkit-box-orient: vertical;
                                            overflow: hidden;
                                        ">
                                            ${escapeHtml(result.result_summary)}
                                        </p>
                                    </div>
                                ` : ''}
                            </div>

                            <div class="ml-4">
                                <button class="ui blue button" onclick="viewLabResult('${result.uuid}')">
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
         * Get test type icon
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

            const now = new Date();
            const thisMonth = results.filter(r => {
                const testDate = new Date(r.test_date);
                return testDate.getMonth() === now.getMonth() && testDate.getFullYear() === now.getFullYear();
            }).length;

            $('#totalCount').text(total);
            $('#completedCount').text(completed);
            $('#pendingCount').text(pending);
            $('#monthCount').text(thisMonth);
        }

        /**
         * View lab result details
         */
        function viewLabResult(uuid) {
            const result = labResultsData.find(r => r.uuid === uuid);
            if (!result) return;

            $('#modalTestName').text(result.test_name);
            $('#viewPatientName').text(result.patient_name || 'Unknown');
            $('#viewPatientId').text(result.patient_custom_id || 'N/A');
            $('#viewTestType').text(result.test_type);
            $('#viewTestDate').text(formatDate(result.test_date));

            const statusClass = result.result_status === 'completed' ? 'green' :
                result.result_status === 'reviewed' ? 'blue' : 'orange';
            $('#viewStatus').html(`<span class="ui label ${statusClass}">${result.result_status.charAt(0).toUpperCase() + result.result_status.slice(1)}</span>`);

            $('#viewDoctorName').text(result.doctor_name || 'Not assigned');

            if (result.result_summary) {
                $('#summarySection').show();
                $('#viewResultSummary').text(result.result_summary);
            } else {
                $('#summarySection').hide();
            }

            if (result.detailed_results) {
                $('#detailedSection').show();
                $('#viewDetailedResults').text(result.detailed_results);
            } else {
                $('#detailedSection').hide();
            }

            if (result.findings) {
                $('#findingsSection').show();
                $('#viewFindings').text(result.findings);
            } else {
                $('#findingsSection').hide();
            }

            $('#viewResultModal').modal('show');
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