<?php
require_once __DIR__ . '/../../core/app.php';

date_default_timezone_set('Asia/Manila');

$patient_data = null;
$error_message = '';

$patient_custom_id = isset($_GET['id']) ? trim($_GET['id']) : '';

if (!empty($patient_custom_id)) {
    try {
        $sql = "SELECT * FROM patients WHERE patient_custom_id = :patient_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['patient_id' => $patient_custom_id]);
        $patient_data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($patient_data) {
            $patient_data['patient_number'] = $patient_data['patient_custom_id'];

            $dob = new DateTime($patient_data['birthdate']);
            $today = new DateTime('today');
            $patient_data['age'] = $dob->diff($today)->y;
        } else {
            $error_message = "Patient record with ID {$patient_custom_id} not found.";
        }
    } catch (PDOException $e) {
        $error_message = "Error retrieving patient data: " . $e->getMessage();
        error_log($e->getMessage());
    }
} else {
    $error_message = "Invalid Patient ID specified.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>Patient Timeline - <?= $patient_data ? $patient_data['patient_number'] : 'N/A' ?></title>
    <?php shared('components/elements/styles'); ?>
</head>

<body class="bg-gradient-to-br from-blue-100 via-cyan-50 to-blue-50 min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4">
        <?php if ($error_message): ?>
            <!-- Error State -->
            <div class="bg-white rounded-2xl shadow-2xl p-10 text-center">
                <div class="ui negative message">
                    <div class="header">Error</div>
                    <p><?= htmlspecialchars($error_message) ?></p>
                </div>
                <a href="<?= app('patients/list') ?>" class="ui primary button mt-4">
                    <i class="arrow left icon"></i>
                    Back to Patient List
                </a>
            </div>
        <?php else: ?>
            <!-- Timeline Container -->
            <div class="bg-white rounded-2xl shadow-2xl p-10">
                <!-- Header Section -->
                <div class="flex justify-between items-center pb-6 mb-8 border-b-2 border-blue-100">
                    <div>
                        <h1 class="text-4xl font-bold text-blue-600 m-0">
                            Patient #<?= htmlspecialchars($patient_data['patient_number']) ?>
                        </h1>
                        <p class="text-gray-500 mt-2 m-0">
                            <?= htmlspecialchars($patient_data['first_name'] . ' ' . $patient_data['last_name']) ?>
                        </p>
                    </div>
                    <div>
                        <span
                            class="ui <?= strtolower($patient_data['status']) === 'new' ? 'orange' : 'green' ?> large label">
                            <?= ucfirst($patient_data['status']) ?>
                        </span>
                    </div>
                </div>

                <!-- Patient Info Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Personal Information -->
                    <div class="ui segment">
                        <h3 class="ui header m-0 mb-4">
                            <i class="user icon"></i>
                            <div class="content">Personal Information</div>
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Full Name:</span>
                                <strong
                                    class="text-gray-800"><?= htmlspecialchars($patient_data['first_name'] . ' ' . $patient_data['last_name']) ?></strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Age:</span>
                                <strong class="text-gray-800"><?= htmlspecialchars($patient_data['age']) ?> years</strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Birthdate:</span>
                                <strong
                                    class="text-gray-800"><?= htmlspecialchars(date('F d, Y', strtotime($patient_data['birthdate']))) ?></strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Email:</span>
                                <strong class="text-gray-800"><?= htmlspecialchars($patient_data['email']) ?></strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Contact:</span>
                                <strong class="text-gray-800"><?= htmlspecialchars($patient_data['contact']) ?></strong>
                            </div>
                        </div>
                    </div>

                    <!-- Medical Information -->
                    <div class="ui segment">
                        <h3 class="ui header m-0 mb-4">
                            <i class="heartbeat icon"></i>
                            <div class="content">Medical Information</div>
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Service Type:</span>
                                <strong
                                    class="text-gray-800"><?= htmlspecialchars($patient_data['service_type']) ?></strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Assigned Doctor:</span>
                                <strong class="text-gray-800"><?= htmlspecialchars($patient_data['doctor']) ?></strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Diagnosis:</span>
                                <strong class="text-gray-800"><?= htmlspecialchars($patient_data['diagnosis']) ?></strong>
                            </div>
                            <?php if (!empty($patient_data['emergency_contact'])): ?>
                                <div class="pt-3 border-t">
                                    <span class="text-gray-600">Emergency Contact:</span>
                                    <p class="text-sm text-gray-700 mt-1">
                                        <?= htmlspecialchars($patient_data['emergency_contact']) ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Timeline Section -->
                <div class="ui segment">
                    <h3 class="ui header m-0 mb-6">
                        <i class="history icon"></i>
                        <div class="content">Patient Timeline</div>
                    </h3>

                    <div class="ui feed">
                        <div class="event">
                            <div class="label">
                                <i class="user plus icon"></i>
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <strong>Patient Registered</strong>
                                    <div class="date"><?= date('F d, Y', strtotime($patient_data['birthdate'])) ?></div>
                                </div>
                                <div class="extra text">
                                    New patient registered in the system with ID
                                    <?= htmlspecialchars($patient_data['patient_number']) ?>
                                </div>
                            </div>
                        </div>

                        <div class="event">
                            <div class="label">
                                <i class="clock outline icon"></i>
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <em class="text-gray-500">No additional timeline events</em>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 mt-8 pt-6 border-t">
                    <a href="<?= app('patients/list') ?>" class="ui button" tabindex="0" aria-label="Back to patient list">
                        <i class="arrow left icon"></i>
                        Back to List
                    </a>
                    <button class="ui primary button" tabindex="0" aria-label="Edit patient information">
                        <i class="edit icon"></i>
                        Edit Patient
                    </button>
                    <button class="ui green button" tabindex="0" aria-label="Add appointment">
                        <i class="calendar plus icon"></i>
                        Add Appointment
                    </button>
                    <button class="ui teal button" tabindex="0" aria-label="Add notes">
                        <i class="sticky note icon"></i>
                        Add Notes
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php shared('components/elements/scripts'); ?>
</body>

</html>