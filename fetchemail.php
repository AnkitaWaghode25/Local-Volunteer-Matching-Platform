<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$database = "registration";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch emails from the database
$sql = "SELECT email FROM volunteer";
$result = $conn->query($sql);

$emails = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $emails[] = $row;
    }
}

// Set header to return JSON data
