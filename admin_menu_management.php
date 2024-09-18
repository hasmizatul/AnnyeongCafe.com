<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu Management</title>
    <style>
        body {
            font-family: "Baskerville", serif;
            margin: 0;
            padding: 0;
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
            font-family:'Times New Roman', sans-serif;
            font-size: 20px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 0 5px;
        }
        button:hover {
            background-color: #1F2B217; /* Darker green on hover */
            color: #fff; 
        }
        .container {
            padding: 20px;
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

        .admin-form {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent background */
        }
        .admin-form label {
            display: block;
            margin-bottom: 10px;
        }
        .admin-form input,
        .admin-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
        }
        .admin-form button {
            padding: 10px 20px;
            background-color: #FFB6C1;
            border: none;
            cursor: pointer;
        }
        .admin-form button:hover {
            background-color: #ff4f7f;
        }
        .header {
            background-color: #1F2B21;
            padding: 20px;
            text-align: center;
        }
        .header nav a {
            color: #ffffff;
            margin: 0 15px;
            text-decoration: none;
            font-size: 18px;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>

<?php

    require_once 'dbconn.php';

?>

    <div class="header">
        <nav>
            <a href="adminprofile.php">HOME</a>
            <!-- <a href="admin_menu_management.php">MENU</a> -->
            <a href="customerorders.php">ORDER</a>
            <a href="logout.php">LOGOUT</a>
        </nav>
    </div>
    
    <div class="container" id="menu-container">
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
                    <button class="remove-menu" data-item="<?= $data['menu_name'] ?>" data-price="<?= $data['menu_price'] ?>" data-menu-id="<?= $data['menu_id'] ?>">REMOVE</button>
                </div>
            </div>
        <?php
            }
        } else {
            echo '<div class="menu-item"><div>No Menu Recorded</div></div>';
        }
        ?>
    </div>
    
    <div class="admin-form">
        <form action="">
            <h3>Add or Update Menu Item</h3>
            <label for="item-id">Menu ID:</label>
            <input type="text" id="item-id">
            <label for="item-name">Name:</label>
            <input type="text" id="item-name">
            <label for="item-price">Price:</label>
            <input type="text" id="item-price">
            <label for="item-image">Image URL:</label>
            <input type="text" id="item-image">
            <button type="submit" name="addOrUpdateItem">Add/Update Item</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartButtons = document.querySelectorAll('.remove-menu');
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
        // let menuItems = [
        //     { id: 1, name: "TTEOKBOKKI", price: "RM16.90", image: "tteokbokki.jpg" },
        //     { id: 2, name: "SEAFOOD RAMYEON", price: "RM25.00", image: "seafood ramyeon.jpg" },
        //     { id: 3, name: "JAJANGMYEON", price: "RM18.90", image: "jajang.jpg" },
        //     { id: 4, name: "ICED MATCHA LATTE", price: "RM8.50", image: "matcha latte.jpg" },
        //     { id: 5, name: "ICED CHOCOLATE", price: "RM7.00", image: "ice chcoco.jpg" },
        //     { id: 6, name: "ICED COFFEE", price: "RM7.00", image: "iced cofee.jpg" }
        // ];

        // function renderMenu() {
        //     const container = document.getElementById('menu-container');
        //     container.innerHTML = '';
        //     menuItems.forEach(item => {
        //         const menuItem = document.createElement('div');
        //         menuItem.classList.add('menu-item');
        //         menuItem.innerHTML = `
        //             <img src="${item.image}" alt="${item.name}">
        //             <div>
        //                 <h2>${item.name}</h2>
        //                 <p>${item.price}</p>
        //                 <button onclick="removeItem(${item.id})">REMOVE</button>
        //             </div>
        //         `;
        //         container.appendChild(menuItem);
        //     });
        // }

        // function addOrUpdateItem() {
        //     const id = document.getElementById('item-id').value;
        //     const name = document.getElementById('item-name').value;
        //     const price = document.getElementById('item-price').value;
        //     const image = document.getElementById('item-image').value;

        //     if (name && price && image) {
        //         if (id) {
        //             const itemIndex = menuItems.findIndex(item => item.id === parseInt(id));
        //             if (itemIndex !== -1) {
        //                 menuItems[itemIndex] = { id: parseInt(id), name, price, image };
        //             } else {
        //                 alert('Item ID not found.');
        //             }
        //         } else {
        //             const newId = menuItems.length ? menuItems[menuItems.length - 1].id + 1 : 1;
        //             menuItems.push({ id: newId, name, price, image });
        //         }
        //         renderMenu();
        //         clearForm();
        //     } else {
        //         alert('Please fill in all fields.');
        //     }
        // }

        // function removeItem(id) {
        //     menuItems = menuItems.filter(item => item.id !== id);
        //     renderMenu();
        // }

        // function clearForm() {
        //     document.getElementById('item-id').value = '';
        //     document.getElementById('item-name').value = '';
        //     document.getElementById('item-price').value = '';
        //     document.getElementById('item-image').value = '';
        // }

        // // Initialize the menu on page load
        // document.addEventListener('DOMContentLoaded', renderMenu);
    </script>
</body>
</html>
