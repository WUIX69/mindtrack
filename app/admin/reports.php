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
$monthlyStats = [
    'new_patients' => [12, 15, 18, 22, 19, 25, 28, 32, 35, 38, 42, 45],
    'appointments' => [45, 52, 48, 65, 58, 72, 68, 75, 82, 78, 85, 90],
    'completed' => [40, 48, 45, 60, 55, 68, 64, 70, 78, 74, 80, 85]
];

$departmentStats = [
    ['name' => 'General Therapy', 'patients' => 85, 'percentage' => 45],
    ['name' => 'Child Psychology', 'patients' => 52, 'percentage' => 28],
    ['name' => 'Couples Therapy', 'patients' => 35, 'percentage' => 18],
    ['name' => 'Other', 'patients' => 18, 'percentage' => 9],
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>Reports & Analytics - Admin - MindTrack</title>
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
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Reports & Analytics</h1>
                    <p class="text-sm text-gray-600 mt-1">System insights and data visualization</p>
                </div>
                <div class="flex gap-2">
                    <button class="ui button">
                        <i class="download icon"></i>
                        Export PDF
                    </button>
                    <button class="ui primary button">
                        <i class="file excel icon"></i>
                        Export Excel
                    </button>
                </div>
            </div>

            <!-- Date Range Filter -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="field">
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Report Type</label>
                        <select class="ui dropdown w-full">
                            <option value="monthly">Monthly Report</option>
                            <option value="quarterly">Quarterly Report</option>
                            <option value="yearly">Yearly Report</option>
                            <option value="custom">Custom Range</option>
                        </select>
                    </div>
                    <div class="field">
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Start Date</label>
                        <input type="date" class="ui input w-full" value="2024-01-01">
                    </div>
                    <div class="field">
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">End Date</label>
                        <input type="date" class="ui input w-full" value="2024-12-31">
                    </div>
                    <div class="field flex items-end">
                        <button class="ui primary button w-full">
                            <i class="chart bar icon"></i>
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">
                <!-- Patient Growth Chart -->
                <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50">
                    <h3 class="text-base font-semibold text-gray-800 mb-4">Patient Growth Trend</h3>
                    <div class="h-64">
                        <canvas id="patientGrowthChart"></canvas>
                    </div>
                </div>

                <!-- Appointments Chart -->
                <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50">
                    <h3 class="text-base font-semibold text-gray-800 mb-4">Appointments Overview</h3>
                    <div class="h-64">
                        <canvas id="appointmentsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Department Statistics -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">
                <!-- Department Breakdown -->
                <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50">
                    <h3 class="text-base font-semibold text-gray-800 mb-4">Patients by Department</h3>
                    <div class="space-y-4">
                        <?php foreach ($departmentStats as $dept): ?>
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-sm font-medium text-gray-700"><?= $dept['name'] ?></span>
                                    <span class="text-sm font-semibold text-blue-600"><?= $dept['patients'] ?>
                                        patients</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: <?= $dept['percentage'] ?>%">
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500"><?= $dept['percentage'] ?>%</span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Department Pie Chart -->
                <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50">
                    <h3 class="text-base font-semibold text-gray-800 mb-4">Distribution by Service</h3>
                    <div class="h-64">
                        <canvas id="departmentPieChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-5 shadow-md text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Average Wait Time</p>
                            <p class="text-3xl font-bold mt-1">15 min</p>
                        </div>
                        <i class="fas fa-clock text-4xl opacity-20"></i>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-5 shadow-md text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Success Rate</p>
                            <p class="text-3xl font-bold mt-1">94%</p>
                        </div>
                        <i class="fas fa-check-circle text-4xl opacity-20"></i>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-5 shadow-md text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Patient Satisfaction</p>
                            <p class="text-3xl font-bold mt-1">4.8/5</p>
                        </div>
                        <i class="fas fa-star text-4xl opacity-20"></i>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg p-5 shadow-md text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm opacity-90">Active Doctors</p>
                            <p class="text-3xl font-bold mt-1">15</p>
                        </div>
                        <i class="fas fa-user-md text-4xl opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="bg-white rounded-lg shadow-sm border border-blue-50 overflow-hidden">
                <div class="p-5 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-800">Detailed Statistics</h3>
                </div>
                <table class="ui celled table">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>New Patients</th>
                            <th>Total Appointments</th>
                            <th>Completed</th>
                            <th>Completion Rate</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        for ($i = 0; $i < 12; $i++):
                            $rate = round(($monthlyStats['completed'][$i] / $monthlyStats['appointments'][$i]) * 100);
                            ?>
                            <tr>
                                <td><?= $months[$i] ?> 2024</td>
                                <td><?= $monthlyStats['new_patients'][$i] ?></td>
                                <td><?= $monthlyStats['appointments'][$i] ?></td>
                                <td><?= $monthlyStats['completed'][$i] ?></td>
                                <td>
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-600 h-2 rounded-full" style="width: <?= $rate ?>%"></div>
                                        </div>
                                        <span class="text-sm font-semibold text-gray-700"><?= $rate ?>%</span>
                                    </div>
                                </td>
                                <td class="font-semibold text-green-600">$<?= number_format(rand(5000, 15000), 2) ?></td>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        $(document).ready(function () {
            $('.ui.dropdown').dropdown();

            // Patient Growth Chart
            const patientCtx = document.getElementById('patientGrowthChart').getContext('2d');
            new Chart(patientCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'New Patients',
                        data: <?= json_encode($monthlyStats['new_patients']) ?>,
                        borderColor: '#0077b6',
                        backgroundColor: 'rgba(0, 119, 182, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Appointments Chart
            const aptCtx = document.getElementById('appointmentsChart').getContext('2d');
            new Chart(aptCtx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Total',
                        data: <?= json_encode($monthlyStats['appointments']) ?>,
                        backgroundColor: 'rgba(0, 119, 182, 0.7)',
                    }, {
                        label: 'Completed',
                        data: <?= json_encode($monthlyStats['completed']) ?>,
                        backgroundColor: 'rgba(76, 175, 80, 0.7)',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Department Pie Chart
            const deptCtx = document.getElementById('departmentPieChart').getContext('2d');
            new Chart(deptCtx, {
                type: 'doughnut',
                data: {
                    labels: <?= json_encode(array_column($departmentStats, 'name')) ?>,
                    datasets: [{
                        data: <?= json_encode(array_column($departmentStats, 'patients')) ?>,
                        backgroundColor: [
                            '#0077b6',
                            '#00A9FF',
                            '#89CFF3',
                            '#A0E9FF'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>