<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect user to login page if not logged in
    header("Location: login.html");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "creativetribe"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required POST parameters are set
    if(isset($_POST["name"], $_POST["email"], $_POST["contact_number"], $_POST["date_of_appointment"], $_POST["photography_service"])) {
        $id = "2";
        $name = $_POST["name"];
        $email = $_POST["email"];
        $contactNumber = $_POST["contact_number"];
        $dateOfAppointment = $_POST["date_of_appointment"];
        $photographyService = $_POST["photography_service"];
        
        // SQL query to insert booking data into the database
        $sql = "INSERT INTO booking_appointments (name, email, contact_number, date_of_appointment, photography_service) VALUES (?, ?, ?, ?, ?)";
        
        // Prepare statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $email, $contactNumber, $dateOfAppointment, $photographyService);
        
        // Execute statement
        if ($stmt->execute()) {
            // Booking appointment saved successfully
            echo "Booking appointment saved successfully";
        } else {
            // Error occurred
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        // If any required POST parameter is missing
        echo "Error: All required parameters are not provided.";
    }
}

// Close connection
$conn->close();
?>
