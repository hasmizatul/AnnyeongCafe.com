<?php
session_start();

// Debugging session variable
//var_dump($_SESSION['cust_id']); // Check if this outputs the expected user_id

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "annyeongcafe";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user_id is set in session
if (isset($_SESSION['cust_id'])) {
    $user_id = $_SESSION['cust_id'];

    // Query to fetch customer details
    $sql = "SELECT name, email, phonenum, address, password FROM customer WHERE cust_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($name, $email, $phonenum, $address, $stored_password);

    // Fetch the results
    if ($stmt->fetch()) {
        // Customer details fetched successfully
    } else {
        echo "Customer not found.";
    }

    $stmt->close();
} else {
    echo "Session cust_id is not set.";
}

// Handle password form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_password = $_POST['password'];

    // Verify entered password with stored password
    if ($entered_password === $stored_password) {
        // Password is correct, proceed to display customer details
        $password_correct = true;
    } else {
        // Password is incorrect, show error message
        $password_error = "Incorrect password.";
    }
}

$conn->close();
?>









<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <style>
        /* CSS styles for your account page */
        body {
            font-family: Arial, sans-serif;
            background-color: #FFB6C1; /* Light pink background */
            color: #000; /* Black text */
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #FFF; /* White background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            color: #FF69B4; /* Pink heading color */
            text-align: center;
        }
        .details {
            margin-top: 20px;
        }
        .details p {
            margin-bottom: 10px;
        }
        .edit-profile-button {
            text-align: center;
            margin-top: 20px;
        }
        .edit-profile-button button {
            background-color: #FF69B4; /* Pink button background */
            color: #FFF; /* White button text */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .edit-profile-button button:hover {
            background-color: #ff4f7f; /* Darker pink on hover */
        }
        .password-form {
            text-align: center;
            margin-top: 20px;
        }
        .password-form input[type="password"] {
            padding: 10px;
            font-size: 16px;
        }
        .password-form button {
            background-color: #FF69B4; /* Pink button background */
            color: #FFF; /* White button text */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-left: 10px;
        }
        .password-form button:hover {
            background-color: #ff4f7f; /* Darker pink on hover */
        }
    </style>
</head>
<body>
    



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>
    <style>
        /* CSS styles for your account page */
        body {
            font-family: Arial, sans-serif;
            background-color: #FFB6C1; /* Light pink background */
            color: #000; /* Black text */
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #FFF; /* White background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            color: #FF69B4; /* Pink heading color */
            text-align: center;
        }
        .details {
            margin-top: 20px;
        }
        .details p {
            margin-bottom: 10px;
        }
        .edit-profile-button {
            text-align: center;
            margin-top: 20px;
        }
        .edit-profile-button button {
            background-color: #FF69B4; /* Pink button background */
            color: #FFF; /* White button text */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .edit-profile-button button:hover {
            background-color: #ff4f7f; /* Darker pink on hover */
        }
        /* Styles from menu.php for menu bar */
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
            background-color: #1F2B217; /* Darker green on hover */
            color: #fff; /* White text on hover */
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
</header>







<div class="container">
    <h2>My Account</h2>
    
    <?php if (isset($name) && isset($password_correct) && $password_correct): ?>
        <div class="details">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($phonenum); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
        </div>
        <div class="edit-profile-button">
            <button onclick="location.href='edit_profile.php'">Edit Profile</button>
        </div>
    <?php elseif (isset($name) && !isset($password_correct)): ?>
        <div class="password-form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="password" name="password" placeholder="Enter your password">
                <button type="submit">Submit</button>
            </form>
            <?php if (isset($password_error)): ?>
                <p style="color: red;"><?php echo $password_error; ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
