<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AnnyeongCafe</title>
    <?php include 'dbconn.php'; ?>
    
    <style>
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
        .form-field input[type="text"],
        .form-field input[type="password"],
        .form-field input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
            font-size: 16px;
            color: #EBB8E6; /* Light pink text color */
        }
        .form-field input[type="text"]:focus,
        .form-field input[type="password"]:focus,
        .form-field input[type="email"]:focus {
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
    
    <div class="dark-overlay"></div>
    <div class="container">
        <h2 style="text-align: center; color: #1F2B21;">CREATE AN ACCOUNT</h2>
        <form name="form" method="post" action="register0.php"> <!-- Changed action to register0.php -->
            <div class="form-field">
                <label for="name">NAME</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-field">
                <label for="email">EMAIL</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-field">
                <label for="address">ADDRESS</label>
                <input type="text" name="address" id="address" required>
            </div>
            <div class="form-field">
                <label for="phonenum">PHONE NUMBER</label>
                <input type="text" name="phonenum" id="phonenum" required>
            </div>
            <div class="form-field">
                <label for="password">PASSWORD</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-field">
                <input type="submit" value="REGISTER">
            </div>
        </form>
    </div>

</body>
</html>

