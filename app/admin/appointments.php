<?php
require_once __DIR__ . '/../../core/app.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: ' . app('auth'));
    exit;
}

// Fetch user information from session
$username = $_SESSION['username'] ?? 'Admin';

// --- DUMMY DATA ---
// TODO: Replace with actual database queries
$appointments = [
    [
        'uuid' => 'apt-001',
        'patient' => 'John Doe',
        'patient_id' => 'P001234',
        'doctor' => 'Dr. Sarah Johnson',
        'date' => '2024-10-23',
        'time' => '09:00 AM',
        'type' => 'Consultation',
        'status' => 'confirmed',
        'notes' => 'Follow-up session'
    ],
    [
        'uuid' => 'apt-002',
        'patient' => 'Jane Smith',
        'patient_id' => 'P001235',
        'doctor' => 'Dr. Mike Chen',
        'date' => '2024-10-23',
        'time' => '10:30 AM',
        'type' => 'Therapy',
        'status' => 'pending',
        'notes' => 'New patient intake'
    ],
    [
        'uuid' => 'apt-003',
        'patient' => 'Robert Lee',
        'patient_id' => 'P001236',
        'doctor' => 'Dr. Emily White',
        'date' => '2024-10-24',
        'time' => '02:00 PM',
        'type' => 'Evaluation',
        'status' => 'pending',
        'notes' => 'Monthly check-up'
    ],
    [
        'uuid' => 'apt-004',
        'patient' => 'Maria Garcia',
        'patient_id' => 'P001237',
        'doctor' => 'Dr. Sarah Johnson',
        'date' => '2024-10-25',
        'time' => '11:00 AM',
        'type' => 'Therapy',
        'status' => 'confirmed',
        'notes' => 'Continuation of treatment'
    ],
    [
        'uuid' => 'apt-005',
        'patient' => 'David Brown',
        'patient_id' => 'P001238',
        'doctor' => 'Dr. Mike Chen',
        'date' => '2024-10-22',
        'time' => '03:00 PM',
        'type' => 'Consultation',
        'status' => 'completed',
        'notes' => 'Initial assessment completed'
    ],
];

