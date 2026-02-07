<?php

rcsScripts();
function rcsScripts()
{
    // All scripts needed by the application
    $scripts = [
        // Regular scripts
        // 'lib/jquery/jquery.min.js', // Loaded in styles.php
        'vendor/fomantic-ui/dist/semantic.min.js',

        // Regular scripts
        'lib/lodash/lodash.min.js',
        'js/loader/window.js',
        'js/scripts.js',
    ];

    foreach ($scripts as $script) {
        echo '<script src="' . asset($script) . '"></script>';
    }
}


utilScripts();
function utilScripts()
{
    // Utility scripts
    $utilityScripts = [
        'middleware.php',
        'functions-additional.php',
    ];

    foreach ($utilityScripts as $script) {
        echo '<script src="' . shared('utils', $script, true) . '"></script>';
    }
}