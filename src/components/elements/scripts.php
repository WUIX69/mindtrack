<?php

rcsScripts();
function rcsScripts()
{
    // All scripts needed by the application
    $scripts = [
        // Regular scripts
        // 'lib/jquery/jquery.min.js', // Loaded in styles.php
        'lib/jquery/jquery.validate.min.js',
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
        'middleware',
        'functions-additional',
    ];

    foreach ($utilityScripts as $script) {
        echo shared('utils', $script);
    }
}