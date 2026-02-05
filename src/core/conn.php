<?php

$conn = null;
try {

    $conn = new PDO(
        "mysql:host=" . $config['db']['host'] .
        ";dbname=" . $config['db']['name'] .
        ";port=" . $config['db']['port'],
        $config['db']['username'],
        $config['db']['password']
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    die("Connection failed: " . $e->getMessage());
}

/* 
 * Now you can use this connection by accessing 
 * the global $conn variable
 * 
 * Example usage:
 * --------------
 * global $conn;
 * $stmt = $conn->query("SELECT * FROM users");
 * 
 */