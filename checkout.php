<?php
session_start();
require_once 'dbconn.php';

date_default_timezone_set('Asia/Kuala_Lumpur');

if (!isset($_SESSION['cust_id'])) {
    // Redirect to the registration page if user data is not available
    header('Location: register.php');
    exit;
}

// Handle form submissions for updating customer info
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['updateInfo'])) {
        $_SESSION['cust_name'] = $_POST['name'];
        $_SESSION['cust_phone'] = $_POST['phone'];
        $_SESSION['cust_address'] = $_POST['address'];

        $cust_id = $_SESSION['cust_id'];
        $cust_name = $_SESSION['cust_name'];
        $cust_phone = $_SESSION['cust_phone'];
        $cust_address = $_SESSION['cust_address'];

        $sql = "UPDATE `customer` SET `name` = '$cust_name', `address` = '$cust_address', `phonenum` = '$cust_phone' WHERE `cust_id` = '$cust_id'";

        if(mysqli_query($conn, $sql)){
            echo "<script> alert('Information Successfully Updated')</script>";
            echo "<script> window.location.href = window.location.href;</script>";
        } else {
            echo "<script> alert('Information not Updated')</script>";
        }

    }

    if (isset($_POST['completeOrder'])) {

        $_SESSION['delivery'] = isset($_POST['delivery']) ? $_POST['delivery'] : ''; // Store delivery method in session
        $_SESSION['payment'] = isset($_POST['payment']) ? $_POST['payment'] : ''; // Store payment method in session

        $_SESSION['delivery_fee'] = $_POST['new_delivery_fee'];
        $_SESSION['total'] = $_POST['new_total'];
        
        // Insert order into database
        $customerId = $_SESSION['cust_id']; // Assuming customer_id is stored in session
        $orderDate = date('Y-m-d H:i:s'); // Current date and time
        $paymentMethod = $_SESSION['payment'];
        $deliveryMethod = $_SESSION['delivery'];
        $deliveryAddress = $_SESSION['cust_address'];
        $customerPhone = $_SESSION['cust_phone'];
        $totalAmount = $_SESSION['total'];
        $orderStatus = 'Ordered';
        $deliveryFee = $_SESSION['delivery_fee'];

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO `order` (cust_id, order_date, payment_method, delivery_method, delivery_address, customer_phone, total_amount, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssssss", $customerId, $orderDate, $paymentMethod, $deliveryMethod, $deliveryAddress, $customerPhone, $totalAmount, $orderStatus);

        // Execute the statement
        if ($stmt->execute()) {
            $orderId = $stmt->insert_id; // Get the inserted order_id
            // Insert order details into order_items table
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $item => $details) {
                    $itemName = $item;
                    $itemID = $details['item_id'];
                    $itemPrice = $details['price'];
                    $itemQuantity = $details['quantity'];

                    // Prepare SQL statement for order items
                    $stmtItems = $conn->prepare("INSERT INTO order_details (order_id, menu_id, menu_name, price, quantity) VALUES (?, ?, ?, ?, ?)");
                    $stmtItems->bind_param("iisdi", $orderId, $itemID, $itemName, $itemPrice, $itemQuantity);

                    // Execute the statement for order items
                    $stmtItems->execute();
                }
            }

            // Clear the cart after successful order placement
            unset($_SESSION['cart']);

            $message = "Cart Successfully Checkout !";
            // Redirect to receipt page after processing form data
            echo "<script>
                alert('$message');
                window.location.href = 'receipt.php?order_id=' + encodeURIComponent('$orderId');
            </script>";

            exit;
        } else {
            echo "Error: " . $conn->error;
        }

        // Close statement
        $stmt->close();
        $conn->close();
    }

}


