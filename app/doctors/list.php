<?php
require_once __DIR__ . '/../../core/app.php';

// Fetch doctors from database or use dummy data
$doctors = [];

try {
    // Try to fetch from database first
    $sql = "SELECT * FROM doctors ORDER BY id DESC";
    $stmt = $conn->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($results)) {
        foreach ($results as $doc) {
            $doctors[] = [
                'id' => $doc['doctor_custom_id'] ?? $doc['id'],
                'name' => 'Dr. ' . $doc['first_name'] . ' ' . $doc['last_name'],
                'specialization' => $doc['specialization'],
                'status' => strtolower($doc['status'] ?? 'active'),
                'email' => $doc['email'],
                'phone' => $doc['phone'],
                'patients' => 0, // To be calculated from appointments
                'availability' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri']
            ];
        }
    } else {
        // Fallback to dummy data if no doctors in database
        $doctors = [
            [
                'id' => 'DR001',
                'name' => 'Dr. Amanda Foster',
                'specialization' => 'Clinical Psychology',
                'status' => 'active',
                'email' => 'amanda.foster@mindtrack.com',
                'phone' => '(555) 111-2222',
                'patients' => 2,
                'availability' => ['Mon', 'Tue', 'Wed', 'Fri']
            ],
            [
                'id' => 'DR002',
                'name' => 'Dr. James Martinez',
                'specialization' => 'Psychiatry',
                'status' => 'active',
                'email' => 'james.martinez@mindtrack.com',
                'phone' => '(555) 222-3333',
                'patients' => 1,
                'availability' => ['Tue', 'Wed', 'Thu']
            ],
            [
                'id' => 'DR003',
                'name' => 'Dr. Lisa Kim',
                'specialization' => 'Child Psychology',
                'status' => 'active',
                'email' => 'lisa.kim@mindtrack.com',
                'phone' => '(555) 333-4444',
                'patients' => 0,
                'availability' => ['Mon', 'Wed', 'Thu', 'Fri']
            ]
        ];
    }
} catch (PDOException $e) {
    error_log("Error fetching doctors: " . $e->getMessage());
    // Use dummy data as fallback
    $doctors = [
        [
            'id' => 'DR001',
            'name' => 'Dr. Amanda Foster',
            'specialization' => 'Clinical Psychology',
            'status' => 'active',
            'email' => 'amanda.foster@mindtrack.com',
            'phone' => '(555) 111-2222',
            'patients' => 2,
            'availability' => ['Mon', 'Tue', 'Wed', 'Fri']
        ]
    ];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>Doctors - MindTrack</title>
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
                        <h1 class="text-3xl font-bold text-gray-800 m-0">Doctors</h1>
                        <p class="text-gray-500 mt-2">Manage and view all registered doctors</p>
                    </div>
                    <a href="<?= app('doctors/register') ?>" class="ui primary large button" tabindex="0"
                        aria-label="Add New Doctor">
                        <i class="plus icon"></i>
                        Add Doctor
                    </a>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                <div class="ui icon input w-full">
                    <input type="text" id="searchInput"
                        placeholder="Search doctors by name, specialization, or email..." class="w-full" tabindex="0"
                        aria-label="Search doctors">
                    <i class="search icon"></i>
                </div>
            </div>

            <!-- Doctors Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if (empty($doctors)): ?>
                    <div class="col-span-full">
                        <div class="ui placeholder segment">
                            <div class="ui icon header">
                                <i class="user md icon"></i>
                                No doctors found
                            </div>
                            <div class="inline">
                                <a href="<?= app('doctors/register') ?>" class="ui primary button">Add First Doctor</a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($doctors as $doctor): ?>
                        <div class="doctor-card bg-white rounded-xl shadow-md hover:shadow-xl transition-shadow p-6"
                            data-name="<?= strtolower($doctor['name']) ?>"
                            data-specialization="<?= strtolower($doctor['specialization']) ?>"
                            data-email="<?= strtolower($doctor['email']) ?>">
                            <!-- Doctor Header -->
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-14 h-14 bg-gradient-to-br from-blue-400 to-cyan-400 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-md text-white text-2xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 m-0"><?= htmlspecialchars($doctor['name']) ?></h3>
                                        <p class="text-sm text-gray-500 m-0"><?= htmlspecialchars($doctor['specialization']) ?>
                                        </p>
                                    </div>
                                </div>
                                <span class="ui green label">
                                    <?= ucfirst($doctor['status']) ?>
                                </span>
                            </div>

                            <!-- Doctor Info -->
                            <div class="space-y-3 mb-4 pb-4 border-b border-gray-100">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="envelope icon"></i>
                                    <span class="truncate"><?= htmlspecialchars($doctor['email']) ?></span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="phone icon"></i>
                                    <span><?= htmlspecialchars($doctor['phone']) ?></span>
                                </div>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="users icon"></i>
                                    <span><?= $doctor['patients'] ?> Active Patients</span>
                                </div>
                            </div>

                            <!-- Availability -->
                            <div class="mb-4">
                                <p class="text-xs text-gray-500 mb-2">Availability:</p>
                                <div class="flex flex-wrap gap-1">
                                    <?php foreach ($doctor['availability'] as $day): ?>
                                        <span class="ui tiny blue label"><?= $day ?></span>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <button class="ui primary fluid button" tabindex="0" aria-label="View doctor details">
                                    <i class="eye icon"></i>
                                    View Profile
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        $(document).ready(function () {
            // Search functionality
            $('#searchInput').on('keyup', function () {
                const searchTerm = $(this).val().toLowerCase();

                $('.doctor-card').each(function () {
                    const name = $(this).data('name');
                    const specialization = $(this).data('specialization');
                    const email = $(this).data('email');

                    if (name.includes(searchTerm) || specialization.includes(searchTerm) || email.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
</body>

</html>