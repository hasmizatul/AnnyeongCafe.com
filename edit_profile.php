<?php
session_start();

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

// Initialize variables
$name = $email = $phonenum = $address = "";
$update_success = false;

// Check if user_id is set in session
if (isset($_SESSION['cust_id'])) {
    $user_id = $_SESSION['cust_id'];

    // Query to fetch customer details
    $sql = "SELECT name, email, phonenum, address FROM customer WHERE cust_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($name, $email, $phonenum, $address);

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

// Handle form submission to update profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phonenum = $_POST['phonenum'];
    $address = $_POST['address'];

    // Update query
    $sql_update = "UPDATE customer SET name = ?, email = ?, phonenum = ?, address = ? WHERE cust_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssi", $name, $email, $phonenum, $address, $user_id);

    if ($stmt_update->execute()) {
        $update_success = true;
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $stmt_update->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        /* CSS styles for edit profile page */
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
        form {
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea {
            width: calc(100% - 12px);
            padding: 10px;
            margin-bottom: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #FF69B4; /* Pink button background */
            color: #FFF; /* White button text */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #ff4f7f; /* Darker pink on hover */
        }
        .back-button {
            text-align: right;
            margin-top: 20px;
        }
        .back-button button {
            background-color: #1F2B21; /* Dark green background */
            color: #FFBBDC; /* Light pink text */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .back-button button:hover {
            background-color: #1c291e; /* Darker green on hover */
        }

        /* Adjusted styles for buttons */
        input[type="submit"] {
            background-color: #FF69B4; /* Pink button background */
        }
        .back-button button {
            background-color: #1F2B21; /* Dark green background */
        }
    </style>
</head>
<body>
<header>
    <div style="text-align: center; margin-top: 10px;">
        <h2>Edit Profile</h2>
    </div>
</header>

<div class="container">
    <?php if ($update_success): ?>
        <p style="text-align: center; color: green;">Profile updated successfully!</p>
    <?php endif; ?>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        
        <label for="phonenum">Phone Number:</label>
        <input type="tel" id="phonenum" name="phonenum" value="<?php echo htmlspecialchars($phonenum); ?>" required>
        
        <label for="address">Address:</label>
        <textarea id="address" name="address" rows="4" required><?php echo htmlspecialchars($address); ?></textarea>
        
        <input type="submit" value="Update Profile">
    </form>
    
    <div class="back-button">
        <button onclick="location.href='menu.php'">Back to Menu</button>
    </div>
</div>

</body>
</html>
