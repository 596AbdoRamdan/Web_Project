<?php
session_start();

// MySQL connection details
$host = '127.0.0.1';
$port = '3306';
$dbname = 'food_db';
$username = 'root';
$password = '';

// Establishing the MySQLi connection
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Checking the connection
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
