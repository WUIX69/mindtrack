<?php
// Tiyakin ang tamang Time Zone (palitan kung iba ang locale)
date_default_timezone_set('Asia/Manila');

// Database Connection
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    // IMPORTANT: Palitan ang "localhost", "root", "", "mindtrack" kung iba ang credentials ninyo.
    $conn = new mysqli("localhost", "root", "", "mindtrack");
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    // Ang error na ito ay nagpapakita na ang 'mindtrack' database ay hindi konektado o wala.
    exit("Database connection failed. Please check your configuration. Error: " . $e->getMessage());
}

// --- 1. HANDLE DATE FILTERING LOGIC ---
$today_date = date('Y-m-d');

// Kukunin ang petsa mula sa URL (selected_date) o gagamitin ang today's date
$filter_date = isset($_GET['selected_date']) && !empty($_GET['selected_date']) 
    ? date('Y-m-d', strtotime($_GET['selected_date'])) 
    : $today_date;

// Para sa Header Title
$day_name = date('l', strtotime($filter_date));
$date_display = date('F j, Y', strtotime($filter_date));

if ($filter_date == $today_date) {
    $main_title = "Today's Appointments";
    $main_subtitle = "Scheduled patient visits for " . date('F j, Y', strtotime($filter_date));
} else {
    // Title kapag nag-click ng date sa Calendar
    $main_title = "Appointments on " . $day_name . ", " . $date_display;
    $main_subtitle = "Viewing scheduled patient visits for a specific date.";
}


// --- 2. FETCH SCHEDULED APPOINTMENTS ---
$appointments = [];
// Kinukuha lang ang appointments base sa $filter_date
$sql_appointments = "
    SELECT 
        a.appointment_id, 
        a.appointment_date, 
        a.appointment_time, 
        a.service_type, 
        a.status, 
        a.remarks,
        b.birthdate AS patient_id_dob,
        b.booking_id
    FROM 
        appointment a
    JOIN 
        booking_request b ON a.booking_id = b.booking_id
    WHERE 
        a.appointment_date = ? 
    ORDER BY 
        a.appointment_time ASC";

$stmt_appt = $conn->prepare($sql_appointments);
$stmt_appt->bind_param("s", $filter_date);
$stmt_appt->execute();
$result_appointments = $stmt_appt->get_result();
if ($result_appointments->num_rows > 0) {
    while ($row = $result_appointments->fetch_assoc()) {
        $appointments[] = $row;
    }
}
$stmt_appt->close();


// --- 3. FETCH PENDING REQUESTS ---
$requests = [];
// CRITICAL: Kinukuha lang ang may status na 'Pending' (Ito ang nagtatanggal sa na-approve na request)
$sql_requests = "SELECT booking_id, birthdate AS patient_id_dob, service_type, booking_date, booking_time, status 
                FROM booking_request 
                WHERE status = 'Pending' 
                ORDER BY booking_date ASC, created_at DESC";

$result_requests = $conn->query($sql_requests);
if ($result_requests->num_rows > 0) {
    while ($row = $result_requests->fetch_assoc()) {
        $requests[] = $row;
    }
}
$pending_count = count($requests); 

$conn->close();

// Determine initial view and handle messages
$initial_view = (isset($_GET['view']) && $_GET['view'] == 'requests') ? 'requests' : 'scheduled';
$today_display_date = date('l, F j, Y'); 

