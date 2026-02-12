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
                ['id' => 'specializations', 'label' => 'Specializations', 'icon' => 'category', 'url' => app('admin/specializations.php')],
            ],
            'doctor' => [
                ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'url' => app('doctor')],
                ['id' => 'schedule', 'label' => 'My Schedule', 'icon' => 'calendar_today', 'url' => app('doctor/schedule.php')],
                ['id' => 'patients', 'label' => 'Patients', 'icon' => 'group', 'url' => app('doctor/patients.php')],
                ['id' => 'notes', 'label' => 'Clinical Notes', 'icon' => 'description', 'url' => app('doctor/notes.php')],
            ],
            'patient' => [
                ['id' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'dashboard', 'url' => app('patient')],
                ['id' => 'appointments', 'label' => 'Appointments', 'icon' => 'calendar_month', 'url' => app('patient/appointments/')],
                ['id' => 'records', 'label' => 'My Records', 'icon' => 'description', 'url' => app('patient/records.php')],
                ['id' => 'resources', 'label' => 'Resources', 'icon' => 'menu_book', 'url' => app('patient/resources.php')],
            ]
        ];
    }
}
