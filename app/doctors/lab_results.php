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
                        <i class="fas fa-flask"></i> Lab Results Management
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Create and manage patient lab results</p>
                </div>
                <button class="ui primary button" id="addLabResultBtn">
                    <i class="plus icon"></i>
                    Add Lab Result
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
                            <p class="text-sm text-gray-600">Total Results</p>
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
                                <i class="fas fa-list-alt"></i> Lab Results
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">All patient lab test results</p>
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
                    <p class="text-gray-500 text-sm mt-2">Click "Add Lab Result" to create a new record</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Lab Result Modal -->
    <div class="ui large modal" id="labResultModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="flask icon"></i>
            <span id="modalTitle">Add Lab Result</span>
        </div>
        <div class="content">
            <form class="ui form" id="labResultForm">
                <input type="hidden" id="resultUuid" name="uuid">
                <input type="hidden" id="isEditMode" value="false">

                <!-- Patient Selection -->
                <div class="field required">
                    <label>Select Patient</label>
                    <select class="ui search dropdown" name="patient_uuid" id="patientSelect" required>
                        <option value="">Choose a patient...</option>
                    </select>
                </div>

                <!-- Test Information -->
                <div class="two fields">
                    <div class="field required">
                        <label>Test Name</label>
                        <input type="text" name="test_name" id="testName" placeholder="e.g., Complete Blood Count"
                            required>
                    </div>
                    <div class="field required">
                        <label>Test Type</label>
                        <select class="ui dropdown" name="test_type" id="testType" required>
                            <option value="">Select Type</option>
                            <option value="Blood Test">Blood Test</option>
                            <option value="Urine Test">Urine Test</option>
                            <option value="X-Ray">X-Ray</option>
                            <option value="MRI">MRI</option>
                            <option value="CT Scan">CT Scan</option>
                            <option value="ECG">ECG</option>
                            <option value="Ultrasound">Ultrasound</option>
                            <option value="Biopsy">Biopsy</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="two fields">
                    <div class="field required">
                        <label>Test Date</label>
                        <input type="date" name="test_date" id="testDate" required>
                    </div>
                    <div class="field required">
                        <label>Status</label>
                        <select class="ui dropdown" name="result_status" id="resultStatus" required>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="reviewed">Reviewed</option>
                        </select>
                    </div>
                </div>

                <!-- Result Summary -->
                <div class="field">
                    <label>Result Summary</label>
                    <textarea name="result_summary" id="resultSummary" rows="2"
                        placeholder="Brief summary of results..."></textarea>
                </div>

                <!-- Detailed Results -->
                <div class="field">
                    <label>Detailed Results</label>
                    <textarea name="detailed_results" id="detailedResults" rows="5" placeholder="Complete test results and measurements...

