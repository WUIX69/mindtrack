<?php
// === DATABASE CONFIGURATION (PALITAN ITO) ===
$DB_SERVER = "localhost";
$DB_USERNAME = "root"; // Palitan ng inyong username
$DB_PASSWORD = "";     // Palitan ng inyong password
$DB_NAME = "mindtrack"; // Palitan ng pangalan ng inyong database

// === 1. CONNECT TO DATABASE ===
$conn = new mysqli($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// === 2. FETCH PATIENT DATA (Gumagamit na ng patient_custom_id) ===
$patients = [];
// Kinuha ko na ang patient_custom_id imbes na ang auto_increment 'id'
$sql = "SELECT patient_custom_id, first_name, last_name, birthdate, email, contact, doctor, diagnosis, status FROM patients";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // I-format ang data habang kino-collect
    while ($p = $result->fetch_assoc()) {
        // Ang patient_number ay ang patient_custom_id na
        $p['patient_number'] = $p['patient_custom_id'];
        
        $dob = new DateTime($p['birthdate']);
        $today = new DateTime('today');
        $p['age'] = $dob->diff($today)->y . ' years old';
        
        $p['status'] = strtolower($p['status']);
        $p['name'] = $p['first_name'] . ' ' . $p['last_name'];
        $p['phone'] = $p['contact']; 
        
        $patients[] = $p;
    }
}

$conn->close();

