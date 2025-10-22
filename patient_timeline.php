<?php
// === DATABASE CONFIGURATION (PALITAN ITO) ===
$DB_SERVER = "localhost";
$DB_USERNAME = "root"; // Palitan ng inyong username
$DB_PASSWORD = "";     // Palitan ng inyong password
$DB_NAME = "mindtrack"; // Palitan ng pangalan ng inyong database

date_default_timezone_set('Asia/Manila');

$patient_data = null;
$error_message = '';

// Kinuha ang ID mula sa URL at sinigurado na string ito
$patient_custom_id = isset($_GET['id']) ? trim($_GET['id']) : '';

if (!empty($patient_custom_id)) {
    // === 1. CONNECT TO DATABASE ===
    $conn = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

    if ($conn->connect_error) {
        $error_message = "Database connection failed: " . $conn->connect_error;
    } else {
        // === 2. USE PREPARED STATEMENT TO FETCH DATA gamit ang patient_custom_id ===
        $sql = "SELECT * FROM patients WHERE patient_custom_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $patient_custom_id); // "s" stands for string
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $patient_data = $result->fetch_assoc();
            
            // Format data for display
            $patient_data['patient_number'] = $patient_data['patient_custom_id']; // Gamitin ang custom ID
            
            $dob = new DateTime($patient_data['birthdate']);
            $today = new DateTime('today');
            $patient_data['age'] = $dob->diff($today)->y;
            
        } else {
            $error_message = "Patient record with ID **{$patient_custom_id}** not found.";
        }
        
        $stmt->close();
    }
    $conn->close();
} else {
    $error_message = "Invalid Patient ID specified. Please go back to the patient list.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Timeline - <?= $patient_data ? $patient_data['patient_number'] : 'N/A' ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary-dark: #0077b6;
            --color-deep-blue: #00A9FF;
            --color-medium-blue: #89CFF3;
            --color-text-dark: #333; 
            --color-text-medium: #666; 
            --color-very-light-blue: #E0F7FF;
            --color-bg-light: #F0F8FF;
            --color-danger-red: #dc3545;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #d3e5ff, #e6f6ff); color: var(--color-text-dark); min-height: 100vh; padding: 30px; }

        .timeline-container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid var(--color-very-light-blue);
            padding-bottom: 15px;
        }

        .patient-identifier h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--color-primary-dark);
            line-height: 1.2;
        }
        .patient-identifier p {
            font-size: 14px;
            color: var(--color-text-medium);
            margin-top: 5px;
        }
        
        .patient-avatar-large {
            width: 60px; height: 60px; border-radius: 50%;
            background-color: var(--color-medium-blue);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 20px;
            margin-right: 20px;
        }

        .info-card-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-card {
            background-color: var(--color-bg-light);
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid var(--color-deep-blue);
        }

        .info-card p {
            font-size: 12px;
            color: var(--color-text-medium);
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .info-card strong {
            display: block;
            font-size: 15px;
            font-weight: 600;
            color: var(--color-text-dark);
        }

        .details-section h3 {
            font-size: 18px;
            color: var(--color-primary-dark);
            border-bottom: 1px solid var(--color-very-light-blue);
            padding-bottom: 10px;
            margin-bottom: 15px;
            margin-top: 20px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dotted #eee;
            font-size: 14px;
        }

        .detail-label {
            font-weight: 500;
            color: var(--color-text-medium);
        }

        .detail-value {
            font-weight: 600;
            color: var(--color-text-dark);
        }

        .btn-back {
            text-decoration: none;
            color: var(--color-primary-dark);
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .error-container {
            text-align: center;
            padding: 50px;
            font-size: 18px;
            color: var(--color-danger-red);
        }
    </style>
</head>
<body>
<a href="pt.php" class="btn-back"><i class="fas fa-arrow-left"></i> Back to Patient List</a>

<div class="timeline-container">
    <?php if ($patient_data): ?>
    
    <div class="header-section">
        <div style="display: flex; align-items: center;">
            <div class="patient-avatar-large" title="<?= htmlspecialchars($patient_data['first_name'] . ' ' . $patient_data['last_name']) ?>">
                <i class="fas fa-user"></i>
            </div>
            <div class="patient-identifier">
                <h1><?= htmlspecialchars($patient_data['first_name'] . ' ' . $patient_data['last_name']) ?></h1>
                <p>Patient Number: **<?= htmlspecialchars($patient_data['patient_number']) ?>**</p>
            </div>
        </div>
    </div>

    <div class="info-card-grid">
        <div class="info-card">
            <p>Patient Number</p>
            <strong><?= htmlspecialchars($patient_data['patient_number']) ?></strong>
        </div>
        <div class="info-card">
            <p>Assigned Doctor</p>
            <strong><?= htmlspecialchars($patient_data['doctor']) ?></strong>
        </div>
        <div class="info-card">
            <p>Service</p>
            <strong><?= htmlspecialchars($patient_data['service_type']) ?></strong>
        </div>
        <div class="info-card">
            <p>Primary Problem</p>
            <strong><?= htmlspecialchars($patient_data['diagnosis']) ?></strong>
        </div>
    </div>

    <div class="details-section">
        <h3>Registration Details</h3>
        <div class="detail-row">
            <span class="detail-label">Full Name</span>
            <span class="detail-value"><?= htmlspecialchars($patient_data['first_name'] . ' ' . $patient_data['last_name']) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Age</span>
            <span class="detail-value"><?= $patient_data['age'] ?> years old</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Birthdate</span>
            <span class="detail-value"><?= date('F j, Y', strtotime($patient_data['birthdate'])) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Email Address</span>
            <span class="detail-value"><?= htmlspecialchars($patient_data['email']) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Contact Number</span>
            <span class="detail-value"><?= htmlspecialchars($patient_data['contact']) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Emergency Contact</span>
            <span class="detail-value"><?= htmlspecialchars($patient_data['emergency_contact']) ?: 'N/A' ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Date Registered</span>
            <span class="detail-value"><?= date('M j, Y g:i A', strtotime($patient_data['date_submitted'])) ?></span>
        </div>
    </div>

    <?php else: ?>
        <div class="error-container">
            <i class="fas fa-exclamation-triangle" style="margin-right: 10px;"></i> <?= $error_message ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>