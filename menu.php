<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Page</title>
    <style>
        body {
            font-family: "Nourd", sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
            height: 100vh;
            color: #000; /* Black text for the entire page */
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
            bottom: 20px; /* Adjust this value to control the distance from the bottom */
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
            color: #000; /* Black text color */
            padding: 10px 30px;
            margin: 0 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #FFB6C1; /* Light pink button color */
            font-size: 16px; /* Set font size to 16px */
            transition: background-color 0.3s, color 0.3s, box-shadow 0.3s, transform 0.3s;
        }
        .menu a:hover {
            background: #FF69B4; /* Darker pink on hover */
            color: #fff; /* White text on hover */
        }
        .menu a:active {
            box-shadow: inset 2px 2px 4px rgba(0, 0, 0, 0.4);
            transform: translateY(4px);
        }
        header {
            background-color: #1F2B21; /* Dark green background */
            color: #FFBBDC; /* Light pink text */
            padding: 20px 70px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: center; /* Center-align text and buttons */
        }
        .left-buttons,
        .right-buttons {
            flex: 1; /* Takes up as much space as available */
            display: flex;
            justify-content: center; /* Center-align buttons */
        }
        .center-space {
            flex: 3; /* Takes up more space in the center */
            text-align: center; /* Center-align text in this space */
        }
        button {
            background-color: transparent;
            border: none;
            color: #EBB8E6; /* Light pink text */
            font-family: 'Times New Roman', sans-serif;
            font-size: 20px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 0 5px;
        }
        button:hover {
            background-color: #1F2B21; /* Darker green on hover */
            color: #fff; 
        }
        .container {
            padding: 10px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .menu-item {
            width: 48%;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent background for better readability */
        }
        .menu-item img {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        .menu-item div {
            flex: 1;
            padding: 0 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .menu-item button {
            background-color: #333;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            align-self: flex-start;
        }
        .menu-item button:hover {
            background-color: #555;
        }
        .show-more {
            display: block;
            width: 100%;
            text-align: center;
            margin: 20px 0;
        }
        .show-more button {
            background-color: #FFB6C1;
            color: white;
            padding: 10px 30px;
            border: none;
            cursor: pointer;
        }
        .show-more button:hover {
            background-color: #ff4f7f;
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
        <?php
            if(isset($_SESSION['cust_id']) && $_SESSION['cust_id'] !== null){
        ?>
            <button onclick="location.href='logout.php'" style="margin-left: 10px;">Logout</button>
        <?php
            }
        ?>
    </div>
</header>

<?php

    require_once 'dbconn.php';

?>


<div class="container">
    
    <?php 
        $sql = "SELECT * FROM `menu_category`";
        $res = mysqli_query($conn, $sql);
        if(mysqli_num_rows($res) > 0){
            while($data = mysqli_fetch_array($res)){
    ?>
        <div class="menu-item">
            <img src="<?= $data['menu_image'] ?>" alt="<?= $data['menu_name'] ?>">
            <div>
                <h2><?= $data['menu_name'] ?></h2>
                <p>RM <?= $data['menu_price'] ?></p>
                <button class="add-to-cart" data-item="<?= $data['menu_name'] ?>" data-price="<?= $data['menu_price'] ?>" data-menu-id="<?= $data['menu_id'] ?>">ADD TO CART</button>
            </div>
        </div>
    <?php
        }
    } else {
        echo '<div class="menu-item"><div>No Menu Recorded</div></div>';
    }
    ?>
    <!-- <div class="menu-item">
        <img src="tteokbokki.jpg" alt="Tteokbokki">
        <div>
            <h2>TTEOKBOKKI</h2>
            <p>RM16.90</p>
            <button class="add-to-cart" data-item="TTEOKBOKKI" data-price="16.90" data-menu-id="1">ADD TO CART</button>
        </div>
    </div>
    <div class="menu-item">
        <img src="seafood_ramyeon.jpg" alt="Seafood Ramyeon">
        <div>
            <h2>SEAFOOD RAMYEON</h2>
            <p>RM25.00</p>
            <button class="add-to-cart" data-item="SEAFOOD RAMYEON" data-price="25.00" data-menu-id="2">ADD TO CART</button>
        </div>
    </div>
    <div class="menu-item">
        <img src="jajang.jpg" alt="Jajangmyeon">
        <div>
            <h2>JAJANGMYEON</h2>
            <p>RM18.90</p>
            <button class="add-to-cart" data-item="JAJANGMYEON" data-price="18.90" data-menu-id="3">ADD TO CART</button>
        </div>
    </div>
    <div class="menu-item">
        <img src="latte.jpg" alt="Iced Matcha Latte">
        <div>
            <h2>ICED MATCHA LATTE</h2>
            <p>RM8.50</p>
            <button class="add-to-cart" data-item="ICED MATCHA LATTE" data-price="8.50" data-menu-id="4">ADD TO CART</button>
        </div>
    </div>
    <div class="menu-item">
        <img src="ice_choco.jpg" alt="Iced Chocolate">
        <div>
            <h2>ICED CHOCOLATE</h2>
            <p>RM7.00</p>
            <button class="add-to-cart" data-item="ICED CHOCOLATE" data-price="7.00" data-menu-id="5">ADD TO CART</button>
        </div>
    </div>
    <div class="menu-item">
        <img src="iced_cofee.jpg" alt="Iced Coffee">
        <div>
            <h2>ICED COFFEE</h2>
            <p>RM7.00</p>
            <button class="add-to-cart" data-item="ICED COFFEE" data-price="7.00" data-menu-id="6">ADD TO CART</button>
        </div>
    </div> -->
    
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                let itemName = button.getAttribute('data-item');
                let itemPrice = parseFloat(button.getAttribute('data-price'));
                let menuId = button.getAttribute('data-menu-id'); // Fetch menu_id from data attribute
                addToCart(itemName, itemPrice, menuId);
            });
        });

        function addToCart(item, price, menuId) {
            fetch('cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=add&item=${encodeURIComponent(item)}&price=${encodeURIComponent(price)}&menu_id=${encodeURIComponent(menuId)}`, // Pass menu_id in the body
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                alert('Item added to cart: ' + item); // Display success message or handle response
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to add item to cart');
            });
        }
    });
</script>


</body>
</html>