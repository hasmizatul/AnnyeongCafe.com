<?php
session_start(); // Start the session at the very top of the file before any HTML output
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AnnyeongCafe - Login</title>
    <style>
        /* Your CSS styles */
        body {
            font-family: "Baskerville", serif;
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
            background-color: #EBB8E6; /* Pink background color */
            border-radius: 10px;
            padding: 40px;
            max-width: 500px;
            margin: 50px auto;
            box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .container:hover {
            transform: translateY(-4px);
            box-shadow: 8px 8px 16px rgba(0, 0, 0, 0.25); 
        }
        .form-field {
            margin-bottom: 20px;
        }
        .form-field label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        .form-field input[type="email"],
        .form-field input[type="password"],
        .form-field input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
            font-size: 16px;
            color: #EBB8E6; /* Light pink text color */
        }
        .form-field input[type="email"]:focus,
        .form-field input[type="password"]:focus,
        .form-field input[type="text"]:focus {
            border-color: #00c4cc;
            outline: none;
        }
        .form-field input[type="submit"] {
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
            color: #EBB8E6; /* Light pink text color */
            padding: 10px 25px; /* Increased padding for bigger button */
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            background-color: #1F2B21; /* Black button color */
            box-shadow: 3px 3px 8px rgba(0, 0, 0, 0.4),
                        inset 1px 1px 2px rgba(255, 255, 255, 0.5),
                        inset -1px -1px 2px rgba(0, 0, 0, 0.2);
            transition: background 0.3s, box-shadow 0.3s, transform 0.3s;
            font-size: 18px; /* Increased font size */
        }
        .form-field input[type="submit"]:hover {
            background-color: #333; /* Darker shade of black on hover */
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4),
                        inset 1px 1px 2px rgba(255, 255, 255, 0.5),
                        inset -1px -1px 2px rgba(0, 0, 0, 0.2);
            transform: translateY(2px);
        }
        .form-field input[type="submit"]:active {
            box-shadow: inset 2px 2px 4px rgba(0, 0, 0, 0.4);
            transform: translateY(4px);
        }
        .error-message {
            text-align: center;
            color: red;
            margin-bottom: 10px;
        }
        .radio-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .radio-container input[type="radio"] {
            display: none;
        }
        .radio-container label {
            margin: 0 10px;
            padding: 10px 20px;
            border: 2px solid #FFB6C1; /* Light pink border */
            border-radius: 5px;
            background-color: #FFB6C1; /* Light pink background */
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }
        .radio-container input[type="radio"]:checked + label {
            background-color: #FF69B4; /* Darker pink when selected */
            color: #fff; /* White text when selected */
        }
    </style>
    <script>
        function toggleInputFields() {
            const customerRadio = document.getElementById('customer');
            const emailField = document.getElementById('email-field');
            const staffIDField = document.getElementById('staff-id-field');
            
            if (customerRadio.checked) {
                emailField.style.display = 'block';
                staffIDField.style.display = 'none';
            } else {
                emailField.style.display = 'none';
                staffIDField.style.display = 'block';
            }
        }

        window.onload = function() {
            toggleInputFields(); // Ensure correct initial state on page load
        };
    </script>
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
    </div>
</header>

<div class="dark-overlay"></div>
<div class="container">
    <h2 style="text-align: center; color: #1F2B21;">LOGIN</h2>
    
    <?php
    // Display success message if it exists
    if (isset($_SESSION["success_message"])) {
        echo '<div style="text-align: center; color: green;">' . $_SESSION["success_message"] . '</div>';
        unset($_SESSION["success_message"]); // Clear the session variable after displaying
    }
    // Display error message if it exists
    if (isset($_SESSION["error_message"])) {
        echo '<div class="error-message">' . $_SESSION["error_message"] . '</div>';
        unset($_SESSION["error_message"]); // Clear the session variable after displaying
    }
    ?>
    
    <form name="form" method="post" action="login0.php"> <!-- Action points to login0.php -->
        <div class="radio-container">
            <input type="radio" name="user_type" id="customer" value="customer" onclick="toggleInputFields()" checked>
            <label for="customer">Customer</label>
            <input type="radio" name="user_type" id="staff" value="staff" onclick="toggleInputFields()">
            <label for="staff">Staff</label>
        </div>
        <div class="form-field" id="email-field">
            <label for="email">EMAIL</label>
            <input type="email" name="email" id="email">
        </div>
        <div class="form-field" id="staff-id-field" style="display: none;">
            <label for="staff_id">Staff ID</label>
            <input type="text" name="staff_id" id="staff_id">
        </div>
        <div class="form-field">
            <label for="password">PASSWORD</label>
            <input type="password" name="staff_password" id="password" required>

        </div>
        <div class="form-field">
            <input type="submit" name="login" value="LOGIN"> <!-- Added name attribute for submit button -->
        </div>
    </form>
</div>

</body>
</html>
