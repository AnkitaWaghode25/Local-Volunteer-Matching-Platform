<?php
// Database connection
$host = "localhost";  // Change if needed
$user = "root";       // Your database username
$pass = "";           // Your database password
$dbname = "registration";  // Change to your database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Hash password
    $interest = $_POST['interest'];
  
   if (!empty($_POST['interest'])) {
        $interest = $_POST['interest']; // Get interest value
    } else {
        die("Error: Please select an interest.");
    }
    // SQL statement
    $sql = "INSERT INTO volunteer(first, last, email, password,interest) VALUES (?, ?, ?, ?,?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $password,$interest);
    
    if ($stmt->execute()) {
        echo "User registered successfully!";

         



    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>