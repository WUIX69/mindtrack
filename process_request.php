<?php
// process_request.php - (MODIFIED: Handles Appointment Status: Complete/Cancel ONLY)

date_default_timezone_set('Asia/Manila');

// Database Connection
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli("localhost", "root", "", "mindtrack");
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    // Kung hindi makakonek sa database, bumalik sa appointment.php
    header("Location: appointment.php?status=error&message=" . urlencode("Database connection failed."));
    exit();
}

$id = $_GET['id'] ?? null; // appointment_id
$action = $_GET['action'] ?? null; // 'complete' or 'cancel'
$selected_date = $_GET['selected_date'] ?? date('Y-m-d'); // Current filter date mula sa appointment.php

// Default redirection: Bumalik sa Scheduled View, gamit ang filter date
$redirect_url = "appointment.php?selected_date=" . urlencode($selected_date) . "&view=scheduled"; 

if (!$id || ($action !== 'complete' && $action !== 'cancel')) {
    header("Location: appointment.php?status=error&message=" . urlencode("Invalid parameters for appointment update."));
    exit();
}

$appointment_id = (int)$id;

try {
    $final_status = ($action === 'complete') ? 'Completed' : 'Cancelled';
    
    // Update status sa 'appointment' table, kung ang status ay 'Scheduled' pa.
    // Tinitiyak na ang ina-update lang ay ang Scheduled appointments.
    $sql_update_appointment = "UPDATE appointment SET status = ? WHERE appointment_id = ? AND status = 'Scheduled'";
    $stmt_update_appointment = $conn->prepare($sql_update_appointment);
    
    if (!$stmt_update_appointment) {
        throw new Exception("Error preparing update statement. Error: " . $conn->error);
    }
    
    $stmt_update_appointment->bind_param("si", $final_status, $appointment_id);
    
    if (!$stmt_update_appointment->execute()) {
        throw new Exception("Error executing update. Error: " . $stmt_update_appointment->error);
    }
    
    if ($stmt_update_appointment->affected_rows === 0) {
        // Ang appointment ay hindi Scheduled, o hindi ito nahanap.
        throw new Exception("Appointment not found or status already changed. Only 'Scheduled' appointments can be updated.");
    }
    
    $stmt_update_appointment->close();
    $conn->close();

    $message = "Appointment ID {$appointment_id} successfully marked as {$final_status}.";
    
    // Success Redirection
    header("Location: {$redirect_url}&status=success&message=" . urlencode($message));
    exit();

} catch (Exception $e) {
    if ($conn) $conn->close();
    $message = "Operation failed: " . $e->getMessage(); 
    
    // Error Redirection
    header("Location: {$redirect_url}&status=error&message=" . urlencode($message));
    exit();
}
?>