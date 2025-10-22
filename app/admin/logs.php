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
// TODO: Replace with actual database queries from activity_logs table
$activityLogs = [
    ['uuid' => 'log-001', 'user' => 'Dr. Sarah Johnson', 'action' => 'Created prescription', 'details' => 'Prescription #RX001 for Patient #P001234', 'ip' => '192.168.1.100', 'timestamp' => '2024-10-22 14:30:25', 'type' => 'create'],
    ['uuid' => 'log-002', 'user' => 'Admin', 'action' => 'Approved user registration', 'details' => 'Approved doctor registration for Dr. Mike Chen', 'ip' => '192.168.1.1', 'timestamp' => '2024-10-22 14:15:10', 'type' => 'update'],
    ['uuid' => 'log-003', 'user' => 'John Doe', 'action' => 'Updated profile', 'details' => 'Changed phone number and emergency contact', 'ip' => '192.168.1.105', 'timestamp' => '2024-10-22 13:45:33', 'type' => 'update'],
    ['uuid' => 'log-004', 'user' => 'System', 'action' => 'Database backup', 'details' => 'Automated backup completed successfully', 'ip' => '127.0.0.1', 'timestamp' => '2024-10-22 12:00:00', 'type' => 'system'],
    ['uuid' => 'log-005', 'user' => 'Dr. Mike Chen', 'action' => 'Confirmed appointment', 'details' => 'Appointment #APT001 confirmed for tomorrow', 'ip' => '192.168.1.102', 'timestamp' => '2024-10-22 11:20:15', 'type' => 'update'],
    ['uuid' => 'log-006', 'user' => 'Admin', 'action' => 'Deleted user', 'details' => 'Removed inactive user account #U00145', 'ip' => '192.168.1.1', 'timestamp' => '2024-10-22 10:05:42', 'type' => 'delete'],
    ['uuid' => 'log-007', 'user' => 'Jane Smith', 'action' => 'Logged in', 'details' => 'Successful login from web browser', 'ip' => '192.168.1.110', 'timestamp' => '2024-10-22 09:30:18', 'type' => 'auth'],
    ['uuid' => 'log-008', 'user' => 'System', 'action' => 'Security scan', 'details' => 'Weekly security scan completed - No threats detected', 'ip' => '127.0.0.1', 'timestamp' => '2024-10-22 08:00:00', 'type' => 'system'],
];

