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
    $org_name = $_POST['org_name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Hash password
    

    // SQL statement
    $sql = "INSERT INTO organization (org_name, email, password) VALUES (?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $org_name, $email, $password);
    
    if ($stmt->execute()) {
        echo "User registered successfully!";
        header("Location: orgreg.html"); // Redirect to another PHP file
exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>