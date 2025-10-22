<?php
require_once __DIR__ . '/../../core/app.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: ' . app('auth'));
    exit;
}

// Fetch user information from session
$username = $_SESSION['username'] ?? 'Admin';

// --- DUMMY DATA ---
// TODO: Replace with actual database queries using Users model
$users = [
    ['uuid' => 'uuid-001', 'name' => 'Dr. Sarah Johnson', 'email' => 'sarah.j@hospital.com', 'role' => 'doctor', 'status' => 'active', 'last_login' => '2024-10-22 09:30', 'created' => '2024-01-15'],
    ['uuid' => 'uuid-002', 'name' => 'John Doe', 'email' => 'john.doe@email.com', 'role' => 'patient', 'status' => 'active', 'last_login' => '2024-10-21 14:20', 'created' => '2024-02-20'],
    ['uuid' => 'uuid-003', 'name' => 'Dr. Mike Chen', 'email' => 'mike.chen@clinic.com', 'role' => 'doctor', 'status' => 'active', 'last_login' => '2024-10-22 08:15', 'created' => '2024-01-10'],
    ['uuid' => 'uuid-004', 'name' => 'Jane Smith', 'email' => 'jane.s@email.com', 'role' => 'patient', 'status' => 'inactive', 'last_login' => '2024-09-15 10:45', 'created' => '2024-03-05'],
    ['uuid' => 'uuid-005', 'name' => 'Dr. Emily White', 'email' => 'emily.white@hospital.com', 'role' => 'doctor', 'status' => 'pending', 'last_login' => null, 'created' => '2024-10-20'],
];

$totalUsers = count($users);
$activeUsers = count(array_filter($users, fn($u) => $u['status'] === 'active'));
$pendingUsers = count(array_filter($users, fn($u) => $u['status'] === 'pending'));
$inactiveUsers = count(array_filter($users, fn($u) => $u['status'] === 'inactive'));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>User Management - Admin - MindTrack</title>
    <?php shared('components/elements/styles'); ?>
</head>

