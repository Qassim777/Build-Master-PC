<?php
// Database configuration
$host = 'localhost:3307:3307';
$username = 'root';
$password = '';
$database = 'build_master_pc';

// Create database connection
$connection = mysqli_connect($host, $username, $password, $database);

// Check if connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>