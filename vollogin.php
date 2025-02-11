<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "registration";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if email and password are received
    if (empty($email) || empty($password)) {
        die("Email or Password field is empty.");
    }

    // Prepare statement to fetch user data
    $sql = "SELECT id, first, last, password FROM volunteer WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $first, $last, $stored_password);
        $stmt->fetch();

        // Verify simple password (plain text)
        if ($password === $stored_password) {
            // Set session variables
            $_SESSION["volunteer_id"] = $id;
            $_SESSION["volunteer_name"] = $first . " " . $last;

            echo "Login successful! Redirecting...";
            header("refresh:2;url=voldashboard.php"); // Redirect after 2 seconds
            exit();
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }

    $stmt->close();
}

$conn->close();
?>
