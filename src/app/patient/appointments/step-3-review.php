<?php
/**
 * Appointment Booking - Step 3: Review & Confirm (Patient)
 */
$pageTitle = "Book Appointment - Review & Confirm";
$currentPage = 'appointments';

// Header configuration
$headerData = [
    'title' => 'Review Your Selection',
    'description' => 'Please double-check your selection before confirming the request.',
    'mb' => 4
];

include_once __DIR__ . '/../layout.php';
?>

<div class="w-full pb-12">
    <?= featured('appointments', 'components/step-3-review', [
        'role' => 'patient',
        'header' => [
            'title' => 'Review Your Selection',
            'description' => 'Please double-check your selection before confirming the request.'
        ],
        'notes' => [
            'label' => 'Notes for the Doctor (Optional)',
            'placeholder' => 'Add any specific concerns, recent symptoms, or information you\'d like your provider to know beforehand...'
        ],
        'confirm_label' => 'Confirm Request',
        'alert' => [
            'title' => 'Pending Approval',
            'text' => "Your appointment is currently <strong>pending approval</strong> by the clinic staff. You will receive an email and mobile notification once your request is confirmed, typically within 2-4 business hours."
        ],
        'back_label' => 'Edit Selection'
    ]) ?>
</div>