<?php
require_once __DIR__ . '/../../core/app.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in'])) {
    header('Location: ' . app('auth'));
    exit;
}

// Fetch user information from session
$username = $_SESSION['username'] ?? 'Admin User';
$userEmail = 'admin@mindtrack.com'; // TODO: Get from database

// --- DUMMY DATA ---
// TODO: Replace with actual database queries
$patientCount = 0;
$doctorCount = 4;
$appointmentCount = 0;

$monthlyAppointments = [0, 0, 0, 3, 1, 4, 3, 5, 8, 4, 0, 0];
$monthlyNewPatients = [0, 0, 0, 2, 2, 5, 4, 8, 10, 6, 0, 0];

$actualDay = 20;
$selectedDay = 20;

$appointments_on_days = [
    '15' => 'with_doctor',
    '18' => 'no_doctor',
    '20' => 'today_selected',
    '25' => 'no_doctor'
];

$activeDoctorsValue = 4;
$patientGrowthPercent = "0";

$days_in_month = 31;
$start_day_offset = 3;
$current_month_name = 'October';
$current_year = date('Y', strtotime('October 2025'));
$header_date = date('l, F j, Y');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>Dashboard - MindTrack</title>
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
                    <h1 class="text-xl font-semibold text-blue-600">PATIENT DASHBOARD</h1>
                    <p class="text-sm text-gray-600 mt-1">Wayside Psyche Resources Center</p>
                </div>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <i class="far fa-calendar-alt"></i>
                    <span><?= $header_date ?></span>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
                <!-- Stat Card 1 -->
                <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50 text-center">
                    <div class="flex justify-center items-center mb-2 gap-2">
                        <div class="w-9 h-9 bg-blue-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-blue-600"></i>
                        </div>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-lg">+0%</span>
                    </div>
                    <div class="text-3xl font-bold text-blue-600"><?= $patientCount ?></div>
                    <div class="text-sm text-gray-600 mt-1">Total Patients</div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50 text-center">
                    <div class="flex justify-center items-center mb-2 gap-2">
                        <div class="w-9 h-9 bg-blue-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-tie text-blue-600"></i>
                        </div>
                        <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-lg">+2 this
                            month</span>
                    </div>
                    <div class="text-3xl font-bold text-blue-600"><?= $activeDoctorsValue ?></div>
                    <div class="text-sm text-gray-600 mt-1">Active Doctors</div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50 text-center">
                    <div class="flex justify-center items-center mb-2 gap-2">
                        <div class="w-9 h-9 bg-blue-200 rounded-full flex items-center justify-center">
                            <i class="far fa-calendar-alt text-blue-600"></i>
                        </div>
                        <span class="text-xs font-semibold text-red-600 bg-red-50 px-2 py-1 rounded-lg">No
                            appointments</span>
                    </div>
                    <div class="text-3xl font-bold text-blue-600"><?= $appointmentCount ?></div>
                    <div class="text-sm text-gray-600 mt-1">Appointments Today</div>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50 text-center">
                    <div class="flex justify-center items-center mb-2 gap-2">
                        <div class="w-9 h-9 bg-blue-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-chart-line text-blue-600"></i>
                        </div>
                        <span class="text-xs font-semibold text-gray-600 bg-gray-100 px-2 py-1 rounded-lg">vs last
                            month</span>
                    </div>
                    <div class="text-3xl font-bold text-blue-600"><?= $patientGrowthPercent ?>%</div>
                    <div class="text-sm text-gray-600 mt-1">Patient Growth</div>
                </div>
            </div>

            <!-- Content Row: Chart & Quick Actions -->
            <div class="flex flex-col lg:flex-row gap-5 mb-6">
                <!-- Chart Section -->
                <div class="flex-1 lg:flex-[3] bg-white rounded-lg p-4 shadow-sm border border-blue-50">
                    <h2 class="text-base font-semibold text-gray-800">Patient Activity Overview (12 Months)</h2>
                    <p class="text-xs text-gray-600 mb-2">Monthly patients and appointments tracking</p>
                    <div class="h-64">
                        <canvas id="activityChart"></canvas>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="flex-1 bg-white rounded-lg p-5 shadow-sm border border-blue-50 flex flex-col gap-4">
                    <div>
                        <h2 class="text-base font-semibold text-gray-800">Quick Actions</h2>
                        <p class="text-xs text-gray-600">Frequently used features</p>
                    </div>

                    <a href="<?= app('patients/register') ?>"
                        class="flex items-center gap-2 text-blue-600 font-semibold hover:text-blue-800 transition-colors">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="flex flex-col items-start">
                            <p class="text-sm font-semibold text-gray-800">Add New Patient</p>
                            <span class="text-xs font-normal text-gray-600">Register a new patient</span>
                        </div>
                    </a>

                    <a href="<?= app('patients/appointments') ?>"
                        class="flex items-center gap-2 text-blue-600 font-semibold hover:text-blue-800 transition-colors">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <i class="far fa-calendar-plus"></i>
                        </div>
                        <div class="flex flex-col items-start">
                            <p class="text-sm font-semibold text-gray-800">Book Appointment</p>
                            <span class="text-xs font-normal text-gray-600">Schedule new appointment</span>
                        </div>
                    </a>

                    <a href="<?= app('patients/list') ?>"
                        class="flex items-center gap-2 text-blue-600 font-semibold hover:text-blue-800 transition-colors">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="flex flex-col items-start">
                            <p class="text-sm font-semibold text-gray-800">View All Patients</p>
                            <span class="text-xs font-normal text-gray-600">Browse patient records</span>
                        </div>
                    </a>

                    <a href="<?= app('patients/prescriptions') ?>"
                        class="flex items-center gap-2 text-blue-600 font-semibold hover:text-blue-800 transition-colors">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <i class="fas fa-prescription"></i>
                        </div>
                        <div class="flex flex-col items-start">
                            <p class="text-sm font-semibold text-gray-800">Prescriptions</p>
                            <span class="text-xs font-normal text-gray-600">Manage prescriptions</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Calendar Row -->
            <div class="bg-white rounded-lg p-4 shadow-sm border border-blue-50 mb-6">
                <!-- Calendar Header -->
                <div class="flex justify-between items-center mb-4 px-2">
                    <h3 class="text-base font-semibold text-blue-600"><?= $current_month_name ?> <?= $current_year ?>
                    </h3>
                    <div class="flex gap-3">
                        <i
                            class="fas fa-chevron-left text-sm cursor-pointer text-blue-600 p-1 hover:bg-blue-50 rounded"></i>
                        <i
                            class="fas fa-chevron-right text-sm cursor-pointer text-blue-600 p-1 hover:bg-blue-50 rounded"></i>
                    </div>
                </div>

                <!-- Calendar Grid -->
                <div class="grid grid-cols-7 gap-1 text-center px-2">
                    <!-- Day Names -->
                    <div class="text-xs font-semibold text-gray-800 pb-2">Sun</div>
                    <div class="text-xs font-semibold text-gray-800 pb-2">Mon</div>
                    <div class="text-xs font-semibold text-gray-800 pb-2">Tue</div>
                    <div class="text-xs font-semibold text-gray-800 pb-2">Wed</div>
                    <div class="text-xs font-semibold text-gray-800 pb-2">Thu</div>
                    <div class="text-xs font-semibold text-gray-800 pb-2">Fri</div>
                    <div class="text-xs font-semibold text-gray-800 pb-2">Sat</div>

                    <!-- Offset Days -->
                    <?php for ($i = 0; $i < $start_day_offset; $i++): ?>
                        <div
                            class="text-xs p-2 rounded-lg text-gray-400 opacity-50 h-9 w-9 flex items-center justify-center mx-auto">
                        </div>
                    <?php endfor; ?>

                    <!-- Calendar Days -->
                    <?php for ($day = 1; $day <= $days_in_month; $day++):
                        $status = $appointments_on_days[$day] ?? '';
                        $class_names = 'text-xs p-2 rounded-lg cursor-pointer font-medium h-9 w-9 flex items-center justify-center mx-auto';

                        if ($status === 'with_doctor') {
                            $class_names .= ' bg-blue-200 text-blue-600 font-semibold';
                        } elseif ($status === 'no_doctor') {
                            $class_names .= ' bg-red-500 text-white font-semibold';
                        } elseif ($status === 'today_selected') {
                            $class_names .= ' bg-blue-600 text-white font-bold';
                        } elseif ($day === $actualDay && !$status) {
                            $class_names .= ' border-2 border-blue-600 text-blue-600';
                        } else {
                            $class_names .= ' text-gray-800';
                        }
                        ?>
                        <div class="<?= $class_names ?>"><?= $day ?></div>
                    <?php endfor; ?>
                </div>

                <!-- Legend -->
                <div class="flex gap-5 pt-4 px-2 text-xs text-gray-600">
                    <div class="flex items-center gap-1">
                        <div class="w-3 h-3 rounded bg-blue-200"></div>
                        <span>With Doctor</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <div class="w-3 h-3 rounded bg-red-500"></div>
                        <span>No Doctor</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <div class="w-3 h-3 rounded border-2 border-blue-600 bg-white"></div>
                        <span>Today</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        const ctx = document.getElementById('activityChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'New Patients',
                        data: <?= json_encode($monthlyNewPatients) ?>,
                        borderColor: '#0077b6',
                        backgroundColor: 'rgba(0, 119, 182, 0.1)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Appointments',
                        data: <?= json_encode($monthlyAppointments) ?>,
                        borderColor: '#00A9FF',
                        backgroundColor: 'rgba(0, 169, 255, 0.1)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>