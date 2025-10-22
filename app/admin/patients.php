<?php
require_once __DIR__ . '/../../core/app.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: ' . app('auth'));
    exit;
}

// Fetch patients from database
$patients = [];
try {
    $sql = "SELECT 
                u.uuid,
                u.first_name, 
                u.last_name, 
                u.email, 
                u.phone as contact,
                u.status,
                pa.patient_custom_id,
                pa.birthdate,
                pa.emergency_contact,
                CONCAT(d.first_name, ' ', d.last_name) as doctor_name
            FROM users u
            LEFT JOIN users_patient_adds pa ON u.uuid = pa.user_uuid
            LEFT JOIN users d ON pa.doctor_uuid = d.uuid
            WHERE u.role = 'patient'
            ORDER BY u.created_at DESC";
    $stmt = $conn->query($sql);

    while ($p = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $p['patient_number'] = $p['patient_custom_id'] ?? 'N/A';

        if ($p['birthdate']) {
            $dob = new DateTime($p['birthdate']);
            $today = new DateTime('today');
            $p['age'] = $dob->diff($today)->y . ' years old';
        } else {
            $p['age'] = 'N/A';
        }

        $p['status'] = strtolower($p['status']);
        $p['name'] = $p['first_name'] . ' ' . $p['last_name'];
        $p['phone'] = $p['contact'];
        $p['doctor'] = $p['doctor_name'] ?? 'Not assigned';

        $patients[] = $p;
    }
} catch (PDOException $e) {
    error_log("Error fetching patients: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>Patients - MindTrack</title>
    <?php shared('components/elements/styles'); ?>
</head>

<body class="bg-gradient-to-br from-blue-100 via-cyan-50 to-blue-50 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include __DIR__ . '/../../components/layout/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Header -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 m-0">Patients</h1>
                        <p class="text-gray-500 mt-2">Manage and view all registered patients</p>
                    </div>
                    <a href="<?= app('patients/register') ?>" class="ui primary large button" tabindex="0"
                        aria-label="Add New Patient">
                        <i class="plus icon"></i>
                        Add Patient
                    </a>
                </div>
            </div>

            <!-- Search and Controls -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <div class="flex justify-between items-center gap-4">
                    <div class="flex-1">
                        <div class="ui icon input w-full">
                            <input type="text" id="searchInput" placeholder="Search patients by name, ID, or email..."
                                class="w-full" tabindex="0" aria-label="Search patients">
                            <i class="search icon"></i>
                        </div>
                    </div>
                    <div class="ui buttons">
                        <button class="ui icon button active" id="gridView" tabindex="0" aria-label="Grid View">
                            <i class="th icon"></i>
                        </button>
                        <button class="ui icon button" id="listView" tabindex="0" aria-label="List View">
                            <i class="list icon"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Patient Grid -->
            <div id="patientGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if (empty($patients)): ?>
                    <div class="col-span-full">
                        <div class="ui placeholder segment">
                            <div class="ui icon header">
                                <i class="users icon"></i>
                                No patients found
                            </div>
                            <div class="inline">
                                <a href="<?= app('patients/register') ?>" class="ui primary button">Add First Patient</a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($patients as $patient): ?>
                        <div class="patient-card bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow p-6"
                            data-name="<?= strtolower($patient['name']) ?>"
                            data-id="<?= strtolower($patient['patient_number']) ?>"
                            data-email="<?= strtolower($patient['email']) ?>">
                            <!-- Patient Header -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 m-0"><?= htmlspecialchars($patient['name']) ?></h3>
                                        <p class="text-sm text-gray-500 m-0">ID:
                                            <?= htmlspecialchars($patient['patient_number']) ?>
                                        </p>
                                    </div>
                                </div>
                                <span class="ui <?= $patient['status'] === 'new' ? 'orange' : 'green' ?> label">
                                    <?= ucfirst($patient['status']) ?>
                                </span>
                            </div>

                            <!-- Patient Info -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="birthday cake icon"></i>
                                    <span><?= htmlspecialchars($patient['age']) ?></span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="envelope icon"></i>
                                    <span class="truncate"><?= htmlspecialchars($patient['email']) ?></span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="phone icon"></i>
                                    <span><?= htmlspecialchars($patient['phone']) ?></span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="user md icon"></i>
                                    <span><?= htmlspecialchars($patient['doctor']) ?></span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <a href="<?= app('patients/timeline') ?>?id=<?= urlencode($patient['patient_number']) ?>"
                                    class="ui primary fluid button" tabindex="0" aria-label="View patient timeline">
                                    <i class="eye icon"></i>
                                    View Timeline
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Patient List (Hidden by default) -->
            <div id="patientList" class="hidden">
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <table class="ui celled table">
                        <thead>
                            <tr>
                                <th>Patient ID</th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Contact</th>
                                <th>Doctor</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($patients as $patient): ?>
                                <tr class="patient-row" data-name="<?= strtolower($patient['name']) ?>"
                                    data-id="<?= strtolower($patient['patient_number']) ?>"
                                    data-email="<?= strtolower($patient['email']) ?>">
                                    <td><?= htmlspecialchars($patient['patient_number']) ?></td>
                                    <td>
                                        <h4 class="ui header m-0">
                                            <div class="content">
                                                <?= htmlspecialchars($patient['name']) ?>
                                                <div class="sub header"><?= htmlspecialchars($patient['email']) ?></div>
                                            </div>
                                        </h4>
                                    </td>
                                    <td><?= htmlspecialchars($patient['age']) ?></td>
                                    <td><?= htmlspecialchars($patient['phone']) ?></td>
                                    <td><?= htmlspecialchars($patient['doctor']) ?></td>
                                    <td>
                                        <span class="ui <?= $patient['status'] === 'new' ? 'orange' : 'green' ?> label">
                                            <?= ucfirst($patient['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= app('patients/timeline') ?>?id=<?= urlencode($patient['patient_number']) ?>"
                                            class="ui primary button" tabindex="0">
                                            <i class="eye icon"></i>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        $(document).ready(function () {
            // Search functionality
            $('#searchInput').on('keyup', function () {
                const searchTerm = $(this).val().toLowerCase();

                $('.patient-card, .patient-row').each(function () {
                    const name = $(this).data('name');
                    const id = $(this).data('id');
                    const email = $(this).data('email');

                    if (name.includes(searchTerm) || id.includes(searchTerm) || email.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // View toggle
            $('#gridView').on('click', function () {
                $(this).addClass('active');
                $('#listView').removeClass('active');
                $('#patientGrid').removeClass('hidden');
                $('#patientList').addClass('hidden');
            });

            $('#listView').on('click', function () {
                $(this).addClass('active');
                $('#gridView').removeClass('active');
                $('#patientList').removeClass('hidden');
                $('#patientGrid').addClass('hidden');
            });
        });
    </script>
</body>

</html>