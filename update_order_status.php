<?php
// Initialize message variable
$message = "";

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate and sanitize input
    $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;

    if ($order_id && $status) {
        // Database connection
        require_once 'dbconn.php'; // Adjust the path as per your file structure
        
        // Prepare update query
        $updateQuery = "UPDATE `order` SET status = ? WHERE order_id = ?";
        
        // Prepare statement
        $stmt = $conn->prepare($updateQuery);
        
        // Bind parameters
        $stmt->bind_param("si", $status, $order_id);
        
        // Execute statement
        if ($stmt->execute()) {
            $message = "Order status updated successfully.";
        } else {
            $message = "Error updating order status: " . $stmt->error;
        }
        
        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        // Handle invalid input
        $message = "Invalid order ID or status.";
    }
} else {
    // Handle if not a POST request
    $message = "Invalid request method.";
}

// Display alert and redirect
echo "<script>alert('$message'); window.location.href = 'customerorders.php';</script>";
?>
