<?php
session_start();
require_once 'dbconn.php';

    if (!isset($_SESSION['cust_id'])) {
        // Redirect to the registration page if user data is not available
        header('Location: register.php');
        exit;
    }

    if(isset($_GET['order_id'])){

        $order_id = $_GET['order_id'];

        // Retrieve the order information
        $orderQuery = "SELECT * FROM `order` WHERE order_id = ?";
        $stmt = $conn->prepare($orderQuery);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $orderResult = $stmt->get_result();
        $order = $orderResult->fetch_assoc();

        // Retrieve the order details information
        $detailsQuery = "SELECT * FROM order_details WHERE order_id = ?";
        $stmt = $conn->prepare($detailsQuery);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $detailsResult = $stmt->get_result();

        // Fetch all order details
        $orderDetails = [];
        while ($row = $detailsResult->fetch_assoc()) {
            $orderDetails[] = $row;
        }

        // Close the statement
        $stmt->close();

    }

    function displayOrderSummary() {
        global $conn;

        $total = 0;

        $order_id = $_GET['order_id'];

        // Retrieve the order information
        $orderQuery = "SELECT * FROM `order` WHERE order_id = ?";
        $stmt = $conn->prepare($orderQuery);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $orderResult = $stmt->get_result();
        $order = $orderResult->fetch_assoc();

        // Retrieve the order details information
        $detailsQuery = "SELECT * FROM order_details WHERE order_id = ?";
        $stmt = $conn->prepare($detailsQuery);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $detailsResult = $stmt->get_result();

        // Fetch all order details
        $orderDetails = [];
        while ($row = $detailsResult->fetch_assoc()) {
            $orderDetails[] = $row;
        }

        // Close the statement
        $stmt->close();

        // Display the order and order details
        if ($order) {

            if($order['delivery_method'] === 'delivery'){

                $deliveryFee = 2.00; // Assuming a fixed delivery fee

            }
            else{

                $deliveryFee = 0.00; // Assuming a fixed delivery fee

            }

            if (!empty($orderDetails)) {
                echo "<table cellpadding='0' cellspacing='0' style='width:100%;'>";
                echo "<thead>";
                echo    "<tr>";
                echo        "<th>#</th>";
                echo        "<th>Item</th>";
                echo        "<th>Price</th>";
                echo        "<th>Quantity</th>";
                echo        "<th>Total Price</th>";
                echo    "</tr>";
                echo "</thead>";
                echo "<tbody>";
                $num = 1;
                foreach ($orderDetails as $detail) {
                    $itemTotal = $detail['price'] * $detail['quantity'];
                    echo "<tr>";
                    echo "<td style='text-align:center;'>" . $num . "</td>";
                    echo "<td>" . htmlspecialchars($detail['menu_name']) . "</td>";
                    echo "<td style='text-align:center;'>" . htmlspecialchars($detail['quantity']) . "</td>";
                    echo "<td style='text-align:center;'>RM " . number_format($detail['price'], 2) . "</td>";
                    echo "<td style='text-align:center;'>RM " . number_format($itemTotal, 2) . "</td>";
                    echo "</tr>";
                    $num++;
                }
            } else {
                echo "<tr><td colspan='5'>No items found in this order.</td></tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<p>Order not found.</p>";
        }

        echo "<p>DELIVERY FEE : <span class='summary-price'>RM" . number_format($deliveryFee, 2) . "</span></p>";
        echo "<p>TOTAL <span class='summary-price'>RM" . number_format($order['total_amount'], 2) . "</span></p>";

        // var_dump($order);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1F2B21;
            color: black; /* Set font color to black for the entire page */
            margin: 0;
            padding: 20px;
        }
        .receipt-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .order-details {
            margin-bottom: 20px;
        }
        .order-details h2 {
            text-align: center;
            color: #FF69B4; /* Pink color for order summary */
        }
        .summary {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
        .summary p {
            margin-bottom: 10px;
        }
        .summary-price {
            float: right;
        }

        table{
            border:1px solid black;
        }

        tr th{
            border:1px solid black;
            padding:10px;
        }

        tr td{
            border:1px solid black;
            padding:10px;
        }
        .btn {
            width: 30%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            cursor: pointer;
            text-align: center;
            display: block;
            background-color: #FFBBDC;
            color: #1F2B21;
            font-weight: bold;
            text-transform: uppercase;
        }
        .proceed-btn {
            background-color: #FFBBDC;
            color: #1F2B21;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="order-details">
            <h2>Order Receipt</h2>
            <p>Thank you, <?php echo isset($_SESSION['cust_name']) ? $_SESSION['cust_name'] : 'Customer'; ?>, for your order!</p>
            <p>Your order details:</p>
            <div class="summary">
                <h3>Order Summary</h3>
                <?php displayOrderSummary(); ?>
            </div>
            <div class="summary">
                <h3>Delivery Information</h3>
                <p>Name: <?php echo isset($_SESSION['cust_name']) ? $_SESSION['cust_name'] : 'Customer'; ?></p>
                <p>Phone Number: <?php echo isset($_SESSION['cust_phone']) ? $_SESSION['cust_phone'] : 'Not provided'; ?></p>
                <p>Address: <?php echo isset($_SESSION['cust_address']) ? $_SESSION['cust_address'] : 'Not provided'; ?></p>
                <p>Delivery Method: <?php echo isset($order['delivery_method']) ? $order['delivery_method'] : 'Not selected'; ?></p>
            </div>
            <div class="summary">
                <h3>Payment Information</h3>
                <p>Payment Method: <?php echo isset($order['payment_method']) ? $order['payment_method'] : 'Not selected'; ?></p>
                <p>Total Amount: RM<?php echo isset($order['total_amount']) ? number_format($order['total_amount'], 2) : '0.00'; ?></p>
            </div>
            <p>We will process your order shortly. Thank you for choosing us!</p>
            <center>
                <p>
                    <button type="button" class="btn proceed-btn" onclick="location.href='menu.php'">Home</button>
                </p>
            </center>
        </div>
    </div>
</body>
</html>