$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
$status = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Appointments - MindTrack Health Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* CSS Variables */
        :root {
            --color-primary-dark: #0077b6; --color-deep-blue: #00A9FF; --color-medium-blue: #89CFF3; --color-light-blue: #A0E9FF;
            --color-very-light-blue: #E0F7FF; --color-text-dark: #333; --color-text-medium: #666; --color-bg-light: #F0F8FF;
            --color-pending: #ffc107; --color-pending-bg: #fff8e1; --color-scheduled: #0077b6; --color-scheduled-bg: #E0F7FF;
            --color-completed: #28a745; --color-completed-bg: #e9f5ea; --color-cancelled: #dc3545; --color-cancelled-bg: #fbebed;
            --color-past-due: #dc3545; --color-past-due-bg: #fbebed;
            --color-success: #28a745;
            --color-error: #dc3545;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #d3e5ff, #e6f6ff); color: var(--color-text-dark); }
        .main-container { display: flex; height: 100vh; overflow: hidden; }
        
        /* Sidebar Styles */
        .sidebar { width: 280px; background: linear-gradient(to top, #d3e5ff, #e6f6ff); box-shadow: 2px 0 10px rgba(0,0,0,0.05); display: flex; flex-direction: column; padding: 30px 0; flex-shrink: 0; }
        .logo-section { display: flex; align-items: center; padding: 0 30px 40px; gap: 10px; }
        .logo-section i { font-size: 28px; color: var(--color-primary-dark); }
        .logo-text h2 { font-size: 18px; font-weight: 600; color: var(--color-primary-dark); line-height: 1; }
        .logo-text p { font-size: 10px; color: var(--color-medium-blue); font-weight: 300; }
        .nav-menu { flex-grow: 1; padding: 0 20px; }
        .nav-item { display: flex; align-items: center; text-decoration: none; color: var(--color-text-medium); font-size: 15px; margin-bottom: 8px; padding: 12px 15px; border-radius: 8px; transition: all 0.2s ease; font-weight: 500; }
        .nav-item:hover:not(.active) { background-color: var(--color-very-light-blue); color: var(--color-primary-dark); }
        .nav-item.active { background-color: white; color: var(--color-primary-dark); font-weight: 600; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .nav-item i { margin-right: 15px; font-size: 18px; color: var(--color-medium-blue); }
        .nav-item.active i { color: var(--color-primary-dark); }
        
        /* Main Content and Header Styles */
        .main-content-area { flex-grow: 1; padding: 30px; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; background: white; border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header h1 { font-size: 20px; color: var(--color-primary-dark); font-weight: 600; }
        .header p { font-size: 14px; color: var(--color-text-medium); margin-top: 5px; }
        .header-date { font-size: 14px; color: var(--color-text-medium); display: flex; align-items: center; gap: 8px; }
        .content-section { background-color: white; padding: 25px; border-radius: 10px; box-shadow: 0 3px 8px rgba(0,0,0,0.05); border: 1px solid var(--color-very-light-blue); }
        .table-controls { display: flex; justify-content: flex-start; align-items: center; margin-bottom: 20px; gap: 15px; }
        
        /* View Switcher Tabs */
        .view-switcher { display: flex; border-radius: 8px; background-color: var(--color-bg-light); padding: 5px; gap: 5px; }
        .view-switcher a { text-decoration: none; color: var(--color-text-medium); padding: 8px 15px; border-radius: 6px; font-size: 14px; font-weight: 500; transition: all 0.2s; cursor: pointer; }
        .view-switcher a.active-view { background-color: white; color: var(--color-primary-dark); font-weight: 600; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .view-switcher a:hover:not(.active-view) { color: var(--color-primary-dark); }
        .view-switcher a i { margin-right: 5px; }
        
        /* Date Filter */
        .date-filter-container { display: flex; align-items: center; margin-left: auto; }
        .date-filter-container label { font-size: 14px; color: var(--color-text-medium); margin-right: 8px; }
        .date-filter-container input[type="date"] {
            padding: 8px 10px; border: 1px solid var(--color-light-blue); border-radius: 6px; font-family: 'Poppins', sans-serif;
            font-size: 14px; color: var(--color-text-dark); background-color: white; transition: border-color 0.2s;
        }
        .date-filter-container input[type="date"]:focus { outline: none; border-color: var(--color-deep-blue); box-shadow: 0 0 0 2px var(--color-very-light-blue); }

        /* Table Styles */
        .appointments-table, .requests-table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
        .appointments-table thead th, .requests-table thead th { text-align: left; padding: 10px 15px; color: var(--color-text-medium); font-size: 13px; font-weight: 600; text-transform: uppercase; }
        .appointments-table tbody td, .requests-table tbody td { background-color: var(--color-bg-light); padding: 15px; font-size: 14px; font-weight: 500; color: var(--color-text-dark); vertical-align: middle; border: 1px solid var(--color-very-light-blue); border-width: 1px 0; }
        .appointments-table tbody tr td:first-child, .requests-table tbody tr td:first-child { border-top-left-radius: 8px; border-bottom-left-radius: 8px; border-left-width: 1px; }
        .appointments-table tbody tr td:last-child, .requests-table tbody tr td:last-child { border-top-right-radius: 8px; border-bottom-right-radius: 8px; border-right-width: 1px; }
        .appointments-table tbody tr:hover td, .requests-table tbody tr:not(.past-due):hover td { background-color: var(--color-very-light-blue); }
        
        /* Specific Request Table Styles */
        .requests-table tbody tr.past-due td { background-color: var(--color-past-due-bg); color: var(--color-past-due); font-style: italic; opacity: 0.7; }
        .datetime-cell { display: flex; flex-direction: column; gap: 4px; }

        /* Status Badges */
        .status-badge { display: inline-block; padding: 5px 12px; border-radius: 15px; font-size: 12px; font-weight: 600; }
        .status-Scheduled { background-color: var(--color-scheduled-bg); color: var(--color-scheduled); }
        .status-Completed { background-color: var(--color-completed-bg); color: var(--color-completed); }
        .status-Cancelled { background-color: var(--color-cancelled-bg); color: var(--color-cancelled); }
        .status-Pending { background-color: var(--color-pending-bg); color: var(--color-pending); }

        /* Action Buttons */
        .actions-cell { display: flex; gap: 5px; }
        .action-icon { background: white; border: 1px solid var(--color-very-light-blue); color: var(--color-text-medium); width: 30px; height: 30px; border-radius: 5px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; text-decoration: none; }
        .action-icon.approve:hover { background-color: #e9f5ea; color: #28a745; }
        .action-icon.decline:hover { background-color: #fbebed; color: #dc3545; }
        .action-icon.complete:hover { background-color: var(--color-completed-bg); color: var(--color-completed); }
        .action-icon.disabled { opacity: 0.5; pointer-events: none; cursor: default; }
        .patient-id-display { text-decoration: none; color: var(--color-primary-dark); font-weight: 600; }
        
        /* Alert Messages */
        .alert-message { padding: 15px; margin-bottom: 20px; border-radius: 8px; font-weight: 500; display: flex; align-items: center; gap: 10px; }
        .alert-success { background-color: #e6f6e6; color: var(--color-success); border: 1px solid var(--color-success); }
        .alert-error { background-color: #fcecec; color: var(--color-error); border: 1px solid var(--color-error); }
    </style>
</head>
<body>
<div class="main-container">
    <div class="sidebar">
        <div class="logo-section"><i class="fas fa-heartbeat"></i><div class="logo-text"><h2>MindTrack</h2><p>Health Management</p></div></div>
        <nav class="nav-menu">
            <a class="nav-item" href="mindtrack.php"><i class="fas fa-th-large"></i>Dashboard</a>
            <a class="nav-item active" href="appointment.php"><i class="far fa-calendar-alt"></i>Appointments</a>
            <a class="nav-item" href="cl.php"><i class="far fa-calendar-check"></i>Calendar</a>
            <a class="nav-item" href="pt.php"><i class="fas fa-users"></i>Patients</a>
            <a class="nav-item" href="doctors.php"><i class="fas fa-user-md"></i>Doctors</a>
            <a class="nav-item" href="set.php"><i class="fas fa-cog"></i>Settings</a>
        </nav>
        <div class="user-info" style="padding: 20px 30px; border-top: 1px solid rgba(0,0,0,0.05); display: flex; align-items: center;">
            <div class="user-avatar" style="width: 36px; height: 36px; border-radius: 50%; background-color: var(--color-light-blue); color: var(--color-primary-dark); display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 14px; margin-right: 10px;">A</div>
            <div class="user-details">
                <strong style="font-size: 14px;">Admin User</strong>
                <span style="font-size: 11px; color: var(--color-text-medium);">admin@mindtrack.com</span>
            </div>
        </div>
    </div>
    <div class="main-content-area">
        <div class="header">
            <div>
                <h1 id="main-header-title"><?= $main_title ?></h1>
                <p id="main-header-subtitle"><?= $main_subtitle ?></p>
            </div>
            <div class="header-date"><span><?= $today_display_date ?></span></div>
        </div>
        
        <?php if (!empty($message)): ?>
            <div class="alert-message alert-<?= $status ?>">
                <i class="fas fa-<?= $status == 'success' ? 'check-circle' : 'exclamation-triangle' ?>"></i>
                <?= $message ?>
            </div>
        <?php endif; ?>

        <div class="content-section">
            <div class="table-controls">
                <div class="view-switcher">
                    <a id="show-scheduled-btn" class="view-btn" data-view="scheduled" href="?selected_date=<?= htmlspecialchars($filter_date) ?>&view=scheduled">
                        <i class="far fa-calendar-check"></i> View Appointments
                    </a>
                    <a id="show-requests-btn" class="view-btn" data-view="requests" href="?view=requests">
                        <i class="fas fa-inbox"></i> Booking Requests 
                        <?php if ($pending_count > 0): ?>
                            <span id="pending-count-badge" style="background:var(--color-pending); color:white; padding: 2px 6px; border-radius: 10px; font-size: 11px; margin-left: 5px;"><?= $pending_count ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                
                <form id="date-filter-form" class="date-filter-container" method="GET" style="<?= $initial_view == 'requests' ? 'display:none;' : '' ?>">
                    <label for="selected_date" style="font-weight: 600;">Filter Date:</label>
                    <input type="date" id="selected_date" name="selected_date" value="<?= htmlspecialchars($filter_date) ?>" onchange="document.getElementById('date-filter-form').submit()">
                    <input type="hidden" name="view" value="scheduled">
                </form>

            </div>

            <div id="scheduled-section">
                <table class="appointments-table">
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Time</th>
                            <th>Service Type</th>
                            <th>Doctor</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($appointments)): ?>
                            <tr><td colspan="7" style="text-align:center; color: var(--color-text-medium); padding: 20px;">No appointments scheduled for <?= date('F j, Y', strtotime($filter_date)) ?>.</td></tr>
                        <?php else: ?>
                            <?php foreach ($appointments as $appt): 
                                // Gumagamit ng birthdate (MMDDYY) bilang Patient ID
                                $patient_id_mmddyy = date('mdy', strtotime($appt['patient_id_dob']));
                                $is_past = strtotime($appt['appointment_date']) < strtotime($today_date);
                                $is_completed = $appt['status'] == 'Completed';
                            ?>
                            <tr>
                                <td>
                                    <span class="patient-id-display">
                                        <?= htmlspecialchars($patient_id_mmddyy) ?>
                                    </span>
                                </td>
                                <td><i class="far fa-clock"></i> <?= date('h:i A', strtotime($appt['appointment_time'])) ?></td>
                                <td><?= htmlspecialchars($appt['service_type']) ?></td>
                                <td><span style="color: #999;">Not Assigned</span></td>
                                <td><span class="status-badge status-<?= htmlspecialchars($appt['status']) ?>"><?= htmlspecialchars($appt['status']) ?></span></td>
                                <td><?= htmlspecialchars($appt['remarks']) ?></td>
                                <td class="actions-cell">
                                    <?php 
                                    $complete_disabled = ($is_completed || $is_past) ? 'disabled' : ''; 
                                    $complete_title = $is_completed ? 'Already Completed' : ($is_past ? 'Past Appointment' : 'Mark as Completed');
                                    ?>
                                    <a href="update_status.php?id=<?= $appt['appointment_id'] ?>&action=complete" class="action-icon complete <?= $complete_disabled ?>" title="<?= $complete_title ?>"><i class="fas fa-check-circle"></i></a>
                                    
                                    <a href="update_status.php?id=<?= $appt['appointment_id'] ?>&action=cancel" class="action-icon decline" title="Cancel Appointment"><i class="fas fa-times"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div id="requests-section" style="display: none;">
                <table class="requests-table">
                    <thead>
                        <tr>
                            <th>Patient ID</th>
                            <th>Requested Date & Time</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($requests)): ?>
                            <tr><td colspan="4" style="text-align:center; color: var(--color-text-medium); padding: 20px;">No new booking requests.</td></tr>
                        <?php else: ?>
                            <?php 
                                $today_date_ts = strtotime($today_date);
                                foreach ($requests as $req): 
                                $is_past_due = (strtotime($req['booking_date']) < $today_date_ts);
                                $row_class = $is_past_due ? 'past-due' : '';
                                $approve_class = $is_past_due ? 'disabled' : '';
                                $approve_title = $is_past_due ? 'Cannot approve: date has passed' : 'Approve Request (Create Appointment)';

                                $request_patient_id_mmddyy = date('mdy', strtotime($req['patient_id_dob']));
                            ?>
                            <tr class="<?= $row_class ?>">
                                <td>
                                    <span class="patient-id-display">
                                        <?= htmlspecialchars($request_patient_id_mmddyy) ?>
                                    </span>
                                </td>
                                <td class="datetime-cell">
                                    <span><i class="far fa-calendar-alt"></i> <?= date('M d, Y', strtotime($req['booking_date'])) ?></span>
                                    <span><i class="far fa-clock"></i> <?= date('h:i A', strtotime($req['booking_time'])) ?></span>
                                    <?php if($is_past_due): ?>
                                        <span style="color:var(--color-past-due); font-weight:600; font-size:12px;">(Past Due)</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($req['service_type']) ?></td>
                                <td class="actions-cell">
                                    <a href="process_request.php?id=<?= $req['booking_id'] ?>&action=approve" class="action-icon approve <?= $approve_class ?>" title="<?= $approve_title ?>"><i class="fas fa-check"></i></a>
                                    
                                    <a href="process_request.php?id=<?= $req['booking_id'] ?>&action=decline" class="action-icon decline" title="Decline Request (Cancel)"><i class="fas fa-times"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const scheduledSection = document.getElementById('scheduled-section');
        const requestsSection = document.getElementById('requests-section');
        const showScheduledBtn = document.getElementById('show-scheduled-btn');
        const showRequestsBtn = document.getElementById('show-requests-btn');
        const headerTitle = document.getElementById('main-header-title');
        const headerSubtitle = document.getElementById('main-header-subtitle');
        const dateFilterForm = document.getElementById('date-filter-form');
        
        // PHP variables used in JS for initial state
        const initialView = '<?= $initial_view ?>';
        const defaultTitleText = "<?= $main_title ?>";
        const defaultSubtitleText = "<?= $main_subtitle ?>";
        const requestsTitleText = "New Booking Requests";
        const requestsSubtitleText = "Review and approve new patient appointment requests.";

        function switchView(view) {
            // Update Active Class
            showScheduledBtn.classList.remove('active-view');
            showRequestsBtn.classList.remove('active-view');
            
            // Toggle Sections and Update Header
            if (view === 'requests') {
                showRequestsBtn.classList.add('active-view');
                requestsSection.style.display = 'block';
                scheduledSection.style.display = 'none';
                dateFilterForm.style.display = 'none'; // Hide date filter
                headerTitle.textContent = requestsTitleText;
                headerSubtitle.textContent = requestsSubtitleText;
            } else {
                showScheduledBtn.classList.add('active-view');
                scheduledSection.style.display = 'block';
                requestsSection.style.display = 'none';
                dateFilterForm.style.display = 'flex'; // Show date filter
                headerTitle.textContent = defaultTitleText;
                headerSubtitle.textContent = defaultSubtitleText;
            }
        }
        
        // Initial setup based on URL parameter or default
        switchView(initialView);

        // Optional: Add event listeners for dynamic switching without page reload
        // Note: For simplicity and to maintain clean URL filtering, the current links are used instead of pure JS listeners.
    });
</script>
</body>
</html>