Example:
- Hemoglobin: 14.5 g/dL
- White Blood Cell Count: 7,500 /μL
- Platelet Count: 250,000 /μL"></textarea>
                </div>

                <!-- Reference Values -->
                <div class="field">
                    <label>Reference Values</label>
                    <textarea name="reference_values" id="referenceValues" rows="3"
                        placeholder="Normal ranges for comparison..."></textarea>
                </div>

                <!-- Findings -->
                <div class="field">
                    <label>Medical Findings</label>
                    <textarea name="findings" id="findings" rows="4"
                        placeholder="Doctor's interpretation and analysis..."></textarea>
                </div>

                <!-- Recommendations -->
                <div class="field">
                    <label>Recommendations</label>
                    <textarea name="recommendations" id="recommendations" rows="3"
                        placeholder="Next steps and advice..."></textarea>
                </div>

                <!-- Notes -->
                <div class="field">
                    <label>Additional Notes</label>
                    <textarea name="notes" id="notes" rows="2" placeholder="Any additional information..."></textarea>
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui button" data-action="close">Cancel</button>
            <button class="ui primary button" id="saveLabResultBtn">
                <i class="save icon"></i>
                Save Lab Result
            </button>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        let labResultsData = [];
        let patientsData = [];
        let currentFilter = 'all';

        $(document).ready(function () {
            // Initialize dropdowns
            $('.ui.dropdown').dropdown();

            // Load data
            loadPatients();
            loadLabResults();

            // Close messages
            $('.message .close').on('click', function () {
                $(this).closest('.message').transition('fade');
            });

            // Form validation
            $('#labResultForm').form({
                fields: {
                    patient_uuid: 'empty',
                    test_name: 'empty',
                    test_type: 'empty',
                    test_date: 'empty',
                    result_status: 'empty'
                }
            });

            // Add lab result button
            $('#addLabResultBtn').on('click', function () {
                openLabResultModal();
            });

            // Save lab result
            $('#saveLabResultBtn').on('click', function () {
                if (!$('#labResultForm').form('is valid')) {
                    return;
                }
                saveLabResult();
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
         * Load patients
         */
        function loadPatients() {
            $.ajax({
                url: apiURL('users') + 'users.php?action=patients',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success && response.data) {
                        patientsData = response.data;
                        populatePatientDropdown();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('Failed to load patients');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Load Patients Error');
                }
            });
        }

        /**
         * Populate patient dropdown
         */
        function populatePatientDropdown() {
            const $select = $('#patientSelect');
            $select.find('option:not(:first)').remove();

            patientsData.forEach(function (patient) {
                const option = `<option value="${patient.uuid}">
                    ${escapeHtml(patient.full_name)} - ${escapeHtml(patient.patient_custom_id || 'N/A')}
                </option>`;
                $select.append(option);
            });

            $select.dropdown('refresh');
        }

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
                                            Patient: ${escapeHtml(result.patient_name || 'Unknown')}
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
                                    <div class="flex items-center gap-2">
                                        <i class="calendar icon text-gray-500"></i>
                                        <span class="text-sm text-gray-700">
                                            <strong>Date:</strong> ${formatDate(result.test_date)}
                                        </span>
                                    </div>
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
                                            ${escapeHtml(result.result_summary)}
                                        </p>
                                    </div>
                                ` : ''}

                                <!-- Tags -->
                                <div class="flex items-center gap-2 flex-wrap">
                                    ${result.detailed_results ? '<span class="ui mini label"><i class="file alternate icon"></i> Detailed</span>' : ''}
                                    ${result.findings ? '<span class="ui mini label pink"><i class="stethoscope icon"></i> Findings</span>' : ''}
                                    ${result.recommendations ? '<span class="ui mini label green"><i class="lightbulb icon"></i> Recommendations</span>' : ''}
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="ml-4 flex flex-col gap-2">
                                <button class="ui blue button" onclick="editLabResult('${result.uuid}')">
                                    <i class="edit icon"></i>
                                    Edit
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

            // This month
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
         * Open modal to add/edit lab result
         */
        function openLabResultModal(uuid = null) {
            // Reset form
            $('#labResultForm').form('clear');
            $('#resultUuid').val('');
            $('#isEditMode').val('false');
            $('#modalTitle').text('Add Lab Result');

            if (uuid) {
                // Edit mode - load data
                const result = labResultsData.find(r => r.uuid === uuid);
                if (result) {
                    $('#isEditMode').val('true');
                    $('#resultUuid').val(uuid);
                    $('#modalTitle').text('Edit Lab Result');

                    $('#patientSelect').dropdown('set selected', result.patient_uuid);
                    $('#testName').val(result.test_name);
                    $('#testType').dropdown('set selected', result.test_type);
                    $('#testDate').val(result.test_date);
                    $('#resultStatus').dropdown('set selected', result.result_status);
                    $('#resultSummary').val(result.result_summary || '');
                    $('#detailedResults').val(result.detailed_results || '');
                    $('#referenceValues').val(result.reference_values || '');
                    $('#findings').val(result.findings || '');
                    $('#recommendations').val(result.recommendations || '');
                    $('#notes').val(result.notes || '');
                }
            }

            $('#labResultModal').modal('show');
        }

        /**
         * Edit lab result (alias)
         */
        function editLabResult(uuid) {
            openLabResultModal(uuid);
        }

        /**
         * Save lab result
         */
        function saveLabResult() {
            const isEdit = $('#isEditMode').val() === 'true';
            const url = apiURL('lab_results') + 'lab_results.php';

            let formData;
            if (isEdit) {
                // PUT request for update
                formData = new URLSearchParams({
                    action: 'update',
                    uuid: $('#resultUuid').val(),
                    test_name: $('#testName').val(),
                    test_type: $('#testType').val(),
                    test_date: $('#testDate').val(),
                    result_status: $('#resultStatus').val(),
                    result_summary: $('#resultSummary').val(),
                    detailed_results: $('#detailedResults').val(),
                    reference_values: $('#referenceValues').val(),
                    findings: $('#findings').val(),
                    recommendations: $('#recommendations').val(),
                    notes: $('#notes').val()
                });
            } else {
                // POST request for create
                formData = new URLSearchParams({
                    patient_uuid: $('#patientSelect').val(),
                    test_name: $('#testName').val(),
                    test_type: $('#testType').val(),
                    test_date: $('#testDate').val(),
                    result_status: $('#resultStatus').val(),
                    result_summary: $('#resultSummary').val(),
                    detailed_results: $('#detailedResults').val(),
                    reference_values: $('#referenceValues').val(),
                    findings: $('#findings').val(),
                    recommendations: $('#recommendations').val(),
                    notes: $('#notes').val()
                });
            }

            $('#saveLabResultBtn').addClass('loading disabled');

            $.ajax({
                url: url,
                method: isEdit ? 'PUT' : 'POST',
                data: formData.toString(),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        showSuccess(isEdit ? 'Lab result updated successfully!' : 'Lab result created successfully!');
                        $('#labResultModal').modal('hide');
                        loadLabResults();
                    } else {
                        showError(response.message || 'Failed to save lab result');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to save lab result');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Save Lab Result Error');
                },
                complete: function () {
                    $('#saveLabResultBtn').removeClass('loading disabled');
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