<?php
// update_status.php - (FINAL FIX: Handles Booking Request Status: Approve/Decline ONLY)
// Gamit ang transactions at mas pinahusay na error checking.

date_default_timezone_set('Asia/Manila');

// 1. Database Connection
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    // IMPORTANT: Palitan ang "localhost", "root", "", "mindtrack" kung iba ang credentials ninyo.
    $conn = new mysqli("localhost", "root", "", "mindtrack");
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    $error_message = "Database connection failed. Check config: " . $e->getMessage(); 
    header("Location: appointment.php?view=requests&status=error&message=" . urlencode($error_message));
    exit();
}

// Kunin at i-sanitize ang input
$booking_id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;
$redirect_url = "appointment.php?view=requests"; // Palaging bumalik sa Requests View

if (!$booking_id || !$action) {
    header("Location: appointment.php?status=error&message=" . urlencode("Invalid parameters for operation."));
    exit();
}

$booking_id = (int)$booking_id;
    
// Simulan ang transaction
$conn->begin_transaction();

try {
    // 1. Kumuha ng data at I-CHECK ang status
    $stmt_select = $conn->prepare("SELECT booking_id, service_type, booking_date, booking_time, status FROM booking_request WHERE booking_id = ?");
    $stmt_select->bind_param("i", $booking_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();
    $booking_data = $result->fetch_assoc();
    $stmt_select->close();

    // CRITICAL CHECK: Dapat Pending pa at may data
    if (!$booking_data || $booking_data['status'] !== 'Pending') {
        throw new Exception("Booking request not found or already processed. Current Status: " . ($booking_data['status'] ?? 'N/A'));
    }

    if ($action === 'approve') {
        // --- APPROVE LOGIC ---
        
        // 2. Check Past Due Date 
        $current_date = date('Y-m-d');
        if ($booking_data['booking_date'] < $current_date) {
            throw new Exception("Cannot approve: The requested date (" . date('M d, Y', strtotime($booking_data['booking_date'])) . ") has already passed.");
        }
        
        // 3. I-insert sa appointment table
        $status_appt = 'Scheduled';
        $remarks_for_appointment = 'Approved from booking request'; 
        
        $sql_insert = "INSERT INTO appointment (booking_id, appointment_date, appointment_time, service_type, status, remarks) 
                       VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        
        if (!$stmt_insert) {
             throw new Exception("Error preparing INSERT query: " . $conn->error);
        }
        
        $stmt_insert->bind_param("isssss", 
            $booking_id, 
            $booking_data['booking_date'], 
            $booking_data['booking_time'], 
            $booking_data['service_type'], 
            $status_appt, 
            $remarks_for_appointment
        );
        
        if (!$stmt_insert->execute()) {
            // Ito ang critical point. Kung pumalya ang INSERT, magpapakita ito ng error.
            $insert_error = $stmt_insert->error;
            $stmt_insert->close();
            throw new Exception("SQL INSERT failed into 'appointment' table. Error: " . $insert_error . ". Check table schema/Foreign Keys.");
        }
        $stmt_insert->close();

        // 4. I-update ang status sa booking_request
        $status_req = 'Approved'; 
        $remarks_for_booking_request = 'Approved and scheduled for ' . date('M d, Y', strtotime($booking_data['booking_date']));
        
        $stmt_update = $conn->prepare("UPDATE booking_request SET status = ?, remarks = ? WHERE booking_id = ? AND status = 'Pending'");
        $stmt_update->bind_param("ssi", $status_req, $remarks_for_booking_request, $booking_id);
        
        if (!$stmt_update->execute()) {
             $update_error = $stmt_update->error;
             $stmt_update->close();
             throw new Exception("SQL UPDATE failed on 'booking_request'. Error: " . $update_error);
        }
        $stmt_update->close();

        // COMMIT: Tiyakin na nag-commit ang lahat
        $conn->commit();
        $message = "Appointment Approved successfully! Now scheduled for " . date('M d, Y', strtotime($booking_data['booking_date'])) . ".";
        
        // Success Redirection (Bumalik sa scheduled view para makita ang bagong appointment)
        $redirect_date_url = "appointment.php?selected_date=" . urlencode($booking_data['booking_date']) . "&view=scheduled&status=success&message=" . urlencode($message);
        header("Location: {$redirect_date_url}");
        exit();

    } elseif ($action === 'decline') {
        // --- DECLINE LOGIC ---
        $status = 'Declined';
        $remarks = 'Declined by Admin'; 
        
        $stmt_update = $conn->prepare("UPDATE booking_request SET status = ?, remarks = ? WHERE booking_id = ? AND status = 'Pending'");
        $stmt_update->bind_param("ssi", $status, $remarks, $booking_id);
        
        if (!$stmt_update->execute()) {
             $update_error = $stmt_update->error;
             $stmt_update->close();
             throw new Exception("Error declining request. Error: " . $update_error);
        }
        
        if ($stmt_update->affected_rows === 0) {
            $conn->rollback(); 
            throw new Exception("Error: Request already processed or not found/Pending during Decline.");
        }
        $stmt_update->close();
        
        $conn->commit();
        $message = "Booking request Declined successfully. Booking ID: {$booking_id}";
        header("Location: {$redirect_url}&status=success&message=" . urlencode($message));
        exit();
        
    } else {
        throw new Exception("Invalid action specified.");
    }
    
} catch (Exception $e) {
    // ROLLBACK: I-undo ang lahat kung may error
    $conn->rollback();
    
    // I-capture ang error message at i-display 
    $message = "Operation failed (ROLLBACK): " . $e->getMessage(); 
    
    header("Location: {$redirect_url}&status=error&message=" . urlencode($message));
    exit();
}
// Fallback
header("Location: appointment.php");
exit();
?>