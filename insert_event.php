<?php
$host = "localhost";  // Change if needed
$user = "root";       // Database username
$pass = "";           // Database password (leave empty if using XAMPP)
$dbname = "registration"; // Your database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize inputs to prevent SQL injection
    $eventName = htmlspecialchars($_POST["event-name"]);
    $eventDescription = htmlspecialchars($_POST["event-description"]);
    $eventDate = $_POST["event-date"];
    $eventTime = $_POST["event-time"];
    $eventLocation = htmlspecialchars($_POST["event-location"]);
    $pastActivities = htmlspecialchars($_POST["past-activities"]);
    $eventCertificates = isset($_POST["event-certificates"]) ? "Yes" : "No";

    // Prepare SQL statement
    $sql = "INSERT INTO events (event_name, event_description, event_date, event_time, event_location, past_activities, certificates)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("sssssss", $eventName, $eventDescription, $eventDate, $eventTime, $eventLocation, $pastActivities, $eventCertificates);

    // Execute and check the result
    if ($stmt->execute()) {
        echo "<script>alert('Event created successfully!');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
