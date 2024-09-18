<?php
include 'dbconn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $action = $_POST['action'];

    if ($conn) {
        try {
            if ($action == 'done') {
                // Handle marking the order as done (this could be updating an order status in the database)
                $stmt = $conn->prepare("UPDATE `order` SET status = 'completed' WHERE order_id = ?");
                $stmt->bind_param("i", $order_id);
                $stmt->execute();
            } elseif ($action == 'cancel') {
                // Handle deleting the order
                $stmt = $conn->prepare("DELETE FROM `order` WHERE order_id = ?");
                $stmt->bind_param("i", $order_id);
                $stmt->execute();
            }
            header('Location: customerorders.php'); // Redirect back to the orders page
            exit;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        echo 'Database connection error';
    }
}
?>

