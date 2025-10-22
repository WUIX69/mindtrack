<aside class="w-72 bg-gradient-to-b from-blue-100 to-cyan-50 shadow-lg flex flex-col">
    <!-- Logo Section -->
    <div class="p-8 border-b border-blue-200">
        <div class="flex items-center gap-3">
            <i class="fas fa-heartbeat text-3xl text-blue-600"></i>
            <div>
                <h2 class="text-xl font-semibold text-blue-600 m-0">MindTrack</h2>
                <p class="text-xs text-gray-500 m-0">Health Management</p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 p-4 overflow-y-auto">
        <?php
        // Determine user role from session
        $userRole = $_SESSION['role'] ?? 'patient';
        $isDoctorDomain = strpos($_SERVER['REQUEST_URI'], '/doctors/') !== false;
        $isPatientDomain = strpos($_SERVER['REQUEST_URI'], '/patients/') !== false;
        $isAdminDomain = strpos($_SERVER['REQUEST_URI'], '/admin/') !== false;

        // Set domain path based on current location or role
        if ($isAdminDomain) {
            $domain = 'admin';
        } elseif ($isDoctorDomain) {
            $domain = 'doctors';
        } elseif ($isPatientDomain) {
            $domain = 'patients';
        } else {
            // Default domain based on role
            if ($userRole === 'admin') {
                $domain = 'admin';
            } elseif ($userRole === 'doctor') {
                $domain = 'doctors';
            } else {
                $domain = 'patients';
            }
        }
        ?>

        <a href="<?= app($domain) ?>"
            class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'index' && uriAppPath() === $domain) ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
            tabindex="0" aria-label="Dashboard">
            <i class="fas fa-th-large text-lg"></i>
            <span>Dashboard</span>
        </a>

        <a href="<?= app($domain . '/appointments') ?>"
            class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'appointments') ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
            tabindex="0" aria-label="Appointments">
            <i class="far fa-calendar-alt text-lg"></i>
            <span>Appointments</span>
        </a>

        <?php if ($userRole === 'patient'): ?>
            <a href="<?= app('patients/prescriptions') ?>"
                class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'prescriptions') ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
                tabindex="0" aria-label="Prescriptions">
                <i class="fas fa-prescription-bottle-alt text-lg"></i>
                <span>Prescriptions</span>
            </a>

            <a href="<?= app('patients/lab_results') ?>"
                class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'lab_results') ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
                tabindex="0" aria-label="Lab Results">
                <i class="fas fa-flask text-lg"></i>
                <span>Lab Results</span>
            </a>
        <?php endif; ?>

        <?php if ($userRole === 'doctor'): ?>
            <a href="<?= app('doctors/prescriptions') ?>"
                class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'prescriptions') ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
                tabindex="0" aria-label="Prescriptions">
                <i class="fas fa-prescription-bottle-alt text-lg"></i>
                <span>Prescriptions</span>
            </a>

            <a href="<?= app('doctors/lab_results') ?>"
                class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'lab_results') ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
                tabindex="0" aria-label="Lab Results">
                <i class="fas fa-flask text-lg"></i>
                <span>Lab Results</span>
            </a>
        <?php endif; ?>

        <?php if ($userRole !== 'patient'): ?>
            <a href="<?= app($domain . '/calendar') ?>"
                class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'calendar') ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
                tabindex="0" aria-label="Calendar">
                <i class="far fa-calendar-check text-lg"></i>
                <span>Calendar</span>
            </a>
        <?php endif; ?>

        <?php if ($userRole === 'admin'): ?>
            <a href="<?= app('admin/enrollments') ?>"
                class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'enrollments') ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
                tabindex="0" aria-label="Enrollments">
                <i class="fas fa-user-plus text-lg"></i>
                <span>Enrollments</span>
            </a>

            <a href="<?= app('admin/booking_requests') ?>"
                class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'booking_requests') ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
                tabindex="0" aria-label="Booking Requests">
                <i class="fas fa-calendar-plus text-lg"></i>
                <span>Booking Requests</span>
            </a>

            <a href="<?= app('admin/patients') ?>"
                class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'patients' && $isAdminDomain) ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
                tabindex="0" aria-label="Patients">
                <i class="fas fa-users text-lg"></i>
                <span>Patients</span>
            </a>

            <a href="<?= app('admin/doctors') ?>"
                class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'doctors' && $isAdminDomain) ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
                tabindex="0" aria-label="Doctors">
                <i class="fas fa-user-md text-lg"></i>
                <span>Doctors</span>
            </a>

            <a href="<?= app('admin/prescriptions') ?>"
                class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'prescriptions' && $isAdminDomain) ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
                tabindex="0" aria-label="Prescriptions">
                <i class="fas fa-prescription-bottle-alt text-lg"></i>
                <span>Prescriptions</span>
            </a>

            <a href="<?= app('admin/lab_results') ?>"
                class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'lab_results' && $isAdminDomain) ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
                tabindex="0" aria-label="Lab Results">
                <i class="fas fa-flask text-lg"></i>
                <span>Lab Results</span>
            </a>

            <a href="<?= app('admin/reports') ?>"
                class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'reports') ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
                tabindex="0" aria-label="Reports">
                <i class="fas fa-chart-bar text-lg"></i>
                <span>Reports</span>
            </a>

            <a href="<?= app('admin/logs') ?>"
                class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'logs') ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
                tabindex="0" aria-label="Activity Logs">
                <i class="fas fa-history text-lg"></i>
                <span>Activity Logs</span>
            </a>
        <?php endif; ?>

        <a href="<?= app($domain . '/settings') ?>"
            class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'settings') ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
            tabindex="0" aria-label="Settings">
            <i class="fas fa-cog text-lg"></i>
            <span>Settings</span>
        </a>
    </nav>

    <!-- User Info -->
    <div class="p-4 border-t border-blue-200">
        <?php
        $userName = $_SESSION['username'] ?? 'User';
        $userEmail = $_SESSION['email'] ?? 'user@mindtrack.com';
        $userInitial = strtoupper(substr($userName, 0, 1));
        $roleLabel = ucfirst($userRole);
        ?>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-200 rounded-full flex items-center justify-center">
                <span class="text-blue-600 font-semibold"><?= $userInitial ?></span>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-gray-800 m-0"><?= htmlspecialchars($userName) ?></p>
                <p class="text-xs text-gray-500 m-0"><?= htmlspecialchars($roleLabel) ?></p>
            </div>
            <a href="<?= app('auth/logout') ?>" class="text-red-500 hover:text-red-700" tabindex="0"
                aria-label="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</aside>