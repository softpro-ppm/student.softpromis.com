<?php
// Database connection
$host = "localhost";
$username = "u820431346_new_account";
$password = "otRkXMf]5;Ny";
$database = "u820431346_new_account";

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create connection
$acc = new mysqli($host, $username, $password, $database);

// Check connection
if ($acc->connect_error) {
    die("Connection failed: " . $acc->connect_error);
}

// Set charset to ensure proper encoding
$acc->set_charset("utf8mb4");
?>