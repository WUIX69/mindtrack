<?php

if (!function_exists('getStaticNotifications')) {
    function getStaticNotifications($role = 'patient')
    {
        $notifications = [];

        if ($role === 'patient') {
            $notifications = [
                ['icon' => 'event_available', 'color' => 'blue', 'title' => 'Appointment Confirmed', 'desc' => 'Your session with Dr. Smith is scheduled for tomorrow at 10:00 AM.', 'time' => '2m ago', 'unread' => true],
                ['icon' => 'description', 'color' => 'green', 'title' => 'Record Update', 'desc' => 'A new lab result has been uploaded to your medical records for review.', 'time' => '1h ago', 'unread' => true],
                ['icon' => 'medication', 'color' => 'purple', 'title' => 'Prescription Renewal', 'desc' => 'Your request for Sertraline renewal has been approved by Dr. Miller.', 'time' => 'Yesterday, 4:15 PM', 'unread' => false],
                ['icon' => 'payment', 'color' => 'orange', 'title' => 'Invoice Generated', 'desc' => 'The invoice for your last session (INV-9821) is now available for payment.', 'time' => 'Yesterday, 11:30 AM', 'unread' => false],
                ['icon' => 'campaign', 'color' => 'blue', 'title' => 'System Maintenance', 'desc' => 'The portal will be undergoing maintenance this Sunday between 2:00 AM and 4:00 AM.', 'time' => 'Oct 24, 2023', 'unread' => false],
                ['icon' => 'event', 'color' => 'blue', 'title' => 'Upcoming Appointment', 'desc' => 'Reminder for your appointment next week.', 'time' => 'Oct 20, 2023', 'unread' => false],
                ['icon' => 'folder_shared', 'color' => 'green', 'title' => 'Document Shared', 'desc' => 'Dr. Smith shared a new document with you.', 'time' => 'Oct 15, 2023', 'unread' => false],
                ['icon' => 'warning', 'color' => 'red', 'title' => 'Missed Appointment', 'desc' => 'You missed your scheduled check-in.', 'time' => 'Oct 10, 2023', 'unread' => false],
            ];
        } elseif ($role === 'doctor') {
            $notifications = [
                ['icon' => 'person_add', 'color' => 'green', 'title' => 'New Patient Assignment', 'desc' => 'You have been assigned a new patient: Alex Johnson.', 'time' => '10m ago', 'unread' => true],
                ['icon' => 'schedule', 'color' => 'orange', 'title' => 'Appointment Rescheduled', 'desc' => 'Maria Garcia requested to reschedule her 2:00 PM session.', 'time' => '2h ago', 'unread' => true],
                ['icon' => 'biotech', 'color' => 'blue', 'title' => 'Lab Results Ready', 'desc' => 'Bloodwork results for patient #8921 are now available for review.', 'time' => 'Yesterday, 3:30 PM', 'unread' => false],
                ['icon' => 'group', 'color' => 'purple', 'title' => 'Case Conference', 'desc' => 'Reminder: Multidisciplinary team meeting at 4:00 PM today.', 'time' => 'Yesterday, 9:00 AM', 'unread' => false],
                ['icon' => 'campaign', 'color' => 'blue', 'title' => 'System Maintenance', 'desc' => 'The portal will be undergoing maintenance this Sunday.', 'time' => 'Oct 24, 2023', 'unread' => false],
                ['icon' => 'feedback', 'color' => 'purple', 'title' => 'Patient Feedback', 'desc' => 'New feedback received from patient #4029.', 'time' => 'Oct 20, 2023', 'unread' => false],
                ['icon' => 'assignment', 'color' => 'green', 'title' => 'Review Required', 'desc' => 'Please review the latest clinical notes for patient #112.', 'time' => 'Oct 18, 2023', 'unread' => false],
            ];
        } elseif ($role === 'admin') {
            $notifications = [
                ['icon' => 'person_add', 'color' => 'blue', 'title' => 'New User Registration', 'desc' => 'A new doctor account (Dr. Alice Chen) is pending verification.', 'time' => '5m ago', 'unread' => true],
                ['icon' => 'warning', 'color' => 'red', 'title' => 'Appointment Escalation', 'desc' => 'Patient #2940 reported an issue with their recent billing.', 'time' => '1h ago', 'unread' => true],
                ['icon' => 'analytics', 'color' => 'green', 'title' => 'Monthly Report Generated', 'desc' => 'Clinic performance metrics for October are now available.', 'time' => 'Yesterday, 5:00 PM', 'unread' => false],
                ['icon' => 'event_busy', 'color' => 'orange', 'title' => 'Doctor Schedule Update', 'desc' => 'Dr. Smith blocked out their calendar for next Friday.', 'time' => 'Yesterday, 10:15 AM', 'unread' => false],
                ['icon' => 'security', 'color' => 'purple', 'title' => 'System Alert', 'desc' => 'Multiple failed login attempts detected from IP 192.168.1.5.', 'time' => 'Oct 24, 2023', 'unread' => false],
                ['icon' => 'update', 'color' => 'blue', 'title' => 'Software Update', 'desc' => 'MindTrack server update v2.0.1 applied successfully.', 'time' => 'Oct 20, 2023', 'unread' => false],
                ['icon' => 'backup', 'color' => 'green', 'title' => 'Backup Complete', 'desc' => 'Manual database backup completed.', 'time' => 'Oct 19, 2023', 'unread' => false],
            ];
        }

        return $notifications;
    }
}

if (!function_exists('getStaticNotificationColors')) {
    function getStaticNotificationColors()
    {
        return [
            'blue' => 'bg-blue-500/10 text-blue-500',
            'green' => 'bg-green-500/10 text-green-500',
            'purple' => 'bg-purple-500/10 text-purple-600 dark:text-purple-400',
            'orange' => 'bg-orange-500/10 text-orange-500',
            'red' => 'bg-red-500/10 text-red-500',
        ];
    }
}
