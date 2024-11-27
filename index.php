<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Register</title>
    
    <style>
        body {
            font-family: "Nourd", sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
            height: 100vh;
            background-image: url('korean.jpg'); /* Replace with your background image URL */
            background-size: cover; /* Cover the entire page */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Do not repeat the image */
            background-attachment: fixed; /* Fix the background image */
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
            font-family:'Times New Roman', sans-serif;
            font-size: 20px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 0 5px;
        }
        button:hover {
            background-color:#1F2B217; /* Darker green on hover */
            color: #fff; 
        }
        .anny {
            font-family: 'Noto serif KR', serif;
            font-size: 110px;
            color: pink;
            text-align: center;
            margin-top: 20px; /* Adjust the distance from the header */
        }
        .welcome-text {
            font-family: Arial, sans-serif;
            font-size: 24px;
            text-align: center;
           /* Adjust the distance from the Annyeong Cafe text */
            color: #fff; /* White text color */
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
        </div>
    </header>
    <div class="anny">
            <p>Annyeong Cafe</p>
    </div>
    <div class="welcome-text">
        <p>Bringing the warmth of Korean hospitality and the joy of authentic flavors to your table. </p>
        <p> Welcome to your new favorite spot!</p>
    </div>
    <div class="dark-overlay"></div>
    <div class="button-container">
        <div class="menu">
            <a href="register.php">SIGN UP</a>
            <a href="login.php">LOG IN</a>
        </div>
    </div>

</body>
</html>