<body class="bg-gradient-to-br from-blue-100 via-cyan-50 to-blue-50 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php shared('components/layout/sidebar') ?>

        <!-- Main Content -->
        <div class="flex-1 p-8 overflow-y-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">User Management</h1>
                    <p class="text-sm text-gray-600 mt-1">Manage system users, roles, and permissions</p>
                </div>
                <button class="ui primary button" id="addUserBtn">
                    <i class="plus icon"></i>
                    Add New User
                </button>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">
                <div class="bg-white rounded-lg p-4 shadow-sm border border-blue-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Users</p>
                            <p class="text-2xl font-bold text-blue-600"><?= $totalUsers ?></p>
                        </div>
                        <i class="fas fa-users text-3xl text-blue-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-green-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Active</p>
                            <p class="text-2xl font-bold text-green-600"><?= $activeUsers ?></p>
                        </div>
                        <i class="fas fa-check-circle text-3xl text-green-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-orange-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Pending</p>
                            <p class="text-2xl font-bold text-orange-600"><?= $pendingUsers ?></p>
                        </div>
                        <i class="fas fa-clock text-3xl text-orange-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Inactive</p>
                            <p class="text-2xl font-bold text-gray-600"><?= $inactiveUsers ?></p>
                        </div>
                        <i class="fas fa-ban text-3xl text-gray-600 opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Filters & Search -->
            <div class="bg-white rounded-lg p-5 shadow-sm border border-blue-50 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="ui search">
                        <div class="ui icon input w-full">
                            <input type="text" placeholder="Search users..." id="searchUsers">
                            <i class="search icon"></i>
                        </div>
                    </div>

                    <select class="ui dropdown" id="filterRole">
                        <option value="">All Roles</option>
                        <option value="admin">Admin</option>
                        <option value="doctor">Doctor</option>
                        <option value="patient">Patient</option>
                    </select>

                    <select class="ui dropdown" id="filterStatus">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending</option>
                        <option value="suspended">Suspended</option>
                    </select>

                    <button class="ui button" id="resetFilters">
                        <i class="redo icon"></i>
                        Reset Filters
                    </button>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow-sm border border-blue-50 overflow-hidden">
                <table class="ui celled table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-blue-200 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 font-semibold">
                                                <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                            </span>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800"><?= htmlspecialchars($user['name']) ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <span class="ui label <?php
                                    echo $user['role'] === 'admin' ? 'purple' :
                                        ($user['role'] === 'doctor' ? 'teal' : 'blue');
                                    ?>">
                                        <i class="<?php
                                        echo $user['role'] === 'admin' ? 'shield' :
                                            ($user['role'] === 'doctor' ? 'user md' : 'user');
                                        ?> icon"></i>
                                        <?= ucfirst($user['role']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="ui label <?php
                                    echo $user['status'] === 'active' ? 'green' :
                                        ($user['status'] === 'pending' ? 'orange' : 'grey');
                                    ?>">
                                        <?= ucfirst($user['status']) ?>
                                    </span>
                                </td>
                                <td class="text-sm text-gray-600">
                                    <?= $user['last_login'] ? date('M j, Y g:i A', strtotime($user['last_login'])) : 'Never' ?>
                                </td>
                                <td class="text-sm text-gray-600">
                                    <?= date('M j, Y', strtotime($user['created'])) ?>
                                </td>
                                <td>
                                    <div class="ui mini buttons">
                                        <button class="ui positive icon button" data-tooltip="Approve"
                                            data-user-uuid="<?= $user['uuid'] ?>">
                                            <i class="check icon"></i>
                                        </button>
                                        <button class="ui blue icon button" data-tooltip="Edit"
                                            data-user-uuid="<?= $user['uuid'] ?>">
                                            <i class="edit icon"></i>
                                        </button>
                                        <button class="ui orange icon button" data-tooltip="Suspend"
                                            data-user-uuid="<?= $user['uuid'] ?>">
                                            <i class="pause icon"></i>
                                        </button>
                                        <button class="ui red icon button" data-tooltip="Delete"
                                            data-user-uuid="<?= $user['uuid'] ?>">
                                            <i class="trash icon"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="p-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">Showing 1 to <?= count($users) ?> of <?= $totalUsers ?> users
                        </p>
                        <div class="ui pagination menu">
                            <a class="icon item"><i class="left chevron icon"></i></a>
                            <a class="active item">1</a>
                            <a class="item">2</a>
                            <a class="item">3</a>
                            <a class="icon item"><i class="right chevron icon"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit User Modal -->
    <div class="ui modal" id="userModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="user plus icon"></i>
            Add New User
        </div>
        <div class="content">
            <form class="ui form" id="userForm">
                <div class="two fields">
                    <div class="field required">
                        <label>First Name</label>
                        <input type="text" name="first_name" placeholder="John">
                    </div>
                    <div class="field required">
                        <label>Last Name</label>
                        <input type="text" name="last_name" placeholder="Doe">
                    </div>
                </div>

                <div class="field required">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="user@example.com">
                </div>

                <div class="field">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" placeholder="+1 (555) 123-4567">
                </div>

                <div class="two fields">
                    <div class="field required">
                        <label>Username</label>
                        <input type="text" name="username" placeholder="johndoe">
                    </div>
                    <div class="field required">
                        <label>Role</label>
                        <select name="role" class="ui dropdown">
                            <option value="">Select Role</option>
                            <option value="patient">Patient</option>
                            <option value="doctor">Doctor</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>

                <div class="two fields">
                    <div class="field required">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="••••••••">
                    </div>
                    <div class="field required">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" placeholder="••••••••">
                    </div>
                </div>

                <div class="field">
                    <label>Status</label>
                    <select name="status" class="ui dropdown">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui cancel button">Cancel</button>
            <button class="ui positive button" id="saveUserBtn">
                <i class="save icon"></i>
                Save User
            </button>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        $(document).ready(function () {
            // Initialize dropdowns
            $('.ui.dropdown').dropdown();

            // Initialize tooltips
            $('[data-tooltip]').popup();

            // Open add user modal
            $('#addUserBtn').on('click', function () {
                $('#userModal').modal('show');
            });

            // Form validation
            $('#userForm').form({
                fields: {
                    first_name: 'empty',
                    last_name: 'empty',
                    email: 'email',
                    username: 'empty',
                    role: 'empty',
                    password: ['empty', 'minLength[6]'],
                    confirm_password: ['empty', 'match[password]']
                }
            });

            // Save user
            $('#saveUserBtn').on('click', function () {
                if ($('#userForm').form('is valid')) {
                    // TODO: Implement AJAX call to save user
                    console.log('Saving user...');
                    $('#userModal').modal('hide');
                }
            });

            // Reset filters
            $('#resetFilters').on('click', function () {
                $('#searchUsers').val('');
                $('#filterRole').dropdown('clear');
                $('#filterStatus').dropdown('clear');
            });
        });
    </script>
</body>

</html>