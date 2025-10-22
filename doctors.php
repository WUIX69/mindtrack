<?php
// PHP DUMMY DATA (Mula sa Doctors image)
$doctors = [
    [
        'name' => 'Dr. Amanda Foster',
        'specialization' => 'Clinical Psychology',
        'status' => 'active',
        'email' => 'amanda.foster@mindtrack.com',
        'phone' => '(555) 111-2222',
        'patients' => 2,
        'availability' => ['Mon', 'Tue', 'Wed', 'Fri']
    ],
    [
        'name' => 'Dr. James Martinez',
        'specialization' => 'Psychiatry',
        'status' => 'active',
        'email' => 'james.martinez@mindtrack.com',
        'phone' => '(555) 222-3333',
        'patients' => 1,
        'availability' => ['Tue', 'Wed', 'Thu']
    ],
    [
        'name' => 'Dr. Lisa Kim',
        'specialization' => 'Child Psychology',
        'status' => 'active',
        'email' => 'lisa.kim@mindtrack.com',
        'phone' => '(555) 333-4444',
        'patients' => 0,
        'availability' => ['Mon', 'Wed', 'Thu', 'Fri']
    ]
];

$header_date = date('l, F j, Y', strtotime('October 20, 2025')); // Static date based on image
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctors - MindTrack Health Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* INAYOS ANG MGA KULAY GAMIT ANG PROVIDED HEX CODES */
        :root {
            --color-primary-dark: #0077b6; /* Mas madilim na primary blue */
            --color-deep-blue: #00A9FF; /* Accent Blue */
            --color-medium-blue: #89CFF3; 
            --color-light-blue: #A0E9FF; 
            --color-very-light-blue: #E0F7FF; /* Mas matingkad na hover/bg light blue */
            --color-text-dark: #333; 
            --color-text-medium: #666; 
            --color-bg-light: #F0F8FF;
            --color-bg-main: #E6F3FA; 
            --color-success-green: #4CAF50;
            --color-danger-red: #dc3545;
            --color-status-active: var(--color-success-green);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%; 
            font-family: 'Poppins', sans-serif;
            /* Inayon sa background gradient ng Dashboard */
            background: linear-gradient(135deg, #d3e5ff, #e6f6ff); 
            color: var(--color-text-dark);
        }

        .main-container { display: flex; height: 100vh; overflow: hidden; }

        /* --- Sidebar Navigation (Copied from Dashboard) --- */
        .sidebar {
            width: 280px;
            background: linear-gradient(to top, #d3e5ff, #e6f6ff); 
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            padding: 30px 0;
            flex-shrink: 0;
        }

        .logo-section { display: flex; align-items: center; padding: 0 30px 40px; gap: 10px; }
        .logo-section i { font-size: 28px; color: var(--color-primary-dark); }
        .logo-text h2 { font-size: 18px; font-weight: 600; color: var(--color-primary-dark); line-height: 1; }
        .logo-text p { font-size: 10px; color: var(--color-medium-blue); font-weight: 300; }

        .nav-menu { flex-grow: 1; padding: 0 20px; } 
        .nav-item {
            display: flex; align-items: center; text-decoration: none; color: var(--color-text-medium); font-size: 15px; margin-bottom: 8px;
            padding: 12px 15px; border-radius: 8px; transition: background-color 0.2s ease, color 0.2s ease; font-weight: 500;
        }
        .nav-item:hover:not(.active) { background-color: var(--color-very-light-blue); color: var(--color-primary-dark); }
        /* Active state for Doctors page */
        .nav-item.active { 
            background-color: white; 
            color: var(--color-primary-dark); 
            font-weight: 600; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.05); 
            border-left: none; 
        }
        .nav-item i { margin-right: 15px; font-size: 18px; color: var(--color-medium-blue); }
        .nav-item.active i { color: var(--color-primary-dark); }

        .user-info { padding: 20px 30px; border-top: 1px solid rgba(0,0,0,0.05); display: flex; align-items: center; }
        .user-avatar {
            width: 36px; height: 36px; border-radius: 50%; background-color: var(--color-light-blue); color: var(--color-primary-dark);
            display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 14px; margin-right: 10px;
        }
        .user-details strong { color: var(--color-text-dark); font-size: 14px; }
        .user-details span { font-size: 11px; color: var(--color-text-medium); }
        /* End Sidebar */

        /* --- Main Content Area --- */
        .main-content-area {
            flex-grow: 1;
            padding: 30px; 
            overflow-y: auto;
        }

        /* Header Style - Inayon sa Dashboard Header */
        .header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 25px; 
        }
        .header-title {
            padding: 0;
        }
        .header-title h1 { font-size: 24px; color: var(--color-text-dark); font-weight: 600; } 
        .header-title p { font-size: 14px; color: var(--color-text-medium); margin-top: 5px; } 

        .btn-add-doctor {
            background-color: var(--color-deep-blue); /* #00A9FF */
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 8px rgba(0, 169, 255, 0.3); /* Shadow for blue button */
        }
        .btn-add-doctor:hover {
            background-color: var(--color-primary-dark);
        }

        /* Doctor Controls (Search, Grid/List) */
        .doctor-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .search-box {
            position: relative;
            width: 500px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 10px 10px 40px;
            border: 1px solid var(--color-very-light-blue);
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }

        .search-box input:focus {
            border-color: var(--color-primary-dark);
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--color-text-medium);
            font-size: 14px;
        }

        .view-toggle {
            display: flex;
            border: 1px solid var(--color-primary-dark);
            border-radius: 8px;
            overflow: hidden;
        }
        .view-toggle button {
            padding: 8px 15px;
            border: none;
            background-color: white;
            color: var(--color-primary-dark);
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            font-size: 14px;
        }
        .view-toggle button:first-child { border-right: 1px solid var(--color-primary-dark); }
        .view-toggle button.active {
            background-color: var(--color-primary-dark);
            color: white;
        }

        /* Doctor Grid */
        .doctor-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .doctor-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.05);
            border: 1px solid var(--color-very-light-blue);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .doctor-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .doctor-icon-box {
            width: 40px; height: 40px; border-radius: 50%;
            background-color: var(--color-light-blue);
            color: var(--color-primary-dark);
            display: flex; align-items: center; justify-content: center;
            font-weight: 600;
            font-size: 16px;
            flex-shrink: 0;
            margin-right: 15px;
        }

        .doctor-info {
            flex-grow: 1;
        }
        .doctor-info h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--color-text-dark);
            line-height: 1.2;
        }
        .doctor-info p {
            font-size: 13px;
            color: var(--color-text-medium);
            margin-top: 2px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-active {
            background-color: rgba(76, 175, 80, 0.1); /* Light green tint */
            color: var(--color-status-active);
        }

        .doctor-details-row {
            display: flex;
            align-items: center;
            font-size: 13px;
            color: var(--color-text-dark);
            margin-bottom: 8px;
        }
        .doctor-details-row i {
            width: 20px;
            text-align: center;
            color: var(--color-medium-blue);
            margin-right: 10px;
        }

        .availability-section {
            padding-top: 15px;
            margin-top: 15px;
            border-top: 1px solid var(--color-very-light-blue);
        }

        .availability-section strong {
            display: block;
            margin-bottom: 10px;
            font-size: 13px;
            color: var(--color-text-dark);
            font-weight: 600;
        }

        .availability-days {
            display: flex;
            gap: 5px;
        }

        .day-badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 500;
            background-color: var(--color-light-blue);
            color: var(--color-primary-dark);
        }

        .card-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
            gap: 10px;
        }

        .btn-edit, .btn-delete {
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-edit {
            background-color: var(--color-bg-light);
            color: var(--color-primary-dark);
            border: 1px solid var(--color-very-light-blue);
        }
        .btn-edit:hover {
            background-color: var(--color-very-light-blue);
        }
        
        .btn-delete {
            background-color: white;
            color: var(--color-danger-red);
            border: 1px solid rgba(220, 53, 69, 0.2);
        }
        .btn-delete:hover {
            background-color: var(--color-danger-red);
            color: white;
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
            <a class="nav-item" href="pt.php"><i class="fas fa-users"></i>Patients</a>
            <a class="nav-item active" href="doctors.php"><i class="fas fa-user-md"></i>Doctors</a>
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
                <h1>Doctors</h1>
                <p>Manage healthcare providers and specialists</p>
            </div>
            <a href="doctor_registration.php" class="btn-add-doctor">
                <i class="fas fa-plus"></i> Add Doctor
            </a>
        </div>

        <div class="doctor-controls">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search doctors by name, specialization, or email...">
            </div>
            <div class="view-toggle">
                <button class="active">Grid</button>
                <button>List</button>
            </div>
        </div>

        <div class="doctor-grid">
            <?php foreach ($doctors as $doctor): ?>
            <div class="doctor-card">
                <div>
                    <div class="doctor-header">
                        <div style="display: flex;">
                            <div class="doctor-icon-box"><i class="fas fa-stethoscope"></i></div>
                            <div class="doctor-info">
                                <h3><?= htmlspecialchars($doctor['name']) ?></h3>
                                <p><?= htmlspecialchars($doctor['specialization']) ?></p>
                            </div>
                        </div>
                        <span class="status-badge status-<?= htmlspecialchars($doctor['status']) ?>"><?= htmlspecialchars($doctor['status']) ?></span>
                    </div>

                    <div class="doctor-details">
                        <div class="doctor-details-row">
                            <i class="fas fa-envelope"></i>
                            <span><?= htmlspecialchars($doctor['email']) ?></span>
                        </div>
                        <div class="doctor-details-row">
                            <i class="fas fa-phone"></i>
                            <span><?= htmlspecialchars($doctor['phone']) ?></span>
                        </div>
                        <div class="doctor-details-row">
                            <i class="fas fa-users"></i>
                            <span><?= htmlspecialchars($doctor['patients']) ?> Patients</span>
                        </div>
                    </div>
                </div>

                <div class="availability-section">
                    <strong>Availability:</strong>
                    <div class="availability-days">
                        <?php 
                        $all_days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                        foreach ($doctor['availability'] as $day): 
                            echo '<span class="day-badge">' . htmlspecialchars($day) . '</span>';
                        endforeach; 
                        ?>
                    </div>
                </div>

                <div class="card-actions">
                    <button class="btn-edit">
                        <i class="fas fa-pencil-alt"></i> Edit
                    </button>
                    <button class="btn-delete">
                        <i class="fas fa-trash-alt"></i> Delete
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

</body>
</html>