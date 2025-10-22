<?php

// Configure PHP settings
ini_set('memory_limit', '512M');
ini_set('max_execution_time', '300');
ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');

// PHP Error Reporting
ini_set('log_errors', 1);
ini_set('error_log', $config['root_path'] . '/logs/error.log');
if ($_ENV['APP_DEBUG']) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
}

// Set timezone
date_default_timezone_set($_ENV['TIMEZONE']);

// Enable OPcache
if (function_exists('opcache_reset')) {
    ini_set('opcache.enable', 1);
    ini_set('opcache.memory_consumption', '128');
    ini_set('opcache.interned_strings_buffer', '8');
    ini_set('opcache.max_accelerated_files', '4000');
    ini_set('opcache.revalidate_freq', '60');
    ini_set('opcache.fast_shutdown', 1);
}

// Output buffering
ini_set('output_buffering', '4096');

// Realpath cache
ini_set('realpath_cache_size', '4096K');
ini_set('realpath_cache_ttl', '600');

// Expose PHP
ini_set('expose_php', 0);

// Input handling
ini_set('max_input_time', '60');
ini_set('max_input_vars', '1000');

// Output compression
if (extension_loaded('zlib')) {
    ini_set('zlib.output_compression', 1);
    ini_set('zlib.output_compression_level', -1);
}

// Disable functions
ini_set('disable_functions', 'exec,passthru,shell_exec,system,proc_open,popen,curl_exec,curl_multi_exec,parse_ini_file,show_source');