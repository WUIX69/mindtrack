<?php
require_once __DIR__ . '/../../core/app.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: ' . app('auth'));
    exit;
}

// Fetch user information from session
$username = $_SESSION['username'] ?? 'Admin';
$userEmail = $_SESSION['email'] ?? 'admin@mindtrack.com';

// --- DUMMY DATA ---
// TODO: Replace with actual database queries
$totalUsers = 156;
$totalPatients = 120;
$totalDoctors = 15;
$pendingApprovals = 8;
$totalAppointments = 45;
$activeAppointments = 12;
$completedAppointments = 28;
$systemUptime = "99.9%";

$recentActivities = [
    ['user' => 'Dr. Sarah Johnson', 'action' => 'Created prescription for Patient #P001234', 'time' => '5 minutes ago', 'type' => 'success'],
    ['user' => 'Admin', 'action' => 'Approved new doctor registration', 'time' => '15 minutes ago', 'type' => 'info'],
    ['user' => 'John Doe', 'action' => 'Updated patient profile', 'time' => '1 hour ago', 'type' => 'warning'],
    ['user' => 'System', 'action' => 'Database backup completed', 'time' => '2 hours ago', 'type' => 'success'],
    ['user' => 'Dr. Mike Chen', 'action' => 'Confirmed appointment for tomorrow', 'time' => '3 hours ago', 'type' => 'info'],
];

$pendingUsers = [
    ['name' => 'Dr. Emily White', 'email' => 'emily.white@hospital.com', 'role' => 'Doctor', 'date' => '2024-10-20'],
    ['name' => 'Sarah Martinez', 'email' => 'sarah.m@email.com', 'role' => 'Patient', 'date' => '2024-10-20'],
    ['name' => 'Dr. Robert Lee', 'email' => 'robert.lee@clinic.com', 'role' => 'Doctor', 'date' => '2024-10-19'],
];

