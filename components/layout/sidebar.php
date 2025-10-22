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

        // Set domain path based on current location or role
        if ($isDoctorDomain) {
            $domain = 'doctors';
        } elseif ($isPatientDomain) {
            $domain = 'patients';
        } else {
            $domain = ($userRole === 'doctor') ? 'doctors' : 'patients';
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

        <a href="<?= app($domain . '/calendar') ?>"
            class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'calendar') ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
            tabindex="0" aria-label="Calendar">
            <i class="far fa-calendar-check text-lg"></i>
            <span>Calendar</span>
        </a>

        <a href="<?= app('patients/list') ?>"
            class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'list' && strpos(uriAppPath(), 'patients') !== false) ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
            tabindex="0" aria-label="Patients">
            <i class="fas fa-users text-lg"></i>
            <span>Patients</span>
        </a>

        <a href="<?= app('doctors/list') ?>"
            class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'list' && strpos(uriAppPath(), 'doctors') !== false) ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
            tabindex="0" aria-label="Doctors">
            <i class="fas fa-user-md text-lg"></i>
            <span>Doctors</span>
        </a>

        <a href="<?= app($domain . '/settings') ?>"
            class="flex items-center gap-4 px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-white hover:text-blue-600 transition-all <?= (uriPagePath() === 'settings') ? 'bg-white text-blue-600 font-semibold shadow-md' : '' ?>"
            tabindex="0" aria-label="Settings">
            <i class="fas fa-cog text-lg"></i>
            <span>Settings</span>
        </a>
    </nav>

    <!-- User Info -->
    <div class="p-4 border-t border-blue-200">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-200 rounded-full flex items-center justify-center">
                <span class="text-blue-600 font-semibold">A</span>
            </div>
            <div class="flex-1">
                <p class="font-semibold text-gray-800 m-0">Admin User</p>
                <p class="text-xs text-gray-500 m-0">admin@mindtrack.com</p>
            </div>
            <a href="<?= app('auth/logout') ?>" class="text-red-500 hover:text-red-700" tabindex="0"
                aria-label="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</aside>