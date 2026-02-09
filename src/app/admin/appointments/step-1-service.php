<?php
/**
 * Appointment Booking - Step 1: Select Service (Admin)
 */
$pageTitle = "Book Appointment - Select Service";
$currentPage = 'appointments';

// Header configuration
$headerData = [
    'title' => 'Book an Appointment',
    'description' => 'Please choose the clinical service you require to continue with your booking.',
    'mb' => 4
];

include_once __DIR__ . '/../layout.php';
?>

<div class="w-full pb-12">
    <?= featured('appointments', 'components/step-1-service', [
        'role' => 'admin'
    ]) ?>
</div>