function displayOrderSummary() {
    $total = 0;
    $deliveryFee = 0;

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item => $details) {
            $total += $details['price'] * $details['quantity'];
        }
    }

    // if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['completeOrder'])) {
    //     if ($_POST['delivery'] === 'delivery') {
    //         $deliveryFee = 2.00; // Adjust delivery fee as needed
    //     }
    //     $_SESSION['delivery'] = $_POST['delivery']; // Store delivery method in session
    //     $_SESSION['payment'] = $_POST['payment']; // Store payment method in session
    // }

    // $total += $deliveryFee;

    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
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
        foreach($_SESSION['cart'] as $item => $display){
            $total_price = 0;
            $total_price = $display['price'] * $display['quantity'];

            echo "<tr>";
            echo    "<td style='text-align:center;'>".$num."</td>";
            echo    "<td>".$item."</td>";
            echo    "<td style='text-align:center;'>RM ".number_format($display['price'], 2)."</td>";
            echo    "<td style='text-align:center;'>".$display['quantity']."</td>";
            echo    "<td style='text-align:center;'>RM ".number_format($total_price, 2)."</td>";
            echo "</tr>";
            $num++;
        }
        echo "</tbody>";
        echo "</table>";
    }
    echo "<p>DELIVERY FEE : <span class='summary-price' id='deliveryFee'>RM" . number_format($deliveryFee, 2) . "</span></p>";
    echo "<p>TOTAL <span class='summary-price' id='total' data-base-total='".number_format($total, 2)."'>RM" . number_format($total, 2) . "</span></p>";

    $_SESSION['total'] = $total;
    $_SESSION['delivery_fee'] = $deliveryFee;
    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white; /* Changed background color to white */
            margin: 0;
            padding: 0;
            color: #FFBBDC;
        }
        .dark-overlay {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }
        .button-container {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            z-index: 1;
        }
        .menu {
            display: flex;
            justify-content: center;
        }
        .menu a {
            text-decoration: none;
            color: #000;
            padding: 10px 30px;
            margin: 0 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #FFB6C1;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s, box-shadow 0.3s, transform 0.3s;
        }
        .menu a:hover {
            background: #FF69B4;
            color: #fff;
        }
        .menu a:active {
            box-shadow: inset 2px 2px 4px rgba(0, 0, 0, 0.4);
            transform: translateY(4px);
        }
        header {
            background-color: #1F2B21;
            color: #FFBBDC;
            padding: 20px 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: center;
        }
        .left-buttons,
        .right-buttons {
            flex: 1;
            display: flex;
            justify-content: center;
        }
        .center-space {
            flex: 3;
            text-align: center;
        }
        .right-buttons {
            flex: 1;
            display: flex;
            justify-content: center;
        }
        .center-space {
            flex: 3;
            text-align: center;
        }
        button {
            background-color: transparent;
            border: none;
            color: #EBB8E6;
            font-family: 'Nourd', sans-serif;
            font-size: 16px;
            cursor: pointer;
            padding: 10px 12px;
            margin: 0 5px;
        }
        button:hover {
            background-color: #2E8B57;
            color: #fff;
        }
        .checkout-container {
            padding: 20px;
            max-width: 800px;
            margin: 20px auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #FFBBDC;
        }
        .customer-details, .order-summary, .complete-order {
            background-color: white;
            color: #1F2B21;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .customer-details h2, .order-summary h2, .complete-order h2 {
            text-align: center;
        }
        .customer-info, .payment-method, .delivery-method {
            margin: 10px 0;
        }
        .summary-price {
            float: right;
        }
        .btn {
            width: 100%;
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
        .edit-btn, .summary-btn, .proceed-btn {
            background-color: #FFBBDC;
            color: #1F2B21;
        }
        .radio-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .radio-group label {
            flex: 1;
            text-align: center;
            cursor: pointer; /* Added cursor style for better usability */
        }
        .radio-group input {
            margin: 0 10px;
            accent-color: #FFBBDC;
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

    </style>
</head>
<body>
    <header>
        <div class="left-buttons">
            <button onclick="location.href='home.php'">Home</button>
            <button onclick="location.href='menu.php'">Menu</button>
            <button onclick="location.href='contact.php'">Contact Us</button>
        </div>
        <div class="center-space">
            <!-- Empty space in the center -->
        </div>
        <div class="right-buttons">
            <button onclick="location.href='cart.php'">View Cart</button>
            <button onclick="location.href='account.php'">My Account</button>
            <button onclick="location.href='logout.php'">Logout</button>
        </div>
    </header>

    <div class="dark-overlay"></div>
    <div class="checkout-container">
        <h1>CHECKOUT</h1>
        <div class="customer-details">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="customer-info">
                    <p>NAME : 
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['cust_name']); ?>" readonly>
                    </p>
                    <p>PHONE NUMBER : 
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($_SESSION['cust_phone']); ?>" readonly>
                    </p>
                    <p>ADDRESS : 
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($_SESSION['cust_address']); ?>" readonly>
                    </p>
                    <button type="button" class="btn edit-btn" onclick="toggleEdit()">EDIT</button>
                </div>
                <button type="submit" name="updateInfo" id="updateInfo" class="btn" style="display:none;">UPDATE INFO</button>
            </form>
        </div>

        <button class="btn summary-btn" onclick="toggleDisplay('order-summary')">VIEW ORDER SUMMARY</button>
        <div id="order-summary" class="order-summary" style="display:none;">
            <h2>ORDER SUMMARY</h2>
            <?php displayOrderSummary(); ?>
        </div>

        <div class="complete-order">
            <h2>COMPLETE MY ORDER</h2>
            <form method="post" action="checkout.php">
                <div class="payment-method">
                    <h3>CHOOSE PAYMENT METHOD</h3>
                    <div class="radio-group">
                        <label><input type="radio" name="payment" value="debit" required>
                        DEBIT / CREDIT CARD</label>
                        <label><input type="radio" name="payment" value="online"> ONLINE PAYMENT</label>
                        <label><input type="radio" name="payment" value="cod"> CASH ON DELIVERY</label>
                        <input type="text" name="new_total" id="new_total" value="<?php echo number_format($_SESSION['total'],2); ?>" hidden>
                        <input type="text" name="new_delivery_fee" id="new_delivery_fee" value="<?php echo number_format($_SESSION['delivery_fee'],2); ?>" hidden>
                    </div>
                </div>
                <div class="delivery-method">
                    <h3>DELIVERY METHOD</h3>
                    <div class="radio-group">
                        <label><input type="radio" class="transport" name="delivery" value="delivery" required> DELIVERY</label>
                        <label><input type="radio" class="transport" name="delivery" value="pickup"> PICKUP</label>
                    </div>
                </div>
                <button type="submit" name="completeOrder" class="btn proceed-btn">COMPLETE ORDER</button>
            </form>
        </div>
    </div>

    <script>
        // JavaScript to toggle edit mode for customer info
        function toggleEdit() {
            var inputs = document.querySelectorAll('.customer-info input');
            var editBtn = document.querySelector('.edit-btn');
            var updateBtn = document.querySelector('#updateInfo');

            inputs.forEach(function(input) {
                input.readOnly = !input.readOnly;
            });

            editBtn.style.display = editBtn.style.display === 'none' ? 'block' : 'none';
            updateBtn.style.display = updateBtn.style.display === 'none' ? 'block' : 'none';
        }

        // JavaScript to toggle visibility of order summary
        function toggleDisplay(elementId) {
            var element = document.getElementById(elementId);
            element.style.display = (element.style.display === 'block') ? 'none' : 'block';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const deliveryRadios = document.querySelectorAll('.transport');
            const deliveryFeeElement = document.getElementById('deliveryFee');
            const totalElement = document.getElementById('total');
            const newtotalElement = document.getElementById('new_total');
            const newdeliveryElement = document.getElementById('new_delivery_fee');

            deliveryRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    let deliveryFee = 0;
                    let total = parseFloat(totalElement.dataset.baseTotal); // Get the base total from data attribute

                    if (this.value === 'delivery') {
                        deliveryFee = 2.00; // Adjust delivery fee as needed
                    }

                    total += deliveryFee;

                    deliveryFeeElement.textContent = "RM " + deliveryFee.toFixed(2);
                    totalElement.textContent = "RM " + total.toFixed(2);
                    newtotalElement.value  = total.toFixed(2);
                    newdeliveryElement.value  = deliveryFee.toFixed(2);
                });
            });
        });
    </script>
</body>
</html>