$totalLogs = count($activityLogs);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>Activity Logs - Admin - MindTrack</title>
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
                    <h1 class="text-2xl font-bold text-gray-800">Activity Logs</h1>
                    <p class="text-sm text-gray-600 mt-1">Monitor all system activities and user actions</p>
                </div>
                <div class="flex gap-2">
                    <button class="ui button">
                        <i class="download icon"></i>
                        Export Logs
                    </button>
                    <button class="ui primary button">
                        <i class="sync icon"></i>
                        Refresh
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-5 mb-6">
                <div class="bg-white rounded-lg p-4 shadow-sm border border-blue-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Logs</p>
                            <p class="text-2xl font-bold text-blue-600"><?= $totalLogs ?></p>
                        </div>
                        <i class="fas fa-list text-3xl text-blue-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-green-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Created</p>
                            <p class="text-2xl font-bold text-green-600">1</p>
                        </div>
                        <i class="fas fa-plus-circle text-3xl text-green-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-orange-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Updated</p>
                            <p class="text-2xl font-bold text-orange-600">3</p>
                        </div>
                        <i class="fas fa-edit text-3xl text-orange-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-red-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Deleted</p>
                            <p class="text-2xl font-bold text-red-600">1</p>
                        </div>
                        <i class="fas fa-trash text-3xl text-red-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-purple-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">System</p>
                            <p class="text-2xl font-bold text-purple-600">2</p>
                        </div>
                        <i class="fas fa-server text-3xl text-purple-600 opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Filters & Search -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="ui search">
                        <div class="ui icon input w-full">
                            <input type="text" placeholder="Search logs..." id="searchLogs">
                            <i class="search icon"></i>
                        </div>
                    </div>

                    <select class="ui dropdown" id="filterType">
                        <option value="">All Types</option>
                        <option value="create">Create</option>
                        <option value="update">Update</option>
                        <option value="delete">Delete</option>
                        <option value="auth">Authentication</option>
                        <option value="system">System</option>
                    </select>

                    <select class="ui dropdown" id="filterUser">
                        <option value="">All Users</option>
                        <option value="admin">Admin</option>
                        <option value="system">System</option>
                        <option value="doctors">Doctors</option>
                        <option value="patients">Patients</option>
                    </select>

                    <input type="date" class="ui input" id="filterDate">

                    <button class="ui button" id="resetFilters">
                        <i class="redo icon"></i>
                        Reset
                    </button>
                </div>
            </div>

            <!-- Activity Timeline -->
            <div class="bg-white rounded-lg shadow-sm border border-blue-50 p-6">
                <h3 class="text-base font-semibold text-gray-800 mb-6">Activity Timeline</h3>
                <div class="space-y-4">
                    <?php foreach ($activityLogs as $log): ?>
                        <div class="flex gap-4 pb-4 border-b border-gray-100 last:border-0">
                            <!-- Icon -->
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center
                                    <?php
                                    echo $log['type'] === 'create' ? 'bg-green-100' :
                                        ($log['type'] === 'update' ? 'bg-orange-100' :
                                            ($log['type'] === 'delete' ? 'bg-red-100' :
                                                ($log['type'] === 'auth' ? 'bg-blue-100' : 'bg-purple-100')));
                                    ?>">
                                    <i class="fas fa-<?php
                                    echo $log['type'] === 'create' ? 'plus' :
                                        ($log['type'] === 'update' ? 'edit' :
                                            ($log['type'] === 'delete' ? 'trash' :
                                                ($log['type'] === 'auth' ? 'sign-in-alt' : 'server')));
                                    ?> 
                                        <?php
                                        echo $log['type'] === 'create' ? 'text-green-600' :
                                            ($log['type'] === 'update' ? 'text-orange-600' :
                                                ($log['type'] === 'delete' ? 'text-red-600' :
                                                    ($log['type'] === 'auth' ? 'text-blue-600' : 'text-purple-600')));
                                        ?>"></i>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            <?= htmlspecialchars($log['user']) ?>
                                            <span class="font-normal text-gray-600">
                                                <?= htmlspecialchars($log['action']) ?>
                                            </span>
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1"><?= htmlspecialchars($log['details']) ?></p>
                                        <div class="flex items-center gap-4 mt-2">
                                            <span class="text-xs text-gray-500">
                                                <i class="clock icon"></i>
                                                <?= date('M j, Y \a\t g:i A', strtotime($log['timestamp'])) ?>
                                            </span>
                                            <span class="text-xs text-gray-500">
                                                <i class="globe icon"></i>
                                                <?= $log['ip'] ?>
                                            </span>
                                            <span class="ui mini label <?php
                                            echo $log['type'] === 'create' ? 'green' :
                                                ($log['type'] === 'update' ? 'orange' :
                                                    ($log['type'] === 'delete' ? 'red' :
                                                        ($log['type'] === 'auth' ? 'blue' : 'purple')));
                                            ?>">
                                                <?= ucfirst($log['type']) ?>
                                            </span>
                                        </div>
                                    </div>
                                    <button class="ui mini icon button" data-tooltip="View Details"
                                        data-log-uuid="<?= $log['uuid'] ?>">
                                        <i class="eye icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">Showing 1 to <?= count($activityLogs) ?> of <?= $totalLogs ?>
                            logs</p>
                        <div class="ui pagination menu">
                            <a class="icon item"><i class="left chevron icon"></i></a>
                            <a class="active item">1</a>
                            <a class="item">2</a>
                            <a class="item">3</a>
                            <a class="icon item"><i class="right chevron icon"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Log Details Modal -->
    <div class="ui modal" id="logDetailsModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="info circle icon"></i>
            Activity Log Details
        </div>
        <div class="content">
            <div class="ui grid">
                <div class="eight wide column">
                    <h4 class="ui dividing header">Log Information</h4>
                    <div class="ui relaxed list">
                        <div class="item">
                            <strong>User:</strong> <span id="modalUser">-</span>
                        </div>
                        <div class="item">
                            <strong>Action:</strong> <span id="modalAction">-</span>
                        </div>
                        <div class="item">
                            <strong>Type:</strong> <span id="modalType">-</span>
                        </div>
                        <div class="item">
                            <strong>Timestamp:</strong> <span id="modalTimestamp">-</span>
                        </div>
                    </div>
                </div>
                <div class="eight wide column">
                    <h4 class="ui dividing header">Additional Details</h4>
                    <div class="ui relaxed list">
                        <div class="item">
                            <strong>IP Address:</strong> <span id="modalIP">-</span>
                        </div>
                        <div class="item">
                            <strong>Details:</strong> <span id="modalDetails">-</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="actions">
            <button class="ui cancel button">Close</button>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        $(document).ready(function () {
            // Initialize dropdowns
            $('.ui.dropdown').dropdown();

            // Initialize tooltips
            $('[data-tooltip]').popup();

            // Reset filters
            $('#resetFilters').on('click', function () {
                $('#searchLogs').val('');
                $('#filterType').dropdown('clear');
                $('#filterUser').dropdown('clear');
                $('#filterDate').val('');
            });

            // View log details (placeholder)
            $('.button[data-log-uuid]').on('click', function () {
                const logUuid = $(this).data('log-uuid');
                // TODO: Fetch and display log details
                $('#logDetailsModal').modal('show');
            });
        });
    </script>
</body>

</html>