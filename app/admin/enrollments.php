<?php
require_once __DIR__ . '/../../core/app.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: ' . app('auth'));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php shared('components/elements/meta'); ?>
    <title>User Enrollments - MindTrack Admin</title>
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
                    <h1 class="text-2xl font-bold text-gray-800">
                        <i class="fas fa-user-plus"></i> User Enrollments
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">Manage user registration requests and enrollments</p>
                </div>
                <button class="ui primary button" id="addUserBtn">
                    <i class="plus icon"></i>
                    Enroll New User
                </button>
            </div>

            <!-- Success/Error Messages -->
            <div id="successMessage" class="ui positive message hidden">
                <i class="close icon"></i>
                <div class="header">Success!</div>
                <p id="successText"></p>
            </div>

            <div id="errorMessage" class="ui negative message hidden">
                <i class="close icon"></i>
                <div class="header">Error</div>
                <p id="errorText"></p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-6">
                <div class="bg-white rounded-lg p-4 shadow-sm border border-orange-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Pending</p>
                            <p class="text-2xl font-bold text-orange-600" id="pendingCount">0</p>
                        </div>
                        <i class="fas fa-hourglass-half text-3xl text-orange-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-green-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Active</p>
                            <p class="text-2xl font-bold text-green-600" id="activeCount">0</p>
                        </div>
                        <i class="fas fa-check-circle text-3xl text-green-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-red-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Inactive</p>
                            <p class="text-2xl font-bold text-red-600" id="inactiveCount">0</p>
                        </div>
                        <i class="fas fa-ban text-3xl text-red-600 opacity-20"></i>
                    </div>
                </div>

                <div class="bg-white rounded-lg p-4 shadow-sm border border-blue-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total</p>
                            <p class="text-2xl font-bold text-blue-600" id="totalCount">0</p>
                        </div>
                        <i class="fas fa-users text-3xl text-blue-600 opacity-20"></i>
                    </div>
                </div>
            </div>

            <!-- Users List -->
            <div class="bg-white rounded-lg shadow-sm border border-blue-50 mb-6">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">
                                <i class="fas fa-list-alt"></i> User Accounts
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Review and manage user enrollments</p>
                        </div>
                        <!-- Filter -->
                        <div class="ui buttons">
                            <button class="ui button active" data-filter="all">All</button>
                            <button class="ui button orange" data-filter="pending">Pending</button>
                            <button class="ui button green" data-filter="active">Active</button>
                            <button class="ui button red" data-filter="inactive">Inactive</button>
                        </div>
                    </div>
                </div>

                <div id="loadingUsers" class="text-center p-10">
                    <div class="ui active inline loader"></div>
                    <p class="mt-4 text-gray-600">Loading users...</p>
                </div>

                <div id="usersContainer" class="hidden p-6">
                    <div class="overflow-x-auto">
                        <table class="ui celled table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Registration Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody">
                                <!-- Populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="noUsers" class="hidden p-10 text-center">
                    <i class="fas fa-user-slash text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 text-lg">No users found</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Enroll User Modal -->
    <div class="ui large modal" id="enrollUserModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="user plus icon"></i>
            Enroll New User
        </div>
        <div class="content">
            <form class="ui form" id="enrollUserForm">
                <div class="two fields">
                    <div class="field required">
                        <label>First Name</label>
                        <input type="text" name="first_name" placeholder="First name" required>
                    </div>
                    <div class="field required">
                        <label>Last Name</label>
                        <input type="text" name="last_name" placeholder="Last name" required>
                    </div>
                </div>

                <div class="two fields">
                    <div class="field required">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="user@example.com" required>
                    </div>
                    <div class="field required">
                        <label>Username</label>
                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                </div>

                <div class="two fields">
                    <div class="field required">
                        <label>Role</label>
                        <select class="ui dropdown" name="role" id="roleSelect" required>
                            <option value="">Select Role</option>
                            <option value="patient">Patient</option>
                            <option value="doctor">Doctor</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="field required">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Temporary password" required>
                    </div>
                </div>

                <!-- Doctor-specific fields -->
                <div id="doctorFields" class="ui segment" style="display: none; background: #e3f2fd;">
                    <h4 class="ui header">Doctor Information</h4>
                    <div class="two fields">
                        <div class="field">
                            <label>Specialization</label>
                            <input type="text" name="specialization" placeholder="e.g., Psychiatrist">
                        </div>
                        <div class="field">
                            <label>License Number</label>
                            <input type="text" name="license_number" placeholder="Medical license number">
                        </div>
                    </div>
                </div>

                <!-- Patient-specific fields -->
                <div id="patientFields" class="ui segment" style="display: none; background: #f1f8e9;">
                    <h4 class="ui header">Patient Information</h4>
                    <div class="two fields">
                        <div class="field">
                            <label>Birthdate</label>
                            <input type="date" name="birthdate">
                        </div>
                        <div class="field">
                            <label>Emergency Contact</label>
                            <input type="tel" name="emergency_contact" placeholder="Emergency contact number">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="actions">
            <button class="ui button" data-action="close">Cancel</button>
            <button class="ui primary button" id="saveEnrollmentBtn">
                <i class="save icon"></i>
                Enroll User
            </button>
        </div>
    </div>

    <!-- User Details Modal -->
    <div class="ui large modal" id="userDetailsModal">
        <i class="close icon"></i>
        <div class="header">
            <i class="user icon"></i>
            User Details
        </div>
        <div class="content">
            <div class="ui grid">
                <div class="eight wide column">
                    <h4 class="ui dividing header">Personal Information</h4>
                    <div class="ui relaxed list">
                        <div class="item">
                            <strong>Full Name:</strong> <span id="viewFullName">-</span>
                        </div>
                        <div class="item">
                            <strong>Email:</strong> <span id="viewEmail">-</span>
                        </div>
                        <div class="item">
                            <strong>Username:</strong> <span id="viewUsername">-</span>
                        </div>
                        <div class="item">
                            <strong>Role:</strong> <span id="viewRole">-</span>
                        </div>
                    </div>
                </div>
                <div class="eight wide column">
                    <h4 class="ui dividing header">Account Status</h4>
                    <div class="ui relaxed list">
                        <div class="item">
                            <strong>Status:</strong> <span id="viewStatus">-</span>
                        </div>
                        <div class="item">
                            <strong>Registration Date:</strong> <span id="viewCreatedAt">-</span>
                        </div>
                        <div class="item">
                            <strong>Last Login:</strong> <span id="viewLastLogin">-</span>
                        </div>
                    </div>
                </div>
            </div>

            <input type="hidden" id="currentUserUuid">
            <input type="hidden" id="currentUserStatus">
        </div>
        <div class="actions">
            <button class="ui button" data-action="close">Close</button>
            <button class="ui red button" id="deactivateBtn" style="display: none;">
                <i class="ban icon"></i>
                Deactivate
            </button>
            <button class="ui green button" id="activateBtn" style="display: none;">
                <i class="check icon"></i>
                Activate
            </button>
        </div>
    </div>

    <?php shared('components/elements/scripts'); ?>

    <script>
        let usersData = [];
        let currentFilter = 'all';

        $(document).ready(function () {
            // Initialize dropdowns
            $('.ui.dropdown').dropdown();

            // Load users
            loadUsers();

            // Close messages
            $('.message .close').on('click', function () {
                $(this).closest('.message').transition('fade');
            });

            // Filter buttons
            $('.ui.buttons button').on('click', function () {
                $('.ui.buttons button').removeClass('active');
                $(this).addClass('active');
                currentFilter = $(this).data('filter');
                displayUsers(usersData, currentFilter);
            });

            // Add user button
            $('#addUserBtn').on('click', function () {
                openEnrollModal();
            });

            // Role selection change
            $('#roleSelect').dropdown({
                onChange: function (value) {
                    $('#doctorFields, #patientFields').hide();
                    if (value === 'doctor') {
                        $('#doctorFields').show();
                    } else if (value === 'patient') {
                        $('#patientFields').show();
                    }
                }
            });

            // Save enrollment
            $('#saveEnrollmentBtn').on('click', function () {
                if (!$('#enrollUserForm').form('is valid')) {
                    return;
                }
                enrollUser();
            });

            // Activate button
            $('#activateBtn').on('click', function () {
                const uuid = $('#currentUserUuid').val();
                updateUserStatus(uuid, 'active');
            });

            // Deactivate button
            $('#deactivateBtn').on('click', function () {
                if (confirm('Are you sure you want to deactivate this user?')) {
                    const uuid = $('#currentUserUuid').val();
                    updateUserStatus(uuid, 'inactive');
                }
            });
        });

        /**
         * Load users
         */
        function loadUsers() {
            $.ajax({
                url: apiURL('users') + 'users.php?action=list',
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        usersData = response.data;
                        displayUsers(usersData, currentFilter);
                        updateStats(usersData);
                    } else {
                        showError(response.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to load users');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Load Users Error');
                },
                complete: function () {
                    $('#loadingUsers').addClass('hidden');
                }
            });
        }

        /**
         * Display users
         */
        function displayUsers(users, filter = 'all') {
            let filteredUsers = users;
            if (filter !== 'all') {
                filteredUsers = users.filter(u => u.status === filter);
            }

            if (filteredUsers.length === 0) {
                $('#usersContainer').addClass('hidden');
                $('#noUsers').removeClass('hidden');
                return;
            }

            $('#usersContainer').removeClass('hidden');
            $('#noUsers').addClass('hidden');

            const tbody = $('#usersTableBody');
            tbody.empty();

            filteredUsers.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

            filteredUsers.forEach(function (user) {
                const statusClass = user.status === 'active' ? 'green' :
                    user.status === 'pending' ? 'orange' : 'red';

                const roleClass = user.role === 'admin' ? 'purple' :
                    user.role === 'doctor' ? 'blue' : 'teal';

                const row = `
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-semibold">${getInitials(user.first_name, user.last_name)}</span>
                                </div>
                                <div>
                                    <div class="font-semibold">${escapeHtml(user.first_name + ' ' + user.last_name)}</div>
                                    <div class="text-xs text-gray-500">@${escapeHtml(user.username)}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="ui mini label ${roleClass}">
                                <i class="${getRoleIcon(user.role)} icon"></i>
                                ${user.role.charAt(0).toUpperCase() + user.role.slice(1)}
                            </span>
                        </td>
                        <td>${escapeHtml(user.email)}</td>
                        <td>
                            <span class="ui mini label ${statusClass}">
                                ${user.status.charAt(0).toUpperCase() + user.status.slice(1)}
                            </span>
                        </td>
                        <td>${formatDate(user.created_at)}</td>
                        <td>
                            <button class="ui tiny blue button" onclick="viewUser('${user.uuid}')">
                                <i class="eye icon"></i>
                                View
                            </button>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        /**
         * Update statistics
         */
        function updateStats(users) {
            const pending = users.filter(u => u.status === 'pending').length;
            const active = users.filter(u => u.status === 'active').length;
            const inactive = users.filter(u => u.status === 'inactive').length;
            const total = users.length;

            $('#pendingCount').text(pending);
            $('#activeCount').text(active);
            $('#inactiveCount').text(inactive);
            $('#totalCount').text(total);
        }

        /**
         * Open enroll modal
         */
        function openEnrollModal() {
            $('#enrollUserForm').form('clear');
            $('#doctorFields, #patientFields').hide();
            $('#enrollUserModal').modal('show');
        }

        /**
         * Enroll user
         */
        function enrollUser() {
            const formData = new URLSearchParams($('#enrollUserForm').serialize());
            formData.append('status', 'active'); // Auto-activate admin-enrolled users

            $('#saveEnrollmentBtn').addClass('loading disabled');

            $.ajax({
                url: apiURL('auth') + 'register.php',
                method: 'POST',
                data: formData.toString(),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        showSuccess('User enrolled successfully!');
                        $('#enrollUserModal').modal('hide');
                        loadUsers();
                    } else {
                        showError(response.message || 'Failed to enroll user');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    showError('Failed to enroll user');
                    ajaxErrorHandler(jqXHR, textStatus, errorThrown, 'Enroll User Error');
                },
                complete: function () {
                    $('#saveEnrollmentBtn').removeClass('loading disabled');
                }
            });
        }

        /**
         * View user details
         */
        function viewUser(uuid) {
            const user = usersData.find(u => u.uuid === uuid);
            if (!user) return;

            $('#viewFullName').text(user.first_name + ' ' + user.last_name);
            $('#viewEmail').text(user.email);
            $('#viewUsername').text(user.username);

            const roleClass = user.role === 'admin' ? 'purple' :
                user.role === 'doctor' ? 'blue' : 'teal';
            $('#viewRole').html(`<span class="ui label ${roleClass}">${user.role.charAt(0).toUpperCase() + user.role.slice(1)}</span>`);

            const statusClass = user.status === 'active' ? 'green' :
                user.status === 'pending' ? 'orange' : 'red';
            $('#viewStatus').html(`<span class="ui label ${statusClass}">${user.status.charAt(0).toUpperCase() + user.status.slice(1)}</span>`);

            $('#viewCreatedAt').text(formatDate(user.created_at));
            $('#viewLastLogin').text(user.last_login ? formatDate(user.last_login) : 'Never');

            $('#currentUserUuid').val(uuid);
            $('#currentUserStatus').val(user.status);

            // Show/hide action buttons based on status
            if (user.status === 'active') {
                $('#activateBtn').hide();
                $('#deactivateBtn').show();
            } else {
                $('#activateBtn').show();
                $('#deactivateBtn').hide();
            }

            $('#userDetailsModal').modal('show');
        }

        /**
         * Update user status
         */
        function updateUserStatus(uuid, status) {
            // TODO: Implement status update API call
            showSuccess(`User ${status} successfully!`);
            $('#userDetailsModal').modal('hide');
            loadUsers();
        }

        /**
         * Get initials
         */
        function getInitials(firstName, lastName) {
            return (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();
        }

        /**
         * Get role icon
         */
        function getRoleIcon(role) {
            if (role === 'admin') return 'shield';
            if (role === 'doctor') return 'user md';
            return 'user';
        }

        /**
         * Show success message
         */
        function showSuccess(message) {
            $('#successText').text(message);
            $('#successMessage').removeClass('hidden');
            setTimeout(() => $('#successMessage').addClass('hidden'), 3000);
        }

        /**
         * Show error message
         */
        function showError(message) {
            $('#errorText').text(message);
            $('#errorMessage').removeClass('hidden');
            setTimeout(() => $('#errorMessage').addClass('hidden'), 5000);
        }

        /**
         * Format date
         */
        function formatDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        }

        /**
         * Escape HTML
         */
        function escapeHtml(text) {
            if (!text) return '';
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</body>

</html>