$header_date = date('l, F j, Y');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>Admin Dashboard - MindTrack</title>
    <?php shared('components/elements/styles'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gradient-to-br from-blue-100 via-cyan-50 to-blue-50 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php shared('components/layout/sidebar') ?>

        <!-- Main Content -->
        <div class="flex-1 p-8 overflow-y-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6 bg-white rounded-xl p-5 shadow-md">
                <div>
                    <h1 class="text-xl font-semibold text-blue-600">ADMIN DASHBOARD</h1>
                    <p class="text-sm text-gray-600 mt-1">System Overview & Management</p>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="far fa-calendar-alt"></i>
                    <span><?= $header_date ?></span>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
                <!-- Total Users -->
                <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50 text-center">
                    <div class="flex justify-center items-center mb-2 gap-2">
                        <div class="w-9 h-9 bg-purple-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-purple-600"></i>
                        </div>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-lg">+12% this
                            month</span>
                    </div>
                    <div class="text-3xl font-bold text-purple-600"><?= $totalUsers ?></div>
                    <div class="text-sm text-gray-600 mt-1">Total Users</div>
                </div>

                <!-- Total Patients -->
                <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50 text-center">
                    <div class="flex justify-center items-center mb-2 gap-2">
                        <div class="w-9 h-9 bg-blue-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-injured text-blue-600"></i>
                        </div>
                        <span
                            class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg"><?= $totalPatients ?>
                            active</span>
                    </div>
                    <div class="text-3xl font-bold text-blue-600"><?= $totalPatients ?></div>
                    <div class="text-sm text-gray-600 mt-1">Patients</div>
                </div>

                <!-- Total Doctors -->
                <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50 text-center">
                    <div class="flex justify-center items-center mb-2 gap-2">
                        <div class="w-9 h-9 bg-teal-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-md text-teal-600"></i>
                        </div>
                        <span
                            class="text-xs font-semibold text-teal-600 bg-teal-50 px-2 py-1 rounded-lg"><?= $totalDoctors ?>
                            doctors</span>
                    </div>
                    <div class="text-3xl font-bold text-teal-600"><?= $totalDoctors ?></div>
                    <div class="text-sm text-gray-600 mt-1">Medical Staff</div>
                </div>

                <!-- Pending Approvals -->
                <div class="bg-white rounded-lg p-5 shadow-sm border border-orange-50 text-center">
                    <div class="flex justify-center items-center mb-2 gap-2">
                        <div class="w-9 h-9 bg-orange-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-orange-600"></i>
                        </div>
                        <span class="text-xs font-semibold text-orange-600 bg-orange-50 px-2 py-1 rounded-lg">Needs
                            action</span>
                    </div>
                    <div class="text-3xl font-bold text-orange-600"><?= $pendingApprovals ?></div>
                    <div class="text-sm text-gray-600 mt-1">Pending Approvals</div>
                </div>
            </div>

            <!-- Appointments Overview -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">
                <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-semibold text-gray-800">Total Appointments</h3>
                        <i class="fas fa-calendar-alt text-2xl text-blue-600"></i>
                    </div>
                    <div class="text-3xl font-bold text-blue-600"><?= $totalAppointments ?></div>
                    <p class="text-xs text-gray-600 mt-2">All scheduled appointments</p>
                </div>

                <div class="bg-white rounded-lg p-5 shadow-sm border border-green-50">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-semibold text-gray-800">Active Today</h3>
                        <i class="fas fa-calendar-check text-2xl text-green-600"></i>
                    </div>
                    <div class="text-3xl font-bold text-green-600"><?= $activeAppointments ?></div>
                    <p class="text-xs text-gray-600 mt-2">Appointments scheduled for today</p>
                </div>

                <div class="bg-white rounded-lg p-5 shadow-sm border border-gray-50">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-semibold text-gray-800">Completed</h3>
                        <i class="fas fa-check-circle text-2xl text-gray-600"></i>
                    </div>
                    <div class="text-3xl font-bold text-gray-600"><?= $completedAppointments ?></div>
                    <p class="text-xs text-gray-600 mt-2">Successfully completed this month</p>
                </div>
            </div>

            <!-- Main Content Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">
                <!-- Recent Activity -->
                <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50">
                    <h2 class="text-base font-semibold text-gray-800 mb-4">Recent Activity</h2>
                    <div class="space-y-3">
                        <?php foreach ($recentActivities as $activity): ?>
                            <div class="flex items-start gap-3 pb-3 border-b border-gray-100 last:border-0">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                                    <?php
                                    echo $activity['type'] === 'success' ? 'bg-green-100' :
                                        ($activity['type'] === 'warning' ? 'bg-orange-100' : 'bg-blue-100');
                                    ?>">
                                    <i class="fas fa-<?php
                                    echo $activity['type'] === 'success' ? 'check' :
                                        ($activity['type'] === 'warning' ? 'exclamation' : 'info');
                                    ?> text-sm <?php
                                     echo $activity['type'] === 'success' ? 'text-green-600' :
                                         ($activity['type'] === 'warning' ? 'text-orange-600' : 'text-blue-600');
                                     ?>"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800"><?= htmlspecialchars($activity['user']) ?>
                                    </p>
                                    <p class="text-xs text-gray-600"><?= htmlspecialchars($activity['action']) ?></p>
                                    <p class="text-xs text-gray-400 mt-1"><?= htmlspecialchars($activity['time']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="<?= app('admin/logs') ?>"
                        class="block text-center text-sm text-blue-600 hover:text-blue-800 font-medium mt-4">
                        View All Activity →
                    </a>
                </div>

                <!-- Pending User Approvals -->
                <div class="bg-white rounded-lg p-5 shadow-sm border border-orange-50">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-base font-semibold text-gray-800">Pending Approvals</h2>
                        <span class="bg-orange-100 text-orange-600 text-xs font-semibold px-2 py-1 rounded-full">
                            <?= count($pendingUsers) ?> pending
                        </span>
                    </div>
                    <div class="space-y-3">
                        <?php foreach ($pendingUsers as $user): ?>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-200 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-semibold text-sm">
                                            <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-800">
                                            <?= htmlspecialchars($user['name']) ?></p>
                                        <p class="text-xs text-gray-600"><?= htmlspecialchars($user['email']) ?></p>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs px-2 py-0.5 rounded bg-blue-100 text-blue-600 font-medium">
                                                <?= $user['role'] ?>
                                            </span>
                                            <span class="text-xs text-gray-500"><?= $user['date'] ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button class="ui mini positive icon button" data-tooltip="Approve"
                                        data-position="top center">
                                        <i class="check icon"></i>
                                    </button>
                                    <button class="ui mini negative icon button" data-tooltip="Reject"
                                        data-position="top center">
                                        <i class="times icon"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a href="<?= app('admin/users') ?>"
                        class="block text-center text-sm text-orange-600 hover:text-orange-800 font-medium mt-4">
                        View All Pending →
                    </a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50">
                <h2 class="text-base font-semibold text-gray-800 mb-4">Quick Actions</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <a href="<?= app('admin/users') ?>"
                        class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg hover:shadow-md transition-all">
                        <i class="fas fa-users-cog text-3xl text-blue-600 mb-2"></i>
                        <span class="text-sm font-semibold text-gray-800">Manage Users</span>
                    </a>

                    <a href="<?= app('admin/appointments') ?>"
                        class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-green-50 to-green-100 rounded-lg hover:shadow-md transition-all">
                        <i class="fas fa-calendar-check text-3xl text-green-600 mb-2"></i>
                        <span class="text-sm font-semibold text-gray-800">Appointments</span>
                    </a>

                    <a href="<?= app('admin/reports') ?>"
                        class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg hover:shadow-md transition-all">
                        <i class="fas fa-chart-bar text-3xl text-purple-600 mb-2"></i>
                        <span class="text-sm font-semibold text-gray-800">Reports</span>
                    </a>

                    <a href="<?= app('admin/settings') ?>"
                        class="flex flex-col items-center justify-center p-4 bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg hover:shadow-md transition-all">
                        <i class="fas fa-cog text-3xl text-gray-600 mb-2"></i>
                        <span class="text-sm font-semibold text-gray-800">Settings</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        $(document).ready(function () {
            // Initialize tooltips
            $('[data-tooltip]').popup();
        });
    </script>
</body>

</html>