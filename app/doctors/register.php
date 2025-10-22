<?php
require_once __DIR__ . '/../../core/app.php';

date_default_timezone_set('Asia/Manila');

$error_message = '';

/**
 * Generate Unique Doctor ID
 * Format: DR + 5-digit unique number (e.g., DR00123)
 */
function generateUniqueDoctorID()
{
    $unique_suffix = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    return 'DR' . $unique_suffix;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $specialization = trim($_POST['specialization'] ?? '');
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    $status = "Active";

    if (empty($first_name) || empty($last_name) || empty($email) || empty($specialization) || empty($phone)) {
        $error_message = "All required fields (Name, Specialization, Email, and Phone Number) must be filled.";
    } else {
        $max_attempts = 5;
        $attempt = 0;
        $success = false;

        while ($attempt < $max_attempts && !$success) {
            $doctor_custom_id = generateUniqueDoctorID();
            $attempt++;

            try {
                $sql = "INSERT INTO doctors (doctor_custom_id, first_name, last_name, specialization, email, phone, status) 
                        VALUES (:doctor_id, :first_name, :last_name, :specialization, :email, :phone, :status)";

                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    'doctor_id' => $doctor_custom_id,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'specialization' => $specialization,
                    'email' => $email,
                    'phone' => $phone,
                    'status' => $status
                ]);

                $success = true;
                header("Location: " . app('doctors/list') . "?registration=success&id=" . urlencode($doctor_custom_id));
                exit;
            } catch (PDOException $e) {
                if ($e->getCode() != 23000) { // Not a duplicate entry error
                    $error_message = "Registration failed: " . $e->getMessage();
                    break;
                }
                // If it's a duplicate, continue loop to try another ID
            }
        }

        if (!$success && empty($error_message)) {
            $error_message = "Registration failed. Could not generate a unique Doctor ID after {$max_attempts} attempts. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>Register New Doctor - MindTrack</title>
    <?php shared('components/elements/styles'); ?>
</head>

<body
    class="bg-gradient-to-br from-blue-100 via-cyan-50 to-blue-50 min-h-screen flex items-center justify-center py-12">
    <div class="w-full max-w-2xl px-4">
        <!-- Registration Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-10">
            <!-- Header -->
            <div class="flex items-center mb-8 pb-6 border-b-2 border-blue-100">
                <i class="fas fa-user-md text-4xl text-blue-600 mr-4"></i>
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 m-0">Register New Doctor</h2>
                    <p class="text-sm text-gray-500 mt-1 m-0">Complete the form below to add a new doctor</p>
                </div>
            </div>

            <!-- Error Message -->
            <?php if (!empty($error_message)): ?>
                <div class="ui negative message">
                    <i class="close icon"></i>
                    <div class="header">Registration Error</div>
                    <p><?= htmlspecialchars($error_message) ?></p>
                </div>
            <?php endif; ?>

            <!-- Registration Form -->
            <form method="POST" class="ui form" id="doctorRegForm">
                <h4 class="ui dividing header">Doctor Information</h4>

                <div class="two fields">
                    <div class="field required">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" id="first_name" placeholder="Enter first name"
                            value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>" required tabindex="0"
                            aria-label="Doctor First Name">
                    </div>
                    <div class="field required">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" id="last_name" placeholder="Enter last name"
                            value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>" required tabindex="0"
                            aria-label="Doctor Last Name">
                    </div>
                </div>

                <div class="field required">
                    <label for="specialization">Specialization</label>
                    <select name="specialization" id="specialization" class="ui dropdown" required tabindex="0"
                        aria-label="Doctor Specialization">
                        <option value="">Select Specialization</option>
                        <option value="Clinical Psychology" <?= ($_POST['specialization'] ?? '') === 'Clinical Psychology' ? 'selected' : '' ?>>Clinical Psychology</option>
                        <option value="Psychiatry" <?= ($_POST['specialization'] ?? '') === 'Psychiatry' ? 'selected' : '' ?>>Psychiatry</option>
                        <option value="Child Psychology" <?= ($_POST['specialization'] ?? '') === 'Child Psychology' ? 'selected' : '' ?>>Child Psychology</option>
                        <option value="Counseling Psychology" <?= ($_POST['specialization'] ?? '') === 'Counseling Psychology' ? 'selected' : '' ?>>Counseling Psychology</option>
                        <option value="Neuropsychology" <?= ($_POST['specialization'] ?? '') === 'Neuropsychology' ? 'selected' : '' ?>>Neuropsychology</option>
                        <option value="Forensic Psychology" <?= ($_POST['specialization'] ?? '') === 'Forensic Psychology' ? 'selected' : '' ?>>Forensic Psychology</option>
                        <option value="Other" <?= ($_POST['specialization'] ?? '') === 'Other' ? 'selected' : '' ?>>Other
                        </option>
                    </select>
                </div>

                <div class="field required">
                    <label for="email">Email Address</label>
                    <div class="ui left icon input">
                        <i class="envelope icon"></i>
                        <input type="email" name="email" id="email" placeholder="doctor@example.com"
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required tabindex="0"
                            aria-label="Doctor Email">
                    </div>
                </div>

                <div class="field required">
                    <label for="phone">Phone Number</label>
                    <div class="ui left icon input">
                        <i class="phone icon"></i>
                        <input type="tel" name="phone" id="phone" placeholder="+63 XXX XXX XXXX"
                            value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required tabindex="0"
                            aria-label="Doctor Phone Number">
                    </div>
                </div>

                <div class="ui info message">
                    <div class="header">Doctor ID Generation</div>
                    <p>A unique Doctor ID (e.g., DR00123) will be automatically generated upon registration.</p>
                </div>

                <div class="flex gap-4 mt-8">
                    <button type="submit" class="ui primary large button flex-1" tabindex="0"
                        aria-label="Register Doctor">
                        <i class="save icon"></i>
                        Register Doctor
                    </button>
                    <a href="<?= app('doctors/list') ?>" class="ui basic large button" tabindex="0"
                        aria-label="Cancel and go back">
                        <i class="arrow left icon"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Back Link -->
        <div class="text-center mt-6">
            <a href="<?= app('doctors/list') ?>"
                class="text-gray-600 hover:text-gray-800 transition-colors inline-flex items-center gap-2" tabindex="0"
                aria-label="Back to doctor list">
                <i class="arrow left icon"></i>
                Back to Doctor List
            </a>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        $(document).ready(function () {
            // Initialize dropdowns
            $('.ui.dropdown').dropdown();

            // Close messages
            $('.message .close').on('click', function () {
                $(this).closest('.message').transition('fade');
            });

            // Form validation
            $('#doctorRegForm').form({
                fields: {
                    first_name: {
                        identifier: 'first_name',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please enter doctor first name'
                            }
                        ]
                    },
                    last_name: {
                        identifier: 'last_name',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please enter doctor last name'
                            }
                        ]
                    },
                    specialization: {
                        identifier: 'specialization',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please select a specialization'
                            }
                        ]
                    },
                    email: {
                        identifier: 'email',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please enter doctor email'
                            },
                            {
                                type: 'email',
                                prompt: 'Please enter a valid email address'
                            }
                        ]
                    },
                    phone: {
                        identifier: 'phone',
                        rules: [
                            {
                                type: 'empty',
                                prompt: 'Please enter doctor phone number'
                            }
                        ]
                    }
                }
            });
        });
    </script>
</body>

</html>