$header_date = date('l, F j, Y', strtotime('October 21, 2025')); 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patients - MindTrack Health Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* CSS... (No changes needed here) */
        :root {
            --color-primary-dark: #0077b6;
            --color-deep-blue: #00A9FF;
            --color-medium-blue: #89CFF3; 
            --color-light-blue: #A0E9FF; 
            --color-very-light-blue: #E0F7FF;
            --color-text-dark: #333; 
            --color-text-medium: #666; 
            --color-bg-light: #F0F8FF;
            --color-status-scheduled: #4CAF50; /* Green for Scheduled/Active */
            --color-status-new: #FFA500; /* Orange for New */
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; font-family: 'Poppins', sans-serif; background: linear-gradient(135deg, #d3e5ff, #e6f6ff); color: var(--color-text-dark); }
        .main-container { display: flex; height: 100vh; overflow: hidden; }

        /* Sidebar, Header, Buttons (Standard) */
        .sidebar { width: 280px; background: linear-gradient(to top, #d3e5ff, #e6f6ff); box-shadow: 2px 0 10px rgba(0,0,0,0.05); display: flex; flex-direction: column; padding: 30px 0; flex-shrink: 0; }
        .logo-section { display: flex; align-items: center; padding: 0 30px 40px; gap: 10px; }
        .logo-section i { font-size: 28px; color: var(--color-primary-dark); }
        .logo-text h2 { font-size: 18px; font-weight: 600; color: var(--color-primary-dark); line-height: 1; }
        .logo-text p { font-size: 10px; color: var(--color-medium-blue); font-weight: 300; }
        .nav-menu { flex-grow: 1; padding: 0 20px; } 
        .nav-item { display: flex; align-items: center; text-decoration: none; color: var(--color-text-medium); font-size: 15px; margin-bottom: 8px; padding: 12px 15px; border-radius: 8px; transition: all 0.2s ease; font-weight: 500; }
        .nav-item:hover:not(.active) { background-color: var(--color-very-light-blue); color: var(--color-primary-dark); }
        .nav-item.active { background-color: white; color: var(--color-primary-dark); font-weight: 600; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-left: none; }
        .nav-item i { margin-right: 15px; font-size: 18px; color: var(--color-medium-blue); }
        .nav-item.active i { color: var(--color-primary-dark); }
        .user-info { padding: 20px 30px; border-top: 1px solid rgba(0,0,0,0.05); display: flex; align-items: center; }
        .user-avatar { width: 36px; height: 36px; border-radius: 50%; background-color: var(--color-light-blue); color: var(--color-primary-dark); display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 14px; margin-right: 10px; }
        .user-details strong { color: var(--color-text-dark); font-size: 14px; }
        .user-details span { font-size: 11px; color: var(--color-text-medium); }
        .main-content-area { flex-grow: 1; padding: 30px; overflow-y: auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .header-title h1 { font-size: 24px; color: var(--color-text-dark); font-weight: 600; } 
        .header-title p { font-size: 14px; color: var(--color-text-medium); margin-top: 5px; } 
        .btn-add-patient { background-color: var(--color-deep-blue); color: white; padding: 10px 15px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: background-color 0.2s; text-decoration: none; display: flex; align-items: center; gap: 8px; box-shadow: 0 4px 8px rgba(0, 169, 255, 0.3); }
        .btn-add-patient:hover { background-color: var(--color-primary-dark); }

        /* Patient Controls (Search, Grid/List) */
        .patient-controls { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .search-box { position: relative; width: 500px; }
        .search-box input { width: 100%; padding: 10px 10px 10px 40px; border: 1px solid var(--color-very-light-blue); border-radius: 8px; font-size: 14px; outline: none; transition: border-color 0.2s; }
        .search-box i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--color-text-medium); font-size: 14px; }
        .view-toggle { display: flex; border: 1px solid var(--color-primary-dark); border-radius: 8px; overflow: hidden; }
        .view-toggle button { padding: 8px 15px; border: none; background-color: white; color: var(--color-primary-dark); font-weight: 600; cursor: pointer; transition: background-color 0.2s; font-size: 14px; }
        .view-toggle button:first-child { border-right: 1px solid var(--color-primary-dark); }
        .view-toggle button.active { background-color: var(--color-primary-dark); color: white; }

        /* Patient Grid & List Styling */
        .patient-list-view { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); 
            gap: 20px; 
            transition: all 0.3s ease;
        }

        .patient-list-view.list-active {
            display: block; /* Para maging stack/list */
        }
        
        /* Grid Card Styling */
        .patient-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.05);
            border: 1px solid var(--color-very-light-blue);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-bottom: 0;
        }
        
        /* List Row Styling */
        .patient-list-view.list-active .patient-card {
            display: grid;
            /* Patient ID, Age, Email, Doctor, Status, Action */
            grid-template-columns: 120px 80px 1fr 150px 100px 100px; 
            align-items: center;
            margin-bottom: 10px;
            padding: 15px 20px;
            gap: 10px;
        }
        
        /* Hide unnecessary details in list view */
        .patient-list-view.list-active .diagnosis-section,
        .patient-list-view.list-active .patient-details-row, /* Hide all detail rows in List view (email, phone, doctor) */
        .patient-list-view.list-active .patient-details, /* Hide the container */
        .patient-list-view.list-active .patient-avatar-box { /* Hide avatar box */
            display: none;
        }
        
        /* Re-show elements needed for list view, but adjust their display */
        .patient-list-view.list-active .patient-header {
            margin-bottom: 0; 
        }
        .patient-list-view.list-active .patient-header > div { 
            display: block; /* Revert flex */
        }
        
        .patient-info h3 { font-size: 16px; font-weight: 600; color: var(--color-primary-dark); line-height: 1.2; }
        .patient-info p { font-size: 12px; color: var(--color-text-medium); margin-top: 2px; }
        .patient-list-view.list-active .patient-info h3 { font-size: 14px; }
        .patient-list-view.list-active .patient-info p { font-size: 11px; }


        .status-badge { display: inline-block; padding: 4px 8px; border-radius: 12px; font-size: 10px; font-weight: 600; text-transform: uppercase; text-align: center; }
        .status-scheduled { background-color: rgba(76, 175, 80, 0.1); color: var(--color-status-scheduled); }
        .status-new { background-color: rgba(255, 165, 0, 0.1); color: var(--color-status-new); }

        .patient-details-row { display: flex; align-items: center; font-size: 13px; color: var(--color-text-dark); margin-bottom: 8px; }
        .patient-details-row i { width: 20px; text-align: center; color: var(--color-medium-blue); margin-right: 10px; }

        .diagnosis-section { padding-top: 15px; margin-top: 15px; border-top: 1px solid var(--color-very-light-blue); font-size: 13px; color: var(--color-text-medium); font-style: italic; }

        .card-actions { display: flex; justify-content: flex-end; margin-top: 20px; }
        .patient-list-view.list-active .card-actions { margin-top: 0; justify-content: center; }

        .btn-timeline { background-color: var(--color-bg-light); color: var(--color-primary-dark); border: 1px solid var(--color-very-light-blue); padding: 8px 15px; border-radius: 5px; font-size: 13px; font-weight: 600; cursor: pointer; transition: background-color 0.2s; text-decoration: none; }
        .btn-timeline:hover { background-color: var(--color-very-light-blue); }
        
        /* List Header (for List View) */
        .patient-list-header { 
            display: none; 
            /* Widths adjusted for the new ID format */
            grid-template-columns: 120px 80px 1fr 150px 100px 100px;
            gap: 10px;
            padding: 10px 20px;
            font-size: 12px;
            font-weight: 600;
            color: var(--color-primary-dark);
            border-bottom: 2px solid var(--color-light-blue);
            margin-bottom: 10px;
            background-color: var(--color-bg-light);
            border-radius: 8px 8px 0 0;
        }
        .patient-list-view.list-active ~ .patient-list-header {
            display: grid;
        }
    </style>
</head>
<body>

<div class="main-container">
    <div class="sidebar">
        <div class="logo-section">
            <i class="fas fa-heartbeat"></i>
            <div class="logo-text">
                <h2>MindTrack</h2>
                <p>Health Management</p>
            </div>
        </div>

        <nav class="nav-menu">
            <a class="nav-item" href="mindtrack.php"><i class="fas fa-th-large"></i>Dashboard</a>
            <a class="nav-item" href="appointment.php"><i class="far fa-calendar-alt"></i>Appointments</a>
            <a class="nav-item" href="cl.php"><i class="far fa-calendar-check"></i>Calendar</a>
            <a class="nav-item active" href="pt.php"><i class="fas fa-users"></i>Patients</a>
            <a class="nav-item" href="doctors.php"><i class="fas fa-user-md"></i>Doctors</a>
            <a class="nav-item" href="set.php"><i class="fas fa-cog"></i>Settings</a>
        </nav>

        <div class="user-info">
            <div class="user-avatar">A</div>
            <div class="user-details">
                <strong>Admin User</strong>
                <span>admin@mindtrack.com</span>
            </div>
        </div>
    </div>

    <div class="main-content-area">
        <div class="header">
            <div class="header-title">
                <h1>Patients (<?= count($patients) ?>)</h1>
                <p>Manage patient records and information</p>
            </div>
            <a href="patient_registration.php" class="btn-add-patient">
                <i class="fas fa-plus"></i> Add Patient
            </a>
        </div>

        <div class="patient-controls">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search patients by ID, email, or diagnosis..." id="searchInput">
            </div>
            <div class="view-toggle">
                <button id="gridViewBtn" class="active">Grid</button>
                <button id="listViewBtn">List</button>
            </div>
        </div>
        
        <div class="patient-list-header" id="listHeader">
            <div>Patient ID</div>
            <div>Age</div>
            <div>Email</div>
            <div>Assigned Doctor</div>
            <div>Status</div>
            <div>Action</div>
        </div>

        <div class="patient-list-view" id="patientListView">
            <?php foreach ($patients as $patient): ?>
            <div class="patient-card">
                <div>
                    <div class="patient-header">
                        <div style="display: flex;">
                            <div class="patient-avatar-box" title="<?= htmlspecialchars($patient['name']) ?>" style="font-size: 11px;"><?= htmlspecialchars($patient['patient_number']) ?></div>
                            <div class="patient-info">
                                <h3><?= htmlspecialchars($patient['patient_number']) ?></h3> 
                                <p><?= htmlspecialchars($patient['age']) ?></p>
                            </div>
                        </div>
                        <span class="status-badge status-<?= htmlspecialchars($patient['status']) ?>"><?= ucfirst(htmlspecialchars($patient['status'])) ?></span>
                    </div>

                    <div class="patient-details">
                        <div class="patient-details-row">
                            <i class="fas fa-envelope"></i>
                            <span><?= htmlspecialchars($patient['email']) ?></span>
                        </div>
                        <div class="patient-details-row">
                            <i class="fas fa-phone"></i>
                            <span><?= htmlspecialchars($patient['phone']) ?></span>
                        </div>
                        <div class="patient-details-row">
                            <i class="fas fa-user-md"></i>
                            <span><?= htmlspecialchars($patient['doctor']) ?></span>
                        </div>
                    </div>
                </div>

                <div class="diagnosis-section">
                    Diagnosis: <?= htmlspecialchars($patient['diagnosis'] ?? 'N/A') ?>
                </div>

                <div class="card-actions">
                    <a href="patient_timeline.php?id=<?= urlencode($patient['patient_custom_id']) ?>" class="btn-timeline">
                        <i class="fas fa-history" style="margin-right: 5px;"></i> Timeline
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const gridViewBtn = document.getElementById('gridViewBtn');
        const listViewBtn = document.getElementById('listViewBtn');
        const patientListView = document.getElementById('patientListView');
        const patientListHeader = document.getElementById('listHeader');

        // Check for saved view state in local storage
        const savedView = localStorage.getItem('patientView') || 'grid';

        function setView(view) {
            if (view === 'list') {
                patientListView.classList.add('list-active');
                gridViewBtn.classList.remove('active');
                listViewBtn.classList.add('active');
            } else {
                patientListView.classList.remove('list-active');
                listViewBtn.classList.remove('active');
                gridViewBtn.classList.add('active');
            }
            localStorage.setItem('patientView', view);
        }

        // Apply saved or default view
        setView(savedView);

        gridViewBtn.addEventListener('click', () => setView('grid'));
        listViewBtn.addEventListener('click', () => setView('list'));
        
        // --- Basic Search Functionality (Client-side) ---
        const searchInput = document.getElementById('searchInput');
        const patientCards = document.querySelectorAll('.patient-card');

        searchInput.addEventListener('keyup', function() {
            const searchTerm = searchInput.value.toLowerCase();

            patientCards.forEach(card => {
                // Search against all card text content
                const textContent = card.textContent.toLowerCase();
                if (textContent.includes(searchTerm)) {
                    card.style.display = ''; // Show
                } else {
                    card.style.display = 'none'; // Hide
                }
            });
        });
    });
</script>

</body>
</html>