<?php
/**
 * Appointment Booking - Step 2: Schedule & Provider (Patient)
 */
$pageTitle = "Book Appointment - Schedule & Provider";
$currentPage = 'appointments';

// Header configuration
$headerData = [
    'title' => 'Schedule & Provider',
    'description' => 'Select a date and time that works for you, then choose your preferred specialist.',
    'mb' => 4
];

include_once __DIR__ . '/../layout.php';
?>

<div class="w-full">
    <?= featured('appointments', 'components/step-2-schedule', [
        'role' => 'patient',
        'header' => [
            'title' => 'Schedule & Provider',
            'description' => 'Select a date and time that works for you, then choose your preferred specialist.'
        ],
        'back_label' => 'Back to Service',
        'continue_label' => 'Review Appointment Details'
    ]) ?>
</div>