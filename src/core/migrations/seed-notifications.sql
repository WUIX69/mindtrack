-- --------------------------------------------------------
-- Seed Notifications for User Testing
-- --------------------------------------------------------

-- Patient: c00e118f-f060-4cf5-bfa5-ab1626415550
INSERT INTO `notifications` (`user_uuid`, `type`, `is_read`, `data`, `created_at`) VALUES
('c00e118f-f060-4cf5-bfa5-ab1626415550', 'appointment_confirmed', 0, '{"title": "Appointment Confirmed", "description": "Your therapy session on Feb 28 is confirmed.", "icon": "check_circle", "color": "green"}', '2026-03-01 10:00:00'),
('c00e118f-f060-4cf5-bfa5-ab1626415550', 'record_update', 0, '{"title": "Clinical Note Signed", "description": "Dr. Emily Chen has signed your clinical note.", "icon": "description", "color": "blue"}', '2026-03-02 11:30:00'),
('c00e118f-f060-4cf5-bfa5-ab1626415550', 'invoice', 1, '{"title": "Invoice Generated", "description": "Invoice #INV-202602 for your session is ready.", "icon": "receipt", "color": "gray"}', '2026-03-03 09:15:00'),
('c00e118f-f060-4cf5-bfa5-ab1626415550', 'system_alert', 0, '{"title": "System Maintenance", "description": "MindTrack will undergo scheduled maintenance tonight at 12 AM.", "icon": "warning", "color": "red"}', '2026-03-04 08:00:00');

-- Doctor: 61702d1b-e347-4fbf-9990-4207762f65ef
INSERT INTO `notifications` (`user_uuid`, `type`, `is_read`, `data`, `created_at`) VALUES
('61702d1b-e347-4fbf-9990-4207762f65ef', 'new_patient', 0, '{"title": "New Appointment", "description": "Patient John Doe booked a session for Mar 11.", "icon": "event", "color": "blue"}', '2026-03-01 14:20:00'),
('61702d1b-e347-4fbf-9990-4207762f65ef', 'appointment_cancelled', 1, '{"title": "Appointment Cancelled", "description": "Patient Test User cancelled their 9:00 AM session.", "icon": "event_busy", "color": "red"}', '2026-03-02 15:00:00'),
('61702d1b-e347-4fbf-9990-4207762f65ef', 'lab_results', 0, '{"title": "Lab Results", "description": "New assessment results uploaded for Patient Jane Doe.", "icon": "science", "color": "indigo"}', '2026-03-03 16:45:00'),
('61702d1b-e347-4fbf-9990-4207762f65ef', 'system_alert', 0, '{"title": "Action Required", "description": "Please review your draft clinical notes from last week.", "icon": "assignment_late", "color": "yellow"}', '2026-03-05 08:30:00');

-- Admin: 6fb2df93-0635-11f1-aa35-d843aec4afd7
INSERT INTO `notifications` (`user_uuid`, `type`, `is_read`, `data`, `created_at`) VALUES
('6fb2df93-0635-11f1-aa35-d843aec4afd7', 'new_registration', 0, '{"title": "New Doctor Registration", "description": "Dr. Kwak requested account verification.", "icon": "person_add", "color": "green"}', '2026-03-01 11:10:00'),
('6fb2df93-0635-11f1-aa35-d843aec4afd7', 'system_alert', 1, '{"title": "Server Health", "description": "Database usage has reached 80% capacity.", "icon": "storage", "color": "red"}', '2026-03-03 02:00:00'),
('6fb2df93-0635-11f1-aa35-d843aec4afd7', 'monthly_report', 0, '{"title": "Monthly Analytics", "description": "The report for February 2026 is now available.", "icon": "bar_chart", "color": "indigo"}', '2026-03-05 09:00:00');
