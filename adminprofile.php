<?php
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['staff_id'])) {
    header("location: login.php");
    exit();
}

// Get the logged-in staff's details from the session
$staffname = $_SESSION['staffname'];
$staff_id = $_SESSION['staff_id'];
$job_role = $_SESSION['job_role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <style>
        body {
            font-family: "Baskerville", serif;
            margin: 0;
            padding: 0;
            background-color: #1F2B21;
            color: #ffffff;
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
        .profile-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }
        .profile-container h1 {
            font-size: 36px;
            color: #ffffff;
            margin-bottom: 20px;
        }
        .profile-card {
            background-color: #FFC0CB;
            padding: 40px;
            border-radius: 10px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .profile-card h2 {
            font-size: 24px;
            color: #1F2B21;
            margin-bottom: 20px;
        }
        .profile-card img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .profile-card p {
            font-size: 18px;
            margin: 10px 0;
            color: #1F2B21;
        }
        .profile-card button {
            background-color: #1F2B21;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px 0;
            width: 100%;
            transition: background-color 0.3s;
        }
        .profile-card button:hover {
            background-color: #333333;
        }
    </style>
</head>
<body>
    <div class="header">
        <nav>
            <a href="adminprofile.php">HOME</a>
            <a href="logout.php">LOGOUT</a>
        </nav>
    </div>
    <div class="profile-container">
        <h1>ADMIN PAGE</h1>
        <div class="profile-card">
            <h2>STAFF INFORMATION</h2>
            <img src="staffpicture.png" alt="Profile Picture">
            <p>Name: <?php echo htmlspecialchars($staffname); ?></p>
            <p>Staff ID: <?php echo htmlspecialchars($staff_id); ?></p>
            <p>Job Role: <?php echo htmlspecialchars($job_role); ?></p>
            <button onclick="location.href='customerorders.php'">VIEW CUSTOMER ORDER LISTS</button>
            <button onclick="location.href='sales_record.php'">VIEW SALES RECORD</button>
            <!-- <button onclick="location.href='admin_menu_management.php'">EDIT/UPDATE MENU ITEMS</button> -->
        </div>
    </div>
</body>
</html>
