<?php
require_once __DIR__ . '/../../core/app.php';

$patientId = $_GET['id'] ?? '';

if (!empty($patientId)) {
    try {
        // Check if patient exists in patients table
        $stmt = $conn->prepare("SELECT * FROM patients WHERE patient_custom_id = :patient_id");
        $stmt->execute(['patient_id' => $patientId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            // Patient registered → go to timeline
            header("Location: " . app("patients/timeline") . "?id=" . urlencode($patientId));
            exit;
        } else {
            // Not registered → redirect to registration
            header("Location: " . app("patients/register") . "?id=" . urlencode($patientId));
            exit;
        }
    } catch (PDOException $e) {
        error_log("Error checking patient: " . $e->getMessage());
        header("Location: " . app("patients/list"));
        exit;
    }
} else {
    // Invalid ID
    header("Location: " . app("patients/list"));
    exit;
}

