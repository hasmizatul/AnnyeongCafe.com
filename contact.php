<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Annyeong Cafe</title>
    
    <style>
        body {
            font-family: "Nourd", sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
            height: 100vh;
            background-color:#FFBBDC ; /* Pink background color */
            color: #000; /* Black text for the entire page */
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
        .content {
            text-align: center;
            padding: 50px 20px;
        }
        .content h1 {
            font-size: 36px;
            font-weight: bold;
        }
        .content p {
            font-size: 18px;
            margin: 20px 0;
        }
        .contact-info {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            text-align: left;
            margin-top: 30px;
        }
        .contact-info div {
            margin: 20px;
        }
        .contact-info h3 {
            font-size: 20px;
            font-weight: bold;
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
<div class="content">
    <h1>Contact Us</h1>
    <p>
        Got a question or just want to chat? We're here for you! Reach out to us by phone, email, or social media.
        Our team at Annyeong Cafe is ready to assist you with any inquiries. Let's connect and make your visit extra special.
    </p>
    <div class="contact-info">
        <div>
            <h3>Get in Touch</h3>
            <p>Instagram</p>
            <p>Facebook</p>
            <p>Twitter</p>
        </div>
        <div>
            <h3>Email</h3>
            <p>annyeongcafe@gmail.com</p>
        </div>
        <div>
            <h3>Location</h3>
            <p>Universiti Teknologi MARA, Kampus Arau</p>
            <p>02600 Arau</p>
            <p>Perlis.</p>
        </div>
    </div>
</div>
</body>
</html>
