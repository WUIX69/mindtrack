<?php
/**
 * Appointment Booking - Step 3: Review & Confirm (Admin)
 */
$pageTitle = "Book Appointment - Review & Confirm";
$currentPage = 'appointments';

// Header configuration
$headerData = [
    'title' => 'Review Selection',
    'description' => 'Please double-check the appointment details before confirming the request.',
    'mb' => 4
];

include_once __DIR__ . '/../layout.php';
?>

<div class="w-full pb-12">
    <?= featured('appointments', 'components/step-3-review', [
        'role' => 'admin',
        'notes' => [
            'label' => 'Administrative Notes (Internal)',
            'placeholder' => 'Add internal notes or special instructions for this booking...'
        ],
        'alert' => [
            'title' => 'Administrative Confirmation',
            'text' => "This appointment will be marked as <strong>confirmed</strong> immediately unless manual oversight is required. Notifications will be sent to both the patient and the provider."
        ]
    ]) ?>
</div>