<?php
session_start();

// Check if cart is set in session
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    echo "<h2>Shopping Cart</h2>";
    echo "<ul>";
    foreach ($_SESSION['cart'] as $productId) {
        echo "<li>Product ID: $productId</li>"; // You can fetch product details from a database based on $productId
    }
    echo "</ul>";
} else {
    echo "<p>Your cart is empty.</p>";
}
?>