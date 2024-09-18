<?php
// register0.php

include 'dbconn.php';

// Error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phonenumber = mysqli_real_escape_string($conn, $_POST['phonenum']); // Corrected variable name
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO customer (name, email, address, phonenum, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $address, $phonenumber, $password);

    // Execute the statement
    if ($stmt->execute()) {
        $message = "Successfully Registered";
        // Redirect to login page after successful registration
        echo "<script>alert('$message'); window.location.href = 'login.php';</script>";
        // header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}
?>
