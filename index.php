<?php
require_once __DIR__ . '/core/app.php';

// Redirect to landing page
header('Location: ' . app('landing'));
exit;