$totalAppointments = count($appointments);
$confirmed = count(array_filter($appointments, fn($a) => $a['status'] === 'confirmed'));
$pending = count(array_filter($appointments, fn($a) => $a['status'] === 'pending'));
$completed = count(array_filter($appointments, fn($a) => $a['status'] === 'completed'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>Appointments - Admin - MindTrack</title>
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
                    <h1 class="text-2xl font-bold text-gray-800">Appointment Management</h1>
                    <p class="text-sm text-gray-600 mt-1">View and manage all system appointments</p>
                </div>
                <button class="ui primary button" id="addAppointmentBtn">
                    <i class="plus icon"></i>
                    Schedule Appointment
                </button>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">
                <div class="bg-white rounded-lg p-4 shadow-sm border border-blue-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="text-2xl font-bold text-blue-600"><?= $totalAppointments ?></p>
                        </div>
                        <i class="fas fa-calendar text-3xl text-blue-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-green-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Confirmed</p>
                            <p class="text-2xl font-bold text-green-600"><?= $confirmed ?></p>
                        </div>
                        <i class="fas fa-check-circle text-3xl text-green-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-orange-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Pending</p>
                            <p class="text-2xl font-bold text-orange-600"><?= $pending ?></p>
                        </div>
                        <i class="fas fa-clock text-3xl text-orange-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Completed</p>
                            <p class="text-2xl font-bold text-gray-600"><?= $completed ?></p>
                        </div>
                        <i class="fas fa-check-double text-3xl text-gray-600 opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Filters & Search -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="ui search">
                        <div class="ui icon input w-full">
                            <input type="text" placeholder="Search appointments..." id="searchAppointments">
                            <i class="search icon"></i>
                        </div>
                    </div>

                    <select class="ui dropdown" id="filterStatus">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>

                    <select class="ui dropdown" id="filterType">
                        <option value="">All Types</option>
                        <option value="consultation">Consultation</option>
                        <option value="therapy">Therapy</option>
                        <option value="evaluation">Evaluation</option>
                    </select>

                    <input type="date" class="ui input" id="filterDate" placeholder="Filter by date">

                    <button class="ui button" id="resetFilters">
                        <i class="redo icon"></i>
                        Reset
                    </button>
                </div>
            </div>

            <!-- Appointments Table -->
            <div class="bg-white rounded-lg shadow-sm border border-blue-50 overflow-hidden">
                <table class="ui celled table">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date & Time</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($appointments as $apt): ?>
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-blue-200 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 font-semibold">
                                                <?= strtoupper(substr($apt['patient'], 0, 1)) ?>
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800"><?= htmlspecialchars($apt['patient']) ?>
                                            </p>
                                            <p class="text-xs text-gray-500"><?= $apt['patient_id'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="font-medium text-gray-800"><?= htmlspecialchars($apt['doctor']) ?></p>
                                </td>
                                <td>
                                    <div class="flex flex-col">
                                        <p class="font-medium text-gray-800">
                                            <i class="calendar icon"></i>
                                            <?= date('M j, Y', strtotime($apt['date'])) ?>
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <i class="clock icon"></i>
                                            <?= $apt['time'] ?>
                                        </p>
                                    </div>
                                </td>
                                <td>
                                    <span class="ui label blue">
                                        <?= ucfirst($apt['type']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="ui label <?php
                                    echo $apt['status'] === 'confirmed' ? 'green' :
                                        ($apt['status'] === 'pending' ? 'orange' :
                                            ($apt['status'] === 'completed' ? 'grey' : 'red'));
                                    ?>">
                                        <?= ucfirst($apt['status']) ?>
                                    </span>
                                </td>
                                <td class="text-sm text-gray-600"><?= htmlspecialchars($apt['notes']) ?></td>
                                <td>
                                    <div class="ui mini buttons">
                                        <?php if ($apt['status'] === 'pending'): ?>
                                            <button class="ui positive icon button" data-tooltip="Confirm"
                                                data-apt-uuid="<?= $apt['uuid'] ?>">
                                                <i class="check icon"></i>
                                            </button>
                                        <?php endif; ?>
                                        <button class="ui blue icon button" data-tooltip="View Details"
                                            data-apt-uuid="<?= $apt['uuid'] ?>">
                                            <i class="eye icon"></i>
                                        </button>
                                        <button class="ui orange icon button" data-tooltip="Reschedule"
                                            data-apt-uuid="<?= $apt['uuid'] ?>">
                                            <i class="calendar alternate icon"></i>
                                        </button>
                                        <button class="ui red icon button" data-tooltip="Cancel"
                                            data-apt-uuid="<?= $apt['uuid'] ?>">
                                            <i class="times icon"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">Showing 1 to <?= count($appointments) ?> of
                            <?= $totalAppointments ?> appointments
                        </p>
                        <div class="ui pagination menu">
                            <a class="icon item"><i class="left chevron icon"></i></a>
                            <a class="active item">1</a>
                            <a class="item">2</a>
                            <a class="icon item"><i class="right chevron icon"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Appointment Modal -->
    <div class="ui modal" id="appointmentModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="calendar plus icon"></i>
            Schedule New Appointment
        </div>
        <div class="content">
            <form class="ui form" id="appointmentForm">
                <div class="two fields">
                    <div class="field required">
                        <label>Patient</label>
                        <select name="patient_uuid" class="ui search dropdown">
                            <option value="">Select Patient</option>
                            <option value="p1">John Doe (P001234)</option>
                            <option value="p2">Jane Smith (P001235)</option>
                        </select>
                    </div>
                    <div class="field required">
                        <label>Doctor</label>
                        <select name="doctor_uuid" class="ui search dropdown">
                            <option value="">Select Doctor</option>
                            <option value="d1">Dr. Sarah Johnson</option>
                            <option value="d2">Dr. Mike Chen</option>
                        </select>
                    </div>
                </div>

                <div class="two fields">
                    <div class="field required">
                        <label>Date</label>
                        <input type="date" name="appointment_date">
                    </div>
                    <div class="field required">
                        <label>Time</label>
                        <input type="time" name="appointment_time">
                    </div>
                </div>

                <div class="field required">
                    <label>Appointment Type</label>
                    <select name="type" class="ui dropdown">
                        <option value="">Select Type</option>
                        <option value="consultation">Consultation</option>
                        <option value="therapy">Therapy</option>
                        <option value="evaluation">Evaluation</option>
                        <option value="follow-up">Follow-up</option>
                    </select>
                </div>

                <div class="field">
                    <label>Notes</label>
                    <textarea name="notes" rows="3" placeholder="Additional notes..."></textarea>
                </div>

                <div class="field">
                    <label>Status</label>
                    <select name="status" class="ui dropdown">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                    </select>
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

    <?php shared('components/elements/scripts'); ?>

    <script>
        $(document).ready(function () {
            // Initialize dropdowns
            $('.ui.dropdown').dropdown();

            // Initialize tooltips
            $('[data-tooltip]').popup();

            // Open add appointment modal
            $('#addAppointmentBtn').on('click', function () {
                $('#appointmentModal').modal('show');
            });

            // Save appointment
            $('#saveAppointmentBtn').on('click', function () {
                // TODO: Implement AJAX call to save appointment
                console.log('Saving appointment...');
                $('#appointmentModal').modal('hide');
            });

            // Reset filters
            $('#resetFilters').on('click', function () {
                $('#searchAppointments').val('');
                $('#filterStatus').dropdown('clear');
                $('#filterType').dropdown('clear');
                $('#filterDate').val('');
            });

            // Confirm appointment
            $('.positive.button[data-apt-uuid]').on('click', function () {
                const aptUuid = $(this).data('apt-uuid');
                // TODO: Implement AJAX call to confirm appointment
                console.log('Confirming appointment:', aptUuid);
            });
        });
    </script>
</body>

</html>