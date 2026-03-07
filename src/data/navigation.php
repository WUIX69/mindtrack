<?php

if (!function_exists('getNavigation')) {
    function getNavigation()
    {
        return [
            'admin' => [
                ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'url' => app('admin')],
                ['id' => 'appointments', 'label' => 'Appointment Requests', 'icon' => 'pending_actions', 'url' => app('admin/appointments/')],
                ['id' => 'patients', 'label' => 'Patients Record', 'icon' => 'patient_list', 'url' => app('admin/patients.php')],
                ['id' => 'doctors', 'label' => 'Doctors Management', 'icon' => 'medical_services', 'url' => app('admin/doctors.php')],
                ['id' => 'services', 'label' => 'Clinical Services', 'icon' => 'list_alt', 'url' => app('admin/services.php')],
                ['id' => 'notes', 'label' => 'Clinical Notes', 'icon' => 'description', 'url' => app('admin/notes.php')],
                ['id' => 'specializations', 'label' => 'Specializations', 'icon' => 'category', 'url' => app('admin/specializations.php')],
                ['id' => 'notifications', 'label' => 'Notifications', 'icon' => 'notifications', 'url' => app('admin/notifications.php')],
            ],
            'doctor' => [
                ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'url' => app('doctor')],
                ['id' => 'appointments', 'label' => 'My Appointments', 'icon' => 'calendar_today', 'url' => app('doctor/appointments.php')],
                ['id' => 'patients', 'label' => 'Patients', 'icon' => 'group', 'url' => app('doctor/patients.php')],
                ['id' => 'notes', 'label' => 'Clinical Notes', 'icon' => 'description', 'url' => app('doctor/notes.php')],
                ['id' => 'notifications', 'label' => 'Notifications', 'icon' => 'notifications', 'url' => app('doctor/notifications.php')],
            ],
            'patient' => [
                ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'url' => app('patient')],
                ['id' => 'appointments', 'label' => 'Appointments', 'icon' => 'calendar_month', 'url' => app('patient/appointments/')],
                ['id' => 'notes', 'label' => 'My Notes', 'icon' => 'note', 'url' => app('patient/notes.php')],
                ['id' => 'resources', 'label' => 'Resources', 'icon' => 'menu_book', 'url' => app('patient/resources.php')],
                ['id' => 'notifications', 'label' => 'Notifications', 'icon' => 'notifications', 'url' => app('patient/notifications.php')],
            ]
        ];
    }
}
