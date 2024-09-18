<?php
session_start();

// Handle cart actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $item = $_POST['item'];
    $price = $_POST['price'];
    $item_id = $_POST['menu_id'];
    

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    switch ($action) {
        case 'add':
            if (isset($_SESSION['cart'][$item])) {
                $_SESSION['cart'][$item]['quantity']++;
            } else {
                $_SESSION['cart'][$item]['item_id'] = $item_id;
                $_SESSION['cart'][$item] = ['price' => $price, 'quantity' => 1, 'item_id' => $item_id];
            }
            echo "<script>alert('Item added to cart: $item'); window.location.href = window.location.href;</script>";
            break;
        case 'remove':
            if (isset($_SESSION['cart'][$item])) {
                if ($_SESSION['cart'][$item]['quantity'] > 1) {
                    $_SESSION['cart'][$item]['quantity']--;
                } else {
                    unset($_SESSION['cart'][$item]);
                }
            }
            echo "<script>alert('Item removed from cart: $item'); window.location.href = window.location.href;</script>";
            break;
        case 'update':
            $quantity = $_POST['quantity'];
            if ($quantity > 0) {
                $_SESSION['cart'][$item]['quantity'] = $quantity;
            } else {
                unset($_SESSION['cart'][$item]);
            }
            echo "<script>alert('Cart Updated'); window.location.href = window.location.href;</script>";
            break;
        default:
            echo "Invalid action";
            break;
    }
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffe4e1;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #1F2B21;
            padding: 30px 20px;
            font-family: 'Times New Roman', sans-serif;
            font-size: 18px;
        }
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        nav ul.left-menu {
            justify-content: flex-start;
        }
        nav ul.right-menu {
            justify-content: flex-end;
        }
        nav ul li {
            margin: 0 20px;
        }
        nav ul li a {
            color: #FFBBDC;
            text-decoration: none;
            font-weight: bold;
        }
        .cart-container {
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .cart-content {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .order-item-container {
            flex: 65%; /* Adjusted width for better balance */
        }
        .order-item, .order-summary {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%; /* Ensure full width */
            margin-bottom: 20px; /* Add space between items */
        }
        .order-item {
        background-color: white;
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 10px 30px;
        display: flex;
        align-items: center;

        }
        .item-details {
         flex: 1;
        display: flex;
        flex-direction: column;
        }
        .item-name {
            font-size: 24px; /* Larger font size for item name */
            font-weight: bold;
            margin-bottom: 10px;
        }
        .item-qty {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .qty-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            margin: 0 5px;
        }
        .item-price {
            font-size: 20px; /* Larger font size for item price */
            margin-top: 10px;
        }
        .order-summary {
            width: 35%;
        }
        .order-summary h2 {
            text-align: center;
        }
        .summary-price {
            float: right;
        }
        .add-more-btn, .checkout-btn {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            cursor: pointer;
        }
        .add-more-btn {
            background-color: #f0ad4e;
            color: white;
        }
        .checkout-btn {
            background-color: #5cb85c;
            color: white;
        }
    </style>
</head>
<body>
<header>
    <nav>
        <ul class="left-menu">
            <li><a href="home.php">Home</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="contact.php">Contact Us</a></li>
        </ul>
        <ul class="right-menu">
            <li><a href="cart.php">View Cart</a></li>
            <li><a href="account.php">My Account</a></li>
            <?php
                if(isset($_SESSION['cust_id']) && $_SESSION['cust_id'] !== null){
            ?>
                <li><a href="logout.php" style="margin-left: 10px;">Logout</a></li>
            <?php
                }
            ?>
        </ul>
    </nav>
</header>

<div class="cart-container">
    <h1>MY CART</h1>
    <div class="cart-content">
        <div class="order-item-container">
            <?php displayCartItems(); ?>
        </div>
        <div class="order-summary">
            <h2>ORDER SUMMARY</h2>
            <?php displayOrderSummary(); ?>
            <form method="post" action="menu.php">
                <button type="submit" class="add-more-btn">ADD MORE ITEMS</button>
            </form>
            <form method="post" action="checkout.php">
                <button type="submit" class="checkout-btn">CHECKOUT</button>
            </form>
        </div>
    </div>
</div>

<?php
function displayCartItems() {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item => $details) {
            echo "
            <div class='order-item'>
                <div class='item-details'>
                    <span class='item-name'>$item</span>
                    <span class='item-qty'>
                        <form method='post' action='cart.php' style='display: inline-block;'>
                            <input type='hidden' name='item' value='$item'>
                            <input type='hidden' name='price' value='{$details['price']}'>
                            <input type='hidden' name='action' value='remove'>
                            <button type='submit' class='qty-btn'>-</button>
                        </form>
                        <span id='quantity'>{$details['quantity']}</span>
                        <form method='post' action='cart.php' style='display: inline-block;'>
                            <input type='hidden' name='item' value='$item'>
                            <input type='hidden' name='price' value='{$details['price']}'>
                            <input type='hidden' name='action' value='add'>
                            <button type='submit' class='qty-btn'>+</button>
                        </form>
                    </span>
                    <span class='item-price'>RM" . number_format($details['price'] * $details['quantity'], 2) . "</span>
                </div>
            </div>";
        }
    } else {
        echo "<p>Your cart is empty.</p>";
    }
}

function displayOrderSummary() {
    $total = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item => $details) {
            $total += $details['price'] * $details['quantity'];
            echo "<p>{$details['quantity']}x $item <span class='summary-price'>RM" . number_format($details['price'] * $details['quantity'], 2) . "</span></p>";
        }
        echo "<p>TOTAL <span class='summary-price'>RM" . number_format($total, 2) . "</span></p>";
    } else {
        echo "<p>Your cart is empty.</p>";
    }
}

?>

</body>
</html>
